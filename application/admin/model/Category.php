<?php
namespace app\admin\model;

use think\Model ,think\Db;

Class Category extends Model
{

	public $auto = ['level','path'];
	protected $autoWriteTimestamp = true;
	protected $createTime = 'cate_time';
	protected $updateTime = false;
	// public function setCreateTimeAttr()
	// {
	// 	return time();
	// }
	// 
	public function setLevelAttr()
	{
		$cate_id = request()->param('pid/d',0);
		if($cate_id==0)
		{
			return 0;
		}else{
			$where =['cate_id'=>$cate_id];
			$row = $this->where($where)->value('level');
			return ($row+1);
		}
	}

	public function setPathAttr()
	{
		$cate_id = request()->param('pid/d',0);
		if($cate_id==0){
			return '0';
		}else{
			$where =['cate_id'=>$cate_id];
			$row = $this->where($where)->value('path');
			return $row.",".$cate_id;
		}
	}
}