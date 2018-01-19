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
    //年度时间控制
    public function controY(){
      $time=M('info_systime')->where("username='人力管理员'")->getField('month');
      $this->assign('time',$time);
      $this->display();
    }
    //执行修改年度控制
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
    //月度最终成绩撤回
    public function withdrawlistM(){
      $search=I('post.search');
      $department=array_unique(M('info_admin')->where("user_department != ''")->getField("user_department",true));
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
      $this->assign('data',$data);$this->assign('department',$department);
      $this->assign('search',$search);
      $this->display();
    }
    //季度最终成绩撤回
    public function withdrawlistQ(){
      $search=I('post.search');
      $department=array_unique(M('info_admin')->where("user_department != ''")->getField("user_department",true));
      $tj['year']=$search[0];
      $tj['quarter']=$search[1];
      //已经确认的
      $tj['if_query'] = 1;
      if($search[2]!=""){
        $tj['department']=$search[2];
      }
      if($tj==""){
        $tj['year']=date("Y");$tj['quarter']=date("m");
      }
      $data=M('gradequarter_confirm')->where($tj)->field("department,quarter,year,group_concat(id_employee) as id_employee,group_concat(name) as name,group_concat(grade_total) as grade_total")->group("department")->select();
      foreach ($data as $k => $v) {
        $data[$k]['name']=str_replace(",","<br>",$v['name']);
        $data[$k]['grade_total']=str_replace(",","<br>",$v['grade_total']);
        $data[$k]['id_employee']=str_replace(",","<br>",$v['id_employee']);
      }
      //dump($data);exit;
      $this->assign('data',$data);$this->assign('department',$department);
      $this->assign('search',$search);
      $this->display();
    }
    //撤回（删除）最终成绩
    public function delete(){
      $tj['year']=I('get.year');
      $tj['month']=I('get.month');
      $tj['department']=I('get.department');
      $tj['quarter'] = I('get.quarter');
      $typ=I("get.typ");
      if($typ=='M'){$this->model=M('grademonth_confirm');}
      if($typ=='Q'){$this->model=M('gradequarter_confirm');}
      // $result=$this->model->where($tj)->delete();
      $this->model->if_query = 0;
      $result = $this->model->where($tj)->save();
      if($result){
        $this->ajaxReturn(array('success'=>1),"json");
      }
      else{
        $this->ajaxReturn(array('success'=>0),"json");
      }
    }
    //人员绩效分配
    public function performance_allocation(){
      $search=I('post.search');
      if($search!=null){
        $tj['year']=$search[0];
        $tj['quarter']=$search[1];
        $tj['department']=$search[2];
        $data=M('gradequarter_confirm')->where($tj)->select();
        foreach ($data as $k => $v) {
          $dqgrade=M('gradequarter_dq')->where("id_employee = ".$v['id_employee'])->getField("grade");
          if($dqgrade==''){$dqgrade=0;}
          $data[$k]['grade_other']=$dqgrade;
          $data[$k]['grade_end']=round($v['grade_total']+$dqgrade,1);
        }
        $this->assign('data',$data);
        $this->assign('search',$search);
      }
      $depart=array_unique(M('info_admin')->getField('user_department',true));
      $this->assign('depart',$depart);
      $this->display();
    }
    //人员绩效提交
    public function PAsub(){
      $data=I('post.');
      $this->model=D('gradequarter_confirm');
      foreach ($data as $k => $v) {
        if($this->model->create($v))
        {
          $this->model->where("id=".$v['id'])->save();
        }
      }
      $this->ajaxReturn(array('success'=>1),"json");
    }
   //组织绩效分配
    public function organization_allocation(){
      $search=I('post.search');
      $department=array_unique(M('info_admin')->where("user_department != ''")->getField("user_department",true));
      if($search==null||$search[2]==null){
        $search[0]=$tj['year']=date('Y');
        $search[1]=$tj['quarter']=session('admin.quarter');
        $i=0;
        foreach ($department as $k => $v) {
          $data[$i]=M('ratequarter_minister')->where($tj)->where("department = '{$v}'")->find();
          if($data[$i]==null){
            $data[$i]['all_grade']=M('gradequarter_confirm')->where($tj)->where("department = '{$v}'")->count("id");
            $data[$i]['not_grade']=M('gradequarter_confirm')->where($tj)->where("department = '{$v}' and if_grade = 0")->count("id");
            $data[$i]['yes_grade']=$data[$i]['all_grade']-$data[$i]['not_grade'];
            $data[$i]['chief']=M('gradequarter_confirm')->where($tj)->where("department = '{$v}' and if_grade = 1 and id_level in (4,8)")->count("id");
            $data[$i]['staff']=$data[$i]['yes_grade']-$data[$i]['chief'];
            $data[$i]['department']=$v;
            $data[$i]['s']=round($data[$i]['yes_grade']*0.05,0);
            $data[$i]['a']=round($data[$i]['yes_grade']*0.25,0);
            $data[$i]['b']=round($data[$i]['yes_grade']*0.4,0);
            $data[$i]['c']=round($data[$i]['yes_grade']*0.3,0);
            
          }
          $i++;
        }
      }
      else{
        $tj['year']=$search[0];
        $tj['quarter']=$search[1];
        $tj['department']=$search[2];
        $data[0]=M('ratequarter_minister')->where($tj)->find();
        if($data[0]==null){
        $data[0]['all_grade']=M('gradequarter_confirm')->where($tj)->count("id");
        $data[0]['not_grade']=M('gradequarter_confirm')->where($tj)->where("if_grade = 0")->count("id");
        $data[0]['yes_grade']=$data[0]['all_grade']-$data[0]['not_grade'];
        $data[0]['chief']=M('gradequarter_confirm')->where($tj)->where("if_grade = 1 and id_level in (4,8)")->count("id");
        $data[0]['staff']=$data[0]['yes_grade']-$data[0]['chief'];
        $data[0]['department']=$search[2];
        $data[0]['s']=round($data[0]['yes_grade']*0.05,0);
        $data[0]['a']=round($data[0]['yes_grade']*0.25,0);
        $data[0]['b']=round($data[0]['yes_grade']*0.4,0);
        $data[0]['c']=round($data[0]['yes_grade']*0.3,0);
        }
      }
      $count=count($data);
      $this->assign('count',$count);
      $this->assign('data',$data);
      $this->assign('search',$search);
      $this->assign('department',$department);
      $this->display();
    }
    //组织绩效提交
    public function OAsub(){
      $data=I('post.');
      $this->model=D('ratequarter_minister');
      foreach ($data as $k => $v) {
        $tj['department']=$v['department'];
        $tj['year']=$v['year'];
        $tj['quarter']=$v['quarter'];
        $result=$this->model->where($tj)->getField('id');
        if($result==null){
          if($this->model->create($v)){
            $this->model->add();
          }
        }
        else{
          if($this->model->create($v)){
            $this->model->where("id={$result}")->save();
          }
        }
      }
      $this->ajaxReturn(array('success'=>1),"json");
    }
    public function OAdelete(){
      $id=I('get.id');
      $this->model=D('ratequarter_minister');
      $this->model->where("id={$id}")->delete();
      $this->ajaxReturn(array('success'=>1),"json");
    }
    public function performance_release(){
      $tj['quarter']=I('get.quarter');
      if($tj['quarter']!=null){
        $tj['year']=session('admin.year_sys');
        $this->model=D('gradequarter_confirm');
     
        $data=$this->model->field("department,year,quarter,group_concat(office) as office")->where($tj)->group("department")->select();
        foreach ($data as $k => $v) {
          $data[$k]['office']=array_unique(explode(',',$v['office']));
          foreach ($data[$k]['office'] as $key => $value) {
            $data[$k]['if_query'][$key]=$this->model->where($tj)->where("office = '{$value}'")->getField('if_query');
          }
        }
        $count=count($data);
        //dump($data);
        $this->assign('data',$data);
        $this->assign('count',$count);
        $this->assign('quarter',$tj['quarter']);
      }
      $this->display();
    }
    public function release(){
      $data=I('post.');
      $department=explode(",", $data['department']);
      $tj['quarter']=$data['quarter'];
      $tj['year']=session('admin.year_sys');
      foreach ($department as $k => $v) {
        $re=M('gradequarter_confirm')->where($tj)->where("department = '{$v}'")->setField('if_query','1');
      }
      $this->ajaxReturn(array('success'=>1),"json");
    }
}