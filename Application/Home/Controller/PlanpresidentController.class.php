<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class PlanpresidentController extends BaseController {
    public function _initialize(){
       if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
     if(session('admin.id_level')!=10){
          $this->redirect('plan/index');
          exit;
        }
    }
   

    public function index(){
      $this->display();
    }
    //部门季度评级确认
    public function Departmental_quarterly_rating_confirmation(){
      $search=I('post.search');
      $tj['user_leader']=session('admin.username');
      $department=array_unique(M('info_admin')->where($tj)->getField('user_department',true));
      unset($tj['user_leader']);
      if($search!=null){
        $tj['year']=$search[0];
        $tj['quarter']=$search[1];
        $tj['department']=$search[2];
        $data['yes']=M('gradequarter_confirm')->where($tj)->where("if_grade = 1 and confirm_rate_minister != '无' and confirm_rate_president = '无'")->order('id')->select();
        $data['no']=M('gradequarter_confirm')->where($tj)->where("if_grade = 0 and confirm_rate_minister != '无' and confirm_rate_president = '无'")->order('id')->select();
        $id='';
        if($data['yes']==null){
           $data['yes']=M('gradequarter_confirm')->where($tj)->where("if_grade = 1 and confirm_rate_minister != '无' and confirm_rate_president != '无'")->order('id')->select();
           $data['no']=M('gradequarter_confirm')->where($tj)->where("if_grade = 0 and confirm_rate_minister != '无' and confirm_rate_president != '无'")->order('id')->select();
           $id=1;
        }
        $sum=M('ratequarter_minister')->where($tj)->find();
        $count=count($data['yes']);
        $this->assign('search',$search);
        $this->assign('data',$data);
        $this->assign('count',$count);
        $this->assign('id',$id);
        $this->assign('sum',$sum);
      }
      $this->assign('department',$department);
      $this->display();
    }
    //部门年度评级确认
    public function Departmental_annual_rating_confirmation(){
    }
    //修改评级等级
    public function mod(){
      $data=I('post.');
      $this->model=D('gradequarter_confirm');
      foreach ($data as $key => $value) {
        $value['confirm_rate_president']=session('admin.username');
        if($this->model->create($value)){
          $this->model->save();
        }
      }
      $this->ajaxReturn(array('success'=>1),"json");
    }
}