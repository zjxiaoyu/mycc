<?php
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model 
{
	protected $insertFields = array('attr_name','attr_type','attr_type_value','type_id');
	protected $updateFields = array('id','attr_name','attr_type','attr_type_value','type_id');
	protected $_validate = array(
		array('attr_name', 'require', '属性名不能为空！', 1, 'regex', 3),
		array('attr_name', '1,60', '属性名的值最长不能超过 60 个字符！', 1, 'length', 3),
		array('attr_type', '可选,唯一', "属性类型的值只能是在 '可选,唯一' 中的一个值！", 2, 'in', 3),
		array('attr_type_value', '1,120', '可选的值的值最长不能超过 120 个字符！', 2, 'length', 3),
		array('type_id', 'require', '类型id不能为空！', 1, 'regex', 3),
		array('type_id', 'number', '类型id必须是一个整数！', 1, 'regex', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($attr_name = I('get.attr_name'))
			$where['attr_name'] = array('like', "%$attr_name%");
		$attr_type = I('get.attr_type');
		if($attr_type != '' && $attr_type != '-1')
			$where['attr_type'] = array('eq', $attr_type);
		if($type_id = I('get.type_id'))
			$where['type_id'] = array('eq', $type_id);
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
        $data['attr_type_value']=str_replace('，',',',$data['attr_type_value']);
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
        $data['attr_type_value']=str_replace('，',',',$data['attr_type_value']);
	}
	// 删除前
	protected function _before_delete($option)
	{
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	/************************************ 其他方法 ********************************************/
}