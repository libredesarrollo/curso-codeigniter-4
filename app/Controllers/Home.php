<?php

namespace App\Controllers;

use \CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	function image($movieId = null, $image = null)
	{
		// abre el archivo en modo binario

		if (!$movieId) { // $movieId== null
			$movieId = $this->request->getGet('movie_id');
		}

		if (!$image) { // $image== null
			$image = $this->request->getGet('image');
		}

		if ($movieId == '' || $image == '') {
			throw PageNotFoundException::forPageNotFound();
		}

		$name = WRITEPATH . 'uploads/movies/' . $movieId . '/' . $image;

		if (!file_exists($name)) {
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

		$dataHeader = [
			'title' => 'Contacto ' . $name
		];

		echo view("dashboard/templates/header", $dataHeader);
		echo view('welcome_message');
		echo view("dashboard/templates/footer");
	}

	public function facebook()
	{

		$fb = new \Facebook\Facebook([
			'app_id' => '828738661334015',
			'app_secret' => '257977e4be224bb8b301b6fd771309a3',
			'default_graph_version' => 'v2.10'
		]);

		$accesee_token = "EAALxu8GFOZC8BAECZAT8ZBbSLEBh35BUKnBxWy819ZBXCBXnhH3Ehoo8RYYc3ZCqPWK82srmSGkzTOwEHfaapNba67XwgbZAXckC9ZAnoMOpZCaZBHpnhJ35cXSPB2qzkhXNu9GHAf5O4caKsCRhd42u637fH28kvuUczAKpEZAqqFmqcsJAwyKWY0Tt98ZAJRKIhTIUWHW80VjdtGJ8V7ld0PdvkEpfjBuijTiQmDN7aVZAZAwZDZD";

		try {
			// Get the \Facebook\GraphNode\GraphUser object for the current user.
			// If you provided a 'default_access_token', the '{access-token}' is optional.

			// Obtener informacion de cuenta /3000102056884477/feed/
			// Obtener informacion de grupo /843589393036713/feed/
			// Obtener informacion de la cuenta configurada /me/
			// Obtener informacion de las publicaciones /me/feed/

			$data = [
				"message" => "Hola Mundo",
				"link" => "www.google.com",
			];

			//$response = $fb->get('/843589393036713/feed', $accesee_token);
			$response = $fb->post('/843589393036713/feed', $data, $accesee_token);
		} catch (\Facebook\Exception\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (\Facebook\Exception\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$body = $response->getBody();
		var_dump($body);

		//var_dump($response->getGraphUser());

		/*$me = $response->getGraphUser();
		echo 'Logged in as ' . $me->getId();*/
	}

	//--------------------------------------------------------------------

}
