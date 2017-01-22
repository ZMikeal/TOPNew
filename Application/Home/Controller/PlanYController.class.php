<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class PlanYController extends BaseController {
  
	 public function _initialize(){
     if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
	 	 if(session('admin.id_level')==2){
          $this->redirect('planjhy/index');
          exit;
        }
	 }
   public function index(){
      
       $this->display();
   }


    public function midplan(){
       $le=session('admin.id_level');
      $id_employee=session('admin.id_employee');
      if($le==3||$le==7)
      {
        $this->model=D('planyear_staff');
        $list = $this->model->field("id,staff_name,year,plan_name,group_concat(plan_name) as plan_name")->where("staff_id=$id_employee")->order('year desc')->group('year')->select();
        //dump($list);exit;
      }
      if($le==4||$le==8)
      {
        $this->model=D('planyear_chief');
        $list = $this->model->field("id,chief_name,year,plan_name,group_concat(plan_name) as plan_name")->where("chief_id=$id_employee")->order('year desc')->group('year')->select();
      }
      if($le==5)
      {
        $this->model=D('planyear_minister');
        $list = $this->model->field("id,minister_name,year,plan_name,group_concat(plan_name) as plan_name")->where("minister_id=$id_employee")->order('year desc')->group('year')->select();
      }
       //dump($list);exit;
       foreach ($list as $k => $v) {   //  循环保存每一条值
                  //$map = array();
                  $list[$k]['plan_name']=str_replace(",","<br>",$v['plan_name']);
                }
      $this->assign('list',$list);// 赋值数据集
      $this->display();
    }




    public function formmidplan(){
      //echo C('USER_TYPE');exit;
      $le=session('admin.id_level');
      
      $tj['year']=session('admin.year');
      //$tj['month']=session('admin.month');
       $date=date('m-d');
       
    if($date < '01-25'&&$date > '01-01')
    {
      //dump($date);exit;
      $time='可以创建计划';
      $tj['year']=date('Y');
      if($le==3||$le==7)
      {
        $this->model=D('planyear_staff');
        $tj['staff_id']=session('admin.id_employee');
        $tj['if_improve']=0;
        $list = $this->model->where($tj)->select();

        $tj['if_improve']=1;
        $nljs = $this->model->where($tj)->select();
        
        $tj['if_improve']=2;
        $tzx = $this->model->where($tj)->select();
      }
      if($le==4||$le==8)
      {
        $this->model=D('planyear_chief');
        $tj['chief_id']=session('admin.id_employee');
        $tj['if_improve']=0;
        $list = $this->model->where($tj)->select();

        $tj['if_improve']=1;
        $nljs = $this->model->where($tj)->select();
        
        $tj['if_improve']=2;
        $tzx = $this->model->where($tj)->select();
      }
      if($le==5)
      {
        $this->model=D('planyear_minister');
        $tj['minister_id']=session('admin.id_employee');
        $tj['if_improve']=0;
        $list = $this->model->where($tj)->select();

        $tj['if_improve']=1;
        $nljs = $this->model->where($tj)->select();
        
        $tj['if_improve']=2;
        $tzx = $this->model->where($tj)->select();
      }

      //dump($time);exit;
      $this->assign('list',$list);// 赋值数据集
      $this->assign('time',$time);
      $this->assign('nljs',$nljs);
      //$this->assign('list1',$list1);
      $this->model=D('info_item');
      $vse = $this->model->order('id desc')->select();
      $this->assign('vse',$vse);// 赋值数据集

    }

      $this->shangji();


      $this->display();
    }





    public function addmplan(){
             $le=session('admin.id_level');
      $id_employee=session('admin.id_employee');
      if($le==3||$le==7)
      {
        $this->model=D('planyear_staff');
        $tj['staff_id']=session('admin.id_employee');
      }
      if($le==4||$le==8)
      {
        $this->model=D('planyear_chief');
         $tj['chief_id']=session('admin.id_employee');
      }
      if($le==5)
      {
        $this->model=D('planyear_minister');
         $tj['minister_id']=session('admin.id_employee');
      }
          $tj['year']=session('admin.year_sys');
          //$tj['month']=session('admin.month');
            $id_employee=session('admin.id_employee');
            $chief_name=session('admin.username');
            //$this->model->where($tj)->delete(); // 删除id为5的用户数据


    	      $plan_name=I('post.gongchengxiangmu');
            $plan_closingdate=I('post.wanchengriqi');
            $plan_weight=I('post.quanzhong');
            $plan_content=I('post.gongzuoneirong');
            $plan_leader=I('post.plan_leader');
            $data1=I('post.plan');
            $id=I('post.id');
            //dump($id);exit;
            //$result=$this->model->where($tj)->delete();


        //$tj['month']=session('admin.month')-1;
        //$tj1['if_continue']=0;
        //$this->model->where($tj)->save($tj1);

    	      foreach ($data1 as $k => $v) {   //  循环保存每一条值
                  $map = array();
                  //$map['k'] = $k;     //  保存216 这个键名
      if($le==3||$le==7)
      {
        $map['staff_id'] = $id_employee;
        $map['staff_name'] = $chief_name;
        $map['plan_leader'] = $v['plan_leader'];
        if($map['plan_leader']=="")
        {
          $map['plan_leader']=session('admin.user_leader');
        }
      }
      if($le==4||$le==8)
      {
        $map['chief_id'] = $id_employee;
        $map['chief_name'] = $chief_name;
        $map['plan_leader'] = session('admin.user_leader');;
      }
      if($le==5)
      {
        $map['minister_id'] = $id_employee;
        $map['minister_name'] = $chief_name;
        $map['plan_leader'] = session('admin.user_leader');;
      }
                  
                  $map['year'] = session('admin.year');
                 // $map['month'] = session('admin.month');
                  $map['department'] = session('admin.user_department');
                  $map['office'] = session('admin.user_office');
                  $map['plan_type'] = $v['plan_type'];
                  $map['plan_classify'] = $v['plan_classify'];
                  $map['plan_name'] = $plan_name[$k-1];
                  $map['plan_closingdate'] = $plan_closingdate[$k-1];
                  $map['plan_weight'] = $plan_weight[$k-1];
                  $map['plan_content'] = $plan_content[$k-1];
                  if($map['plan_type']=="能力建设")
                  {
                    $map['if_improve']=1;
                  }
                  if($map['plan_type']=="调整项")
                  {
                    $map['if_improve']=2;
                  }
                  //$map['if_continue'] = $v['if_continue'];
                  
                  if($id[$k-1]==null)
                  {
                     if($map['plan_name']!="")
                     {
                      if($map['if_improve']!=2)
                      {
                      if($this->model->create($map)){
                            $this->model->add();
                          }
                        }
                     }
                  }
                  if($id[$k-1]!=null)
                  {
                    $idd=$id[$k-1];
                    if($map['plan_name']!="")
                     {
                      if($map['if_improve']!=2)
                      {
                      if($this->model->create($map)){
                            $this->model->where("id=$idd")->save();
                          }
                        }
                     }
                     if($map['plan_name']=="")
                     {
                      if($this->model->create($map)){
                            $this->model->where("id=$idd")->delete();
                          }
                     }
                  }
                  

                }

                //$this->success('创建计划成功！',U('Plan/formmidplan'));
                echo 
        "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <script> alert('创建计划成功！');parent.location.href='../PlanY/formmidplan'; </script>"; 
    }



    protected function shangji(){
      $username=session('admin.user_leader');
      //dump($username);exit;
      if($username!="")
      {
      $list1 = M('info_admin')->where('username="'.$username.'"')->find();
      $tj['year']=session('admin.year_sys');
      //$tj['month']=session('admin.month');
      // if($list1['id_level']==3)
      // {
      //   $list2 = M('planyear_staff')->where('staff_id="'.$list1['id_employee'].'"')->select();
      // }

        if($list1['id_level']==4||$list1['id_level']==8)
        {
          //dump($list1);exit;
          $tj['chief_id']=$list1['id_employee'];
          $list2 = M('planyear_chief')->where($tj)->select();
        }
        else if($list1['id_level']==5)
        {
          $tj['minister_id']=$list1['id_employee'];
          $list2 = M('planyear_minister')->where($tj)->select();
        }
        else if($list1['id_level']==3)
        {
          $tj['staff_id']=$list1['id_employee'];
          $list2 = M('planyear_staff')->where($tj)->select();
        }
      }
      if($username=="")
      {
        $list2=1; 
      }
      //dump($list2.length);exit;
      $this->assign('list2',$list2);// 赋值数据集
    }

    public function showplan(){
      $tj['year']=I('get.year');
      //$tj['month']=I('get.month');
      //dump($tj);exit;
      $le=session('admin.id_level');
      $id_employee=session('admin.id_employee');
      if($le==3||$le==7)
      {
        $this->model=D('planyear_staff');
        $tj['staff_id']=session('admin.id_employee');
      }
      if($le==4||$le==8)
      {
        $this->model=D('planyear_chief');
         $tj['chief_id']=session('admin.id_employee');
      }
      if($le==5)
      {
        $this->model=D('planyear_minister');
        $tj['minister_id']=session('admin.id_employee');
      }
      //dump($tj);exit;
      $list = $this->model->where($tj)->select();
      $this->assign('list',$list);
      $this->display();
    }

    public function modmidplan(){
     
      //$tj['month']=session('admin.month_sys');
      $date=date('m-d');
      if($date < '12-27'&&$date > '12-20')
      {
          $tj['year']=session('admin.year_sys');
          $le=session('admin.id_level');
          $id_employee=session('admin.id_employee');
          if($le==3||$le==7)
          {
            $this->model=D('planyear_staff');
            $tj['staff_id']=session('admin.id_employee');
          }
          if($le==4||$le==8)
          {
            $this->model=D('planyear_chief');
            $tj['chief_id']=session('admin.id_employee');
          }
          if($le==5)
          {
            $this->model=D('planyear_minister');
            $tj['minister_id']=session('admin.id_employee');
          }
          $list = $this->model->where($tj)->select();
          $this->assign('list',$list);
      }
      //dump($tj);exit;
    
      $this->display();
    }
    
    public function addmodplan(){
      $data=I('post.');
      //dump($data);
      $le=session('admin.id_level');
      $id_employee=session('admin.id_employee');
      if($le==3||$le==7)
      {
        $this->model=D('planyear_staff');
        $tj['staff_id']=session('admin.id_employee');
      }
      if($le==4||$le==8)
      {
        $this->model=D('planyear_chief');
         $tj['chief_id']=session('admin.id_employee');
      }
      if($le==5)
      {
        $this->model=D('planyear_minister');
         $tj['minister_id']=session('admin.id_employee');
      }
      //dump($data);exit;
      foreach ($data as $k => $v) {

        if($v["plan_sum"] != ""||$v['plan_self']!="")
        {
          //dump($v["plan_sum"]);exit;
           if($this->model->create($v)){
              $this->model->save();
             }  
        }     
      }
       echo 
        "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <script> alert('更新成功！');parent.location.href='../PlanY/modmidplan'; </script>"; 

    }
    public function confirm(){
    $id=I('post.vid');
    $tj['plan_name']=I('post.shixiang');
    $tj['plan_content']=I('post.neirong');
    $tj['plan_closingdate']=I('post.shijian');
    $le=session('admin.id_level');
      if($le==3||$le==7)
      {
        $this->model=D('planyear_staff');
      }
      if($le==4||$le==8)
      {
        $this->model=D('planyear_chief');
      }
      if($le==5)
      {
        $this->model=D('planyear_minister');
      }
      $this->model->where("id=$id")->setField('if_confirm',0);
      if($this->model->create($tj)){
        $this->model->where("id=$id")->save();
      }
      $this->ajaxReturn(array('success'=>1),"json");
   }
   
}