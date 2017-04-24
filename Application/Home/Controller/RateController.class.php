<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class RateController extends BaseController {
  public function _initialize(){
     if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
     if(session('admin.id_level')==2){
          $this->redirect('planjhy/index');
          exit;
        }
     if(session('admin.id_level')==1){
          $this->redirect('plansuper/index');
          exit;
        }
   }
   //科长评级
  public function rate_chief(){
    //季度时间规划
    if (session('admin.quarter')==2||session('admin.quarter')==3||session('admin.quarter')==4) {
      $chief_condition['quarter']     = session('admin.quarter')-1;
      $chief_condition['year']        = session('admin.year_sys');
    }
    else if (session('admin.quarter')==1) {
      $chief_condition['quarter']     = 4;
      $chief_condition['year']        = session('admin.year_sys')-1;
    }

    $chief_condition['department']    = session('admin.user_department');
    $rate      = M('ratequarter_minister')->where($chief_condition)->find();

    $chief_condition['if_grade']=1;
    $rate_model= D('gradequarter_confirm');
    $rate_data = $rate_model->Table(array('gradequarter_confirm'=>'a','info_admin'=>'b'))  
                      ->field('a.id,a.name,a.year,a.quarter,a.department,a.office,a.id_employee,a.id_level,a.grade_one,a.grade_two,a.grade_three,grade_end,a.leader_rate')  
                      ->where("(b.id_level in (4,8) and b.username=a.name) or  (b.if_authority in (2,3) and b.username=a.name)")  
                      ->where($chief_condition)
                      ->select();
    $rate_chief_count=count($rate_data);


    //不参评科级
    $chief_condition['if_grade']=0;
    $data_no=M('gradequarter_confirm')->where($chief_condition)->select();

    $this->assign('rate',$rate);
    $this->assign('data',$rate_data);
    $this->assign('data_no',$data_no);
    $this->assign('rate_chief_count',$rate_chief_count);
    $this->display();
  }

   //科长评级录入
   public function ratesub(){
    $data=I('post.');
    $this->model=D('gradequarter_confirm');
    foreach ($data as $k => $v){
      if($v['leader_rate']!=''){
        if($this->model->create($v)){
          $this->model->save();
        }
      }
    }
    $this->ajaxReturn(array('success'=>1),"json");
   }
  
   //科室评级分配录入
   public function ratequarter_chief(){
    $data=I('post.');
    $this->model=D('ratequarter_chief');
    foreach ($data as $k => $v) {
      if($v['id']==''){
        $v['department']=session('admin.user_department');
        $v['year']=session('admin.year_sys');
        $v['quarter']=session('admin.quarter_last');
        unset($v['id']);
        if($this->model->create($v)){
          $this->model->add();
        }
      }
      else{
        if($this->model->create($v)){
          $this->model->save();
        }
      }
    }
    $this->ajaxReturn(array('success'=>1),"json");
   }
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   public function rate_staff(){
    
    if (session('admin.quarter')==2||session('admin.quarter')==3||session('admin.quarter')==4) {
      $tj['quarter'] = session('admin.quarter')-1;
      $tj['year']=session('admin.year_sys');
    }
    else if (session('admin.quarter')==1) {
      $tj['quarter'] = 4;
      $tj['year']=session('admin.year_sys')-1;
    }
    $data_authority = session('admin.if_authority');
    $tj['department']=session('admin.user_department');
    $rate=M('ratequarter_minister')->where($tj)->find();
    if(session('admin.id_level')==4){
      $tj['office']=session('admin.user_office');
      $rate_chief=M('ratequarter_chief')->where($tj)->find();
    }
    else if(session('admin.id_level')==5){
      $rate_chief=$rate;
      $depart=session('admin.user_department');
      $office=array_unique(M('info_admin')->where("user_department = '{$depart}'")->getField('user_office',true));
      $this->assign('office',$office);
      $search=I('post.search');
      if($search!=null){
        $tj['office']=$search;
        $rate_chief=M('ratequarter_chief')->where($tj)->find();
        $rate_authority = D('gradequarter_confirm')->Table(array('gradequarter_confirm'=>'a','info_admin'=>'b'))  
                      ->field('a.id,a.name,a.year,a.quarter,a.department,a.office,a.id_employee,a.id_level,a.grade_one,a.grade_two,a.grade_three,grade_end,a.leader_rate')  
                      ->where("(b.id_level in (4,8) and b.username=a.name) or  (b.if_authority in (2,3) and b.username=a.name)")  
                      ->where($chief_condition)
                      ->select();
        $this->assign('search',$search);
      }
      else{
        $tj['office']='无';
        $rate_chief['office']=$rate['department'];
      }
    }
    //授权科长
    else if (session('admin.id_level')==3 && session('admin.if_authority')==3) {
      $name_authority =  session('admin.username');
      $tj['office']=session('admin.user_office');
      $rate_chief=M('ratequarter_chief')->where($tj)->find();
    }

    $this->assign('rate',$rate);
    $this->assign('rate_chief',$rate_chief);

    $tj['if_grade']=1;
    $data=M('gradequarter_confirm')->where($tj)->where("id_level in (3,7)")->where("name <> '$name_authority'")->order("grade_total desc")->select();
    foreach ($data as $k => $v) {
      $data[$k]['confirm_rate']=$v['leader_rate'];
    }
    $i=0;
    for($j=1;$j<=count($data);$j++)
    {
      if($rate_chief['s']!=0)
      {
        $data[$i]['leader_rate']=1;
        $i++;
        $rate_chief['s']--;
      }
      else if($rate_chief['a']!=0)
      {
        $data[$i]['leader_rate']=2;
        $i++;
        $rate_chief['a']--;
      }
      else if($rate_chief['b']!=0)
      {
        $data[$i]['leader_rate']=3;
        $i++;
        $rate_chief['b']--;
      }
      else if($rate_chief['c']!=0)
      {
        $data[$i]['leader_rate']=4;
        $i++;
        $rate_chief['c']--;
      }
    }

    $tj['if_grade']=0;
    $data_no=M('gradequarter_confirm')->where($tj)->where("id_level in (3,7)")->order("grade_total desc")->select();
    
    $count=count($data);
    $this->assign('data',$data);
    $this->assign('data_no',$data_no);
    $this->assign('count',$count);
    $this->assign('authority',$data_authority);
    $this->display();
   }

   //季度分配
    public function rate_allocation(){
    //时间配置
      if(session('admin.quarter')==2||session('admin.quarter')==3|session('admin.quarter')==4)
      {
        $tj['quarter']=session('admin.quarter')-1;
        $tj['year']=session('admin.year_sys');
      }
      else if (session('admin.quarter')==1) {
        $tj['quarter']=4;
        $tj['year']=session('admin.year_sys')-1;
      }
      //其他配置
      $tj['department']=session('admin.user_department');
      $rate=M('ratequarter_minister')->where($tj)->find();
      $office1=array_unique(M('gradequarter_confirm')->where("department = '".$tj['department']."'")->getField('office',true));
      $i=1;

    foreach ($office1 as $k => $v) {
      $tj['office']=$v;
      $data_model = D('gradequarter_confirm');

      $s[$i] = M('ratequarter_chief')->where($tj)->getField('s');
      $a[$i] = M('ratequarter_chief')->where($tj)->getField('a');
      $b[$i] = M('ratequarter_chief')->where($tj)->getField('b');
      $c[$i] = M('ratequarter_chief')->where($tj)->getField('c');
      $id[$i] = M('ratequarter_chief')->where($tj)->getField('id');

      $data[$i]=$data_model->where($tj)->find();
      //提交科室总人数
      $data[$i]['all_grade']=$data_model->where($tj)->count('id');
      //科室参评总人数
      $tj['if_grade']=1;
      $data[$i]['yes_grade']=$data_model->where($tj)->count('id');
      //科室不参评总人数
      $data[$i]['not_grade']=$data[$i]['all_grade']-$data[$i]['yes_grade'];
      //科级参评人数
      $data[$i]['chief']=$data_model->Table(array('gradequarter_confirm'=>'a','info_admin'=>'b'))
                                    ->where($tj)->where("(b.id_level in (4,8) and b.username=a.name) or  (b.if_authority in (2,3) and b.username=a.name)")
                                    ->count('a.id');
      //科室员工参评人数
      $data[$i]['staff']=$data[$i]['yes_grade']-$data[$i]['chief']-$data_authority;
      //科级参评等级
      $tj['if_grade']=1;
      $data[$i]['chief_rate']=$data_model->Table(array('gradequarter_confirm'=>'a','info_admin'=>'b'))
                                         ->where($tj)->where("(b.id_level in (4,8) and b.username=a.name) or  (b.if_authority in (2,3) and b.username=a.name)")
                                         ->getField('a.leader_rate');
      unset($tj['if_grade']);
      $office[$i]=$v;
      $i++;
     }
     //dump($data);exit;
     $officecount=count($office);
     $this->assign('office',$office);
     $this->assign('officecount',$officecount);
     $this->assign('rate',$rate);
     $this->assign('data',$data);
     $this->assign('quarter',$quarter);

     $this->assign('s',$s);
     $this->assign('a',$a);
     $this->assign('b',$b);
     $this->assign('c',$c);
     $this->assign('id',$id);
     $this->display();
   }

   public function rate_query(){
    $search=I('post.search');
    if($search!=null){
      $tj['yaer']=$search[0];
      $tj['quarter']=$search[1];
      if(session('admin.id_level')==4){
        $tj['office']=session('admin.user_office');
      }
      else{
        $tj['department']=session('admin.user_department');
      }
      $data=M('gradequarter_confirm')->where($tj)->order("name desc")->select();
      $this->assign('data',$data);
    }
    $this->assign('search',$search);
    $this->display();
   }
   //历史查看
   public function quarter_query(){
    $name=session('admin.username');
    $data=M('gradequarter_confirm')->where("name = '{$name}' and if_query = 1")->order('year desc')->order('quarter desc')->select();
    $this->assign('data',$data);
    $this->display();
   }

   //季度评级提交
   public function RatesubmissionQ(){
    $quarter=I('get.quarter');
      $tj['year']=session('admin.year');
      $tj['department']=session('admin.user_department');
      
      for($i=1;$i<=4;$i++){
        $tj['quarter']=$i;
        $data[$i]=count(M('gradequarter_confirm')->where($tj)->select());
        $office[$i]=array_unique(M('gradequarter_confirm')->where($tj)->getField('office',true));
        $office[$i]=implode(',', $office[$i]);
      }
      $id='';
      if($quarter!="")
      {
        $tj['quarter']=$quarter;
        if($quarter==1){$month="1,2,3";}
        if($quarter==2){$month="4,5,6";}
        if($quarter==3){$month="7,8,9";}
        if($quarter==4){$month="10,11,12";}
        $data['staff']=M('gradequarter_confirm')->where($tj)->where("id_level in (3,7) and confirm_rate_minister != '无' and if_grade =1")->select();
        $data['chief']=M('gradequarter_confirm')->where($tj)->where("id_level in (4,8) and confirm_rate_minister != '无' and if_grade =1")->select();
        $data['no']=M('gradequarter_confirm')->where($tj)->where("id_level in (4,8,3,7) and confirm_rate_minister != '无' and if_grade =0")->select();
        $id=1;
        if($data['staff']==null&&$data['chief']==null)
        {
          $data['staff']=M('gradequarter_confirm')->where($tj)->where("id_level in (3,7) and confirm_rate_minister = '无' and if_grade =1")->select();
          $data['chief']=M('gradequarter_confirm')->where($tj)->where("id_level in (4,8) and confirm_rate_minister = '无' and if_grade =1")->select();
          $data['no']=M('gradequarter_confirm')->where($tj)->where("id_level in (4,8,3,7) and confirm_rate_minister = '无' and if_grade =0")->select();
          $id='';
        }
        $this->assign('quarter',$quarter);
      }
      //dump($data);
      $this->assign('id',$id);
      $this->assign('data',$data);
      $this->assign('office',$office);
      $this->assign('quarter',$quarter);
      $this->display();
   }
   //提交最终版
   public function finalgradeQ(){
      $data=I('post.');
      foreach ($data['chief1'] as $k => $v) {
       $m['confirm_rate_minister']=session('admin.username');
       $this->model=D('gradequarter_confirm');
       if($this->model->create($m))
        $this->model->where($v)->save();
      }
      foreach ($data['staff1'] as $k => $v) {
       $m['confirm_rate_minister']=session('admin.username');
       $this->model=D('gradequarter_confirm');
       if($this->model->create($m))
        $this->model->where($v)->save();
      }
      foreach ($data['no'] as $k => $v) {
       $m['confirm_rate_minister']=session('admin.username');
       $this->model=D('gradequarter_confirm');
       if($this->model->create($m))
        $this->model->where($v)->save();
      }
      $this->ajaxReturn(array('success'=>1),"json");
  }
}