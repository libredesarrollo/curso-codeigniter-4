<?php

namespace App\Controllers\Store;

use App\Models\MovieModel;
use App\Models\MovieImageModel;
use App\Controllers\Store\CustomBaseController;
use App\Models\PaymentModel;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Buyed extends CustomBaseController
{

    private $customKeys;
    function __construct()
    {
        $this->customKeys = config("CustomKeys");
    }

    public function index()
    {

        helper('util');

        $paymentModel = new PaymentModel();
        $payments = $paymentModel->asObject()
            ->select('payments.*, movies.title as movie')
            ->join('movies', 'movies.id = e_id')
            ->where('model', 'movie')
            ->where('user_id', $this->session->id)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [
            'payments' => $payments
        ];

        $this->_loadDefaultView('Compras', $data, 'index');
    }

    public function show($id = null)
    {
        helper('text');

        $paymentModel = new PaymentModel();

        $payment = $paymentModel->asObject()
            ->select('payments.*, movies.title as movie, movies.description as movie_description')
            ->join('movies', 'movies.id = e_id')
            ->where('model', 'movie')
            ->where('user_id', $this->session->id)
            ->find($id);


        $imageModel = new MovieImageModel();

        if ($payment == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->_loadDefaultView(
            null,
            [
                'payment' => $payment,
                'images' => $imageModel->getByMovieId($payment->e_id)
            ],
            'show'
        );
    }

    public function show_stripe($id = null)
    {
        \Stripe\Stripe::setApiKey('sk_test_92m8MOLtJC17D59nYPHbMsFO');

        $payment = \Stripe\PaymentIntent::retrieve(
            'pi_1GeQQVEK4SIuNqirqsW30X6D'
        );

        echo json_encode($payment);
    }

    private function _loadDefaultView($title, $data, $view)
    {

        $dataHeader = [
            'title' => $title,
            'stripeClientKey' => $this->customKeys->stripeClientKey,
        ];

        echo view("store/templates/header", $dataHeader);
        echo view("store/buyed/$view", $data);
        echo view("store/templates/footer");
    }
}
