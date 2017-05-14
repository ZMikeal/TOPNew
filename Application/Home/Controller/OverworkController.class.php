<?php
/**
 * Created by PhpStorm.
 * User: zhangtong02
 * Date: 2017-2-21
 * Time: 18:09
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;
class OverworkController extends Controller {
    public function overwork_apply(){
    	$this->model=D('planoverwork_total');
    	$username           = session('admin.username'); 
    	$tj['name']			    = session('admin.username'); 
    	$tj['id_employee']  = session('admin.id_employee');
    	$id_level           = session('admin.id_level');
    	if(session('admin.id_level')=='3' || session('admin.id_level')=='7'){
    		$list=$this->model->where($tj)->where("(chief_confirm='未确认' AND minister_confirm='未确认') OR (chief_confirm='通过' AND minister_confirm='退回') OR (chief_confirm='退回' AND minister_confirm='未确认') OR (chief='$username' AND minister_confirm='未确认')")->order('id desc')->select();
    		$countlist=count($list);
    	}
      elseif (session('admin.id_level')=='4' || session('admin.id_level')=='8') {
        $list=$this->model->where($tj)->where(" minister_confirm='未确认' OR minister_confirm='退回'")->order('id desc')->select();
        $countlist=count($list);
      }
    	
    	$this->assign('list',$list);
    	$this->assign('countlist',$countlist);
      $this->display();
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function overwork_show(){
    	$this->model=D('planoverwork_total');
    	$tj['name']			= session('admin.username'); 
    	$tj['id_employee']  = session('admin.id_employee');
    	
    	//获取搜寻条件
    	$startTime          = I('post.startTime');
    	$endTime            = I('post.endTime');
    	$startTime_select   = $startTime.' 00:00:00';
    	$endTime_select     = $endTime.' 59:59:59';
    	///~
    	if($startTime!="" && $endTime!=""){
    		$data = $this->model->where("overworkStartTime>='$startTime_select' AND overworkStartTime<='$endTime_select'")->where($tj)->select();
    	}
    	else if($startTime==''){
    		$data = $this->model->where($tj)->order("overworkStartTime DESC")->select();
    	}

      //获取图表时间以及信息
      $overworkFlotNowTime           = date("Y-m-d");
      $overworkFlotBeforeTime        = date('Y-m-d', strtotime('-15 days'));
      
    	$this->assign('data',$data);
    	$this->assign('flot',$flot);
    	$this->assign('startTime',$startTime);
    	$this->assign('endTime',$endTime);
    	$this->assign('overworkFlotNowTime',$overworkFlotNowTime);
    	$this->assign('overworkFlotBeforeTime',$overworkFlotBeforeTime);
      $this->display();


    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function overwork_chart(){
    	$this->model=D('planoverwork_total');
    	$tj['name']			= session('admin.username'); 
    	$tj['id_employee']  = session('admin.id_employee');

    	//获取图表时间以及信息
    	$overworkFlotNowTime           = date("Y-m-d");
    	$overworkFlotBeforeTime        = date('Y-m-d', strtotime('-15 days'));
    	$overworkFlotNowTime_select    = $overworkFlotNowTime.' 59:59:59';
    	$overworkFlotBeforeTime_select = $overworkFlotBeforeTime.' 00:00:00';
    	
    	$flot=$this->model->where("overworkStartTime>='$overworkFlotBeforeTime' AND overworkStartTime<='$overworkFlotNowTime_select'")->where($tj)->order("overworkStartTime ASC")->field('overworkStartTime,overworkTotalTime')->select();
    	
    	//将ISO Date 转成 Timestamp
    	$dt_start = strtotime($overworkFlotBeforeTime);
    	$dt_end   = strtotime($overworkFlotNowTime);
    	$i=0;
    	do { 
        	//将 Timestamp 转成 ISO Date 输出
        	$temp  =  date('Y-m-d', $dt_start);
	        if(substr($flot[$i]['overworkstarttime'], 0,10)!=$temp){
	        	echo substr($flot['overworkStartTime'], 0,10);
	        	$temp_arr = array(array('overworkStartTime' => $temp,'overworkTotalTime' => "0" ));
	        	array_splice($flot,$i,0,$temp_arr);
	    	}
	        $i++;
    	}while (($dt_start += 86400) <= $dt_end);// 重复 Timestamp + 1 天(86400), 直至大于结束日期中止

    	if(!empty($flot))
      	{
  
      		 $this->ajaxReturn($flot);
      		// $this->ajaxReturn(array('success'=>1),"json");
      	}
      	else
      	{
        	$this->ajaxReturn(array('success'=>0),"json");
      	}

    	
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function overwork_approval(){
    	//获取Model
    	$this->model  = D('planoverwork_total');
    	$name         = session('admin.username');
      $id_level     = session('admin.id_level');
      if($id_level=='4' || $id_level=='8' || $id_level=='3')
        $count = $this->model->where("chief='$name' AND chief_confirm='未确认'")->count(); // 查询满足要求的总记录数 $map表示查询条件
      elseif ($id_level=='5') {
        $count = $this->model->where("minister='$name' AND minister_confirm='未确认' AND chief_confirm='通过'")->count(); // 查询满足要求的总记录数 $map表示查询条件
      }
      $Page  = new Page($count,15); // 实例化分页类 传入总记录数

      //设置分页点样式
      $Page->lastSuffix=false;
      $Page->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;每页<b>15</b>条&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
      $Page->setConfig('prev','上一页');
      $Page->setConfig('next','下一页');
      $Page->setConfig('last','末页');
      $Page->setConfig('first','首页');
      $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
      ///~

      $show= $Page->show();// 分页显示输出
      if($id_level=='4' || $id_level=='8' || $id_level=='3')
    	 $data=$this->model->where("chief='$name' AND chief_confirm='未确认'")->order('name')->limit($Page->firstRow.','.$Page->listRows)->select();
      elseif ($id_level=='5') {
        $data=$this->model->where("minister='$name' AND minister_confirm='未确认' AND chief_confirm='通过'")->order('name')->limit($Page->firstRow.','.$Page->listRows)->select();
      }
    	$this->assign('data',$data);
      $this->assign('page',$show);// 赋值分页输出
    	$this->display(); 
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function overwork_reback(){
      $overwork                  = M('planoverwork_total');
      $id_level                  = session('admin.id_level');
      $condition['id']           = I('post.overwork_id');
      $data['chief_suggestion']  = I('post.suggestion');
      if($id_level=='4' || $id_level=='8' || $id_level=='3')
        $data['chief_confirm']   = '退回';
      elseif ($id_level=='5')
        $data['minister_confirm']= '退回';
      $result                    = $overwork->where($condition)->save($data);
      if($result)
        $this->ajaxReturn(array('success' =>1),"json");
      else
        $this->ajaxReturn(array('success' =>0),"json");
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
    public function overwork_pass(){
      $data                    =I('post.');
      $id_level                = session('admin.id_level');
      $overwork_id             = explode(",", $data['overwork_id']);

      if($id_level=='4' || $id_level=='8' || $id_level=='3')
        $data['chief_confirm']      = '通过';
      elseif ($id_level=='5') {
        $data['minister_confirm']   = '通过';
      }

      foreach ($overwork_id as $k => $v) {
        $result = M('planoverwork_total')->where("id = '{$v}'")->save($data);
      }

      if($result)
        $this->ajaxReturn(array('success' =>1),"json");
      else
        $this->ajaxReturn(array('success' =>0),"json");
    }
   
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function overwork_history(){
      $this->model = D('planoverwork_total');
      $id_level    = session('admin.id_level');

      if ($id_level != 5) {
        $term['office']     = session('admin.user_office'); 
        $term['department']  = session('admin.user_department');
      }
      elseif ($id_level = 5) {
        $term['department']  = session('admin.user_department');
      }
      
      //获取搜寻条件
      $startTime          = I('post.startTime');
      $endTime            = I('post.endTime');
      $startTime_select   = $startTime.' 00:00:00';
      $endTime_select     = $endTime.' 59:59:59';
      ///~
      if($startTime!="" && $endTime!=""){
        $data = $this->model->where("overworkStartTime>='$startTime_select' AND overworkStartTime<='$endTime_select'")->where($term)->select();
      }
      else if($startTime==''){
        $data = $this->model->where($term)->order("overworkStartTime DESC")->select();
      }


      $this->assign('data',$data);
      $this->assign('flot',$flot);
      $this->assign('startTime',$startTime);
      $this->assign('endTime',$endTime);
      $this->assign('overworkFlotNowTime',$overworkFlotNowTime);
      $this->assign('overworkFlotBeforeTime',$overworkFlotBeforeTime);
      $this->display();


    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function overwork_add(){
    	//获取Model
    	$this->model=D('planoverwork_total');
    	// 获取前端所需变量
    	$overworkType      = I('overworkType');
    	$overworkStartTime = I('overworkStartTime');
    	$overworkEndTime   = I('overworkEndTime');
		  $overworkTotalTime = I('overworkTotalTime');
		  $overworkContent   = I('overworkContent');
		  ///~
		  // 获取需要的session变量
		  $id_level    = session('admin.id_level');
		  $name        = session('admin.username');  
    	$id_employee = session('admin.id_employee');
    	$department  = session('admin.user_department');
    	$office      = session('admin.user_office');
      $if_authority= session('admin.if_authority');
      dump($if_authority);
   		//获取正确的科长与部长
      	if ($id_level=='3'||$id_level=='7') {
      		# code...
      		
          if ($if_authority == '2' || $if_authority == '3') {
            $chief        = $name;
            $minister     = session('admin.user_leader');
            $chief_confirm  = "通过";
          }
          else  //没有任何授权
          {
            $chief        = session('admin.user_leader');
            $minister     = M('info_admin')->where("username='$chief'")->getField('user_leader');
            $chief_confirm  = "未确认";
          }
      	}
      	elseif ($id_level=='4'||$id_level=='8') {
      		# code...
      		$chief 	  		= $name;
      		$minister 		= session('admin.user_leader');
      		$chief_confirm  = "通过";
      	}
      	///~
      	//逐条保存数据
      	foreach ($overworkTotalTime as $key => $value) {
      		# code...
      		$map = array();	//存储数据
      		$map['overworkType']      = $overworkType[$key];
      		$map['overworkStartTime'] = $overworkStartTime[$key];
      		$map['overworkEndTime']   = $overworkEndTime[$key];
      		$map['overworkTotalTime'] = $overworkTotalTime[$key];
      		$map['overworkContent']   = $overworkContent[$key];
      		$map['name']			        = $name;
      		$map['id_employee']	      = $id_employee;
      		$map['department']		    = $department;
      		$map['office']			      = $office;
      		$map['chief']			        = $chief;
      		$map['minister']		      = $minister;
      		$map['addTime']			      = date('y-m-d h:i:s',time());
      		$map['chief_confirm']	    = $chief_confirm;
      		
      		if($map['overworkTotalTime']!=''){
      			if($this->model->create($map)){
      				$this->model->add();
      			}
      		}
      	}
      	///~
      	$this->redirect('Overwork/overwork_apply');	
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function overwork_update(){
    	//获取单条信息ID
    	$id = I('id');
    	//获取Model
    	$this->model=D('planoverwork_total');
    	// 获取前端所需变量
    	$overworkType      = I('overworkTypeUpdate');
    	$overworkStartTime = I('overworkStartTimeUpdate');
    	$overworkEndTime   = I('overworkEndTimeUpdate');
		  $overworkTotalTime = I('overworkTotalTimeUpdate');
		  $overworkContent   = I('overworkContentUpdate');
    	// 获取需要的session变量
		  $id_level    = session('admin.id_level');
		  $name        = session('admin.username');  
    	$id_employee = session('admin.id_employee');
    	$department  = session('admin.user_department');
    	$office      = session('admin.user_office');
    	$chief 		 = session('admin.user_leader');
      	if ($id_level=='3'||$id_level=='7') {
      		# code...
      		$chief 	  			= session('admin.user_leader');
      		$minister 			= M('info_admin')->where("username='$chief'")->getField('user_leader');
      		$chief_confirm  	= "未确认";
      		$minister_confirm	= "未确认";
      	}
      	elseif ($id_level=='4'||$id_level=='8') {
      		# code...
      		$chief 	  			= $name;
      		$minister 			= session('admin.user_leader');
      		$chief_confirm  	= "通过";
      		$minister_confirm	= "未确认";
      	}
      	///~
      	foreach ($id as $key => $value) {
      		# code...
      		$map = array();	//修改数据
      		$map['overworkType']      = $overworkType[$key];
      		$map['overworkStartTime'] = $overworkStartTime[$key];
      		$map['overworkEndTime']   = $overworkEndTime[$key];
      		$map['overworkTotalTime'] = $overworkTotalTime[$key];
      		$map['overworkContent']   = $overworkContent[$key];
      		$map['name']			        = $name;
      		$map['id_employee']	      = $id_employee;
      		$map['department']		    = $department;
      		$map['office']			      = $office;
      		$map['chief']			        = $chief;
      		$map['minister']		      = $minister;
      		$map['updateTime']		    = date('y-m-d h:i:s',time());
      		$map['chief_confirm']	    = $chief_confirm;
      		$map['minister_confirm']  = $minister_confirm;
      		if($map['overworkTotalTime']!=''){
      			if($this->model->create($map)){
      				$this->model->where("id=$value")->save();
      			}
      		}
      	}
      	$this->redirect('Overwork/overwork_apply');		
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//删除选中的加班预报
    public function overwork_delete(){
    	$id = I('id');
    	$this->model=D('planoverwork_total');
    	$this->model->delete($id);

    	$this->redirect('Overwork/overwork_apply');
    }
///~
}
