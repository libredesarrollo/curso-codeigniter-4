<?php

use CodeIgniter\RESTful\ResourceController;

class MyRestApi extends ResourceController
{

    public function genericPaginateResponse($data, $msj, $code, $pager)
    {

        $pageURI = $pager->getPageURI();
        if ($code == 200 && count($data) > 0) {
            return $this->respond(array(
                "data" => array(
                    "data" => $data,
                    "current_page" => $pager->getCurrentPage(),
                    "last_page" => $pager->getLastPage(),
                    "last_page_url" => $pageURI."?page=".$pager->getLastPage(),
                    "first_page" => $pager->getFirstPage(),
                    "first_page_url" => $pageURI."?page=".$pager->getFirstPage(),
                    "prev_page_url" => $pager->getPreviousPageURI(),
                    "next_page_url" => $pager->getNextPageURI(),
                    "path" => $pager->getPageURI(),
                    "per_page" => $pager->getPerPage(),
                    "more" => $pager->hasMore()
                ),
                "code" => $code
            )); //, 404, "No hay nada"
        } else {
            return $this->respond(array(
                "msj" => $msj,
                "code" => $code
            ));
        }
    }

    public function genericResponse($data, $msj, $code)
    {

        if ($code == 200) {
            return $this->respond(array(
                "data" => $data,
                "code" => $code
            )); //, 404, "No hay nada"
        } else{
            return $this->respond(array(
                "msj" => $msj,
                "code" => $code
            ));
            
        }

    }

}
