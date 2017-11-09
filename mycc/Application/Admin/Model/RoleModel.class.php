<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名不能为空！', 1, 'regex', 3),
		array('role_name', '1,30', '角色名的值最长不能超过 30 个字符！', 1, 'length', 3),
	);
	public function search($pageSize = 2)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($role_name = I('get.role_name'))
			$where['role_name'] = array('like', "%$role_name%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')
            ->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')
            ->join('LEFT JOIN jxshop_pri_role b ON a.id=b.role_id LEFT JOIN jxshop_privilege c ON b.pri_id=c.id')
            ->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
	    $pid=I('post.pri_id');
        $model=M('pri_role');
        $model->where(array(
            'role_id'=>array('eq',$option['where']['id'])
        ))->delete();
        if($pid)
        {

            foreach ($pid as $k=>$v)
            {
                $model->add(array(
                   'role_id'=>$option['where']['id'],
                    'pri_id'=>$v
                ));
            }
        }
	}
	//添加后
	protected function _after_insert($data, $options)
    {
        $pid=I('post.pri_id');
        if($pid)
        {
            foreach ($pid as $k=>$v)
            {
                $model=M('pri_role');
                $model->add(array(
                    'role_id'=>$data['id'],
                    'pri_id'=>$v
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
        $model=M('pri_role');
        $model->where(array(
            'role_id'=>array('eq',$option['where']['id'])
        ))->delete();
	}
	/************************************ 其他方法 ********************************************/
}