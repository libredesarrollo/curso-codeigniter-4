<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;

class MyLibraries extends BaseController
{
    public function curl_get()
    {
        $client = \Config\Services::curlrequest();

        $res = $client->get('http://codeigniter4.test/rest-movie', [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        //$body = json_decode($res->getBody());
        echo $res->getBody();
    }

    public function curl_post()
    {
        $client = \Config\Services::curlrequest();

        $res = $client->post('http://codeigniter4.test/rest-movie', [
            'form_params' => [
                'category_id' => 1,
                'title' => 'Título nueva peli',
                'description' => 'lorem imput'
            ]
        ]);

        //$body = json_decode($res->getBody());
        echo $res->getBody();
    }

    public function curl_put()
    {
        $client = \Config\Services::curlrequest();

        $res = $client->put('http://codeigniter4.test/rest-movie/22', [
            'form_params' => [
                'category_id' => 1,
                'title' => 'Título new',
                'description' => 'lorem imput..'
            ]
        ]);

        //$body = json_decode($res->getBody());
        echo $res->getBody();
    }

    public function curl_remove()
    {
        $client = \Config\Services::curlrequest();

        $res = $client->delete('http://codeigniter4.test/rest-movie/21', [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $body = json_decode($res->getBody());

        var_dump($body);
    } //https://codeigniter.com/user_guide/libraries/curlrequest.html?highlight=curlrequest

    // agentes
    public function agent()
    {
        $data = $this->request->getUserAgent();

        $dataHeader = [
            'title' => "Agent"
        ];

        echo view("dashboard/templates/header", $dataHeader);
        echo view("librarie/my_agent", ['agent' => $data]);
        echo view("dashboard/templates/footer");
    }

    // uri
    public function uri()
    {
        $uri = $this->request->uri;

        $data = new \CodeIgniter\HTTP\URI('https://www.desarrollolibre.net/blog/django/creando-nuestro-primer-proyecto-y-aplicacion-en-django');

        $dataHeader = [
            'title' => "Uri"
        ];

        echo view("dashboard/templates/header", $dataHeader);
        echo view("librarie/my_uri", ['uri' => $data]);
        echo view("dashboard/templates/footer");
    }

    public function email()
    {
        $email = \Config\Services::email();

        $config['protocol'] = 'smtp';
        $config['mailPath'] = 'smtp.mailtrap.io';
        $config['SMTPPort']  = 2525;
        $config['SMTPUser'] = true;
        $config['SMTPUser'] = true;
        $config['CRLF'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['mailType'] = "html";

        $email->initialize($config);

        $email->setFrom('andres@gmail.com', 'Andres');
        $email->setTo('someone@example.com');

        $email->setSubject('Email Test');
        $email->setMessage('<h1>Hola Mundo</h1>');

        $email->send();
    }

    public function encrypt()
    {
        $encrypter = \Config\Services::encrypter();

        $cadena = "Hola mundo de prueba";

        $encrypt = $encrypter->encrypt($cadena);

        //echo $encrypt;

        echo $encrypter->decrypt($encrypt);
    }

    public function time()
    {
        $time = new Time('+3 week');
        $time = Time::parse('+3 week');
        $time = Time::parse('now');

        /*        echo $time->year;           
         echo $time->month;          
         echo $time->day;           
         echo $time->hour;           
         echo $time->minute;        
         echo $time->second;        */

        $time = Time::parse('March 10, 2017', 'America/Chicago');

        echo $time->humanize();
    }

    public function file(){
        //echo dirname(__DIR__);

        $file = new File('C:\laragon\www\codeigniter4\public\robots.txt');

        $dataHeader = [
            'title' => "File"
        ];

        echo view("dashboard/templates/header", $dataHeader);
        echo view("librarie/my_file", ['file' => $file]);
        echo view("dashboard/templates/footer");
    }
}
