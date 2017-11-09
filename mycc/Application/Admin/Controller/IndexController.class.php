<?php
namespace Admin\Controller;
class IndexController extends BaseController {
    public function index()
    {
        $this->display();
    }
    public function top()
    {
        $this->display();
    }
    public function menu()
    {
        $adminmodel=D('admin');
        $pridata=$adminmodel->chk_two();
        $this->assign('pridata',$pridata);
        $this->display();
    }
    public function main()
    {
        $this->display();
    }

}