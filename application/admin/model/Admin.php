<?php
namespace app\admin\model;

use think\Model;
class Admin extends Model
{
	//protected $pk = 'id'; 
	/*public function check($name)
	{
		//$data = $this->where('admin_name',$name)->find();
		//
		$data = $this->get(1);
		echo $this->getLastSql();
		return $data;
	}*/
	public $insert = ['admin_salt'];
	public $readonly = ['admin_name','admin_salt'];
	public $salt;

	public function setAdminPwdAttr($value){
		$this->salt = createSalt();
		return createPwd($value,$this->salt);
	}

	public function setAdminSaltAttr(){
		return $this->salt;
	}

	public function getStatusAttr($value)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$value];
    }
}