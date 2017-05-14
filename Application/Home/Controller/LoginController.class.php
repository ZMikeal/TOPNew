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
    $admin=M('info_admin')->where($map)->where("if_delete=0")->find();
    if($admin){
      
      if($admin['id_level']==2)
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
         //dump($admin);exit;
         $this->redirect('Planjhy/index');
      }

      // 66 代表交付物信息管理员
      if($admin['id_level'] == 66)
      {
        session('admin', $admin);
        $this->redirect('GLY/JFWindex');
      }
      // 77 代表技术文件管理员
      if($admin['id_level'] == 77)
      {
        session('admin', $admin);
        $this->redirect('GLY/JSindex');
      }
      // 88 代表样车管理员
      if($admin['id_level'] == 88)
      {
        session('admin', $admin);
        $this->redirect('GLY/YCindex');
      }
      
      if($admin['id_level']==1)
      {
        $dat['id_employee']=$admin['id_employee'];
        $dat['user_department']=$admin['user_department'];
        $admin['month_sys']=date('m');
        $admin['year_sys']=date('Y');
         if($admin['month_sys']==1||$admin['month_sys']==2||$admin['month_sys']==3){$admin['quarter']=1;}
         if($admin['month_sys']==4||$admin['month_sys']==5||$admin['month_sys']==6){$admin['quarter']=2;}
         if($admin['month_sys']==7||$admin['month_sys']==8||$admin['month_sys']==9){$admin['quarter']=3;}
         if($admin['month_sys']==10||$admin['month_sys']==11||$admin['month_sys']==12){$admin['quarter']=4;}
        session('admin',$admin);
         //dump($admin);exit;
        $this->redirect('Plansuper/index');
      }
      //  6 代表党群管理员
      if($admin['id_level']==6)
      {
        $dat['id_employee']=$admin['id_employee'];
        $dat['user_department']=$admin['user_department'];
        $admin['month_sys']=date('m');
        $admin['year_sys']=date('Y');
        session('admin',$admin);
         //dump($admin);exit;
         $this->redirect('Plandq/index');
      }

      //  10 代表院级
      if($admin['id_level']==10)
      {
        $dat['id_employee']=$admin['id_employee'];
        $dat['user_department']=$admin['user_department'];
        $admin['month_sys']=date('m');
         $admin['year_sys']=date('Y');
        session('admin',$admin);
         $this->redirect('Planpresident/index');
      }

      if($admin['id_level']!=2&&$admin['id_level']!=1&&$admin['id_level']!=6)
      {
        $dat['id_employee']=$admin['id_employee'];
        $dat['user_department']=$admin['user_department'];
        $p = M('info_systime')->where($dat)->select();
        $Year=date('Y');
        $m=M('info_systime')->where("username='人力管理员' and year='{$Year}'")->getField('month');
        if($m==''){$m=1;}
        $admin['Year']=$m;
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
         if($admin['month_sys']==1||$admin['month_sys']==2||$admin['month_sys']==3){$admin['quarter']=1;$admin['quarter_last']=4;}
         if($admin['month_sys']==4||$admin['month_sys']==5||$admin['month_sys']==6){$admin['quarter']=2;$admin['quarter_last']=1;}
         if($admin['month_sys']==7||$admin['month_sys']==8||$admin['month_sys']==9){$admin['quarter']=3;$admin['quarter_last']=2;}
         if($admin['month_sys']==10||$admin['month_sys']==11||$admin['month_sys']==12){$admin['quarter']=4;$admin['quarter_last']=3;}

         if($admin['nickname']=="limenglin"||$admin['nickname']=="zhangjianping01"||$admin['nickname']=="jiangyiling"||$admin['nickname']=="duqiang"||$admin['nickname']=="lizhao"||$admin['nickname']=="liangxiuqing"||$admin['nickname']=="wangwei04"||$admin['nickname']=="zhangjingsong"||$admin['nickname']=="mahaizhen"||$admin['nickname']=="yurongjiang")
          $admin['overwork_after18']=1;
        else
          $admin['overwork_after18']=0;
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