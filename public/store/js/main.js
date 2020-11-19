if (typeof (Stripe) != "undefined")
  var stripe = Stripe(stripeClientKey);

function stripeForm(movieId) {

  // instancia para definir elementos de stripe
  var elements = stripe.elements();

  // estilo del card
  var style = {
    base: {
      color: "#32325d",
    }
  };

  // creamos el card
  var card = elements.create("card", {
    style: style
  });
  card.mount("#card-element");

  // escuchador evento Stripe que detecta 
  // cuando introducimos una tarjeta invalida
  card.addEventListener('change', ({
    error
  }) => {
    const displayError = document.getElementById('card-errors');
    if (error) {
      displayError.textContent = error.message;
    } else {
      displayError.textContent = '';
    }
  });

  // hacemos una peticion para crear la Intencion de Pago o PaymentIntent
  var response = fetch('/store/movie/stripe/client_secret_stripe/' + movieId).then(function (response) {
    return response.json();
  }).then(function (responseJson) {
    var clientSecret = responseJson.client_secret;
    // llamamos al metodo que permite crear el pago
    requestPayToStripe(clientSecret, card, movieId);
  });
}
/*
 *** funcion que se encarga de crear un pago de Stripe y de devolver la respuesta
 *** (1) - clientSecret generado gracias al PaymentIntent
 *** (2) - card componente de card de la TDC
 */
function requestPayToStripe(clientSecret, card, movieId) {

  // al detectar el evento del envio del formulario procesamos el pago
  var form = document.getElementById('payment-form');
  form.addEventListener('submit', function (ev) {

    // bloqueamos el boton submit del form
    document.querySelector("#payment-form button[type=submit]").disabled = true
    // cerramos el modal
    $('#formStripe').modal("hide")

    ev.preventDefault();
    stripe.confirmCardPayment(clientSecret, {
      payment_method: {
        card: card,
        billing_details: {
          name: 'Jenny Rosen'
        }
      }
    }).then(function (result) {
      // respuesta del pago realizado
      console.log(result);
      if (result.error) {
        // Show error to your customer (e.g., insufficient funds)
        console.log(result.error.message);
      } else {
        // The payment has been processed!
        if (result.paymentIntent.status === 'succeeded') {
          //alert("Compra exitosa")
          sendPayIdStripe(movieId, result.paymentIntent.id)
        } else {
          alert("Problema con la compra")
        }
      }
    });
  });
}

/*
 *** funcion que se encarga de mandar el ID del pago realizado
 *** (1) - movieId
 *** (2) - ID de pago
 */
function sendPayIdStripe(movieId, paymentId) {

  // enviamos una peticion fetch por post
  var formData = new FormData()
  formData.append('payment_id', paymentId);

  fetch('/store/movie/stripe/buy_success/' + movieId, {
    method: 'POST',
    body: formData
  }).then(function (response) {
    return response.json();
  }).then(function (responseJson) {
    alert(responseJson.msj)
    if (responseJson.code == 200) {
      // respuesta existosa
    } else {

    }
  });
}