<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Controllers\BaseController;
use App\Models\MovieModel;
use \CodeIgniter\Exceptions\PageNotFoundException;

class CategoryAutoCRUD extends CRUDBaseController
{

    public function __construct()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM movies');
        $this->setQuery($query);

        $dataHeader = [
            'title' => "CRUD Movie"
        ];

        $this->setModel(new MovieModel());

        $this->nameValidation = "movies";

        $this->HTMLheader = view("dashboard/templates/header", $dataHeader);
        $this->HTMLfooter = view("dashboard/templates/footer");
    }
}
