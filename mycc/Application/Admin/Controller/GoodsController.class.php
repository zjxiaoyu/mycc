<?php
namespace Admin\Controller;
class GoodsController extends BaseController {
    public function ajaxGetAttr()
    {
        $type_id=I('get.type_id');
        $attr_model=M('attribute');
        $attrdata=$attr_model->where(array(
            'type_id'=>array('eq',$type_id)
        ))->select();
        echo json_encode($attrdata);
    }
    //添加
    public function add()
    {
       if(IS_POST)
        {
           //生成模型
            $model=D('Goods');
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

       }else
           {
               $model=D('Category');
               $data=$model->gettree();

               $typemodel=M('type');
               $typedata=$typemodel->select();

               $this->assign(array(
                   'typedata'=>$typedata,
                   'data'=>$data,
                   '_page_tile'=>'添加商品',
                   '_page_btn_name'=>'商品列表',
                   '_page_btn_link'=>U('lst'),
               ));
               $this->display();
           }

    }

    public function lst()
    {
        $model=D('Goods');
        $data=$model->search();
        $catmodel=D('category');
        $cat=$catmodel->gettree();
        $this->assign('data',$data['data']);
        $this->assign('show',$data['show']);
        $this->assign(array(
            'cat'=>$cat,
            '_page_tile'=>'商品列表',
            '_page_btn_name'=>'添加商品',
            '_page_btn_link'=>U('add'),
        ));
        $this->display();
        /*echo MODULE_NAME;
        echo '</br>';
        echo CONTROLLER_NAME;
        echo '</br>';
        echo ACTION_NAME;*/
    }
    //修改
    public function edit()
    {
        if(IS_POST)
        {
            //生成模型
            $model=D('Goods');
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
        $model=M('Goods');
        $info=$model->find($id);
        $this->assign('info',$info);
        /*$where=array();
        $where['id']=array('eq',$id);
        $data=$model->where($where)->find();*/

         //商品属性表数据
       /* $model_goods=M('goods_attr');
        $goods_attr=$model_goods->where(array(
            'id'=>array('eq', $id)
        ))->select();*/

        //属性表数据
        $model_attr=M('attribute');
        $attr_data=$model_attr->alias('a')
        ->join("left join jxshop_goods_attr b on (a.id=b.attr_id )")
        ->where(array(
            'b.id'=>array('eq',$id),
           'a.type_id'=>array('eq',$info['type_id'])
        ))->select();

        $this->assign('attr_data', $attr_data);

        $typemodel=M('type');
        $typedata=$typemodel->select();

        $model_cat=M('goods_cat');
        $good_cat=$model_cat->where(array(
            'goods_id'=>array('eq',$id)
        ))->select();
        $cat=D('category');
        $cat_id=$cat->gettree();
        $this->assign(array(
            'typedata'=>$typedata,
            'cat_id'=>$cat_id,
            'good_cat'=>$good_cat,
            '_page_tile'=>'商品修改',
            '_page_btn_name'=>'商品列表',
            '_page_btn_link'=>U('lst'),
        ));

        $this->display();
    }
    //删除功能
    public function delete()
    {
        $id=I('get.id');
        $model=D('Goods');
        $info=$model->delete($id);
        if(false!==$info){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }


    }

}