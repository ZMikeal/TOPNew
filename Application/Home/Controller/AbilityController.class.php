<?php
/**
 * Created by PhpStorm.
 * User: zhangtong02
 * Date: 2017-5-01
 * Time: 18:09
 */

namespace Home\Controller;
use Think\Controller;

/**
* 实现能力建设功能模块
*/
class AbilityController extends Controller
{
	public function ability_building()
	{
		# 实现能力建设模块之半年计划新建与修改前端
		//能力修改查询条件
		$conditionBuilding['halfyear']	   = session('admin.halfyear_sys');
		$conditionBuilding['year']		   = session('admin.year_sys');
		$conditionBuilding['id_employee']  = session('admin.id_employee');
		//能力总结查询条件
		$conditionSummarize['halfyear']    = session('admin.halfyear_last');
		$conditionSummarize['year']        = session('admin.year_last');
		$conditionSummarize['id_employee'] = session('admin.id_employee');
		//能力目标查询条件
		if(session('admin.id_level')==3||session('admin.id_level')==7)
			$conditionTarget['ability_level']  = 3;
		elseif (session('admin.id_level')==4||session('admin.id_level')==8)
			$conditionTarget['ability_level']  = 4;

		$abilityTargetModel        = D('info_ability');
		$abilityBuildingModel      = D('planability_total');
		$abilitySummarizeModel     = D('planability_total');

		$listBuilding	= $abilityBuildingModel->where($conditionBuilding)->select();
		$abilityTarget  = $abilityTargetModel->where($conditionTarget)->select();
		$listSummarize	= $abilitySummarizeModel->where($conditionSummarize)->select();

		$this->assign('listBuilding',$listBuilding);
		$this->assign('abilityTarget',$abilityTarget);
		$this->assign('listSummarize',$listSummarize);
		$this->display();
	}
	public function ability_add()
	{
		# 实现能力建设模块之半年计划添加功能
		$this->model   =D("planability_total");
		//获取seesion信息
		$name 		   = session('admin.username');
		$id_employee   = session('admin.id_employee');
		$office        = session('admin.user_office');
		$department    = session('admin.user_department');
		$leader    	   = session('admin.user_leader');
		$level    	   = session('admin.id_level');
		$addtime       = date('y-m-d h:i:s',time());
		$halfyear	   = session('admin.halfyear_sys');
		$year		   = session('admin.year_sys');


		// 获取前端所需变量
		$id            	 	= I('abilityId');
    	$abilityTarget      = I('abilityTarget');
    	$abilityDescribe    = I('abilityDescribe');
    	$abilityPlan     	= I('abilityPlan');

    	//逐条保存数据
      	foreach ($abilityDescribe as $key => $value) {
      		# 存储数据
      		$map = array();
      		$map['abilityTarget']      = $abilityTarget[$key];
      		$map['abilityDescribe']    = $abilityDescribe[$key];
      		$map['abilityPlan']        = $abilityPlan[$key];
      		$map['abilityAddTime']	   = $addtime;
      		$map['name']			   = $name;
      		$map['id_employee']	       = $id_employee;
      		$map['department']		   = $department;
      		$map['office']			   = $office;
      		$map['leader']	           = $leader;
      		$map['id_level']		   = $level;
      		$map['year']		       = $year;
      		$map['halfyear']		   = $halfyear;

      		if($map['abilityDescribe']!='' && $id[$key]==''){
      			if($this->model->create($map)){
      				$this->model->add();
      			}
      		}
      		elseif ($map['abilityDescribe']!='' && $id[$key]!='') {
      			if($this->model->create($map)){
      				$this->model->where("id=$id[$key]")->save();
      			}
      		}
      	}
		$this->redirect('Ability/ability_building');
	}
	public function ability_summarize()
	{
	# 实现能力建设模块之半年计划总结功能
		$this->model   =D("planability_total");
		$id            	 	= I('abilityId');
		$abilitySummarize   = I('abilitySummarize');
		$abilitySelfGrade   = I('abilitySelfGrade');
		$sumtime            = date('y-m-d h:i:s',time());

		//逐条保存数据
      	foreach ($id as $key => $value) {
      		# 存储数据
      		$map = array();
      		$map['abilitySummarize']   = $abilitySummarize[$key];
      		$map['abilitySelfGrade']   = $abilitySelfGrade[$key];
      		$map['abilitySumTime']     = $sumtime;
      		if ( $id[$key]!='') {
      			if($this->model->create($map)){
      				$this->model->where("id=$value")->save();
      			}
      		}
      	}
		$this->redirect('Ability/ability_building');
	}

	public function ability_grade()
	{
		# 实现能力建设模块之半年计划评分查询
		$abilityGradeModel  = D("planability_total");
		$id_level           = session('admin.id_level');
		//能力评分查询条件
		$conditionGrade['halfyear']    = session('admin.halfyear_last');
		$conditionGrade['year']        = session('admin.year_last');
		$conditionGrade['department']  = session('admin.user_department');
		$conditionGrade['leader']  	   = session('admin.username');
		if($id_level == 4 or $id_level == 3){
            $conditionGrade['office']      = session('admin.user_office');
        }

		$listGrade	= $abilityGradeModel->field("id_employee,id_level,name,year,halfyear,department,office,group_concat(id) as id,group_concat(abilityLeaderGrade) as abilityLeaderGrade,group_concat(abilityTarget) as abilityTarget,group_concat(abilityDescribe) as abilityDescribe")->group('name')->where($conditionGrade)->select();
		foreach ($listGrade as $k => $v) {
            $listGrade[$k]['abilitytarget']   = str_replace(",","<br>",$v['abilitytarget']);
            $listGrade[$k]['abilitydescribe'] = str_replace(",","<br>",$v['abilitydescribe']);

            $sum=0;
            $leadergrade=explode(',',$listGrade[$k]['abilityleadergrade']);
            foreach ($leadergrade as $key => $value) {
            	$sum+=$value;
            }
            if($sum==0)
            {
                $listGrade[$k]['abilitysumgrade']="";
            }
            else if($sum!=0)
            {
             	$listGrade[$k]['abilitysumgrade']=$sum;
            }

        }
		$this->assign('listGrade',$listGrade);
		$this->display();

	}

	public function ability_mark(){
	    # 实现能力建设模块之个人打分

        $abilityMarkModel  = M("planability_total");
        $id_group          = I('get.id');
        $id = '("'.str_replace(',','","',$id_group).'")';
        $listMark=$abilityMarkModel->where("id in $id")->select();
        $this->assign('listMark',$listMark);
        $this->display();
    }

    public function ability_marking(){
        # 实现能力建设模块之个人存储
        $id             = I('post.abilityId');
        $abilityMarking = I('post.abilityMarking');
        $markingModel   = D('planability_total');

        foreach ($id as $key => $value){
            # 存储数据
            $map = array();
            $map['abilityLeaderGrade']   = $abilityMarking[$key];
            if ($id[$key]!=''){
                if($markingModel->create($map)){
                    $markingModel->where("id=$value")->save();
                }
            }
        }
        $this->redirect('Ability/ability_grade');
    }

    public function ability_history(){
        # 实现能力建设模块之个人历史查询

        $abilityHistoryModel      = D('planability_total');
        $conditionHistory['name'] = session('admin.username');

        $listHistory = $abilityHistoryModel->where($conditionHistory)->group('year,halfyear')->select();
        $listHistoryCount=count($listHistory);
        foreach ($listHistory as $key=>$value){
            $conditionHistory['year']     = $value['year'];
            $conditionHistory['halfyear'] = $value['halfyear'];

            $list[$key] = $abilityHistoryModel->where($conditionHistory)->select();
        }

        $this->assign('list',$list);
        $this->assign('listHistoryCount',$listHistoryCount);
        $this->display();
    }
}