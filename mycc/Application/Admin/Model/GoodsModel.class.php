<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model
{
    //列表展示
    public function search()
   {
       /*******搜索功能*****/
       $where=array();
       if($gn=I('get.gn'))
       {
           $where['goods_name'] = array('like',"%$gn%");
       }
       $fp=I('get.fp');
       $tp=I('get.tp');
       if($fp&&$tp)
       {
           $where['shop_price']=array('between',array($fp,$tp));
       }elseif($fp)
       {
           $where['shop_price']=array('egt',$fp);
       }elseif($tp)
       {
           $where['shop_price']=array('elt',$tp);
       }
       $ios=I('get.ios');
       if($ios=='是'||$ios=='否')
       {
           $where['is_on_sale']=array('eq',$ios);
       }
       //分类搜索
        $cat_id=I('get.cat_id');
        if($cat_id)
        {
            $catmodel=D('category');
            $children=$catmodel->getChildren($cat_id);
            $children[]=$cat_id;
            $chi=implode(',',$children);
            $goodsmodel=M('goods_cat');
            $ext_goods_id=$goodsmodel->field('GROUP_CONCAT(goods_id) gid')->where(array(
                'cat_id'=>array('in',$chi)
            ))->find();

            if($ext_goods_id['gid'])
            {
                $ext_id=$ext_goods_id['gid'];
                $or="or id IN ($ext_id)";
            }else
                $or='';

            $where['cat_id']=array('exp',"IN ($chi) $or ");
        }

       /*******分页*****/
       $count      = $this->where($where)->count();
       $Page       = new \Think\Page($count,2);
       $show       = $Page->show();// 分页显示输出

    $data=$this->where($where)->order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    return array(
        'data'=>$data,
        'show'=>$show,
    );
   }

    //允许接受的字段
   protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc,cat_id,type_id';
    //验证的规则
   protected $_validate = array(
       array('goods_name','require','商品名称不能为空',1),
       array('market_price','currency','价格为货币类型',1),
       array('shop_price','currency','价格为货币类型',1),
       array('cat_id','require','主分类不能为空',1),
   );

    protected function _after_insert($data, $options)
    {
        //处理商品属性
        $model_goods_attr=M('goods_attr');
        $goodsId=$data['id'];
        $attr_id=I('post.attr_id');
        $goods_attr=I('post.goods_attr');
        if($attr_id)
        {
            foreach ($attr_id as $k=>$v)
            {
                $model_goods_attr->add(array(
                    'id'=>$goodsId,
                     'attr_id'=>$v,
                    'attr_value'=>$goods_attr[$k]
                ));
            }
        }

        //处理拓展分类
        $ext_cat_id=I('post.ext_cat_id');
        $model=M('goods_cat');
        foreach ($ext_cat_id as $v)
        {
            //处理空的拓展分类
            if(empty($v))
                continue;
            $model->add(array(
                'goods_id'=>$data['id'],
                'cat_id'=>$v
            ));
        }

    }

    protected function _before_insert(&$data,$option)
   {
       $data['addtime'] = time();
       $data['goods_desc'] = clearXSS($_POST['goods_desc']);
       if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
           //上传
           $upload = new \Think\Upload();// 实例化上传类
           $upload->maxSize = 2 * 1024 * 1024;// 设置附件上传大小
           $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
           $upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
           $upload->savePath = 'Goods/'; // 设置附件上传（子）目录
           // 上传文件
           $info = $upload->upload();
           if (!$info) {// 上传错误提示错误信息
               $this->error = $upload->getError();
               return false;
           } else {
               //图片处理
               $image = new \Think\Image();
               $savename = $info['logo']['savename'];
               $savepath = $info['logo']['savepath'];
               $logo = $savepath . $savename;
               $mid_logo= $savepath . mid_ . $savename;
               $sm_logo =$savepath . sm_ . $savename;
               $image->open('./Public/Uploads/' . $logo);
               $image->thumb(300, 300)->save('./Public/Uploads/' . $mid_logo);
               $image->thumb(150, 150)->save('./Public/Uploads/' . $sm_logo);
               $data['logo'] = $logo;
               $data['mid_logo'] = $mid_logo;
               $data['sm_logo'] = $sm_logo;

           }
       }
   }

       protected function _before_update(&$data,$option)
   {
       //处理属性

       $model_goods_attr=M('goods_attr');
       $model_goods_attr->delete($option['where']['id']);

           $attr_id=I('post.attr_id');
           $goods_attr=I('post.goods_attr');
           if($attr_id)
           {
               foreach ($attr_id as $k=>$v)
               {
                   $model_goods_attr->add(array(
                       'id'=>$option['where']['id'],
                       'attr_id'=>$v,
                       'attr_value'=>$goods_attr[$k]
                   ));
               }
           }


      //拓展分类处理
       $model=M('goods_cat');
       $ext_cat_id=I('post.ext_cat_id');
       $model->where(array(
           'goods_id'=>array('eq',$option['where']['id'])
       ))->delete();


       foreach ($ext_cat_id as $v)
       {
           //处理空的拓展分类
           if(empty($v))
               continue;
           $model->add(array(
               'goods_id'=>$option['where']['id'],
               'cat_id'=>$v
           ));
       }
       $data['goods_desc'] = clearXSS($_POST['goods_desc']);
       if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
           //上传
           $upload = new \Think\Upload();// 实例化上传类
           $upload->maxSize = 2 * 1024 * 1024;// 设置附件上传大小
           $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
           $upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
           $upload->savePath = 'Goods/'; // 设置附件上传（子）目录
           // 上传文件
           $info = $upload->upload();
           if (!$info) {// 上传错误提示错误信息
               $this->error = $upload->getError();
               return false;
           } else
           {
               //图片处理
               $image = new \Think\Image();
               $savename = $info['logo']['savename'];
               $savepath = $info['logo']['savepath'];
               $logo =  $savepath . $savename;
               $mid_logo =  $savepath . mid_ . $savename;
               $sm_logo =  $savepath . sm_ . $savename;
               $image->open('./Public/Uploads/' .$logo);
               $image->thumb(300, 300)->save('./Public/Uploads/' .$mid_logo);
               $image->thumb(150, 150)->save('./Public/Uploads/' .$sm_logo);
               $data['logo'] = $logo;
               $data['mid_logo'] = $mid_logo;
               $data['sm_logo'] = $sm_logo;
               //删除老图片
               $oldlogo=$this->field('logo,sm_logo,mid_logo')->find($option['where']['id']);
               //$oldsm_logo=$this->field('sm_logo')->find($option['where']['id']);
              //$oldmd_logo=$this->field('mid_logo')->find($option['where']['id']);
               is_file('./Public/Uploads/'.$oldlogo['logo'])?unlink('./Public/Uploads/'.$oldlogo['logo']):'';
               is_file('./Public/Uploads/'.$oldlogo['sm_logo'])?unlink('./Public/Uploads/'.$oldlogo['sm_logo']):'';
               is_file('./Public/Uploads/'.$oldlogo['mid_logo'])?unlink('./Public/Uploads/'.$oldlogo['mid_logo']):'';

           }
       }

   }

   protected function _before_delete($options)
   {
     //删除老的图片
       $oldlogo=$this->field('logo,sm_logo,mid_logo')->find($options['where']['id']);
       is_file('./Public/Uploads/'.$oldlogo['logo'])?unlink('./Public/Uploads/'.$oldlogo['logo']):'';
       is_file('./Public/Uploads/'.$oldlogo['sm_logo'])?unlink('./Public/Uploads/'.$oldlogo['sm_logo']):'';
       is_file('./Public/Uploads/'.$oldlogo['mid_logo'])?unlink('./Public/Uploads/'.$oldlogo['mid_logo']):'';
       //删除拓展表
       $model=M('goods_cat');
       $model->where(array(
           'goods_id'=>array('eq',$options['where']['id'])
       ))->delete();
   }

}

