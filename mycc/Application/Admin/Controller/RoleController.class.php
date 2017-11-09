<?php
namespace Admin\Controller;
class RoleController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Role');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());

    	}
        $primodel=D('privilege');
        $pridata=$primodel->getTree();

		// 设置页面中的信息
		$this->assign(array(
		    'pridata'=>$pridata,
			'_page_title' => '添加角色表',
			'_page_btn_name' => '角色表列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Role');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Role');
    	$data = $model->find($id);
    	$this->assign('data', $data);


        $primodel=D('privilege');
        $pridata=$primodel->getTree();

        //获取中间表的数据
        $pr_ro_model=M('pri_role');
        $prid= $pr_ro_model->field('GROUP_CONCAT(pri_id) pid')->where(array(
            'role_id'=>array('eq',$id)
        ))->find();
        $pid=explode(',',$prid['pid']);
		// 设置页面中的信息
		$this->assign(array(
		    'pridata'=>$pridata,
            'pid'=>$pid,
			'_page_title' => '修改角色表',
			'_page_btn_name' => '角色表列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Role');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Role');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));
         //取出权限

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '角色表列表',
			'_page_btn_name' => '添加角色表',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }
}