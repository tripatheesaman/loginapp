<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $DBGroup = 'default';
    protected $allowedFields = ['oauth_id', 'first_name', 'last_name', 'email', 'password', 'created_at', 'updated_at'];

      // Check if the user is already registered
    public function isAlreadyRegistered($auth_id){
      
        $result = $this->db->table('user')->getWhere(['oauth_id'=>$auth_id])->getRowArray();
        $result>0?$status = true:$status = false;
        return $status;

    }

    // Insert user data
    public function insertRecord($userData){
        $this->db->table('user')->insert($userData);

    }

    // Update previously stored record to new ones
    public function updateRecord($userData, $authId){
        $this->db->table('user')->where(['oauth_id' => $authId ])->update($userData);

    }


    //Get user for login auth
    public function getUser($email){
        $userData = $this->db->table('user')->where('email', $email)->get()->getResultArray();

        return $userData[0] ?? false ;
    }


}