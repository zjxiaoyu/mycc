<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model
{
    //允许接受的字段
    protected $insertFields = 'cate_name,parent_id';
    //验证的规则
    protected $_validate = array(
        array('cate_name','require','分类名称不能为空',1),
    );
    //获得树状的结构
    public function gettree()
    {
        $data=$this->select();
        return $this->_getTree($data);
    }
    //递归调用
    private function _getTree($data,$parent_id=0,$level=0)
    {
        static $_ret=array();
        foreach ($data as $k=>$v)
        {
            if($v['parent_id']==$parent_id)
            {
                $v['level']=$level;
                $_ret[]=$v;
                $this->_getTree($data,$v['id'],$level+1);
            }

        }
        return $_ret;
    }

    public function getChildren($catId)
    {
        $data=$this->select();
        return $this->_getChildren($data,$catId,true);
    }
    //筛选子分类 加一个状态 每次第一次进入去除以前的结果
    private function _getChildren($data,$catId,$isClear=false)
    {
        static $_ret=array();
        if($isClear)
        {
            $_ret=array();
        }
        foreach($data as $k=>$v)
        {
            if($v['parent_id']==$catId)
            {
                $_ret[]=$v['id'];
                $this->_getChildren($data,$v['id']);
            }
        }
        return $_ret;
    }
    protected function _before_delete($option)
    {
        $Children=$this->getChildren($option['where']['id']);
       if($Children)
        {
            $Children=implode(',',$Children);
            $this->execute("delete from jxshop_category where id IN ($Children)");
        }

    }
}

