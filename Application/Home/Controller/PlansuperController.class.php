<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class PlansuperController extends BaseController {
    public function _initialize(){
       if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
     if(session('admin.id_level')!=1){
          $this->redirect('plan/index');
          exit;
        }
    }
   

    public function index(){

       $this->display();
    }

    public function controY(){
      $time=M('info_systime')->where("username='人力管理员'")->getField('month');
      $this->assign('time',$time);
      $this->display();
    }
     
    public function modY(){
      $tj1['month']=I('post.time');
      $tj['year']=date('Y');
      $tj['username']=session('admin.username');
      $this->model=M('info_systime');
      if($this->model->where("username='{$tj['username']}'")->find()=='')
      {
         $tj['month']=$tj1['month'];
         if($this->model->create($tj))
         {
          $this->model->add();
         }
      }
      else
      {
        if($this->model->create($tj1))
         {
          $this->model->where($tj)->save();
         }
      }
       echo 
         "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <script type='text/javascript'> alert('创建时间成功！');parent.location.href='../Plansuper/controY'; </script>";
    }
    public function withdrawlist(){
      $search=I('post.search');
      $tj['year']=$search[0];$tj['month']=$search[1];
      if($search[2]!=""){
        $tj['department']=$search[2];
      }
      if($tj==""){
        $tj['year']=date("Y");$tj['month']=date("m");
      }
      $data=M('grademonth_confirm')->where($tj)->field("department,month,year,group_concat(id_employee) as id_employee,group_concat(name) as name,group_concat(grade_total) as grade_total")->group("department")->select();
      foreach ($data as $k => $v) {
        $data[$k]['name']=str_replace(",","<br>",$v['name']);
        $data[$k]['grade_total']=str_replace(",","<br>",$v['grade_total']);
        $data[$k]['id_employee']=str_replace(",","<br>",$v['id_employee']);
      }
      //dump($data);exit;
      $this->assign('data',$data);
      $this->assign('search',$search);
      $this->display();
    }
    public function delete(){
      $tj['year']=I('get.year');$tj['month']=I('get.month');$tj['department']=I('get.department');
      $result=M('grademonth_confirm')->where($tj)->delete();
      if($result){
        $this->ajaxReturn(array('success'=>1),"json");
      }
      else{
        $this->ajaxReturn(array('success'=>0),"json");
      }
    }






	 
    public function index1(){
     //    $groups_list=M('admin')->where()->order('id desc')->select();
    	// $this->assign('groups_list',$groups_list);
       if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
     // if(session('admin.id_level')!=2){
     //      $this->redirect('plan/index');
     //      exit;
     //  }
     if(session('admin.id_level')==2){
          $this->redirect('index/index2');
           exit;
      }
        $this->display();
    }
    public function index2(){

       if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
        if(session('admin.id_level')!=2){
           $this->redirect('index/index1');
           exit;
       }
        $this->display();
    }
   
}