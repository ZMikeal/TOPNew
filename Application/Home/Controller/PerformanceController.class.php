<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class PerformanceController extends BaseController {
    public function _initialize(){
	     if(!session('?admin')){
          $this->redirect('login/login');
          exit;
          }
       if(session('admin.id_level')==2){
          $this->redirect('index/index2');
           exit;
          }
    }
    public function Planconfirm(){
      $level=session('admin.id_level');
      $tj['plan_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      $tj['month']=session('admin.month');
      if($level==4)
      {
        $this->model=D('planmonth_staff');
        $jh = $this->model->field("id,staff_id,staff_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->order('staff_name')->group('staff_name')->select();
      }
      if($level==5)
      {
        $this->model=D('planmonth_chief');
        $jh = $this->model->field("id,chief_id,chief_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('chief_name')->select();
      }
      foreach ($jh as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      //dump($jh);exit;
      $this->assign('jh',$jh);
      $this->display();
    }
    public function PlanconfirmY(){
      $level=session('admin.id_level');
      $tj['plan_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      //$tj['month']=session('admin.month');
      if($level==4)
      {
        $this->model=D('planyear_staff');
        $jh = $this->model->field("id,staff_id,staff_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('staff_name')->select();
      }
      if($level==5)
      {
        $this->model=D('planyear_chief');
        $jh = $this->model->field("id,chief_id,chief_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('chief_name')->select();
      }
      foreach ($jh as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      //dump($jh);exit;
      $this->assign('jh',$jh);
      $this->display();
    }
    public function Pplan(){
      $tj=I('get.id');
      $tj=explode(",", $tj);
       $le=session('admin.id_level');
      if($le==4)
      {
        $this->model=D('planmonth_staff');
        $name=$this->model->where("id=$tj[0]")->getField('staff_name');
      }
      if($le==5)
      {
        $this->model=D('planmonth_chief');
        $name=$this->model->where("id=$tj[0]")->getField('chief_name');
      }
      //dump($tj);exit;
      foreach ($tj as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $shuju[$k]=$this->model->where("id=$v")->find();
                }
                //dump($shuju);exit;
        $this->assign('shuju',$shuju);
        $this->assign('name',$name);
        $this->display();
    }
    public function PplanY(){
      $tj=I('get.id');
      $tj=explode(",", $tj);
       $le=session('admin.id_level');
      if($le==4)
      {
        $this->model=D('planyear_staff');
        $name=$this->model->where("id=$tj[0]")->getField('staff_name');
      }
      if($le==5)
      {
        $this->model=D('planyear_chief');
        $name=$this->model->where("id=$tj[0]")->getField('chief_name');
      }
      //dump($tj);exit;
      foreach ($tj as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $shuju[$k]=$this->model->where("id=$v")->find();
                }
                //dump($shuju);exit;
        $this->assign('shuju',$shuju);
        $this->assign('name',$name);
        $this->display();
    }
   
   public function confirm(){
    $id=I('get.vid');
       $le=session('admin.id_level');
      if($le==4)
      {
        $this->model=D('planmonth_staff');
      }
      if($le==5)
      {
        $this->model=D('planmonth_chief');
      }
      $resulet=$this->model->where("id=$id")->setField('if_confirm',1);
      $this->ajaxReturn(array('success'=>1),"json");

   }
   public function confirmY(){
    $id=I('get.vid');
       $le=session('admin.id_level');
      if($le==4)
      {
        $this->model=D('planyear_staff');
      }
      if($le==5)
      {
        $this->model=D('planyear_chief');
      }
      $resulet=$this->model->where("id=$id")->setField('if_confirm',1);
      $this->ajaxReturn(array('success'=>1),"json");

   }
   public function notconfirm(){
    $tj['id']=I('post.id');
    $tj['plan_confirm']=I('post.confirm');
    $tj['if_confirm']=-1;
       $le=session('admin.id_level');
      if($le==4)
      {
        $this->model=D('planmonth_staff');
      }
      if($le==5)
      {
        $this->model=D('planmonth_chief');
      }
      $id=$tj['id'];
      if($this->model->create($tj)){
        $this->model->where("id=$id")->save();
      }
      $this->ajaxReturn(array('success'=>1),"json");

   }
   public function notconfirmY(){
    $tj['id']=I('post.id');
    $tj['plan_confirm']=I('post.confirm');
    $tj['if_confirm']=-1;
       $le=session('admin.id_level');
      if($le==4)
      {
        $this->model=D('planyear_staff');
      }
      if($le==5)
      {
        $this->model=D('planyear_chief');
      }
      $id=$tj['id'];
      if($this->model->create($tj)){
        $this->model->where("id=$id")->save();
      }
      $this->ajaxReturn(array('success'=>1),"json");

   }


    public function PlangradeM(){
      $level=session('admin.id_level');
      $tj['plan_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      $tj['month']=session('admin.month');
      if($level==4)
      {
        $this->model=D('planmonth_staff');
        $jh = $this->model->field("id,staff_id,staff_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->order('staff_name')->group('staff_name')->select();
      }
      if($level==5)
      {
        $this->model=D('planmonth_chief');
        $jh = $this->model->field("id,chief_id,chief_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('chief_name')->select();
      }
      foreach ($jh as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      //dump($jh);exit;
      $this->assign('jh',$jh);
      $this->display();
    }
    public function PlangradeY(){
      $level=session('admin.id_level');
      $tj['plan_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      //$tj['month']=session('admin.month');
      if($level==4)
      {
        $this->model=D('planyear_staff');
        $jh = $this->model->field("id,staff_id,staff_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('staff_name')->select();
      }
      if($level==5)
      {
        $this->model=D('planyear_chief');
        $jh = $this->model->field("id,chief_id,chief_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('chief_name')->select();
      }
      foreach ($jh as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      //dump($jh);exit;
      $this->assign('jh',$jh);
      $this->display();
    }
    public function PlangradeshowM(){
      $tj=I('get.id');
      $tj=explode(",", $tj);
       $le=session('admin.id_level');
       //dump($tj);exit;
      if($le==4)
      {
        $this->model=D('planmonth_staff');
        $name=$this->model->where("id=$tj[0]")->getField('staff_name');
      }
      if($le==5)
      {
        $this->model=D('planmonth_chief');
        $name=$this->model->where("id=$tj[0]")->getField('chief_name');
      }
      //dump($tj);exit;
      foreach ($tj as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $shuju[$k]=$this->model->where("id=$v")->find();
                }
                //dump($shuju);exit;
        $this->assign('name',$name);
        $this->assign('shuju',$shuju);
        $this->display();
    }
    public function PlangradeshowY(){
      $tj=I('get.id');
      $tj=explode(",", $tj);
       $le=session('admin.id_level');
      if($le==4)
      {
        $this->model=D('planyear_staff');
        $name=$this->model->where("id=$tj[0]")->getField('staff_name');
      }
      if($le==5)
      {
        $this->model=D('planyear_chief');
        $name=$this->model->where("id=$tj[0]")->getField('chief_name');
      }
      //dump($tj);exit;
      foreach ($tj as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $shuju[$k]=$this->model->where("id=$v")->find();
                }
                //dump($shuju);exit;
        $this->assign('name',$name);
        $this->assign('shuju',$shuju);
        $this->display();
    }
}