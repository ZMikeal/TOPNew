<?php
/**
 * Created by PhpStorm.
 * User: zhangtong02
 * Date: 2017-2-21
 * Time: 18:09
 */
namespace Home\Controller;
use Think\Controller;
class OverworkController extends Controller {
    public function overwork_apply(){
    	$this->model=D('planoverwork_total');
    	$username           = session('admin.username'); 
    	$tj['name']			= session('admin.username'); 
    	$tj['id_employee']  = session('admin.id_employee');
    	$id_level    = session('admin.id_level');
    	if(session('admin.id_level')=='3' || session('admin.id_level')=='7'){
    		$list=$this->model->where($tj)->where("(chief_confirm='未确认' AND minister_confirm='未确认') OR (chief_confirm='通过' AND minister_confirm='退回') OR (chief_confirm='退回' AND minister_confirm='未确认') OR (chief='$username' AND minister_confirm='未确认')")->select();
    		$countlist=count($list);
    	}
    	
    	$this->assign('list',$list);
    	$this->assign('countlist',$countlist);
        $this->display();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function overwork_show(){
    	$this->model=D('planoverwork_total');
    	$tj['name']			= session('admin.username'); 
    	$tj['id_employee']  = session('admin.id_employee');

    	//获取图表时间以及信息
    	$overworkFlotNowTime           = date("Y-m-d");
    	$overworkFlotBeforeTime        = date('Y-m-d', strtotime('-15 days'));
    	
    	$flot=$this->model->where("overworkStartTime>='$overworkFlotBeforeTime' AND overworkStartTime<='$overworkFlotNowTime'")->where($tj)->order("overworkStartTime ASC")->field('overworkStartTime,overworkTotalTime')->select();
    	
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

    	//dump($flot);

    	if(!empty($flot))
      	{
      		// return "sss";
        	// $this->ajaxReturn($flot,"success");
        	 // echo json_encode($flot);
      		// $this->ajaxReturn($flot);
      		print_r($flot);
      	}
      	else
      	{
        	$this->ajaxReturn(array('success'=>0),"json");
      	}
    	//获取搜寻条件
    	$startTime          = I('post.startTime');
    	$endTime            = I('post.endTime');
    	$startTime_select   = $startTime.' 00:00:00';
    	$endTime_select     = $endTime.' 00:00:00';
    	///~
    	if($startTime!="" && $endTime!=""){
    		$data = $this->model->where("overworkStartTime>='$startTime_select' AND overworkStartTime<='$endTime_select'")->where($tj)->select();
    	}
    	else if($startTime==''){
    		$data = $this->model->where($tj)->select();
    	}
    	$this->assign('data',$data);
    	$this->assign('flot',$flot);
    	$this->assign('startTime',$startTime);
    	$this->assign('endTime',$endTime);
    	$this->assign('overworkFlotNowTime',$overworkFlotNowTime);
    	$this->assign('overworkFlotBeforeTime',$overworkFlotBeforeTime);
      	$this->display();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
   		//获取正确的科长与部长
      	if ($id_level=='3'||$id_level=='7') {
      		# code...
      		$chief 	  		= session('admin.user_leader');
      		$minister 		= M('info_admin')->where("username='$chief'")->getField('user_leader');
      		$chief_confirm  = "未确认";

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
      		$map['name']			  = $name;
      		$map['id_employee']	      = $id_employee;
      		$map['department']		  = $department;
      		$map['office']			  = $office;
      		$map['chief']			  = $chief;
      		$map['minister']		  = $minister;
      		$map['addTime']			  = date('y-m-d h:i:s',time());
      		$map['chief_confirm']	  = $chief_confirm;
      		
      		if($map['overworkTotalTime']!=''){
      			if($this->model->create($map)){
      				$this->model->add();
      			}
      		}
      	}
      	///~
      	$this->redirect('Overwork/overwork_apply');	
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
      		$map['name']			  = $name;
      		$map['id_employee']	      = $id_employee;
      		$map['department']		  = $department;
      		$map['office']			  = $office;
      		$map['chief']			  = $chief;
      		$map['minister']		  = $minister;
      		$map['updateTime']		  = date('y-m-d h:i:s',time());
      		$map['chief_confirm']	  = $chief_confirm;
      		$map['minister_confirm']  = $minister_confirm;
      		if($map['overworkTotalTime']!=''){
      			if($this->model->create($map)){
      				$this->model->where("id=$value")->save();
      			}
      		}
      	}
      	$this->redirect('Overwork/overwork_apply');		
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//删除选中的加班预报
    public function overwork_delete(){
    	$id = I('id');
    	$this->model=D('planoverwork_total');
    	$this->model->delete($id);

    	$this->redirect('Overwork/overwork_apply');
    }
///~
}
