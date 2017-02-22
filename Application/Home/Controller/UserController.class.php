<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class UserController extends BaseController {

	 
    public function index(){
     //    $groups_list=M('admin')->where()->order('id desc')->select();
    	// $this->assign('groups_list',$groups_list);
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

      $tj['id_employee']=session('admin.id_employee');
      $list = M('info_admin')->where($tj)->find();
      //dump($list);exit;
       $this->assign('list',$list);

        $this->display();
    }

    public function moduser(){
      $data=I('post.');
      $this->model=D('info_admin');
      $id['id_employee']=session('admin.id_employee');
      $this->model->where($id)->save($data);
      //dump($data);exit;
        echo 
        "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <script> alert('修改成功！需重新登录！');parent.location.href='../login/login'; </script>"; 
    }

    public function pass(){
      $this->display();
    }
    public function modpass(){
      $this->model=D('info_admin');
      $user['pas']=I('post.pas');
      $user['pas1']=I('post.pas1'); 
     if(session('admin.password')==md5(md5($user['pas']))){//POST验证成功

       $result['success']=1;
       $data['username']=session('admin.username');
       $data1['password']=md5(md5($user['pas1']));
       $data['id_employee']=session('admin.id_employee');
       if($this->model->create($data1)){
        $this->model->where($data)->save();
        $this->ajaxReturn($result,"json");
       }
       else{
        $this->ajaxReturn(array('success'=>0),"json");
       }
      }
     else{
       $this->ajaxReturn(array('success'=>-1),"json");
      }
      $this->display();
    }
   
}