<?php namespace App\Models;

use CodeIgniter\Model;

class MovieModel extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description','category_id'];

    function getAll(){
        return $this->asArray()
        ->select('movies.*, categories.title as category')
        ->join('categories','categories.id = movies.category_id')
        ->first();
    }

}
