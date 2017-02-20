<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class PerformanceController extends BaseController {
    public function _initialize(){
	     if(!session('?admin')){
          $this->redirect('login/login');
          exit;
          }
       // if(session('admin.id_level')==2){
       //    $this->redirect('index/index2');
       //     exit;
       //    }
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
        $this->model=D('planmonth_minister');
        $jh2 = $this->model->field("id,minister_id,minister_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->order('minister_name')->group('minister_name')->select();
        foreach ($jh2 as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh2[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      }
      foreach ($jh as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      //dump($jh);exit;
      $this->assign('jh',$jh);
      $this->assign('jh1',$jh1);
      $this->assign('jh2',$jh2);
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
        $this->model=D('planyear_staff');
        $jh_staff = $this->model->field("id,staff_id,staff_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('staff_name')->select();
        $this->model=D('planyear_minister');
        $jh_minister = $this->model->field("id,minister_id,minister_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(id) as id")->where($tj)->group('minister_name')->select();
        foreach ($jh_staff as $k => $v) {
                    $jh_staff[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  }
        $this->assign('jh_staff',$jh_staff);
        foreach ($jh_minister as $k => $v) {
                    $jh_minister[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  }
        $this->assign('jh_minister',$jh_minister);
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
        else if($lev==5){
          $this->model=D('planmonth_minister');
          $name=$this->model->where("id=$tj[0]")->getField('minister_name');
        }
        else{
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
        $this->assign('lev',$lev);
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
        $lev=I('get.lev');
        if($lev==3){
          $this->model=D('planyear_staff');
          $name=$this->model->where("id=$tj[0]")->getField('staff_name');
        }
        else if($lev==5){
          $this->model=D('planyear_minister');
          $name=$this->model->where("id=$tj[0]")->getField('minister_name');
        }
        else{
          $this->model=D('planyear_chief');
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
        $this->assign('lev',$lev);
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
        $lev=I('get.lev');
        if($lev==3){
          $this->model=D('planmonth_staff');
        }
        else if($lev==5){
          $this->model=D('planmonth_minister');
        }
        else{
          $this->model=D('planmonth_chief');
        }
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
        $lev=I('get.lev');
        if($lev==3){
          $this->model=D('planyear_staff');
        }
        else if($lev==5){
          $this->model=D('planyear_minister');
        }
        else{
          $this->model=D('planyear_chief');
        }
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
        $lev=I('post.lev');
        if($lev==3){
          $this->model=D('planmonth_staff');
        }
        else if($lev==5){
          $this->model=D('planmonth_minister');
        }
        else{
          $this->model=D('planmonth_chief');
        }
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
        $lev=I('post.lev');
        if($lev==3){
          $this->model=D('planyear_staff');
        }
        else if($lev==5){
          $this->model=D('planyear_minister');
        }
        else{
          $this->model=D('planyear_chief');
        }
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
      $searchhh=I('post.searchhh');
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
        //
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

        if($searchhh==""){
        $tjhh['year']=session('admin.year');
        $tjhh['month']=session('admin.month');
        $searchhh[0]=session('admin.year');
        $searchhh[1]=session('admin.month');
        $searchhh[2]="";
        }
        else{
        $tjhh['year']=$searchhh[0];
        $tjhh['month']=$searchhh[1];    
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
        
            $this->model=D('planmonth_minister');
            $tjhh['plan_leader']=session('admin.username');
            $jh2 = $this->model->field("id,minister_id,minister_name,office,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tjhh)->group('minister_name')->select();
            foreach ($jh2 as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh2[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  $jh2[$k]['plan_grade']=explode(",", $v['plan_grade']);
                  $sum=0;
                  foreach ($jh2[$k]['plan_grade'] as $key => $value) {
                    $sum+=$value;
                  }
                  if($sum==0)
                  {
                    $jh2[$k]['plan_grade']="";
                  }
                  if($sum!=0)
                  {
                    $jh2[$k]['plan_grade']=$sum;
                  }                  
                }
                $this->assign('jh2',$jh2);
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
      $this->assign('searchhh',$searchhh);
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

        $this->model=D('planmonth_minister');
        $jh2 = $this->model->field("id,minister_id,minister_name,year,month,plan_name,plan_grade,group_concat(plan_name) as plan_name,group_concat(id) as id,group_concat(plan_grade) as plan_grade")->where($tj)->order('minister_name')->group('minister_name')->select();
        $this->model=D('grademonth_minister');
        //jh1是部长查看科员plan_leader为自己的数据
        foreach ($jh2 as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $jh2[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                  $jh2[$k]['plan_grade']=explode(",", $v['plan_grade']);
                  
                  $sum=0;
                  foreach ($jh2[$k]['plan_grade'] as $key => $value) {
                    $sum+=$value;
                  }
                  if($sum==0)
                  {
                    $jh2[$k]['plan_grade']="";
                  }
                  if($sum!=0)
                  {
                    $jh2[$k]['plan_grade']=$sum;
                  }                  
                }
                $this->assign('jh2',$jh2);
       }
      $this->assign('jh',$jh);
      $this->display();
    }
    //~
    //季度计划评分列表
    public function PlangradeQ(){
      $level=session('admin.id_level');
      $tj['year']=session('admin.year');
      $tj['month']=session('admin.month');
      
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
        else if($lev==5){
        $this->model=D('planmonth_minister');
        $name=$this->model->where("id=$tj[0]")->find();
        $this->model=D('grademonth_minister');
        $name1['minister_id']=$name['minister_id'];
        $name1['year']=$name['year'];
        $name1['month']=$name['month'];
        $name1['grade_leader']=$name['plan_leader'];
        $sum=$this->model->where($name1)->getField('grade');
        //dump($name);exit;
        $name[1]=$name['minister_name'];
        $name[2]=$name['year'];
        $name[3]=$name['month'];
        $this->model=D('planmonth_minister');
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
          else if($lev==5)
            $this->model=D('planmonth_minister');
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
          $tj['plan_leader']=session('admin.username');
           $count = $this->model->field("id,staff_id,staff_name,year,month,group_concat(plan_grade) as plan_grade,plan_leader")->where($tj)->group('plan_leader')->select();
           //dump($count);exit;
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
          if($lev==5)
          {
          //dump($lev);exit;
          $this->model=D('planmonth_minister');       
          $tj['minister_id']=$admin['minister_id'];
          $tj['minister_name']=$admin['minister_name'];
          $tj['year']=$admin['year'];
          $tj['month']=$admin['month'];
          $tj['plan_leader']=session('admin.username');
           $count = $this->model->field("id,minister_id,minister_name,year,month,group_concat(plan_grade) as plan_grade,plan_leader")->where($tj)->group('plan_leader')->select();
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
                 $tj['minister_id']=$v['minister_id'];$tj['minister_name']=$v['minister_name'];$tj['yaer']=$v['year'];$tj['month']=$v['month'];
                 $tj['grade_leader']=$v['plan_leader'];$tj['minister_department']=$admin['department'];$tj['minister_office']=$admin['office'];
                 $this->model=D('grademonth_minister');
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
          // $this->model=D('info_admin');
          // $tj['chief_id']=$admin['chief_id'];
          // $tj['chief_name']=$admin['chief_name'];
          // $tj['year']=$admin['year'];
          // $tj['month']=$admin['month'];
          // $admin=$this->model->where("id_employee=".$tj['chief_id'])->find();
          // $tj['chief_department']=$admin['user_department'];
          // $tj['chief_office']=$admin['user_office'];
          // $tj['grade_leader']=session('admin.username');
          // $this->model=D('grademonth_chief');


          $this->model=D('planmonth_chief');       
          $tj['chief_id']=$admin['chief_id'];
          $tj['chief_name']=$admin['chief_name'];
          $tj['year']=$admin['year'];
          $tj['month']=$admin['month'];
          $tj['plan_leader']=session('admin.username');
           $count = $this->model->field("id,chief_id,chief_name,year,month,group_concat(plan_grade) as plan_grade,plan_leader")->where($tj)->group('plan_leader')->select();
                     //dump($count);exit;
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
          }
          $this->model=D('grademonth_chief');
          $tj['chief_department']=$admin['department'];$tj['chief_office']=$admin['office'];
          if($tj['chief_department']==''){unset($tj['chief_department']);}
          if($tj['chief_office']==''){unset($tj['chief_office']);}
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
    public function GradesubmissionM(){
      $tj['year']=session('admin.year');
      $tj['department']=session('admin.user_department');
      for($i=1;$i<=12;$i++){
        $tj['month']=$i;
        $sum[$i]=0;
        $data[$i]=count(M('grademonth_confirm')->where($tj)->select());
        if($data[$i]!=null){
          $grade[$i]=M('grademonth_confirm')->where($tj)->getField('grade_total',true);
          foreach ($grade[$i] as $key => $value) {
            $sum[$i]+=$value;
          }
          $sum[$i]=$sum[$i]/$data[$i];
        }
      }
      $tj['month']=str_replace ("0", "", session('admin.month_sys'));
      if($data[$tj['month']]==""){
        $tj1['user_department']=session('admin.user_department');
        $all[$tj['month']]=count(M('info_admin')->where($tj1)->where("id_level in (3,4,7,8)")->select());
        $sum[$tj['month']]=count(array_unique(M('grademonth_staff')->where($tj)->where("'grade' != '' and 'staff_department' = '".$tj['department']."'")->select()))+count(array_unique(M('grademonth_chief')->where($tj)->where("'grade' != '' and 'staff_department' = '".$tj['department']."'")->select()));
      }
      $this->assign('data',$data);
      $this->assign('all',$all);
      $this->assign('sum',$sum);
      $this->display();
    }
    public function daihao(){
      $id="confirm";
      $month=I('get.month');
      $tj['month']=I('get.month');
      $tj['year']=session('admin.year');
      $tj['department']=session('admin.user_department');
      $data['staff']=M('grademonth_confirm')->where($tj)->where("id_level=3")->select();
      $data['chief']=M('grademonth_confirm')->where($tj)->where("id_level=4")->select();
      if($data['staff']==null&&$data['chief']==null){
        $id="";
        unset($tj['department']);
        $tj['chief_department']=session('admin.user_department');
        $data['chief']=M('grademonth_chief')->where($tj)->order('chief_office desc')->select();
        unset($tj['chief_department']);
        $tj['staff_department']=session('admin.user_department');
        $data['staff']=M('grademonth_staff')->field("staff_id,staff_name,staff_department,staff_office,year,month,group_concat(grade) as grade,group_concat(grade_leader) as grade_leader,grade_last")->where($tj)->order('staff_office desc')->group('staff_name')->select();
        
        foreach ($data['staff'] as $k => $v) {
          
          $info=M('info_admin')->where("username = '".$v['staff_name']."'")->getField('id_level,user_job');
          $key=array_keys($info);
          $data['staff'][$k]['level']=$key[0];
          $data['staff'][$k]['job']=$info[$key[0]];
          $grade[$k]=explode(",", $data['staff'][$k]['grade']);
          $sum=0;
          foreach ($grade[$k] as $key => $value) {
            $sum+=$value;
          }
          $data['staff'][$k]['grade']=$sum;
        }
        foreach ($data['chief'] as $k => $v) {
          $info=M('info_admin')->where("username = '".$v['chief_name']."'")->getField('id_level,user_job');
          // dump(array_keys($info));exit;
          $key=array_keys($info);
          $data['chief'][$k]['level']=$key[0];
          $data['chief'][$k]['job']=$info[$key[0]];
        }
      }
      //dump($data);exit;
      $this->assign('data',$data);
      $this->assign('id',$id);
      $this->assign('month',$month);
      $this->display();
    }
    public function daihao1(){
      $data=I('post.');
      //dump($data);exit;
      foreach($data['chief'] as $k => $v){
        $this->model=M('grademonth_confirm');
        $v['grade_last']=session('admin.username');
        if($this->model->create($v))
             {
                $this->model->add();
             }
      }
      foreach($data['staff'] as $k => $v){
        $this->model=M('grademonth_confirm');
        $v['grade_last']=session('admin.username');
        if($this->model->create($v))
             {
                $this->model->add();
             }
      }
      $this->ajaxReturn(array('success'=>1),"json");
    }
    public function Gradequarter(){
      $quarter = I('get.quarter');
      $info=implode(',',M('info_admin')->where("user_leader = '".session('admin.username')."'")->getField('username',true));
      $tj['grade_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      if(session('admin.id_level')==4){
        $level='3,7';
      }
      if(session('admin.id_level')==5){
        $level='4,8';
      } 
      $info=str_replace(",","','",$info);
      $data[1]=M('grademonth_confirm')->field("id_employee,name,department,id_level,office,year,job,group_concat(month) as month,group_concat(grade_total) as grade")->where($tj)->where("month in (1,2,3) and name in ('".$info."') and id_level in (".$level.")")->group('name')->select();
      $data[2]=M('grademonth_confirm')->field("id_employee,name,department,id_level,office,year,job,group_concat(month) as month,group_concat(grade_total) as grade")->where($tj)->where("month in (4,5,6) and name in ('".$info."') and id_level in (".$level.")")->group('name')->select();
      $data[3]=M('grademonth_confirm')->field("id_employee,name,department,id_level,office,year,job,group_concat(month) as month,group_concat(grade_total) as grade")->where($tj)->where("month in (7,8,9) and name in ('".$info."') and id_level in (".$level.")")->group('name')->select();
      $data[4]=M('grademonth_confirm')->field("id_employee,name,department,id_level,office,year,job,group_concat(month) as month,group_concat(grade_total) as grade")->where($tj)->where("month in (10,11,12) and name in ('".$info."') and id_level in (".$level.")")->group('name')->select();
      for($i=1;$i<=4;$i++){
        $data1[$i]=count($data[$i]);
      }
      //显示季度内容
      if($quarter!='')
      {
        $data=$data[$quarter];
        foreach ($data as $key => $value) {
        $data[$key]['month']=explode(",", $value['month']);
        $data[$key]['grade']=explode(",", $value['grade']);  
        }
        foreach ($data as $k => $v) {
          for($i=0;$i<3;$i++)
          {
          if($v['month'][$i]==1||$v['month'][$i]==4||$v['month'][$i]==7||$v['month'][$i]==10){$data[$k][0]=$v['grade'][$i];}
          if($v['month'][$i]==2||$v['month'][$i]==5||$v['month'][$i]==8||$v['month'][$i]==11){$data[$k][1]=$v['grade'][$i];}
          if($v['month'][$i]==3||$v['month'][$i]==6||$v['month'][$i]==9||$v['month'][$i]==12){$data[$k][2]=$v['grade'][$i];}
          }

        }
        foreach ($data as $k => $v) {
          $sum=0;
          $count=count($v['grade']);
          for($i=0;$i<$count;$i++)
          {
            $sum+=$v['grade'][$i];
          }
          $data[$k]['sum']=round(($sum/$count)*0.7,1);
        }
        //dump($data);exit;
        $this->assign('data',$data);
      }
      $this->assign('quarter',$quarter);
      $this->assign('data1',$data1);
      $this->display();

    }
    public function quarterlist(){
      $quarter = I('get.quarter');

      $info=implode(',',M('info_admin')->where("user_leader = '".session('admin.username')."'")->getField('username',true));
      $tj['grade_leader']=session('admin.username');
      $tj['year']=session('admin.year');
      if(session('admin.id_level')==4){
        $level='3,7';
      }
      if(session('admin.id_level')==5){
        $level='4,8';
      } 
      $info=str_replace(",","','",$info);
      if($quarter==1){
        $month='1,2,3';
      }
      if($quarter==2){
        $month='4,5,6';
      }
      if($quarter==3){
        $month='7,8,9';
      }
      if($quarter==4){
        $month='10,11,12';
      }
      $data=M('grademonth_confirm')->field("id_employee,name,department,id_level,office,year,job,group_concat(month) as month,group_concat(grade_total) as grade")->where($tj)->where("month in (".$month.") and name in ('".$info."') and id_level in (".$level.")")->group('name')->select();
      
      foreach ($data as $key => $value) {
        $data[$key]['month']=explode(",", $value['month']);
        $data[$key]['grade']=explode(",", $value['grade']);
      }
      //dump($data);exit;
      $this->assign('data',$data);
      $this->assign('quarter',$quarter);
      $this->display();

    }

}