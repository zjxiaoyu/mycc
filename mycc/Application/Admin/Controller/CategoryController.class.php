<?php
namespace Admin\Controller;
class CategoryController extends BaseController {
    //添加
    public function add()
    {
       if(IS_POST)
        {
           //生成模型
            $model=D('Category');
            if($model->create(I('post.'),1))
            {
              if($model->add())
              {
                  $this->success('添加成功',U('lst'),3);
                  exit;
              }

            }
            $error=$model->getError();
            $this->error($error);

       }else{
           $model=D('Category');
           $data=$model->gettree();
               $this->assign(array(
                   'data'=>$data,
                   '_page_tile'=>'添加分类',
                   '_page_btn_name'=>'分类列表',
                   '_page_btn_link'=>U('lst'),
               ));
           $this->display();
       }




    }
    //列表
    public function lst()
    {
        $model=D('Category');
        $data=$model->gettree();
        $this->assign('data',$data);
        $this->assign(array(
            '_page_tile'=>'分类列表',
            '_page_btn_name'=>'添加分类',
            '_page_btn_link'=>U('add'),
        ));
        $this->display();
    }
    //修改
    public function edit()
    {
        if(IS_POST)
        {
            //生成模型
            $model=D('Category');
            if($model->create(I('post.'),2))
            {
                //数据不变返回0否则是false
                if(false!==$model->save())
                {
                    $this->success('修改成功',U('lst'),3);
                    exit;
                }

            }
            $error=$model->getError();
            $this->error($error);

        }
        $id=I('get.id');
        $model=D('Category');
        /*$where=array();
        $where['id']=array('eq',$id);
        $data=$model->where($where)->find();*/
        $info=$model->find($id);
        $data=$model->gettree();
        $children= $model->getChildren($id);
        $this->assign('info',$info);
        $this->assign(array(
            'children'=>$children,
            'data'=>$data,
            '_page_tile'=>'分类修改',
            '_page_btn_name'=>'分类列表',
            '_page_btn_link'=>U('lst'),
        ));
        $this->display();
    }
    //删除功能
    public function delete()
    {
        $id=I('get.id');
        $model=D('Category');
        $info=$model->delete($id);
        if(false!==$info){
            $this->success('删除成功',U('lst'),100);
        }else{
            $this->error('删除失败');
        }


    }

}