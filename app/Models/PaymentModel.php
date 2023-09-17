<?php

namespace App\Models;
use CodeIgniter\Model;

class PaymentModel extends Model{

    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $DBGroup = 'default';
    protected $allowedFields = ['oauth_id', 'full_name', 'email', 'pid', 'status', 'created_at', 'updated_at'];

public function insertRecord($paymentDetails){

    $this->db->table('order')->insert($paymentDetails);

}
public function updateStatus($id){
    $this->db->table('order')->where(['pid' => $id ])->update(["status"=>true]);
}


}