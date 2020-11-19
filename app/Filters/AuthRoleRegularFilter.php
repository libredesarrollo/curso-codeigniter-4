<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthRoleRegularFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $session = session();

        if($session->type != "regular"){
            return redirect()->route('user_login_get');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}