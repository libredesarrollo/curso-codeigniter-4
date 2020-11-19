<?php namespace App\Controllers\web;
use App\Models\UserModel;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;

class User extends BaseController {

    public function login(){

        //$session = \Config\Services::session();
        $this->_loadDefaultView([],'login');

        return $this->_redirectAuth();
    }

    public function login_post(){

        helper('user');
        $userModel = new UserModel();

        $emailUserName = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->select('id,username,email,password,type')->orWhere('email', $emailUserName)->orWhere('username', $emailUserName)->first();

        if(!$user){
            return redirect()->back()->with('message', 'Usuario y/o contraseña incorrecto');
            return;
        }

        if(verifyPassword($password, $user['password'])){
            // construir sesion
            unset($user['password']);
            //var_dump($user);
            $session = session();
            $session->set($user);    
            return $this->_redirectAuth();
            
        }

        return redirect()->back()->with('message', 'Usuario y/o contraseña incorrecto');

        //var_dump($user);

    }

    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to("/login");
    }

    private function _redirectAuth(){
        $session = session();

        if($session->type == "admin"){
            return redirect()->to("/movie")->with('message', 'Hola '.$session->username);
        } else if($session->type == "regular"){
            return redirect()->to("/")->with('message', 'Hola '.$session->username);
        }
    }

    private function _loadDefaultView($data,$view){

        echo view("user/templates/header");
        echo view("user/control/$view",$data);
        echo view("user/templates/footer");
    }


}