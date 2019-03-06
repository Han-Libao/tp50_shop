<?php
namespace app\admin\controller;

use \think\Controller,\think\Request;

Class Category extends Controller
{
	public function categoryList()
	{
		$data = model('Category')->select();
		//$data = $data->toArray();
		$data = $this->getInfo($data);
		foreach($data as $k=>$v){
            echo $v['cate_id']."--".$v['cate_name']."--".$v['pid'];
            echo '<br>';
        }
		$this->assign('data',$data);
		//return $this->fetch();
	}

	public function getInfo($cateInfo,$pid=0,$level=0){
	    static $info=[];
	    foreach($cateInfo as $k=>$v){
	        if($v['pid']==$pid){
	            $v['level']=$level;
	            $info[]=$v;
	            $this->getInfo($cateInfo,$v['cate_id'],$v['level']+1);
	        }
	    }
	    return $info;

	}
}