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

        $this->setModel(new MovieModel());

        $this->paginated = true;

        $this->listName = ['id' => 'Id', 'category_id' => 'Categoría', 'title' => 'Título', 'description' => 'Descripción', 'price' => 'Precio'];

        $query = $db->query('SELECT * FROM movies');
        $this->setQuery($query);

        $dataHeader = [
            'title' => "CRUD Movie"
        ];

        $this->setRelationOneToMany('category_id', new CategoryModel(), 'id', 'title');

        $this->nameValidation = "movies";

        $this->HTMLheader = view("dashboard/templates/header", $dataHeader);
        $this->HTMLfooter = view("dashboard/templates/footer");
    }
}
