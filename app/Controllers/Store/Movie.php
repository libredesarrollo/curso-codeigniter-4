<?php

namespace App\Controllers\Store;

use App\Models\MovieModel;
use App\Models\PaymentModel;
use App\Models\CategoryModel;
use App\Models\MovieImageModel;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use App\Controllers\Store\CustomBaseController;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use \CodeIgniter\Exceptions\PageNotFoundException;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class Movie extends CustomBaseController
{

    private $customKeys;
    function __construct()
    {
        $this->customKeys = config("CustomKeys");
    }

    public function index()
    {

        /*$forge = \Config\Database::forge();
        $forge->createDatabase('testCode4');

        if ($forge->dropDatabase('testCode4')) {
            echo 'Database deleted!';
        }*/

        helper('text');

        $search = $this->request->getGet('search');
        $category_id = $this->request->getGet('category_id');

        $movie = new MovieModel();
        $category = new CategoryModel();

        $movieImage = $movie->asObject()
            ->select('movies.*, categories.title as category, any_value(movie_images.image) as image')
            ->join('categories', 'categories.id = movies.category_id')
            ->join('movie_images', 'movies.id = movie_id', 'left')
            ->groupBy('movies.id');

        if ($search) {
            $movieImage->like('movies.title', $search);
        }

        if ($category_id) {
            $movieImage->where('categories.id', $category_id);
        }


        $movieImage = $movieImage->paginate(10);

        //BUG
        $movies = $movie->asObject()
            ->select('movies.*, categories.title as category')
            ->join('categories', 'categories.id = movies.category_id');

        if ($search) {
            $movies->like('movies.title', $search);
            //$movies->orLike('categories.title', $search);
        }

        if ($category_id) {
            $movies->where('categories.id', $category_id);
        }

        $movies = $movies->paginate(10);

        //END BUG


        $data = [
            'movies' => $movieImage,
            'pager' => $movie->pager,
            'categories' => $category->asObject()->findAll(),
            'search' => $search,
            'category_id' => $category_id,
        ];

        $this->_loadDefaultView('Listado de películas', $data, 'index');
    }

    public function show($id = null)
    {

        $movieModel = new MovieModel();
        $movie = $movieModel->asObject()->find($id);
        $imageModel = new MovieImageModel();

        if ($movie == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->_loadDefaultView(
            $movie->title,
            [
                'movie' => $movie,
                'images' => $imageModel->getByMovieId($id)
            ],
            'show'
        );
    }

    public function form_stripe($id = null)
    {

        $movieModel = new MovieModel();
        $movie = $movieModel->asObject()->find($id);

        if ($movie == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        echo view("store/movie/pay/stripe_form", ['movie' => $movie]);
    }

    public function buy_success_old($id = null)
    {

        $movieModel = new MovieModel();
        $movie = $movieModel->asObject()->find($id);

        if ($movie == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $session = session();

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->customKeys->paypalClientKey,     // ClientID
                $this->customKeys->paypalSecretKey      // ClientSecret
            )
        );

        // Get payment object by passing paymentId
        $paymentId = $_GET['paymentId'];

        $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];

        // Execute payment with payer ID
        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            // Execute payment
            $result = $payment->execute($execution, $apiContext);
            //var_dump($result);
            echo $paymentId;
            $paymentModel = new PaymentModel();

            $id = $paymentModel->insert([
                'user_id' => $session->id,
                'e_id' => $movie->id,
                'model' => 'movie',
                'price' => $movie->price,
                'payment_id' => $paymentId
            ]);

            return redirect()->route('store_buyed_show', [$id])->with('message', 'Gracias por su compra');
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }

    public function buy_cancel($id = null)
    {
        echo "buy_cancel";
    }

    public function buy($id = null)
    {

        helper('text');

        $movieModel = new MovieModel();
        $movie = $movieModel->asObject()->find($id);
        $imageModel = new MovieImageModel();

        if ($movie == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $environment = new SandboxEnvironment($this->customKeys->paypalClientKey, $this->customKeys->paypalSecretKey);
        $client = new PayPalHttpClient($environment);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "test_ref_id1",
                "amount" => [
                    "value" => $movie->price,
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => base_url() . route_to('store_movie_buy_success', $id),
                "return_url" => base_url() . route_to('store_movie_buy_success', $id)
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //print_r($response->result->links[1]->href);
            print_r($response->result->id);
            $this->_loadDefaultView(
                null,
                [
                    'movie' => $movie,
                    'images' => $imageModel->getByMovieId($id),
                    'approval' => $response->result->links[1]->href
                ],
                'buy'
            );
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function buy_success($id = null)
    {

        $movieModel = new MovieModel();
        $movie = $movieModel->asObject()->find($id);

        if ($movie == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $session = session();

        $paymentModel = new PaymentModel();

        $request = new OrdersCaptureRequest($_GET['token']);
        $request->prefer('return=representation');
        try {

            $environment = new SandboxEnvironment($this->customKeys->paypalClientKey, $this->customKeys->paypalSecretKey);
            $client = new PayPalHttpClient($environment);
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            $id = $paymentModel->insert([
                'user_id' => $session->id,
                'e_id' => $movie->id,
                'model' => 'movie',
                'price' => $movie->price,
                'payment_id' => $_GET['token']
            ]);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //print_r($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }



        return redirect()->route('store_buyed_show', [$id])->with('message', 'Gracias por su compra');
    }

    public function buy_old($id = null)
    {

        helper('text');

        $movieModel = new MovieModel();
        $movie = $movieModel->asObject()->find($id);
        $imageModel = new MovieImageModel();

        if ($movie == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        // After Step 1
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->customKeys->paypalClientKey,     // ClientID
                $this->customKeys->paypalSecretKey
            )
        );

        // After Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($movie->price);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(base_url() . route_to('store_movie_buy_success', $id))
            ->setCancelUrl(base_url() . route_to('store_movie_buy_success', $id));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        // After Step 3
        try {
            $payment->create($apiContext);
            echo $payment->id;

            $this->_loadDefaultView(
                null,
                [
                    'movie' => $movie,
                    'images' => $imageModel->getByMovieId($id),
                    'approval' => $payment->getApprovalLink()
                ],
                'buy'
            );

            //echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }
    }

    public function buy_success_stripe($id = null)
    {

        $movieModel = new MovieModel();
        $movie = $movieModel->asObject()->find($id);

        if ($movie == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $paymentId = $this->request->getPost('payment_id'); //"pi_1GiHBqEK4SIuNqirnoZiISad";

        // procesar el pago Stripe
        \Stripe\Stripe::setApiKey($this->customKeys->stripeSecretKey);

        $intent = \Stripe\PaymentIntent::retrieve(
            $paymentId
        );

        if ($intent->status == "succeeded") {
            $paymentModel = new PaymentModel();
            $id = $paymentModel->insert([
                'user_id' => $this->session->id,
                'e_id' => $movie->id,
                'model' => 'movie',
                'price' => $movie->price,
                'payment_id' => $paymentId,
                'type' => 'stripe'
            ]);

            echo json_encode(array('msj' => "Pago realizado correctamente", 'code' => 200));
            return;
        }

        echo json_encode(array('msj' => $intent->status, 'code' => 500));
    }

    public function client_secret_stripe($id)
    {

        $movieModel = new MovieModel();
        $movie = $movieModel->asObject()->find($id);

        $secret = "";

        if ($movie == null) {
            echo json_encode(array('client_secret' => $secret));
            return;
        }

        \Stripe\Stripe::setApiKey($this->customKeys->stripeSecretKey);

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $movie->price * 100,
            'currency' => 'usd',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        $secret = $intent->client_secret;

        echo json_encode(array('client_secret' => $secret));
    }

    private function _loadDefaultView($title, $data, $view)
    {

        $dataHeader = [
            'title' => $title,
            'stripeClientKey' => $this->customKeys->stripeClientKey,
        ];

        echo view("store/templates/header", $dataHeader);
        echo view("store/movie/$view", $data);
        echo view("store/templates/footer");
    }
}
