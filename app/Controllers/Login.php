<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends BaseController
{
    private $googleClient= NULL;
    private $facebook = NULL;
    private $fbHelper = NULL;
    private $userModel = NULL;
     function __construct() {
        //Form Helper
        helper(['form', 'uuid']);
        // Load the google and facebook libraries
        require_once APPPATH."libraries/vendor/autoload.php";
        
        $this->userModel = new UserModel();

        //Google Api Client Configuration
        $this->googleClient= new \Google_Client();
        $this->googleClient->setClientId("927791898420-e227o6kdp53pa85rlm7suveuij8af8nm.apps.googleusercontent.com");
        $this->googleClient->setClientSecret("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");
        $this->googleClient->setRedirectUri("http://localhost/loginapp/public/loginWithGoogle");
        $this->googleClient->addScope("profile");
        $this->googleClient->addScope("email");

        //Facebook Api Client Configuration
        $this->facebook = new \Facebook\Facebook([
            "app_id"=> "1228848804478410",
            'app_secret' => "d4d7ac1dcd706a5c89b7c5575361695b",
            "default_graph_version"=>"v2.3"
        ]);
        $this->fbHelper = $this->facebook->getRedirectLoginHelper();

    }
    public function index()
    {
        //Check if the user is already logged in
        if(session()->get("User Data")){
			session()->setFlashData("Error", "You have Already Logged In");
            return redirect()->to(base_url()."public/profile");
		}

        // Create the google sign in link
        $data = array();
        $data['googleLink'] = '<a class = "text-reset text-decoration-none" href="'.$this->googleClient->createAuthUrl().'" >Sign In WIth Google</a>';
        session()->set("Google Login", $data['googleLink']);
        
        //Create facebook sign in link
        $fb_permission = ['email'];
        $data['facebookLink'] = $this->fbHelper->getLoginUrl("http://localhost/loginapp/public/loginWithFacebook?",$fb_permission);
        session()->set("Facebook Login", $data['facebookLink']);
        $data['errors'] = NULL;
        return view('login',$data);
    }

    // A display page
    public function profilePage(){
        if(!session()->get("User Data")){
			session()->setFlashData("Login Error", "Please Login Again!");
			return redirect()->to(base_url()."public");
		}
        return view("profile");
    }  

    //Login using the app's form
    public function loginWithForm(){
      
        $rules = [
            'email'         => 'required|min_length[6]|max_length[50]|valid_email',
            'password'      => 'required|min_length[6]|max_length[200]',
        ];

        if($this->validate($rules)){
            $email = $this->request->getVar("email");
            $password = $this->request->getVar("password");
            $responseData = $this->userModel->getUser($email);
            // echo "<pre/>";print_r($responseData);die;
            if($responseData){
                $dbPassword = $responseData['password'];
                $passwordVerification = password_verify($password,$dbPassword );
                if($passwordVerification){

                    $fullName = $responseData['first_name'] . " " . $responseData['last_name'];
                    $userData = [
                        "oauth_id" => $responseData['oauth_id'],
                        "full_name" => $fullName,
                        "email" => $responseData['email']
                    ];
                    session()->set("User Data", $userData);
                    return redirect()->to(base_url()."public/profile");
                }else{
                    session()->setFlashdata('msg', 'Wrong Password');
                    return redirect()->to(base_url()."public/login");
                }
            }else{
                session()->setFlashdata('msg', 'Email not Found');
                return redirect()->to(base_url()."public/login");
            }

        }else{
            $data['errors'] = $this->validator->getErrors();
            session()->setFlashdata("errors", $data['errors']);
            return redirect()->to(base_url()."public/login")->withInput();
  
        
        }
    }


    



    
    
    // Google login function (API redirects here)
    public function loginWithGoogle(){
        
            //Get access token from google
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar("code"));
        if(!isset($token['error'])){
            $this->googleClient->setAccessToken($token['access_token']);
            session()->set("Access Token", $token['access_token']);

                // Initialize a new Google oauth2 service with the config
            $googleServices = new \Google_Service_Oauth2($this->googleClient);
            // Get the data
            $data = $googleServices->userinfo->get();

            //This is what gets inserted in db
            $userData  = array();

            // If user is already registered just update the details
            if($this->userModel->isAlreadyRegistered($data['id'])){

                    $userData = [
                            "first_name" => $data['givenName'],
                            "last_name" => $data['familyName'],
                            "email" => $data['email'],
                            

                    ];
                    $this->userModel->updateRecord($userData,$data['id']);

                    //else create a new record and insert
            }else{
                $userData = [
                    "oauth_id" => $data['id'],
                    "first_name" => $data['givenName'],
                    "last_name" => $data['familyName'],
                    "email" => $data['email'],
                    "password"=> "GoogleClient",

                ];
                $this->userModel->insertRecord($userData);
            }
            $userData['oauth_id'] = $data['id'];
            $userData['full_name'] = $data['givenName'] . " " . $data['familyName']; 
            //set userdata in session for later use
            session()->set("User Data", $userData);
            
        }else{ // if google sends error token
            session()->setFlashdata("Login Error","Something went wrong!");
            return redirect()->to(base_url()."public");
        }

        //Login Succesful
        return redirect()->to(base_url()."public/profile");
       

    }



    // Facebook login function(API redirects here)

    public function loginWithFacebook(){
        // app id 1228848804478410
        //app secret d4d7ac1dcd706a5c89b7c5575361695b
        if($this->request->getVar('state')){
			$this->fbHelper->getPersistentDataHandler()->set('state', $this->request->getVar('state'));
		}
            if($this->request->getVar("code")){
                if((session()->get("Access Token"))){
                    $token = session()->get("Access Token");
                }else{
                    $token = $this->fbHelper->getAccessToken();
                    session()->set("Access Token", $token);
                    $this->facebook->setDefaultAccessToken($token);
                }
                $response = $this->facebook->get('/me?fields=email,name', $token);
                $userInfo = $response->getGraphUser();
                $nameSplitArray = explode(" ", $userInfo['name']);
                if($this->userModel->isAlreadyRegistered($userInfo['id'])){

                    $userInfo['email']?$userEmail = $userInfo['email'] : $userEmail = "facebooklogin";

                    $userData = [
                            "first_name" => $nameSplitArray[0],
                            "last_name" => $nameSplitArray[1],
                            "email" => $userEmail,
                            

                    ];
                    $this->userModel->updateRecord($userData,$userInfo['id']);

                    //else create a new record and insert
            }else{
                $userInfo['email']?$userEmail = $userInfo['email'] : $userEmail = "facebooklogin";
                $userData = [
                    "oauth_id" => $userInfo['id'],
                    "first_name" => $nameSplitArray[0],
                    "last_name" => $nameSplitArray[1],
                    "email" => $userEmail,
                    "password"=> "FaceboookClient",

                ];
                $this->userModel->insertRecord($userData);
            }
            $userData['full_name'] = $userInfo['name']; 
            //set userdata in session for later use
            session()->set("User Data", $userData);
                
            }else{
                session()->setFlashdata("Login Error","Something went wrong!");
            return redirect()->to(base_url()."public");
            }
            //Login Succesful
        return redirect()->to(base_url()."public/profile");
        }


    

    //Logout Function
    public function logout(){
        //Remove token and userdata
        session()->remove("User Data");
        session()->remove("Access Token");

        //Check if it was successful
        if(!session()->get("User Data") && !session()->get("Access Token")){
            session()->setFlashdata("Login Error","Successfully logged out");
            return redirect()->to(base_url()."public");
        }else{
            session()->setFlashdata("Error", "Logout Failed");
            return redirect()->to(base_url()."public/profile");
        }
    }
}

