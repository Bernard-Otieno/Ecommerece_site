<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index()
    {
        $data = [];
        helper(['form']);


        if ($this->request->getMethod() == 'post') {
            //let's do the validation here
            $rules = [
                'email' => 'required|min_length[5]|max_length[50]|valid_email',
                'password' => 'required|min_length[4]|max_length[255]|validateUser[email,password]',
            ];//validating the user credentials in the database

            $errors = [
                'password' => [
                    'validateUser' => 'Email or Password doesn\'t match'// error message when one credtential is wrong
                ]
            ];

            if (! $this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            }else{
                $model = new UserModel();

                $user = $model->where('email', $this->request->getVar('email'))
                                            ->first();// taking the first record

                $this->setUserSession($user);// passing user object from model
                //$session->setFlashdata('success', 'Successful Registration');
                return redirect()->to('auth/profile');

            }
        }

        echo view('template/header', $data);
        echo view('auth/login');
        echo view('template/footer');
    }

    private function setUserSession($user){
        $data = [
            'id' => $user['id'],
            'firstname' => $user['firstname'],      //data object
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }

    public function register(){
        $data = [];
        helper(['form']);

        if ($this->request->getMethod() == 'post') {
            //let's do the validation here
            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[2]|max_length[20]',
                'email' => 'required|min_length[4|max_length[50]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[4]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            }else{
                $model = new UserModel();

                $newData = [
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                ];
                $model->save($newData);
                $session = session();
                $session->setFlashdata('success', 'Successful Registration');
                return redirect()->to('/');

            }
        }


        echo view('template/header', $data);
        echo view('auth/register');
        echo view('template/footer');
    }

    public function profile(){
        
        $data = [];
        helper(['form']);
        $model = new UserModel();

        if ($this->request->getMethod() == 'post') {
            //let's do the validation here
            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
                ];

            if($this->request->getPost('password') != ''){
                $rules['password'] = 'required|min_length[4]|max_length[255]';
                $rules['password_confirm'] = 'matches[password]';
            }


            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            }else{

                $newData = [
                    'id' => session()->get('id'),
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                    ];
                    if($this->request->getPost('password') != ''){
                        $newData['password'] = $this->request->getPost('password');
                    }
                $model->save($newData);

                session()->setFlashdata('success', 'Successfuly Updated');
                return redirect()->to('/profile');

            }
        }

        $data['user'] = $model->where('id', session()->get('id'))->first();
        echo view('template/header', $data);
        echo view('auth/profile');
        echo view('template/footer');
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }

    //--------------------------------------------------------------------

}
