<?php
namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model 
{
	protected $insertFields = array('pri_name','module_name','controller_name','action_name','parent_id');
	protected $updateFields = array('id','pri_name','module_name','controller_name','action_name','parent_id');
	protected $_validate = array(
		array('pri_name', 'require', '权限名称不能为空！', 1, 'regex', 3),
		//array('module_name', 'require', '模块名不能为空！', 1, 'regex', 3),
		array('module_name', '0,60', '模块名的值最长不能超过 60 个字符！', 1, 'length', 3),
		//array('controller_name', 'require', '控制器名不能为空！', 1, 'regex', 3),
		array('controller_name', '0,60', '控制器名的值最长不能超过 60 个字符！', 1, 'length', 3),
		//array('action_name', 'require', '方法名不能为空！', 1, 'regex', 3),
		array('action_name', '0,60', '方法名的值最长不能超过 60 个字符！', 1, 'length', 3),
		array('parent_id', 'require', '上一级权限不能为空！', 1, 'regex', 3),
		array('parent_id', 'number', '上一级权限必须是一个整数！', 1, 'regex', 3),
	);
	/************************************* 递归相关方法 *************************************/
	public function getTree()
	{
		$data = $this->select();
		return $this->_reSort($data);
	}
	private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$ret[] = $v;
				$this->_reSort($data, $v['id'], $level+1, FALSE);
			}
		}
		return $ret;
	}
	public function getChildren($id)
	{
		$data = $this->select();
		return $this->_children($data, $id);
	}
	private function _children($data, $parent_id=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['id'];
				$this->_children($data, $v['id'], FALSE);
			}
		}
		return $ret;
	}
	/************************************ 其他方法 ********************************************/
	public function _before_delete($option)
	{
		// 先找出所有的子分类
		$children = $this->getChildren($option['where']['id']);
		// 如果有子分类都删除掉
		if($children)
		{
			$children = implode(',', $children);
			$this->execute("DELETE FROM jxshop_privilege WHERE id IN($children)");
		}
		$model=M('pri_role');
        $model->where(array(
            'pri_id'=>$option['where']['id']
        ))->delete();
	}
}