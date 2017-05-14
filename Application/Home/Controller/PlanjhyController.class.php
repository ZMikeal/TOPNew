<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class PlanjhyController extends BaseController {
	 	 public function _initialize(){
       if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
     if(session('admin.id_level')==3||session('admin.id_level')==4||session('admin.id_level')==5||session('admin.id_level')==7||session('admin.id_level')==8){
          $this->redirect('plan/index');
          exit;
        }
   }
	 

    public function index(){

       $this->display();
   }

    public function midplan(){
       $le=session('admin.id_level');
      $id_employee=session('admin.id_employee');
      if($le==3)
      {
        $this->model=D('planmonth_staff');
        $list = $this->model->where("staff_id=$id_employee")->select();
        //dump($list);exit;
      }
      if($le==4)
      {
        $this->model=D('planmonth_chief');
        $list = $this->model->where("chief_id=$id_employee")->select();
      }
      if($le==5)
      {
        $this->model=D('planmonth_minister');
        $list = $this->model->where("minister_id=$id_employee")->select();
      }

      $this->assign('list',$list);
      $this->shangji();
      $this->display();
    }

    public function formmidplan(){
      //echo C('USER_TYPE');exit;
      $le=session('admin.user_department');
      $this->model=D('info_admin');
      $list = $this->model->where("user_department='".$le."'")->select();
      $this->assign('list',$list);

      $vse['1'] = date('Y');
      $vse['2'] = date('Y') - 1;
      $vse['m'] = date('m');
      
      $this->assign('year',$vse);    
      $list1 = M('info_systime')->where("user_department='".$le."'")->select();
      $this->assign('list1',$list1);
      //dump($list1);exit;

      $this->display();
    }

    public function delete(){
      // $id=I('get.uid');
      $id1=I('post.pas');
      //echo 'hhhh';exit;
      //dump($id1);exit;
      $result=M('info_systime')->where("id=$id1")->delete();
       if($result)
      {
        $this->ajaxReturn(array('success'=>1),"json");
      }
      else
      {
        $this->ajaxReturn(array('success'=>0),"json");
      }
    }


    public function addmplan(){
           
            $this->model=D('info_systime');
            $data1=I('post.plan');
            $id1=I('post.ii');
            //dump($id1);exit;
            $data2=I('id_employee');
            $department=session('admin.user_department');
            //dump($data2);exit;
            //$result=$this->model->where("user_department='".$department."'")->delete();
    	      foreach ($data1 as $k => $v) {
                  $map = array();
                  //$map['k'] = $k;     //  保存216 这个键名
      
                  $map['year'] = $v['year'];;
                  $map['month'] = $v['month'];
                  $map['id_employee'] = $data2[$k-1];
                  $hot=M('info_admin')->where("id_employee='".$map['id_employee']."'")->getField('username');
                  $map['username'] = $hot;
                  $map['id_employee'] = $data2[$k-1];
                  $map['user_department']=session('admin.user_department');
                  
                  //dump($map);exit;
                  if($id1[$k-1]!=null)
                  {
                    $id=$id1[$k-1];
                     if($map['id_employee']!="")
                     {
                      if($this->model->create($map)){
                            $this->model->where("id=$id")->save();
                          }    
                     }
                     if($map['id_employee']=="")
                     {
                      if($this->model->create($map)){
                            $this->model->where("id=$id")->delete();
                          }    
                     }
                   }
                   if($id1[$k-1]==null)
                   {
                     if($map['id_employee']!="")
                     {
                      if($this->model->create($map)){
                            $this->model->add();
                          }    
                     }
                   }
                 
                  }

                //$this->success('创建时间成功！',U('Planjhy/formmidplan'));
  echo 
         "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <script type='text/javascript'> alert('创建时间成功！');parent.location.href='../Planjhy/formmidplan'; </script>"; 

    }

    protected function shangji(){
      $username=session('admin.user_leader');
      //dump($username);exit;
      if($username!="")
      {
      $list1 = M('info_admin')->where('username="'.$username.'"')->find();
      //dump($list1);exit;
      if($list1['id_level']==3)
      {
        $list2 = M('planmonth_staff')->where('staff_id="'.$list1['id_employee'].'"')->select();
      }
      if($list1['id_level']==4)
      {
        //dump($list1);exit;
        $list2 = M('planmonth_chief')->where('chief_id="'.$list1['id_employee'].'"')->select();
      }
      if($list1['id_level']==5)
      {
        $list2 = M('planmonth_minister')->where('minister_id="'.$list1['id_employee'].'"')->select();
      }
      }
      //dump($list2.length);exit;
      $this->assign('list2',$list2);
    }


     public function vse(){
      $this->model=D('info_item');
      $tj['if_delete']='0';
      $tj['department']=session('admin.user_department');
      //dump($tj);
      $vse = $this->model->where($tj)->select();
      //dump($vse);exit;
      $this->assign('vse',$vse);// 赋值数据集

      $tj['if_delete']='1';
      $tj['department']=session('admin.user_department');
      //dump($tj);
      $vse1 = $this->model->where($tj)->select();
      //dump($vse);exit;
      $this->assign('vse1',$vse1);// 赋值数据集

      
      $this->model=D('info_admin');
      $tj1['user_department']=session('admin.user_department');
      $form_vse = $this->model->where($tj1)->select();
      $this->assign('form_vse',$form_vse);// 赋值数据集
      //dump($form_vse);



      $this->model=D('info_project');
      $project=$this->model->where()->select();
      //dump($project);exit;
      $this->assign('project',$project);// 赋值数据集
      $this->display();
    }
    public function vseform(){
      $vse=I('post.vse');
      $project=I('post.project');
      $this->model=D('info_item');
      $tj1['department']=session('admin.user_department');
      $tj1['project']=$project;
      $tj1['vse']=$vse;
      $finduser=$this->model->where($tj1)->find();
      if($finduser){
        $result['success']=-1;
        $this->ajaxReturn($result,"json");
      }
      else{
        $this->model=D('info_admin');
        $tj['user_department']=session('admin.user_department');
        $tj['username']=$vse;
        $user = $this->model->where($tj)->find();
        $map['vse_id']=$user['id_employee'];
        $map['department']=$user['user_department'];
        $map['office']=$user['user_office'];
        $map['leader']=$user['user_leader'];
        $map['if_delete']=0;
        $map['project']=$project;
        $map['vse']=$vse;
        $map['dm']=0;
        $map['xm']=0;
        $this->model=D('info_item');
        if($this->model->create($map)){
        $this->model->add();
        $result['success']=1;
        $this->ajaxReturn($result,"json");
       }
       else{
        $result['success']=0;
        $this->ajaxReturn($result,"json");
       }
      }
       $this->display();
    }
    public function vsemod(){
      $tj1['id']=I('post.itemid');
      $tj['project']=I('post.itempro');
      $tj['vse_id']=I('post.itemuid');
      $this->model=D('info_item');
      $result=$this->model->where($tj)->find();
      if($result)
      {
        $result['success']=-1;
        $this->ajaxReturn($result,"json");
      }
      else
      {
        $tj2['project']=I('post.itempro');
        if($this->model->create($tj2))
        {
        $this->model->where($tj1)->save();
        $result['success']=1;
        //$result['ss']=$tj['vse_id'];
        $this->ajaxReturn($result,"json");
        }
        else
        {
           $result['success']=0;
           $this->ajaxReturn($result,"json");
        }
      }
       
    }
    public function deletevse(){
       $vid=I('get.vid');
       $this->model=D('info_item');
       $result=$this->model->where("id=$vid")->setField('if_delete',1);
        $result1['success']=1;
        $this->ajaxReturn($result1,"json");
    }  
    public function recovervse(){
       $vid=I('get.vid');
       $this->model=D('info_item');
       $result=$this->model->where("id=$vid")->setField('if_delete',0);
        $result1['success']=1;
        $this->ajaxReturn($result1,"json");
    }  


    public function user(){
      $this->model=D('info_admin');
      $tj['if_delete']='0';
      $tj['user_department']=session('admin.user_department');
      //dump($tj);
      $vse = $this->model->where($tj)->order('id desc')->select();
      $this->assign('vse',$vse);// 赋值数据集

      $tj['if_delete']='1';
      $tj['user_department']=session('admin.user_department');
      //dump($tj);
      $vse1 = $this->model->where($tj)->order('id desc')->select();
      //dump($vse);exit;
      $this->assign('vse1',$vse1);// 赋值数据集
      $leadertj['user_department']=session('admin.user_department');
      $leader=$this->model->where($leadertj)->where("id_level in (4,5,8) or if_authority in (1,2,3,4)")->getField('username',true);
      $this->model=D('info_admin');
      $tj1['user_department']=session('admin.user_department');
      $form_vse = $this->model->where($tj1)->select();
      $this->assign('form_vse',$form_vse);// 赋值数据集
      $this->assign('leader',$leader);   
      $this->display();
    }

    public function leader(){
      $this->model=D('info_admin');
      $lev=I('post.level');
      $leadertj['user_department']=session('admin.user_department');
      $depart = $leadertj['user_department'];
      if($lev=="部长"){
         $leader=$this->model->where("(id_level = 10) OR ((id_level = 5) AND (user_department= '$depart' ))")->getField('username',true);
      }
      if($lev=="科长"){
         $leader=$this->model->where($leadertj)->where("id_level = 5")->getField('username',true);
      }
      if($lev=="科员"||$lev==""){
         $leader=$this->model->where($leadertj)->where("(id_level in (4,5,8)) OR (if_authority in (2,3,4))")->getField('username',true);
      }
      if($lev=="项目经理"){
         $leader=$this->model->where($leadertj)->where("(id_level in (4,5)) OR (if_authority in (2,3))")->getField('username',true);
      }
      $this->ajaxReturn($leader, 'json');
    }

    public function userform(){
      $username=I('post.username');
      $id_employee=I('post.id_employee');
      $this->model=D('info_admin');
      $finduser=$this->model->where("id_employee=$id_employee and if_delete=0")->find();
      if($finduser){
        $result['success']=-1;
        $this->ajaxReturn($result,"json");
      }
      else{
        $map['username']=$username;
        $map['user_department']=session('admin.user_department');
        $map['user_office']=I('post.office1');
        $map['user_leader']=I('post.leader1');
        $map['if_delete']=0;
        $map['id_level']=I('post.level1');;
        $map['id_employee']=I('post.id_employee');
        $map['user_job']=I('post.job');
        $map['nickname']=I('post.nickname');
        $map['user_type']=I('post.type1');

        if($this->model->create($map)){
        $this->model->add();
        $result['success']=1;
        $this->ajaxReturn($result,"json");
       }
       else{
        $result['success']=0;
        $this->ajaxReturn($result,"json");
       }
      }
       $this->display();
    }
    public function usermod(){
      $tj1['id']=I('post.id');
      $this->model=D('info_admin');
      //$result=$this->model->where($tj)->find();
      
        $tj2['user_office']=I('post.office');
        $tj2['user_job']=I('post.job');
        $tj2['id_level']=I('post.level');
        $tj2['if_authority']=I('post.radio');
        if($tj2['if_authority']==""){
          unset($tj2['if_authority']);
        }
        if($tj2['id_level']==""){
          unset($tj2['id_level']);
        }
        $tj2['user_type']=I('post.typee');
        if($tj2['user_type']==""){
          unset($tj2['user_type']);
        }
        $tj2['user_leader']=I('post.leader');
        if($tj2['user_leader']==""){
          unset($tj2['user_leader']);
        }
        if($this->model->create($tj2))
        {
        $this->model->where($tj1)->save();
        $result['success']=1;
        //$result['ss']=$tj['vse_id'];
        $this->ajaxReturn($result,"json");
        }
        else
        {
           $result['success']=0;
           $this->ajaxReturn($result,"json");
        }
      
       
    }
    public function deleteuser(){
       $vid=I('get.vid');
       $this->model=D('info_admin');
       $result=$this->model->where("id=$vid")->setField('if_delete',1);
        $result1['success']=1;
        $this->ajaxReturn($result1,"json");
    }  
    public function deleuser(){
       $vid=I('get.vid');
       $this->model=D('info_admin');
       $result=$this->model->where("id=$vid")->delete();
        $result1['success']=1;
        $this->ajaxReturn($result1,"json");
    }  
    public function recoveruserpas(){
       $vid=I('get.vid');
       $this->model=D('info_admin');
       $result=$this->model->where("id=$vid")->setField('password','14e1b600b1fd579f47433b88e8d85291');
        $result1['success']=1;
        $this->ajaxReturn($result1,"json");
    }  
    public function recoveruser(){
       $vid=I('get.vid');
       $this->model=D('info_admin');
       $result=$this->model->where("id=$vid")->setField('if_delete',0);
        $result1['success']=1;
        $this->ajaxReturn($result1,"json");
    }

    //月度计划提交情况查看
    public function Plan_submission(){
      $search=I('post.search');
      if($search!=""){
        $tj['id_level']=$search;
      }
      else{
        $tj['id_level']=3;
        $search=3;
      }
      $tj['user_department']=session('admin.user_department');
      $all=M('info_admin')->where($tj)->where("if_delete=0")->getField('username',true);
      $month=date('m');

       if($tj['id_level']==3||$tj['id_level']==7){$this->model=M('planmonth_staff'); $name='staff_name';}
       if($tj['id_level']==4||$tj['id_level']==8){$this->model=M('planmonth_chief'); $name='chief_name';}
       if($tj['id_level']==5){$this->model=M('planmonth_minister'); $name='minister_name';}

      unset($tj['id_level']);
      unset($tj['user_department']);
      $tj['department']=session('admin.user_department');
      $tj['year']=date('Y');
      for($i=0;$i<$month;$i++)
      {
        $tj['month']=$i+1;
        $submitted[$i]=array_unique($this->model->where($tj)->getField("$name",true));

        $intersect[$i]=array_intersect($all,$submitted[$i]);//返回两个数组的交集
        $intersectsum[$i]=count($intersect[$i]);//计算提交人数

        $diff[$i]=array_diff($all,$intersect[$i]);//返回两个数组的差集
        $diffsum[$i]=count($diff[$i]);//计算未提交人数

        $intersect[$i]=implode(',', $intersect[$i]);
        $diff[$i]=implode(',', $diff[$i]);
        
        if($intersect[$i]==""&&$intersectsum[$i]=="")
        {
          $diff[$i]=implode(',', $all);
          $diffsum[$i]=count($all);
        }
      }

      $date['month']=$month;
      $date['year']=date('Y');
      $this->assign('intersect',$intersect);
      $this->assign('intersectsum',$intersectsum);
      $this->assign('diff',$diff);
      $this->assign('diffsum',$diffsum);
      $this->assign('date',$date);
      $this->assign('search',$search);
      //dump($intersect);exit;
      $this->display();
    }
    //年度计划提交情况查看
    public function Plan_submissionY(){
      $search=I('post.search');
      if($search!=""){
        $tj['id_level']=$search;
      }
      else{
        $tj['id_level']=3;
        $search=3;
      }
      $tj['user_department']=session('admin.user_department');
      $all=M('info_admin')->where($tj)->where("if_delete=0")->getField('username',true);

       if($tj['id_level']==3||$tj['id_level']==7){$this->model=M('planyear_staff'); $name='staff_name';}
       if($tj['id_level']==4||$tj['id_level']==8){$this->model=M('planyear_chief'); $name='chief_name';}
       if($tj['id_level']==5){$this->model=M('planyear_minister'); $name='minister_name';}

      unset($tj['id_level']);
      unset($tj['user_department']);
      $tj['department']=session('admin.user_department');
      $tj['year']=date('Y');
      for($i=2017;$i<=$tj['year'];$i++)
      {
        $submitted[$i]=array_unique($this->model->where($tj)->getField("$name",true));

        $intersect[$i]=array_intersect($all,$submitted[$i]);
        $intersectsum[$i]=count($intersect[$i]);

        $diff[$i]=array_diff($all,$intersect[$i]);
        $diffsum[$i]=count($diff[$i]);

        $intersect[$i]=implode(',', $intersect[$i]);
        $diff[$i]=implode(',', $diff[$i]);

        if($intersectsum[$i]==""&&$intersect[$i]=="")
        {
          $diff[$i]=implode(',', $all);
          $diffsum[$i]=count($all);
        }
      }
      $date['year']=date('Y');
      $this->assign('intersect',$intersect);
      $this->assign('intersectsum',$intersectsum);
      $this->assign('diff',$diff);
      $this->assign('diffsum',$diffsum);
      $this->assign('date',$date);
      $this->assign('search',$search);
      //dump($intersect);exit;
      $this->display();
    }
    public function submissionshowlist(){
      $tj['id_level']=I('get.level');
      $tj['user_department']=session('admin.user_department');
      $all=M('info_admin')->where($tj)->where("if_delete=0")->getField('username',true);
      $all=implode("','", $all);
      $lev=$tj['id_level'];
      $tj1['month']=I('get.month')+1;
      $tj1['year']=date('Y');
      $tj1['department']=session('admin.user_department');
      if($lev==3||$lev==7){
        $this->model=M('planmonth_staff');
        $jh = $this->model->field("if_confirm,staff_id,staff_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(if_confirm) as if_confirm")->where($tj1)->where("staff_name in ('".$all."')")->order('staff_id DESC')->group('staff_name')->select();
      }
      if($tj['id_level']==4||$tj['id_level']==8){
        $this->model=M('planmonth_chief'); 
        $jh = $this->model->field("if_confirm,chief_id,chief_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(if_confirm) as if_confirm")->where($tj1)->where("chief_name in ('".$all."')")->order('chief_id DESC')->group('chief_name')->select();
      }
      if($tj['id_level']==5){
        $this->model=M('planmonth_minister'); 
        $jh = $this->model->field("if_confirm,minister_id,minister_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(if_confirm) as if_confirm")->where($tj1)->where("minister_name in ('".$all."')")->order('minister_id DESC')->group('minister_name')->select();
      }
      foreach ($jh as $k => $v) {
        $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
        $a=array('0'=>'待确认','1'=>'已确认','-1'=>'已退回',','=>'<br>');
        $jh[$k]['if_confirm']=strtr($v['if_confirm'],$a);
      }
      $this->assign('lev',$lev);
      $this->assign('jh',$jh);
      $this->display();
    }
    public function submissionshowlistY(){
      $tj['id_level']=I('get.level');
      $tj['user_department']=session('admin.user_department');
      $all=M('info_admin')->where($tj)->where("if_delete=0")->getField('username',true);
      $all=implode("','", $all);
      $lev=$tj['id_level'];
      $tj1['year']=I('get.year');
      $tj1['department']=session('admin.user_department');
      if($lev==3||$lev==7){
        $this->model=M('planyear_staff');
        $jh = $this->model->field("if_confirm,staff_id,staff_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(if_confirm) as if_confirm")->where($tj1)->where("staff_name in ('".$all."')")->order('staff_id DESC')->group('staff_name')->select();
      }
      if($tj['id_level']==4||$tj['id_level']==8){
        $this->model=M('planyear_chief'); 
        $jh = $this->model->field("if_confirm,chief_id,chief_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(if_confirm) as if_confirm")->where($tj1)->where("chief_name in ('".$all."')")->order('chief_id DESC')->group('chief_name')->select();
      }
      if($tj['id_level']==5){
        $this->model=M('planyear_minister'); 
        $jh = $this->model->field("if_confirm,minister_id,minister_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(if_confirm) as if_confirm")->where($tj1)->where("minister_name in ('".$all."')")->order('minister_id DESC')->group('minister_name')->select();
      }
      foreach ($jh as $k => $v) {
        $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
        $a=array('0'=>'待确认','1'=>'已确认','-1'=>'已退回',','=>'<br>');
        $jh[$k]['if_confirm']=strtr($v['if_confirm'],$a);
      }
      $this->assign('lev',$lev);
      $this->assign('jh',$jh);
      $this->display();
    }
    //月度工作总结查看
    public function Plan_evaluation(){
      $search=I('post.search');
      if($search!=""){
        $tj['id_level']=$search;
      }
      else{
        $tj['id_level']=3;
        $search=3;
      }
      $tj['user_department']=session('admin.user_department');
      $all=M('info_admin')->where($tj)->where("if_delete=0")->getField('username',true);
      $month=date('m');

       if($tj['id_level']==3||$tj['id_level']==7){$this->model=M('planmonth_staff'); $name='staff_name';}
       if($tj['id_level']==4||$tj['id_level']==8){$this->model=M('planmonth_chief'); $name='chief_name';}
       if($tj['id_level']==5){$this->model=M('planmonth_minister'); $name='minister_name';}

      unset($tj['id_level']);
      unset($tj['user_department']);
      $tj['department']=session('admin.user_department');
      $tj['year']=date('Y');
      for($i=0;$i<$month;$i++)
      {
        $tj['month']=$i+1;
        $submitted[$i]=array_unique($this->model->where($tj)->getField("$name",true));
        $intersect[$i]=array_intersect($all,$submitted[$i]);
        $planself_submitted[$i]=array_unique($this->model->where($tj)->where("Plan_sum!=''")->getField("$name",true));
        $planself_intersect[$i]=array_intersect($intersect[$i],$planself_submitted[$i]);
        $planself_intersectsum[$i]=count($planself_intersect[$i]);
        $planself_diff[$i]=array_diff($intersect[$i],$planself_intersect[$i]);
        $planself_diffsum[$i]=count($planself_diff[$i]);

        $planself_intersect[$i]=implode(',', $planself_intersect[$i]);
        $planself_diff[$i]=implode(',', $planself_diff[$i]);

        if($planself_intersect[$i]==""&&$planself_diff[$i]=="")
        {
          $planself_diff[$i]=implode(',', $intersect[$i]);
          $planself_diffsum[$i]=count($intersect[$i]);
        }
      }
      $date['month']=$month;
      $date['year']=date('Y');
      $this->assign('intersect',$planself_intersect);
      $this->assign('intersectsum',$planself_intersectsum);
      $this->assign('diff',$planself_diff);
      $this->assign('diffsum',$planself_diffsum);
      $this->assign('date',$date);
      $this->assign('search',$search);
      //dump($intersect);exit;
      $this->display();
    }
    //年度工作总结查看
    public function Plan_evaluationY(){
      $search=I('post.search');
      if($search!=""){
        $tj['id_level']=$search;
      }
      else{
        $tj['id_level']=3;
        $search=3;
      }
      $tj['user_department']=session('admin.user_department');
      $all=M('info_admin')->where($tj)->where("if_delete=0")->getField('username',true);

       if($tj['id_level']==3||$tj['id_level']==7){$this->model=M('planyear_staff'); $name='staff_name';}
       if($tj['id_level']==4||$tj['id_level']==8){$this->model=M('planyear_chief'); $name='chief_name';}
       if($tj['id_level']==5){$this->model=M('planyear_minister'); $name='minister_name';}

      unset($tj['id_level']);
      unset($tj['user_department']);
      $tj['department']=session('admin.user_department');
      $tj['year']=date('Y');
      for($i=2017;$i<=$tj['year'];$i++)
      {
        $submitted[$i]=array_unique($this->model->where($tj)->getField("$name",true));
        $intersect[$i]=array_intersect($all,$submitted[$i]);
        $planself_submitted[$i]=array_unique($this->model->where($tj)->where("Plan_sum!=''")->getField("$name",true));
        $planself_intersect[$i]=array_intersect($intersect[$i],$planself_submitted[$i]);
        $planself_intersectsum[$i]=count($planself_intersect[$i]);
        $planself_diff[$i]=array_diff($intersect[$i],$planself_intersect[$i]);
        $planself_diffsum[$i]=count($planself_diff[$i]);

        $planself_intersect[$i]=implode(',', $planself_intersect[$i]);
        $planself_diff[$i]=implode(',', $planself_diff[$i]);

        if($planself_intersect[$i]==""&&$planself_diff[$i]=="")
        {
          $planself_diff[$i]=implode(',', $intersect[$i]);
          $planself_diffsum[$i]=count($intersect[$i]);
        }
      }
      $date['year']=date('Y');
      $this->assign('intersect',$planself_intersect);
      $this->assign('intersectsum',$planself_intersectsum);
      $this->assign('diff',$planself_diff);
      $this->assign('diffsum',$planself_diffsum);
      $this->assign('date',$date);
      $this->assign('search',$search);
      //dump($intersect);exit;
      $this->display();
    }
    public function evaluationshowlist(){
      $tj['id_level']=I('get.level');
      //$tj['id_level1']=I('get.year');
      //dump($tj);exit;
      $tj['user_department']=session('admin.user_department');
      $all=M('info_admin')->where($tj)->where("if_delete=0")->getField('username',true);
      $all=implode("','", $all);
      $lev=$tj['id_level'];
      $tj1['month']=I('get.month')+1;
      $tj1['year']=date('Y');
      $tj1['department']=session('admin.user_department');
      if($lev==3||$lev==7){
        $this->model=M('planmonth_staff');
        $jh = $this->model->field("plan_sum,plan_grade,staff_id,staff_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(plan_sum) as plan_sum,group_concat(plan_grade) as plan_grade")->where($tj1)->where("staff_name in ('".$all."')")->where("plan_sum!=''")->order('staff_id desc')->group('staff_name')->select();
      }
      if($tj['id_level']==4||$tj['id_level']==8){
        $this->model=M('planmonth_chief'); 
        $jh = $this->model->field("plan_sum,plan_grade,chief_id,chief_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(plan_sum) as plan_sum,group_concat(plan_grade) as plan_grade")->where($tj1)->where("chief_name in ('".$all."')")->where("plan_sum!=''")->order('chief_id desc')->group('chief_name')->select();
      }
      if($tj['id_level']==5){
        $this->model=M('planmonth_minister'); 
        $jh = $this->model->field("plan_sum,plan_grade,minister_id,minister_name,year,month,plan_name,group_concat(plan_name) as plan_name,group_concat(plan_sum) as plan_sum,group_concat(plan_grade) as plan_grade")->where($tj1)->where("minister_name in ('".$all."')")->where("plan_sum!=''")->order('minister_id desc')->group('minister_name')->select();
      }
      foreach ($jh as $k => $v) {
        $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
        $a=array('0'=>'待确认','1'=>'已确认','-1'=>'已退回',','=>'<br>');
        $jh[$k]['plan_sum']=strtr($v['plan_sum'],$a);
        $jh[$k]['plan_grade']=strtr($v['plan_grade'],$a);
      }
      $this->assign('lev',$lev);
      $this->assign('jh',$jh);
      $this->display();
    }
     public function evaluationshowlistY(){
      $tj['id_level']=I('get.level');
      $tj['user_department']=session('admin.user_department');
      $all=M('info_admin')->where($tj)->where("if_delete=0")->getField('username',true);
      $all=implode("','", $all);
      $lev=$tj['id_level'];
      $tj1['year']=I('get.year');
      $tj1['department']=session('admin.user_department');
      if($lev==3||$lev==7){
        $this->model=M('planyear_staff');
        $jh = $this->model->field("plan_sum,plan_grade,staff_id,staff_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(plan_sum) as plan_sum,group_concat(plan_grade) as plan_grade")->where($tj1)->where("staff_name in ('".$all."')")->where("plan_sum!=''")->order('staff_id desc')->group('staff_name')->select();
      }
      if($tj['id_level']==4||$tj['id_level']==8){
        $this->model=M('planyear_chief'); 
        $jh = $this->model->field("plan_sum,plan_grade,chief_id,chief_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(plan_sum) as plan_sum,group_concat(plan_grade) as plan_grade")->where($tj1)->where("chief_name in ('".$all."')")->where("plan_sum!=''")->order('chief_id desc')->group('chief_name')->select();
      }
      if($tj['id_level']==5){
        $this->model=M('planyear_minister'); 
        $jh = $this->model->field("plan_sum,plan_grade,minister_id,minister_name,year,plan_name,group_concat(plan_name) as plan_name,group_concat(plan_sum) as plan_sum,group_concat(plan_grade) as plan_grade")->where($tj1)->where("minister_name in ('".$all."')")->where("plan_sum!=''")->order('minister_id desc')->group('minister_name')->select();
      }
      foreach ($jh as $k => $v) {
        $jh[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
        $a=array('0'=>'待确认','1'=>'已确认','-1'=>'已退回',','=>'<br>');
        $jh[$k]['plan_sum']=strtr($v['plan_sum'],$a);
        $jh[$k]['plan_grade']=strtr($v['plan_grade'],$a);
      }
      $this->assign('lev',$lev);
      $this->assign('jh',$jh);
      $this->display();
    }
    //清单调整
    public function Plan_adjustment(){
      $search=I('post.search');
      if(session('admin.user_department')!='')
      {
        $tj['department']=session('admin.user_department');
      }
      if($search[3]=='')
      {
        $data='';
      }
      else
      {
        if($search[2]==3||$search[2]==7){$this->model=M('planmonth_staff');$tj['staff_id']=$search[3];}
        if($search[2]==4||$search[2]==8){$this->model=M('planmonth_chief');$tj['chief_id']=$search[3];}
        if($search[2]==5){$this->model=M('planmonth_minister');$tj['minister_id']=$search[3];}
        $tj['year']=$search[0];
        $tj['month']=$search[1];
        $data=$this->model->where($tj)->select();
        $this->assign('data',$data);
        //dump($data);exit;
      }
      $this->assign('search',$search);
      $this->display();
    }
    public function mod(){
      $level=trim(I('post.level'));
      $tj1['id']=trim(I('post.id'));
      $tj['plan_leader']=trim(I('post.leader'));
      $tj['month']=trim(I('post.month'));
      $tj['year']=trim(I('post.year'));
      $tj['department']=trim(I('post.department'));
      $tj['office']=trim(I('post.office'));
      if($level==3||$level==7){$this->model=D('planmonth_staff');}
      if($level==4||$level==8){$this->model=D('planmonth_chief');}
      if($level==5){$this->model=D('planmonth_miniter');}
      if($this->model->create($tj))
        {
          $this->model->where($tj1)->save();
          $result['success']=1;
          $this->ajaxReturn($result,"json");
        }
        else
        {
          $result['success']=0;
          $this->ajaxReturn($result,"json");
        }
    }
    //评分调整
    public function Grade_adjustment(){
      $search=I('post.search');
      if($search[3]=='')
      {
        $data='';
      }
      else
      {
        if($search[2]==3||$search[2]==7)
        {
          $this->model=M('grademonth_staff');$tj['staff_id']=$search[3];
          if(session('admin.user_department')!='')
            {
              $tj['staff_department']=session('admin.user_department');
            }
        }
        if($search[2]==4||$search[2]==8)
        {
          $this->model=M('grademonth_chief');$tj['chief_id']=$search[3];
          if(session('admin.user_department')!='')
            {
              $tj['chief_department']=session('admin.user_department');
            }
        }
        if($search[2]==5)
        {
          $this->model=M('grademonth_minister');$tj['minister_id']=$search[3];
          if(session('admin.user_department')!='')
            {
              $tj['minister_department']=session('admin.user_department');
            }
        }
        $tj['year']=$search[0];
        $tj['month']=$search[1];
        //dump($tj);exit;
        $data=$this->model->where($tj)->select();
        $this->assign('data',$data);
        //dump($data);exit;
      }
      $this->special();
      $this->assign('search',$search);
      $this->display();
    }
    //特殊人员遍历方法
    protected function special(){
      $tj['year']=session('admin.year');
      $tj['month']=session('admin.month');
      if($tj['month']==1){
        $tj['month']=12;
        $tj['year']=session('admin.year')-1;
      }
      else
      {
         $tj['month']=session('admin.month')-1;
      }
      $tj['user_department']=session('admin.user_department');
      //$tj['grade_leader']=session('admin.username');
      $special_user=M('info_admin')->where($tj)->order('username desc')->getField('username',true);
      $this->assign('special_user',$special_user);
      $special1=M('grademonth_staff')->where($tj)->where("if_special = 1 and staff_department='".$tj['user_department']."'")->select();
      foreach ($special1 as $k => $v) {
        $special1[$k]['level']=3;
        $special1[$k]['name']=$v['staff_name'];
      }
      $special2=M('grademonth_chief')->where($tj)->where("if_special = 1 and chief_department='".$tj['user_department']."'")->select();
      foreach ($special2 as $k => $v) {
        $special2[$k]['level']=4;
        $special2[$k]['name']=$v['chief_name'];
      }
      $special3=M('grademonth_minister')->where($tj)->where("if_special = 1 and minister_department='".$tj['user_department']."'")->select();
      foreach ($special3 as $k => $v) {
        $special3[$k]['level']=5;
        $special3[$k]['name']=$v['minister_name'];
      }
      $special=array_merge($special1,$special2,$special3);
      $this->assign('special',$special);
      $this->assign('tj',$tj);
    } 
    public function grademod(){
      $level=I('post.level');
      $tj1['id']=I('post.id');
      
      if($level==3||$level==7){$this->model=D('grademonth_staff');$tj['staff_office']=trim(I('post.office'));}
      if($level==4||$level==8){$this->model=D('grademonth_chief');$tj['chief_office']=trim(I('post.office'));}
      if($level==5){$this->model=D('grademonth_miniter');$tj['miniter_office']=trim(I('post.office'));}
      if($this->model->create($tj))
        {
          $this->model->where($tj1)->save();
          $result['success']=1;
          $this->ajaxReturn($result,"json");
        }
        else
        {
          $result['success']=0;
          $this->ajaxReturn($result,"json");
        }
    }
    public function gradedelete(){
      $level=I('post.level');
      $tj1['id']=I('post.id');
      if($level==3||$level==7){$this->model=D('grademonth_staff');}
      if($level==4||$level==8){$this->model=D('grademonth_chief');}
      if($level==5){$this->model=D('grademonth_miniter');}
      if( $this->model->where($tj1)->delete())
        {
          $result['success']=1;
          $this->ajaxReturn($result,"json");
        }
        else
        {
          $result['success']=0;
          $this->ajaxReturn($result,"json");
        }
    }
}