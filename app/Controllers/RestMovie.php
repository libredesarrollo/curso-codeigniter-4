<?php namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\MovieModel;
use MyRestApi;

class RestMovie extends MyRestApi
{

    protected $modelName = 'App\Models\MovieModel';
    protected $format = 'json';

    public function index()
    {

        return $this->genericResponse($this->model->findAll(),null,200);

        /*

    $data = [
    'movies' => $movie->asObject()
    ->select('movies.*, categories.title as category')
    ->join('categories','categories.id = movies.category_id')
    ->paginate(10),
    'pager' => $movie->pager
    ];*/

    }

    public function paginate(){
        $movieImage = $this->model->asObject()
            ->select('movies.*, categories.title as category, any_value(movie_images.image) as image')
            ->join('categories', 'categories.id = movies.category_id')
            ->join('movie_images', 'movies.id = movie_id', 'left')
            ->groupBy('movies.id');

        return $this->genericPaginateResponse($movieImage->paginate(10),null,200,$movieImage->pager);

    }

    public function search(){
        $search = $this->request->getGet('search');
        $category_id = $this->request->getGet('category_id');

        $movieImage = $this->model->asObject()
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

        return $this->genericPaginateResponse($movieImage->paginate(10),null,200,$movieImage->pager);

    }

    public function show($id = null)
    {
        return $this->genericResponse($this->model->find($id),null,200);
    }

    public function delete($id = null)
    {

        $movie = new MovieModel();
        $movie->delete($id);

        return $this->genericResponse("Producto eliminado",null,200);
    }

    public function create()
    {

        $movie = new MovieModel();
        $category = new CategoryModel();

        if ($this->validate('movies')) {

            if(!$this->request->getPost('category_id'))
                return $this->genericResponse(null, array("category_id" => "Categoría no existe"), 500);
            
            if (!$category->get($this->request->getPost('category_id'))) {
                return $this->genericResponse(null, array("category_id" => "Categoría no existe"), 500);
            }

            $id = $movie->insert([
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'category_id' => $this->request->getPost('category_id'),
            ]);

            return $this->genericResponse($this->model->find($id), null, 200);

        }

        $validation = \Config\Services::validation();

        return $this->genericResponse(null, $validation->getErrors(), 500);

        // errores
        //return redirect()->back()->withInput();
    }

    public function update($id = null)
    {

        $movie = new MovieModel();
        $category = new CategoryModel();

        $data = $this->request->getRawInput();

        if ($this->validate('movies')) {

            if(!$data['category_id'])
                return $this->genericResponse(null, array("category_id" => "Categoría no existe"), 500);

            if (!$movie->get($id)) {
                return $this->genericResponse(null, array("movie_id" => "Película no existe"), 500);
            }

            if (!$category->get($data['category_id'])) {
                return $this->genericResponse(null, array("category_id" => "Categoría no existe"), 500);
            }

            $movie->update($id,[
                'title' => $data['title'],
                'description' => $data['description'],
                'category_id' => $data['category_id'],
            ]);

            return $this->genericResponse($this->model->find($id), null, 200);

        }

        $validation = \Config\Services::validation();

        return $this->genericResponse(null, $validation->getErrors(), 500);

        // errores
        //return redirect()->back()->withInput();
    }

    public function categories(){
        $category = new CategoryModel();
        return $this->genericResponse($category->findAll(),null,200);
    }

}
