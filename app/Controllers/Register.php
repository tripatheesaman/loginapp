<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;



class Register extends BaseController
{
    private $userModel = NULL;
     function __construct() {
        //Form Helper
        helper(['form']);
        $this->userModel = new UserModel();

    }
    public function index()
    {
        //Check if the user is already logged in
        if(session()->get("User Data")){
			session()->setFlashData("Error", "You have Already Logged In");
            return redirect()->to(base_url()."public/profile");
		}

        return view("register");
    }


    //Login using the app's form
    public function registerConfirmation(){
      
        $rules = [
            'first_name'          => 'required|min_length[3]|max_length[20]',
            'last_name'          => 'required|min_length[3]|max_length[20]',
            'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
            'password'      => 'required|min_length[6]|max_length[200]',
            'confirm_password'  => 'required|matches[password]'
        ];

        if($this->validate($rules)){
            $id = bin2hex(random_bytes(16));
            $firstName = $this->request->getVar("first_name");
            $lastName = $this->request->getVar("last_name");
            $email = $this->request->getVar("email");
            $password = $this->request->getVar("password");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userData = [
                "oauth_id" => $id,
                "first_name" => $firstName,
                "last_name" => $lastName,
                "email" => $email,
                "password"=> $hashedPassword
            ];

            $this->userModel->insertRecord($userData);
            return redirect()->to(base_url()."public/login");

        
        }else{
            $data['errors'] = $this->validator->getErrors();
            session()->setFlashdata("errors", $data['errors']);
            return redirect()->to(base_url()."public/register")->withInput();
        }

    }
    
    }