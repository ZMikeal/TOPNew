<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class PlandqController extends BaseController {
    public function _initialize(){
       if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
     if(session('admin.id_level')!=6){
          $this->redirect('plan/index');
          exit;
        }
    }
   

    public function index(){
      $this->display();
    }
    //党群分
    public function dqgrade(){
      $search=I("post.search");
      if($search==null){
        $data="";
      }
      else{
        $data=M('gradequarter_dq')->where($search)->select();
      }
      $this->assign('data',$data);
      $this->assign('search',$search);
      $this->display();
    }
    //获取人员信息
    public function getinformation(){
      $employee=I('post.employee');
      $data=M('info_admin')->where("id_employee = 3171")->getField('id_employee,username,user_department,user_office');
      $this->ajaxReturn(array('success'=>1,'nam'=>$data[$employee]['username'],'department'=>$data[$employee]['user_department'],'office'=>$data[$employee]['user_office']),"json");
    }
    //修改党群成绩分数
    public function dqgradesub(){
      $data=I('post.');
      foreach ($data as $k => $v) {
        if($v['id_employee']!=null&&$v['grade']!=null){
          $this->model=D('gradequarter_dq');
          $v['year']=session('admin.year_sys');
          $result=$this->model->where("id_employee = ".$v['id_employee'])->find();
          if($result!=null){
            if($this->model->create($v))
            {
              $this->model->where("id_employee = ".$v['id_employee'])->save();
            }
          }
          else{
            if($this->model->create($v))
            {
              $this->model->add();
            }
          } 
        }
      }
      $this->ajaxReturn(array('success'=>1),"json");
    }
    //删除成绩
    public function delet_dqgrade(){
      $id=I('post.id');
      $resule=M('gradequarter_dq')->where("id={$id}")->delete();
      $this->ajaxReturn(array('success'=>1),"json");
    }
}