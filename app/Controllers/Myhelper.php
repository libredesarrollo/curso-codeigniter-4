<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Myhelper extends BaseController
{
    public function array()
    {
        helper('array');

        $data = [
            'uno' => [
                'dos' => [
                    'tres' => 4
                ]
            ]
        ];

        $val = dot_array_search('uno.dos.tres', $data);
        $val = dot_array_search('uno.dos', $data);
        $val = dot_array_search('uno.*', $data);
        var_dump($val);
    }

    public function filesystem()
    {
        helper('filesystem');

        //$map = directory_map('.');
        //$map = directory_map('./bootstrap',1);
        //$map = directory_map('../app',1);
        //var_dump($map);

        write_file('./bootstrap/customcss.css', 'body{color:red}');
    }

    public function number()
    {
        helper('number');

        /* echo number_to_size(456); // Returns 456 Bytes
        echo number_to_size(4567); // Returns 4.5 KB
        echo number_to_size(45678); // Returns 44.6 KB
        echo number_to_size(456789); // Returns 447.8 KB
        echo number_to_size(3456789); // Returns 3.3 MB
        echo number_to_size(12345678912345); // Returns 1.8 GB
        echo number_to_size(123456789123456789); // Returns 11,228.3 TB*/

        echo number_to_amount(123456789);
    }

    public function text()
    {
        helper('text');

        //echo random_string('alpha',10);
        //echo increment_string('file','-',8);

        for ($i = 0; $i < 10; $i++) {
            echo alternator(' uno', ' dos', ' tres', ' cuatro');
        }
    }

    public function url()
    {
        //echo site_url('noticia/otro/12');
        $segment = ['noticia','otro',13];
        //echo site_url($segment);
        //echo base_url();
        //echo base_url($segment);
        echo uri_string();
    }
}
