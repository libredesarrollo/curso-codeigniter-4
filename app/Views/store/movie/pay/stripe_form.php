<form id="payment-form">
    <div id="card-element">
        <!-- Elements will create input elements here -->
    </div>

    <!-- We'll put the error messages in this element -->
    <div id="card-errors" role="alert"></div>

    <hr>

    <button type="submit" class="btn btn-success float-right" id="submit">Pagar <i class="fas fa-dollar-sign"></i> <?= $movie->price ?> </button>
</form>