<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
      public function login(){
      $this->display();
  }
  public function dologin(){
    //dump(session('admin'));//exit;
    //adminname
    //password
    $map=array(
    'nickname'=> I('post.username'),
    'password'=> md5(md5(I('post.password')))
    );
    $admin=M('info_admin')->where($map)->find();
    if($admin){
      
      if($admin['id_level']==2)
      {
         session('admin',$admin);
         //dump($admin);exit;
         $this->redirect('Planjhy/index');
      }
      
      // $modal2 = M('class');
      //   $parentlist = $modal2->where('lzh_fclass=0')->select();
      //   //dump($parentlist);exit;
      //   $catlist=array();
      //   for($i=0;$i<count($parentlist);$i++){
      //     $cat = array();
      //     $cat['catid'] = $parentlist[$i]['lzh_cid'];
      //     $cat['name'] = $parentlist[$i]['lzh_cname'];
      //     $cat['subcat'] = $modal2->where('lzh_fclass='.$parentlist[$i]['lzh_cid'])->select();
      //     $catlist[]=$cat;
          
        
        //dump($admin);exit;
        //session('catlist',$catlist);
      if($admin['id_level']!=2)
      {
        $dat['id_employee']=$admin['id_employee'];
        $dat['user_department']=$admin['user_department'];
        $p = M('info_systime')->where($dat)->select();
        //dump($p);
        if($p!=null)
        {
         $admin['month']=$p[0]['month'];
         $admin['year']=$p[0]['year'];
        }
        if($p==null)
        {
         $admin['month']=date('m');
      $admin['year']=date('Y');
        }
         $admin['month_sys']=date('m');
         $admin['year_sys']=date('Y');
        session('admin',$admin);
        //dump(session('admin'));exit;
        $this->redirect('Plan/index');
      }
    }
    else{
      // $this->error("用户名或密码不正确",3);
      // $this->redirect('login/login');
        echo 
        "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <script> alert('用户名或密码不正确！');parent.location.href='../login/login'; </script>"; 
    }

  }
  public function loginout(){
    session('admin',null);
    //dump(session('admin'));exit;
    $this->redirect('login/login');

  }
}