<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class PlanjhyController extends BaseController {
	 	 public function _initialize(){
       if(!session('?admin')){
          $this->redirect('login/login');
          exit;
        }
     if(session('admin.id_level')!=2){
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
        $result1['success']=1;
        //$this->redirect('Planjhy/formmidplan');
        $this->ajaxReturn($result1,"json");
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
      $leader=$this->model->where($leadertj)->where("id_level in (4,5)")->getField('username',true);
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
      if($lev=="科员"){
         $leader=$this->model->where($leadertj)->where("id_level in (4,5)")->getField('username',true);
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
      $result=$this->model->where($tj)->find();
      
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
}