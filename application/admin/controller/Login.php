<?php
namespace app\admin\controller;

use think\Controller,think\Request,app\admin\model\Admin;

class Login extends Controller
{
	protected $m;
	protected $rq;
	public function _initialize(){
		parent::_initialize();
		$this->m = new Admin;
		$this->rq = Request::instance();
	}
	public function login()
	{
		if($this->rq->isPost()){
			$data = $this->rq->only(['password','name','verity'],'post');
			/*if(!captcha_check($data['verity'])){
				$this->error('验证码错误！');
			}*/
			$where = ['admin_name'=>$data['name']];
			if($infoObj = $this->m->where($where)->find()){
				$info = $infoObj->toArray();
			}
			if(empty($info)){
				$this->error('账户密码不正确！1');
			}
			//var_dump($info);
			$pwd = createPwd($data['password'],$info['admin_salt']);
			
			if($info['admin_pwd'] !== $pwd)
			{
				$this->error('账户密码不正确！！2');
			}else{
				// 存储session信息
				// $admin=['admin_id'=>$admin_info['admin_id'],'admin_name'=>$admin_info['admin_name']];
                session('admin',$info);
                //修改最后一个登录的时间和ip;
                $arr=[
                    'last_login_ip'=>request()->ip(),
                    'last_login_time'=>time()
                ];

                $update_where=['admin_id'=>$info['admin_id']];
                model('Admin')->where($update_where)->update($arr);
                $this->success('登陆成功','index/index');
			}
		}else{
			$this->view->engine->layout(false); //不使用layout模式
			return $this->fetch('login');
		}
	}
}