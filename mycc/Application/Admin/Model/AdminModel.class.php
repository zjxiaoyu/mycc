<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('username','password','code');
	protected $updateFields = array('id','username','password');

    //登陆验证规则
    public $_login_validate = array(
        array('username', 'require', '管理员不能为空！', 1),
        array('username', '1,30', '管理员的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('password', 'require', '密码不能为空！', 1),
        array('password', '1,32', '密码的值最长不能超过 32 个字符！', 1, 'length', 3),
        array('code', 'require', '验证码不能为空！', 1, 'regex', 3),
        array('code', 'code', '验证码不正确', 1, 'callback'),
    );

    protected function code($code, $id = '')
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
	protected $_validate = array(
		array('username', 'require', '管理员不能为空！', 1, 'regex', 3),
		array('username', '1,30', '管理员的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 3),
		array('password', '1,32', '密码的值最长不能超过 32 个字符！', 1, 'length', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
        $data['password']=md5($data['password']);
	}
	//添加后
    protected  function _after_insert($data, $options)
    {
       $rid=I('post.rid');
        $model=M('admin_role');
        foreach ($rid as $k=>$v)
        {
            $model->add(array(
                'admin_id'=>$data['id'],
                'role_id'=>$v
            ));
        }
    }

    // 修改前
	protected function _before_update(&$data, $option)
	{
        $data['password']=md5($data['password']);
	    $armodel=M('admin_role');
        $armodel->where(array(
            'admin_id'=>array('eq',$option['where']['id'])
        ))->delete();
       $rid=I('post.rid');
      if($rid)
        {
            foreach ($rid as $k=>$v)
            {
                $armodel->add(array(
                    'admin_id'=>$option['where']['id'],
                    'role_id'=>$v
                ));
            }
        }
	}
	// 删除前
	protected function _before_delete($option)
	{
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
		$model=M('admin_role');
        $model->where(array(
            'admin_id'=>array('eq',$option['where']['id'])
        ))->delete();
	}
	/************************************ 其他方法 ********************************************/
	public function login()
    {
        $username=$this->username;
        $password=$this->password;
        $res=$this->where(array(
            'username'=>array('eq',$username)
        ))->find();
        if($res)
        {
          if($res['password']==md5($password))
          {
              session('id',$res['id']);
              session('username',$res['username']);
              return true;
          }else
           {
               $this->error='密码错误';
               return false;
           }
        }else
        {
            $this->error='用户不存在';
            return false;
        }
    }

    //权限验证
    public function chk_pri()
    {

        if(CONTROLLER_NAME=='Index')
        {
            return true;
        }
        $id=session('id');
        if($id==1)
        {
            return true;
        }
        $id=session('id');
        $module=MODULE_NAME;
        $controller=CONTROLLER_NAME;
        $action=ACTION_NAME;
        $sql="select count(a.admin_id) has
                from jxshop_admin_role a 
                LEFT JOIN jxshop_pri_role b on a.role_id=b.role_id
                LEFT JOIN jxshop_privilege c on b.pri_id=c.id
                where a.admin_id=$id and c.module_name='$module' and c.controller_name='$controller' and c.action_name='$action'";
        $has = $this->query($sql);
        return ($has[0]['has']>0);

    }

    public function chk_two()
    {
        //根据id获取权限表的信息
        $id=session('id');
        $primodel=M('privilege');
        if($id==1)
        {
            $pridata=$primodel->select();
        }else{
            $sql="select c.*
                from jxshop_admin_role a 
                LEFT JOIN jxshop_pri_role b on a.role_id=b.role_id
                LEFT JOIN jxshop_privilege c on b.pri_id=c.id
                where a.admin_id=$id";
            $pridata=$primodel->query($sql);

        }
        $res=array();
        foreach($pridata as $k=>$v)
        {
            if($v['parent_id']==0)
            {

                foreach($pridata as $kk=>$vv)
                {
                    if($vv['parent_id']==$v['id'])
                    {
                        $v['children'][]=$vv;
                    }
                }
                $res[]=$v;
            }
        }
       return  $res;
    }
}