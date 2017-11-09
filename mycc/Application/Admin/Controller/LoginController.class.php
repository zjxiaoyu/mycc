<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller
{

    public function login()
    {
        if(IS_POST)
        {
            $model = D('Admin');
            if($model->validate($model->_login_validate)->create(I('post.')))
            {
                if($id = $model->login())
                {
                    $this->success('登陆成功', U('Admin/Index/index'));
                    exit;
                }
            }
            $this->error($model->getError());

        }
        $this->display();
    }
    public function code()
    {
        $config =    array(
            'fontSize'    =>    20,    // 验证码字体大小
            'length'      =>    2,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
}