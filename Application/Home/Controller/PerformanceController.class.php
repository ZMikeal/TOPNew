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
    //月度计划确认列表
    public function Planconfirm(){
      $level=session('admin.id_level');
      $tj['plan_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      $tj['month']=session('admin.month');
      if($level==4||$level==7||$level==8||$level==3)
      {
        $this->model=D('planmonth_staff');
        $jh = $this->model->field("id,staff_id,staff_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->order('staff_name')->group('staff_name')->select();
      }
      if($level==5)
      {
        $this->model=D('planmonth_staff');
        $jh1 = $this->model->field("id,staff_id,staff_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->order('staff_name')->group('staff_name')->select();
      
        $this->model=D('planmonth_chief');
        $jh = $this->model->field("id,chief_id,chief_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('chief_name')->select();
        foreach ($jh1 as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh1[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      }
      foreach ($jh as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      //dump($jh);exit;
      $this->assign('jh',$jh);
      $this->assign('jh1',$jh1);
      $this->display();
    }
    //~
    //年度计划确认列表
    public function PlanconfirmY(){
      $level=session('admin.id_level');
      $tj['plan_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      //$tj['month']=session('admin.month');
      if($level==4||$level==7||$level==8)
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
    //~
    //月度计划确认
    public function Pplan(){
      $tj=I('get.id');
      $tj=explode(",", $tj);
       $le=session('admin.id_level');
      if($le==4||$le==7||$le==8||$le==3)
      {
        $this->model=D('planmonth_staff');
        $name=$this->model->where("id=$tj[0]")->getField('staff_name');
      }
      if($le==5)
      {
        $lev=I('get.lev');
        if($lev==3){
          $this->model=D('planmonth_staff');
          $name=$this->model->where("id=$tj[0]")->getField('staff_name');
        }
        else
        {
        $this->model=D('planmonth_chief');
        $name=$this->model->where("id=$tj[0]")->getField('chief_name');
      }
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
    //~
    //年度计划确认
    public function PplanY(){
      $tj=I('get.id');
      $tj=explode(",", $tj);
       $le=session('admin.id_level');
      if($le==4||$le==7||$le==8)
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
   //月度计划确认数据写入
   public function confirm(){
    $id=I('get.vid');
       $le=session('admin.id_level');
      if($le==4||$le==7||$le==8||$le==3)
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
   //~
   //年度计划确认数据写入
   public function confirmY(){
    $id=I('get.vid');
       $le=session('admin.id_level');
      if($le==4||$le==7||$le==8||$le==3)
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
   //~
   //月度计划退回数据写入
   public function notconfirm(){
    $tj['id']=I('post.id');
    $tj['plan_confirm']=I('post.confirm');
    $tj['if_confirm']=-1;
       $le=session('admin.id_level');
      if($le==4||$le==7||$le==8||$le==3)
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
   //~
   //年度计划退回数据写入
   public function notconfirmY(){
    $tj['id']=I('post.id');
    $tj['plan_confirm']=I('post.confirm');
    $tj['if_confirm']=-1;
       $le=session('admin.id_level');
      if($le==4||$le==7||$le==8||$le==3)
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
   //~
   //月度绩效查看列表
    public function PlangradelistM(){
      $search=I('post.search');        
      $searchh=I('post.searchh');
      //dump($searchh);dump($search);exit;
      if($search==""){
        $tj['year']=session('admin.year');
        $tj['month']=session('admin.month');
        $search[0]=session('admin.year');
        $search[1]=session('admin.month');
        $search[2]="";
      }
      else{
        $tj['year']=$search[0];
        $tj['month']=$search[1];    
      }
      $tj['plan_leader']=session('admin.username');
      $search1=session('admin.user_office');

      $level=session('admin.id_level');
      //决定了是只检索自己的评价人还是所有评价人的list
      //dump($tj);exit();
      if($level==4||$level==7||$level==8||$level==3)
      {
        if($level==4){
          unset($tj['plan_leader']);
          $tj['office']=session('admin.user_office');
        }
        $this->model=D('planmonth_staff');
        $jh = $this->model->field("id,staff_id,office,staff_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tj)->group('staff_name')->select();
        $tjn['plan_leader']=session('admin.username');
        $jh1 = $this->model->field("id,staff_id,office,staff_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tjn)->where("'office' != '".$tj['office']."'")->group('staff_name')->select();
         foreach ($jh1 as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh1[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  $jh1[$k]['plan_grade']=explode(",", $v['plan_grade']);
                  $sum=0;
                  foreach ($jh1[$k]['plan_grade'] as $key => $value) {
                    $sum+=$value;
                  }
                  if($sum==0)
                  {
                    $jh1[$k]['plan_grade']="";
                  }
                  if($sum!=0)
                  {
                    $jh1[$k]['plan_grade']=$sum;
                  }                  
                }
                $this->assign('jh1',$jh1);
        $this->model=D('grademonth_staff');
      }
      if($level==5)
      {
        if(session('admin.user_job')=="副部长")
        {
          $this->model=D('planmonth_chief');
          $jh = $this->model->field("id,chief_id,office,chief_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tj)->group('chief_name')->select();
          $this->model=D('grademonth_chief');
        }
        else
        {
        $depart=session('admin.user_department');
        $search1=M('info_admin')->where("user_department='".$depart."'")->distinct(true)->getField('user_office',true);
        //dump($department);exit;
        if($search[2]=="")
        {
          unset($tj['plan_leader']);
          $tj['department']=session('admin.user_department');
        }
        else
        {
          unset($tj['plan_leader']);
          $tj['office']=$search[2];
        }
        $this->model=D('planmonth_chief');
        $jh = $this->model->field("id,chief_id,office,chief_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tj)->group('chief_name')->select();
        $this->model=D('grademonth_chief');
        }
      }

      foreach ($jh as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  $jh[$k]['plan_grade']=explode(",", $v['plan_grade']);
                  $sum=0;
                  foreach ($jh[$k]['plan_grade'] as $key => $value) {
                    $sum+=$value;
                  }
                  if($sum==0)
                  {
                    $jh[$k]['plan_grade']="";
                  }
                  if($sum!=0)
                  {
                    $jh[$k]['plan_grade']=$sum;
                  }                  
                }
                //dump($search1);exit;
      //dump($jh);exit;
     if($level==5||$level==4){
        if($searchh==""){
        $tjh['year']=session('admin.year');
        $tjh['month']=session('admin.month');
        $searchh[0]=session('admin.year');
        $searchh[1]=session('admin.month');
        $searchh[2]="";
        }
        else{
        $tjh['year']=$searchh[0];
        $tjh['month']=$searchh[1];    
        }

        if(session('admin.user_job')=="副部长")
        {
          $tjh['plan_leader']=session('admin.username');
          $this->model=D('planmonth_staff');
          $jh1 = $this->model->field("id,staff_id,staff_name,office,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tjh)->group('staff_name')->select();
        }
        else
        {
          if($level==5)
          {
            if($searchh[2]=="")
            {
              unset($tjh['plan_leader']);
              $tjh['department']=session('admin.user_department');
            }
            else
            {
              unset($tjh['plan_leader']);
              $tjh['office']=$searchh[2];
            }
            $this->model=D('planmonth_staff');
            $jh1 = $this->model->field("id,staff_id,staff_name,office,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tjh)->group('staff_name')->select();
        
          }
          else{
            $this->model=D('planmonth_staff');
            $tjh['plan_leader']=session('admin.username');
            $tj['office']=session('admin.user_office');
            $jh1 = $this->model->field("id,staff_id,office,staff_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tjh)->where("'office' != '".$tj['office']."'")->group('staff_name')->select();
          }
        }
        
        foreach ($jh1 as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh1[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  $jh1[$k]['plan_grade']=explode(",", $v['plan_grade']);
                  $sum=0;
                  foreach ($jh1[$k]['plan_grade'] as $key => $value) {
                    $sum+=$value;
                  }
                  if($sum==0)
                  {
                    $jh1[$k]['plan_grade']="";
                  }
                  if($sum!=0)
                  {
                    $jh1[$k]['plan_grade']=$sum;
                  }                  
                }
                $this->assign('jh1',$jh1);
     }//dump($jh1);exit;
      $this->assign('jh',$jh);
      $this->assign('search',$search);
      $this->assign('searchh',$searchh);
      $this->assign('search1',$search1);
      $this->display();
   }
   //~
   //月度绩效查看列表显示详情
   public function PlangradelistshowM(){
      $tj=I('get.id');
      $level=I('get.level');
      $tj=explode(",", $tj);
      $le=session('admin.id_level');
       //dump($tj);dump($level);;exit;
      if($le==5)
      {
        $this->model=D('planmonth_chief');
        $name=$this->model->where("id=$tj[0]")->find();
        $this->model=D('grademonth_chief');
        $name1['chief_id']=$name['chief_id'];
        $name1['year']=$name['year'];
        $name1['month']=$name['month'];
        $name1['grade_leader']=$name['plan_leader'];
        $sum=$this->model->where($name1)->getField('grade');
        $name[1]=$name['chief_name'];
        $name[2]=$name['year'];
        $name[3]=$name['month'];
        $this->model=D('planmonth_chief');
      }
      else if($le==4||$le==7||$level==3||$le==8);
      {
        $this->model=D('planmonth_staff');
        $name=$this->model->where("id=$tj[0]")->find();
        //dump($name);exit();
        $this->model=D('grademonth_staff');
        $name1['staff_id']=$name['staff_id'];   //name1查询条件变量
        $name1['year']=$name['year'];
        $name1['month']=$name['month'];
        $name1['grade_leader']=$name['plan_leader'];
        $sum=$this->model->where($name1)->getField('grade');
        //dump($sum);exit;
        $name[1]=$name['staff_name'];
        $name[2]=$name['year'];
        $name[3]=$name['month'];
        $this->model=D('planmonth_staff');
      }
      
      //dump($tj);exit;
      foreach ($tj as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $shuju[$k]=$this->model->where("id=$v")->find();
                  $f=1;
                  for($i=0;$i<6;$i++)
                  {
                    $shuju[$k]['fenshu'][$i]['fen']=round($shuju[$k]['plan_weight']*$f);
                    $f-=0.2;
                  }
                  $shuju[$k]['fenshu'][0]['dengji']=S;
                  $shuju[$k]['fenshu'][1]['dengji']=A;
                  $shuju[$k]['fenshu'][2]['dengji']=B;
                  $shuju[$k]['fenshu'][3]['dengji']=C;
                  $shuju[$k]['fenshu'][4]['dengji']=D;
                  $shuju[$k]['fenshu'][5]['dengji']=E;
                }
                //dump($shuju);exit;
        $this->assign('name',$name);
        $this->assign('sum',$sum);
        $this->assign('shuju',$shuju);
        $this->display();
    }
    //~
    //月度计划评分列表
    public function PlangradeM(){
      $level=session('admin.id_level');
      $tj['plan_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      $tj['month']=session('admin.month');
      if($tj['month']==1){
        $tj['month']=12;
        $tj['year']=session('admin.year')-1;
      }
      else
         $tj['month']=session('admin.month')-1;
      
      //dump($tj);exit;
      if($level==4||$level==7||$level==8||$level==3)
      {
        $this->model=D('planmonth_staff');
        $jh = $this->model->field("id,staff_id,staff_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tj)->order('staff_name')->group('staff_name')->select();
        $this->model=D('grademonth_staff');
        //dump($jh);exit;
      }
      if($level==5)
      {
        $this->model=D('planmonth_chief');
        $jh = $this->model->field("id,chief_id,chief_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tj)->group('chief_name')->select();
        $this->model=D('grademonth_chief');//jh是查看自己下级plan_leader为自己的数据
      }
      foreach ($jh as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  $jh[$k]['plan_grade']=explode(",", $v['plan_grade']);
                  
                  $sum=0;
                  foreach ($jh[$k]['plan_grade'] as $key => $value) {
                    $sum+=$value;
                  }
                  if($sum==0)
                  {
                    $jh[$k]['plan_grade']="";
                  }
                  if($sum!=0)
                  {
                    $jh[$k]['plan_grade']=$sum;
                  }                  
                }
     if($level==5)
      {
        $this->model=D('planmonth_staff');
        $jh1 = $this->model->field("id,staff_id,staff_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tj)->order('staff_name')->group('staff_name')->select();
        $this->model=D('grademonth_staff');
        //jh1是部长查看科员plan_leader为自己的数据
        foreach ($jh1 as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh1[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  $jh1[$k]['plan_grade']=explode(",", $v['plan_grade']);
                  
                  $sum=0;
                  foreach ($jh1[$k]['plan_grade'] as $key => $value) {
                    $sum+=$value;
                  }
                  if($sum==0)
                  {
                    $jh1[$k]['plan_grade']="";
                  }
                  if($sum!=0)
                  {
                    $jh1[$k]['plan_grade']=$sum;
                  }                  
                }
                $this->assign('jh1',$jh1);
       }
      //dump($jh);exit;
      $this->assign('jh',$jh);
      $this->display();
    }
    //~
    //年度计划评分列表
    public function PlangradeY(){
      $level=session('admin.id_level');
      $tj['plan_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      //$tj['month']=session('admin.month');
      if($level==4||$level==7||$level==8)
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
    //~
    //月度计划评分
    public function PlangradeshowM(){
      $tj=I('get.id');
      $tj=explode(",", $tj);
      $hrf=I('get.hrf');
      $this->assign('hrf',$hrf);
      $le=session('admin.id_level');
       //dump($tj);exit;
      if($le==4||$le==7||$le==8||$le==3)
      {
        $this->model=D('planmonth_staff');
        $name=$this->model->where("id=$tj[0]")->find();
        $this->model=D('grademonth_staff');
        $name1['staff_id']=$name['staff_id'];
        $name1['year']=$name['year'];
        $name1['month']=$name['month'];
        $name1['grade_leader']=$name['plan_leader'];
        $sum=$this->model->where($name1)->getField('grade');
        //dump($name);exit;
        $name[1]=$name['staff_name'];
        $name[2]=$name['year'];
        $name[3]=$name['month'];
        $this->model=D('planmonth_staff');
      }
      if($le==5)
      {
        $lev=I('get.lev');
        if($lev==3){
        $this->model=D('planmonth_staff');
        $name=$this->model->where("id=$tj[0]")->find();
        $this->model=D('grademonth_staff');
        $name1['staff_id']=$name['staff_id'];
        $name1['year']=$name['year'];
        $name1['month']=$name['month'];
        $name1['grade_leader']=$name['plan_leader'];
        $sum=$this->model->where($name1)->getField('grade');
        //dump($name);exit;
        $name[1]=$name['staff_name'];
        $name[2]=$name['year'];
        $name[3]=$name['month'];
        $this->model=D('planmonth_staff');
        }
        else
        {
        $this->model=D('planmonth_chief');
        $name=$this->model->where("id=$tj[0]")->find();
        $this->model=D('grademonth_chief');
        $name1['chief_id']=$name['chief_id'];
        $name1['year']=$name['year'];
        $name1['month']=$name['month'];
        $name1['grade_leader']=$name['plan_leader'];
        $sum=$this->model->where($name1)->getField('grade');
        $name[1]=$name['chief_name'];
        $name[2]=$name['year'];
        $name[3]=$name['month'];
        $this->model=D('planmonth_chief');
        }
      }
      //dump($lev);exit;
      foreach ($tj as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $shuju[$k]=$this->model->where("id=$v")->find();
                  $f=1;
                  for($i=0;$i<6;$i++)
                  {
                    $shuju[$k]['fenshu'][$i]['fen']=round($shuju[$k]['plan_weight']*$f);
                    $f-=0.2;
                  }
                  $shuju[$k]['fenshu'][0]['dengji']=S;
                  $shuju[$k]['fenshu'][1]['dengji']=A;
                  $shuju[$k]['fenshu'][2]['dengji']=B;
                  $shuju[$k]['fenshu'][3]['dengji']=C;
                  $shuju[$k]['fenshu'][4]['dengji']=D;
                  $shuju[$k]['fenshu'][5]['dengji']=E;
                }
                //dump($shuju);exit;
        $this->assign('name',$name);
        $this->assign('sum',$sum);$this->assign('lev',$lev);
        $this->assign('shuju',$shuju);
        $this->display();
    }
    //~
    //月度分数写入数据库
    public function addgradeM(){
      $data=I('post.');
      $lev=$data['lev'];
      //dump($lev);exit;
      $ii=count($data['id']);
      $le=session('admin.id_level');
      for($i=0;$i<$ii;$i++)
      {
        $id=$data['id'][$i];
        $grade=$data['fenshu'][$i];
        if($le==4||$le==7||$le==8||$le==3)
        {
          $this->model=D('planmonth_staff');
        }
        if($le==5)
        {
          if($lev==3)
            $this->model=D('planmonth_staff');
          else
            $this->model=D('planmonth_chief');
        }
        $this->model->where("id=$id")->setField('plan_grade',$grade);
        //dump($id);
        $admin=$this->model->where("id=$id")->find();
      }
        if($le==4||$le==7||$le==8||$le==3)
        {
          $this->model=D('info_admin');         
          $tj['staff_id']=$admin['staff_id'];
          $tj['staff_name']=$admin['staff_name'];
          $tj['year']=$admin['year'];
          $tj['month']=$admin['month'];
          $admin=$this->model->where("id_employee=".$tj['staff_id'])->find();
          $tj['staff_department']=$admin['user_department'];
          $tj['staff_office']=$admin['user_office'];
          $tj['grade_leader']=session('admin.username');
          $this->model=D('grademonth_staff');

          $found=$this->model->where($tj)->find();
          if($found=="")
          {
             $tj['grade']=$data['sum'];
             $tj['grade_leader']=session('admin.username');$tj['grade_last']="";
             if($this->model->create($tj))
                $this->model->add();
          }  
         else
          {
              $id=$found['id'];$tj['grade_last']="";
              $this->model->where($tj)->setField('grade',$data['sum']);
          }
        }
        //ump($lev);exit;
        if($le==5)
        {
          if($lev==3)
          {
          //dump($lev);exit;
          $this->model=D('planmonth_staff');       
          $tj['staff_id']=$admin['staff_id'];
          $tj['staff_name']=$admin['staff_name'];
          $tj['year']=$admin['year'];
          $tj['month']=$admin['month'];
           $count = $this->model->field("id,staff_id,staff_name,year,month,group_concat(plan_grade) as plan_grade,plan_leader")->where($tj)->group('plan_leader')->select();
           foreach ($count as $k => $v) {   //  循环保存每一条值
                  //$map = array();

                  $count[$k]['plan_grade']=explode(",", $v['plan_grade']);
                  $sum=0;
                  foreach ($count[$k]['plan_grade'] as $key => $value) {
                    $sum+=$value;
                  }
                  if($sum==0)
                  {
                    $count[$k]['plan_grade']="";
                  }
                  if($sum!=0)
                  {
                    $count[$k]['plan_grade']=$sum;
                  }
                  //dump($admin);
                  //dump($k);
                 $tj['staff_id']=$v['staff_id'];$tj['staff_name']=$v['staff_name'];$tj['yaer']=$v['year'];$tj['month']=$v['month'];
                 $tj['grade_leader']=$v['plan_leader'];$tj['staff_department']=$admin['department'];$tj['staff_office']=$admin['office'];
                 $this->model=D('grademonth_staff');
                 $found=$this->model->where($tj)->find();
                  //dump($found);
                 
                if($found=="")
                 {
                    $tj['grade']=$count[$k]['plan_grade'];
                    $tj['grade_last']=session('admin.username');
                    if($this->model->create($tj))
                    {
                      //dump($tj);
                      $this->model->add();
                    }
                 }  
               else
                {
                  $id=$found['id'];$tj['grade_last']=session('admin.username');
                  $this->model->where($tj)->setField('grade',$count[$k]['plan_grade']);
                }
           }//dump($count);exit;
          }
          if($lev=="")
          {
          $this->model=D('info_admin');
          $tj['chief_id']=$admin['chief_id'];
          $tj['chief_name']=$admin['chief_name'];
          $tj['year']=$admin['year'];
          $tj['month']=$admin['month'];
          $admin=$this->model->where("id_employee=".$tj['chief_id'])->find();
          $tj['chief_department']=$admin['user_department'];
          $tj['chief_office']=$admin['user_office'];
          $tj['grade_leader']=session('admin.username');
          $this->model=D('grademonth_chief');
          //dump($tj);exit;
          }
          $found=$this->model->where($tj)->find();
           if($found=="")
            {
             $tj['grade']=$data['sum'];
             $tj['grade_leader']=session('admin.username');$tj['grade_last']="";
             if($this->model->create($tj))
             {
                $this->model->add();
             }
            }  
          else
           {
              $id=$found['id'];$tj['grade_last']="";
              $this->model->where($tj)->setField('grade',$data['sum']);
           }
        }    
        //dump($tj);exit;   
        $this->ajaxReturn(array('success'=>1),"json");
    }

    //年度评分列表查看
    public function PlangradeshowY(){
      $tj=I('get.id');
      $tj=explode(",", $tj);
      $le=session('admin.id_level');
      if($le==4||$le==7||$le==8||$le==3)
      {
        $this->model=D('planyear_staff');
        $name=$this->model->where("id=$tj[0]")->getField('staff_name');
      }
      else if($le==5)
      {
        $this->model=D('planyear_chief');
        $name=$this->model->where("id=$tj[0]")->getField('chief_name');
      }
      //dump($tj);exit;
      //循环保存每一条值
      foreach ($tj as $k => $v) {               
                  $shuju[$k]=$this->model->where("id=$v")->find();
                  $f=1;
                  for($i=0;$i<6;$i++)
                  {
                    $shuju[$k]['fenshu'][$i]['fen']=round($shuju[$k]['plan_weight']*$f);
                    $f-=0.2;
                  }
                  $shuju[$k]['fenshu'][0]['dengji']=S;
                  $shuju[$k]['fenshu'][1]['dengji']=A;
                  $shuju[$k]['fenshu'][2]['dengji']=B;
                  $shuju[$k]['fenshu'][3]['dengji']=C;
                  $shuju[$k]['fenshu'][4]['dengji']=D;
                  $shuju[$k]['fenshu'][5]['dengji']=E;
      }
        //dump($shuju);exit;
        $this->assign('name',$name);
        $this->assign('shuju',$shuju);
        $this->display();
    }
    //~
}