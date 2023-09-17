<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PaymentModel;

class Payment extends BaseController{
    private $paymentModel = NULL;
    function __construct() {
        $this->paymentModel = new PaymentModel();

    }
    public function index(){
        $formInputs = [
            'scd' => "EPAYTEST",
            'su' => "http://localhost/loginapp/public/verify?q=su",
            'fu' => "http://localhost/loginapp/public/verify?q=fu",
            'pid' => bin2hex(random_bytes(16)),
            'amt' => 90,
            'txAmt' => 3,
            'psc' => 2,
            'pdc' => 5,
            'tAmt' => 100,
        ];
        $currentUserData = session()->get("User Data");
        $userDetails = [
            'oauth_id'=>$currentUserData['oauth_id']?? "1234",
            'full_name'=>$currentUserData['full_name'],
            'email'=>$currentUserData['email'],
            'pid'=>$formInputs['pid'],
            'status'=>false,
        ];
        $this->paymentModel->insertRecord($userDetails);
        $htmlForm = '<form method="POST" action="https://uat.esewa.com.np/epay/main" id="esewa-form">';

        foreach ($formInputs as $name => $value):
            $htmlForm .= sprintf('<input name="%s" type="hidden" value="%s">', $name, $value);
        endforeach;

        $htmlForm .= '</form><script type="text/javascript">document.getElementById("esewa-form").submit();</script>';
      
        echo $htmlForm;
    }

    public function verify(){
        require_once APPPATH."libraries/vendor/autoload.php";
        
        $client = new \GuzzleHttp\Client([
            'base_uri' => "https://uat.esewa.com.np",
            'http_errors' => false,
            'headers' => [
                'User-Agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'Accept' => 'application/xml',
            ],
            'allow_redirects' => [
                'protocols' => ['https'],
            ],
        ]);
        $pid = $this->request->getVar("oid");
   
        $request = $client->post('/epay/transrec', [
            'form_params' => [
                'scd' => "EPAYTEST",
                'rid' => $this->request->getVar("refId"),
                'pid' => $this->request->getVar("oid"),
                'amt' => $this->request->getVar("amt"),
            ],
        ]);

        // grab response and parse the XML
        $response = $this->parseXml($request->getBody()->getContents());


        // check for "success" or "failure" status
        if(strtolower($response) === 'success'){
            $data['pid'] = $pid;
            $this->paymentModel->updateStatus($pid);
            return view("success",$data);
        }else{
            return view("failure");
        }
    }

    /**
     * This method parse XML string and return the object.
     */

    
    private function parseXml(string $xmlStr): string
    {
        // Load the XML string
        $xml = simplexml_load_string($xmlStr);
        // extract the value
        return trim((string)$xml->response_code);
    }
}