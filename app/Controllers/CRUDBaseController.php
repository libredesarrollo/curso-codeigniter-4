<?php

namespace App\Controllers;

use CodeIgniter\Database\BaseResult;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;

class CRUDBaseController extends BaseController
{

    public $primaryId = 'id';
    public $iheading = []; // colunmas internas
    public $eheading = []; // colunmas externas
    private $query = '';

    private $rows = [];
    private $types = [];


    private $model;

    private $HTMLbody;
    public $HTMLheader;
    public $HTMLfooter;

    public $nameValidation = "";


    public function setQuery($query)
    {
        if (!empty($query)) {
            if ($query instanceof BaseResult) {
                $this->query = $query;
                $this->_setFromDBResult();
            }
        }
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    private function _setFromDBResult()
    {
        $this->rows = $this->query->getResultArray();
        $this->eheading = $this->iheading = $this->query->getFieldNames();

        $types = $this->query->getFieldData();

        foreach ($types  as $key => $t) {

            $h = $this->eheading[$key];

            $this->types[$h] = $this->_setTypeField($types[$key]->type_name, $types[$key]->length);
        }

        //var_dump($this->types);

        // var_dump($types[3]->length / 3);
    }


    public function index()
    {

        //var_dump($this->request->uri);

        //echo $this->request->getServer('REQUEST_URI');
        //echo $this->request->getServer('HTTP_REFERER');

        $baseURL = $this->request->getServer('REQUEST_URI');
        $this->HTMLbody = view('Custom/CRUDBaseController/index', ['rows' => $this->rows, 'eheading' => $this->eheading, 'iheading' => $this->iheading, 'primaryId' => $this->primaryId, 'baseURL' =>  $this->_getSegmentURL()]);
        $this->_loadDefaultView();
    }

    public  function edit($id)
    {
        $record = $this->model->find($id);
        $validation =  \Config\Services::validation();

        $this->HTMLbody = view('Custom/CRUDBaseController/edit', ['validation' => $validation, 'record' => $record, 'eheading' => $this->eheading, 'iheading' => $this->iheading, 'primaryId' => $this->primaryId, 'baseURL' => $this->_getSegmentURL(), 'types' => $this->types]);
        $this->_loadDefaultView();
    }

    public function update($id)
    {
        $record = $this->model->find($id);

        if ($record == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        if ($this->validate($this->nameValidation)) {
            $data = [];
            foreach ($this->eheading as $key => $h) {
                $data[$h] = $this->request->getPost($h);
            }

            $this->model->update($id, $data);

            return redirect()->to($this->_getSegmentURL() . "/$id/edit")->with("message", "Registro editado con éxito");
        }



        return redirect()->back()->withInput();
    }

    public  function new()
    {
        $validation =  \Config\Services::validation();
        $this->HTMLbody = view('Custom/CRUDBaseController/new', ['validation' => $validation, 'eheading' => $this->eheading, 'iheading' => $this->iheading, 'primaryId' => $this->primaryId, 'baseURL' => $this->_getSegmentURL(), 'types' => $this->types]);
        $this->_loadDefaultView();
    }

    public function create()
    {

        if ($this->validate($this->nameValidation)) {
            $data = [];
            foreach ($this->eheading as $key => $h) {
                $data[$h] = $this->request->getPost($h);
            }

            $id = $this->model->insert($data);

            return redirect()->to($this->_getSegmentURL() . "/$id/edit")->with("message", "Registro creado con éxito");
        }

        return redirect()->back()->withInput();
    }


    private function _loadDefaultView()
    {

        echo $this->HTMLheader;
        echo $this->HTMLbody;
        echo $this->HTMLfooter;
    }

    private function _getSegmentURL($segment = 1)
    {

        $uri = new \CodeIgniter\HTTP\URI(base_url($this->request->getServer('REQUEST_URI')));
        return base_url($uri->getSegment($segment));
    }

    private function _setTypeField($typeDB, $length)
    {

        $type = "text";

        switch ($typeDB) {
            case 'long':
                $type = "number";
                break;
            case 'blob':
            case 'var_string':

                if ($length / 3 >= 1000) {
                    $type = "textarea";
                }

                break;
            case 'newdecimal':
                $type = "text";
                break;
        }

        return $type;
    }
}
