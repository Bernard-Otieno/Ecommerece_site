<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login.php');
    }

    public function processlogin(){
        $userModel = new UserModel();
        $user_details = $userModel-> getOneUser();
        $session = session();
        $session->set('user_details',$user_details);


        return redirect()->to('auth/homepage');
    }
    public function processAdmin(){
        $admin_details = new AdminModel();
        $admin_details = $admin_details-> getOneUser1();
        $session = session();
        $session->set('admin_details',$admin_details);


        return redirect()->to('auth/admin');
    }

    public function homepage(){
        return view('auth/homepage.php');
    }
    public function register(){
        return view('auth/register.php');
    }
    public function processRegistration(){

    }


}