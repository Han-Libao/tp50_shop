<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//生成盐值
function createSalt(){
    $str='0123456789asdhfgk=+-*//';
    return substr(str_shuffle($str),rand(1,25),6);
}

//生成密码
function createPwd($pwd,$salt){
    return md5(md5($pwd).md5($salt).'shop');
}

function getInfo($cateInfo,$pid=0,$level=0){
    static $info=[];
    foreach($cateInfo as $k=>$v){
        if($v['pid']==$pid){
            ///$v['level']=$level;
            $info[]=$v;
            getInfo($cateInfo,$v['cate_id'],$v['level']+1);
        }
    }
    return $info;
}