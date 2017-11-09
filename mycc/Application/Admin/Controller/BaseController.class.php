<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller
{
 public function __construct()
 {
     parent::__construct();
     $id=session('id');
     if(!$id)
     {
         $this->error('必须先登陆',U('admin/login/login'));
     }

     //验证权限

     $adminmodel=D('admin');
     if(!$adminmodel->chk_pri())
     {
         $this->error('没有权限');
     }
 }


}