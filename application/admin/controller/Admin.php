<?php
namespace app\admin\Controller;

use think\Controller,think\Request,think\Db;

class Admin extends Controller
{
	protected $rq;
	public function _initialize()
	{
		$this->rq = Request::instance();
	}
	public function admin_list()
	{
		//echo 1;
		return $this->fetch();
	}

	public function admin_info(){
		$p = input('get.page');
		if (empty($p)) {
            exit('非法操作此页面');
        }
        $page_num = input('get.limit');
        if (empty($page_num)) {
            exit('非法操作此页面');
        }
        $admin_info = model('Admin')->page($p,$page_num)->select();
        $count = model("Admin")->count();

        $info= ['code' => '0', 'msg' => '', 'count' => $count, 'data' => $admin_info];

        echo json_encode($info);
	}

	public function admin_add(){
		if($this->rq->isPost() && $this->rq->isAjax()){
			$data = input('post.');
			/*$salt = createSalt();
			$data['admin_pwd'] = createPwd($data['admin_pwd'],$salt);*/
			$add = model('Admin')->allowField(true)->save($data);
			//echo model('Admin')->getLastSql();
			if($add){
				echo json_encode(['font'=>'成功','code'=>200]);
			}else{
				echo json_encode(['font'=>'失败','code'=>400]);
			}
		}else{
			return $this->fetch();
		}
	}
}