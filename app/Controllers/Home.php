<?php namespace App\Controllers;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	function image($movieId = null, $image = null){
		// abre el archivo en modo binario

		if(!$movieId){// $movieId== null
			$movieId = $this->request->getGet('movie_id');
		}

		if(!$image){// $image== null
			$image = $this->request->getGet('image');
		}

		if($movieId == '' || $image == ''){
			throw PageNotFoundException::forPageNotFound();
		}

		$name = WRITEPATH.'uploads/movies/'.$movieId.'/'.$image;

		if(!file_exists($name)){
			throw PageNotFoundException::forPageNotFound();
		}

		$fp = fopen($name, 'rb');

		// envía las cabeceras correctas
		header("Content-Type: image/png");
		header("Content-Length: " . filesize($name));

		// vuelca la imagen y detiene el script
		fpassthru($fp);
		exit;
	}

	public function contacto($name = "Pepe")
	{

		$dataHeader =[
            'title' => 'Contacto '.$name
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view('welcome_message');
        echo view("dashboard/templates/footer");
	}

	//--------------------------------------------------------------------

}
