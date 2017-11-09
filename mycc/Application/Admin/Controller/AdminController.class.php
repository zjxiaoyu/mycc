<?php
namespace Admin\Controller;
class AdminController extends BaseController
{


    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin');
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
    	//添加角色的功能
        $model_role=M('role');
        $rodata=$model_role->select();

		// 设置页面中的信息
		$this->assign(array(
		    'rodata'=>$rodata,
			'_page_title' => '添加管理员表',
			'_page_btn_name' => '管理员表列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }

    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Admin');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))),100);
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Admin');
    	$data = $model->find($id);
    	$this->assign('data', $data);

        $model_role=M('role');
        $rodata=$model_role->select();

        //获取admin_role数据
        $model_ad_ro=M('admin_role');
        $ro_ad=$model_ad_ro->field('GROUP_CONCAT(role_id) rid')->where(array(
            'admin_id'=>array('eq',$id)
        ))->find();
        $rid=explode(',',$ro_ad['rid']);
		// 设置页面中的信息
		$this->assign(array(
		    'rodata'=>$rodata,
            'rid'=>$rid,
			'_page_title' => '修改管理员表',
			'_page_btn_name' => '管理员表列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin');
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
    	$model = D('Admin');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '管理员表列表',
			'_page_btn_name' => '添加管理员表',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }

}