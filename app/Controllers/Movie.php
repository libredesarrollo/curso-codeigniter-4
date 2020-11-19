<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\CategoryModel;
use App\Models\MovieImageModel;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\View\Table;

use CodeIgniter\Controller;

class Movie extends BaseController
{

    public function index()
    {

        $movie = new MovieModel();

        $data = [
            'movies' => $movie->asObject()
                ->select('movies.*, categories.title as category')
                ->join('categories', 'categories.id = movies.category_id')
                ->paginate(10),
            'pager' => $movie->pager
        ];

        $this->_loadDefaultView('Listado de películas', $data, 'index');
    }

    public function new()
    {

        $category = new CategoryModel();

        //mkdir('writeable/uploads/test',0755,true);

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Crear película', ['validation' => $validation, 'movie' => new MovieModel(), 'categories' => $category->asObject()->findAll()], 'new');
    }

    public function create()
    {

        $movie = new MovieModel();

        if ($this->validate('movies')) {
            $id = $movie->insert([
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'category_id' => $this->request->getPost('category_id'),
            ]);

            return redirect()->to("/movie/$id/edit")->with('message', 'Película creada con éxito.');
        }

        return redirect()->back()->withInput();
    }

    public function edit($id = null)
    {

        $category = new CategoryModel();
        $images = new MovieImageModel();
        $movie = new MovieModel();

        if ($movie->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView(
            'Actualizar película',
            [
                'validation' => $validation, 'movie' => $movie->asObject()->find($id),
                'categories' => $category->asObject()->findAll(),
                'images' => $images->getByMovieId($id)
            ],
            'edit'
        );
    }

    public function update($id = null)
    {

        $movie = new MovieModel();

        if ($movie->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        if ($this->validate('movies')) {
            $movie->update($id, [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'category_id' => $this->request->getPost('category_id'),
            ]);

            $this->_upload($id);

            return redirect()->to('/movie')->with('message', 'Película editada con éxito.');
        }

        return redirect()->back()->withInput();
    }

    public function delete($id = null)
    {

        $movie = new MovieModel();

        if ($movie->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $movie->delete($id);

        return redirect()->to('/movie')->with('message', 'Película eliminada con éxito.');
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

    public function delete_image($imageId)
    {

        $imageModel = new MovieImageModel();

        $image = $imageModel->asObject()->find($imageId);

        if ($image == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $imgRute = WRITEPATH . 'uploads/movies/' . $image->movie_id . '/' . $image->image;

        if (!file_exists($imgRute)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $imageModel->delete($imageId);

        unlink($imgRute);

        return redirect()->back()->with('message', 'Imagen eliminada con éxito.');
    }


    private function _upload($movieId)
    {

        $images = new MovieImageModel();

        if ($imagefile = $this->request->getFile('image')) {

            if ($imagefile->isValid() && !$imagefile->hasMoved()) {

                $validated = $this->validate([
                    'image' => [
                        'uploaded[image]',
                        'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
                        'max_size[image,4096]',
                    ],
                ]);
         
                if ($validated) {
                    //echo "Todo OK";
                    //return true;
                }else{
                    //var_dump($this->validator->listErrors());
                    //echo "Error";
                    //return false;
                }

                $newName = $imagefile->getRandomName();
                $imagefile->move(WRITEPATH . 'uploads/movies/' . $movieId, $newName);

                $images->save([
                    'movie_id' => $movieId,
                    'image' => $newName
                ]);
            }
        }
    }

    private function _loadDefaultView($title, $data, $view)
    {

        $dataHeader = [
            'title' => $title
        ];

        echo view("dashboard/templates/header", $dataHeader);
        echo view("dashboard/movie/$view", $data);
        echo view("dashboard/templates/footer");
    }
}
