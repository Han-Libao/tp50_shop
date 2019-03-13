<?php
namespace app\admin\controller;

use \think\Controller,\think\Request;

Class Category extends Controller
{
	public function categoryList()
	{
		$data = model('Category')->select();
		//$data = $data->toArray();
		$data = getInfo($data);
		$this->assign('data',$data);
		/*foreach ($data as $value) {
			echo $value['cate_id']."--".$value['cate_name']."--".$value['level']."<br/>";
		}*/
		return $this->fetch();
	}

	public function changeCategory($cate_id)
	{
		if(request()->isAjax() && request()->isPost()){
			$data = input('post.');

			$this->checkCateName();
			$where = ['cate_id'=>$data['cate_id']];
			$status = model('Category')->save($data,$where);
			//echo json_encode($data);exit;
			if($status){
				echo json_encode(['font'=>'修改成功！','code'=>1]);
			}else{
				echo json_encode(['font'=>'修改失败！','code'=>0]);
			}
		}else{
			$data = model('Category')->select();
			$data = getInfo($data);
			$info = model('Category')->where('cate_id',$cate_id)->find();
			$this->assign('data',$data);
			$this->assign('info',$info);
			return $this->fetch();
		}
	}

	public function addCategory($pid=0)
	{
		if(request()->isAjax() && request()->isPost()){
			$data = input('post.');
			$this->checkCateName();
			$status = model('Category')->save($data);
			if($status){
				echo json_encode(['font'=>'添加成功！','code'=>1]);
			}else{
				echo json_encode(['font'=>'添加失败！','code'=>0]);
			}
		}else{
			$data = model('Category')->select();
			$data = getInfo($data);
			$this->assign('data',$data);
			$this->assign('pid',$pid);
			return $this->fetch();
		}
	}

	public function checkCateName()
	{
		$cate_name = input('post.cate_name');
		$where = ['cate_name'=>$cate_name];
		$res = model('Category')->where($where)->find();
		if(!empty($res)){
			echo json_encode(['font'=>'失败','code'=>400]);
			exit;
		}
		
	}

	
}