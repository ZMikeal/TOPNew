<?php
    namespace Home\Controller;
    use Home\Controller\BaseController;
    use Home\Model\VehicleModel;
    class GLYController extends BaseController{
        public function _initialize(){

        }

        // -----------------------------------------------------------------------------------
        // -----------------------------------样车--------------------------------------------
        // -----------------------------------------------------------------------------------
        public function YCindex(){
            // $this->model = D('vehicle_infos');
            // $vehicles = $this->model->where("if_delete = 0")->order('id')->select();
            // $this->assign('vehicles', $vehicles);
            // $this->display();  
            // $User = M('User','other_','mysql://root:1234@192.168.1.10/demo#utf8');


            // $Vehicle = M("Vehicle_infos");

            $Vehicle = M("Vehicle_infos", '', 'mysql://test:123456@192.168.10.30/wechat#utf8');

            // $Vehicle = M("Vehicle_infos",'', 'mysql://atao:123456@192.168.10.30/wechat#utf8');



            $vehicles = $Vehicle->where("if_delete = 0")->order('id')->select();

            // var_dump($vehicles);
            // exit();

            $this->assign('vehicles', $vehicles);
            $this->display();

        }

        public function yc_add(){
            $shunxu_number = I('post.shunxu_number');

            $this->model = D('vehicle_infos');
            $finded = $this->model->where("shunxu_number=$shunxu_number and if_delete=0")->find();
            if($finded)
            {
                $result['success'] = -1;
                $this->ajaxReturn($result, "json");
            }
            else
            {
                $tj1['shunxu_number'] = I('post.shunxu_number');
                $tj1['xiangmu_name'] = I('post.xiangmu_name');
                $tj1['depart'] = I('post.depart');
                $tj1['vehicle_yongtu'] = I('post.vehicle_yongtu');
                $tj1['in_date'] = I('post.in_date');
                $tj1['yanfajieduan'] = I('post.yanfajieduan');
                $tj1['type'] = I('post.type');
                $tj1['bumen'] = I('post.bumen');
                $tj1['vehicle_type'] = I('post.vehicle_type');
                $tj1['guige_xinghao'] = I('post.guige_xinghao');
                $tj1['gonggao_type'] = I('post.gonggao_type');
                $tj1['vin'] = I('post.vin');
                $tj1['fadongji_hao'] = I('post.fadongji_hao');
                $tj1['yaoshi_num'] = I('post.yaoshi_num');
                $tj1['suiche_tool'] = I('post.suiche_tool');
                $tj1['biandu_xiang'] = I('post.biandu_xiang');
                $tj1['color'] = I('post.color');
                $tj1['vehicle_status_info'] = I('post.vehicle_status_info');
                $tj1['cunfang_addr_info'] = I('post.cunfang_addr_info');
                $tj1['addr_type_info'] = I('post.addr_type_info');
                $tj1['baofei_pici'] = I('post.baofei_pici');
                $tj1['jie_depart'] = I('post.jie_depart');
                $tj1['jie_person'] = I('post.jie_person');
                $tj1['jie_person_nick'] = I('post.jie_person_nick');
                $tj1['jie_connection'] = I('post.jie_connection');
                $tj1['jie_start_date'] = I('post.jie_start_date');
                $tj1['jie_end_date'] = I('post.jie_end_date');
                $tj1['beizhu'] = I('post.beizhu');

                if($this->model->create($tj1))
                {
                    $this->model->add();
                    $result['success'] = 1;
                    $this->ajaxReturn($result, "json");
                }
                else
                {
                    $result['success'] = 0;
                    $this->ajaxReturn($result, "json");
                }
            }

            $this->display();
        }

        public function yc_edit(){
            $tj['shunxu_number'] = I('post.shunxu_numberTijiao');
            $this->model = D('vehicle_infos');
            $result = $this->model->where($tj)->find();

            $tj1['xiangmu_name'] = I('post.xiangmu_name');
            $tj1['depart'] = I('post.depart');
            $tj1['vehicle_yongtu'] = I('post.vehicle_yongtu');
            $tj1['in_date'] = I('post.in_date');
            $tj1['yanfajieduan'] = I('post.yanfajieduan');
            $tj1['type'] = I('post.type');
            $tj1['bumen'] = I('post.bumen');
            $tj1['vehicle_type'] = I('post.vehicle_type');
            $tj1['guige_xinghao'] = I('post.guige_xinghao');
            $tj1['gonggao_type'] = I('post.gonggao_type');
            $tj1['vin'] = I('post.vin');
            $tj1['fadongji_hao'] = I('post.fadongji_hao');
            $tj1['yaoshi_num'] = I('post.yaoshi_num');
            $tj1['suiche_tool'] = I('post.suiche_tool');
            $tj1['biandu_xiang'] = I('post.biandu_xiang');
            $tj1['color'] = I('post.color');
            $tj1['vehicle_status_info'] = I('post.vehicle_status_info');
            $tj1['cunfang_addr_info'] = I('post.cunfang_addr_info');
            $tj1['addr_type_info'] = I('post.addr_type_info');
            $tj1['baofei_pici'] = I('post.baofei_pici');
            $tj1['jie_depart'] = I('post.jie_depart');
            $tj1['jie_person'] = I('post.jie_person');
            $tj1['jie_person_nick'] = I('post.jie_person_nick');
            $tj1['jie_connection'] = I('post.jie_connection');
            $tj1['jie_start_date'] = I('post.jie_start_date');
            $tj1['jie_end_date'] = I('post.jie_end_date');
            $tj1['beizhu'] = I('post.beizhu');


            if($this->model->create($tj1))
            {
                $this->model->where($tj)->save();
                $result['success'] = 1;
                $this->ajaxReturn($result, "json");
            }
            else
            {
                $result['success'] = 0;
                $this->ajaxReturn($result, "json");
            }


        }
        public function yc_delete()
        {
            $id = I('get.vid');
            $this->model = D('vehicle_infos');
            $result = $this->model->where("id=$id")->setField('if_delete', 1);
            $result['success'] = 1;
            $this->ajaxReturn($result, "json");
        }
        // -----------------------------------------------------------------------------------
        // -----------------------------------交付物--------------------------------------------
        // -----------------------------------------------------------------------------------

        public function JFWindex()
        {
            // $this->model = D('jiaofus');
            // $jiaofus = $this->model->where("if_delete = 0")->order('id')->select();

            // $Jiaofu = M("Jiaofus", '', 'mysql://test:123456@192.168.10.30/wechat#utf8');
            $Jiaofu = $this->createModel("Jiaofus");
            $jiaofus = $Jiaofu->where("if_delete = 0")->order('id')->select();

            $this->assign('jiaofus', $jiaofus);
            $this->display();   
        }


        public function jfw_edit()
        {
            $tj['bianhao'] = I('post.bianhaoTijiao');


            // $this->model = D('jiaofus');
            // $result = $this->model->where($tj)->find();

            // $Jiaofu = M("Jiaofus", '', 'mysql://test:123456@192.168.10.30/wechat#utf8');
            $Jiaofu = $this->createModel("Jiaofus");

            // $result = $Jiaofu->where($tj)->find();

            $tj1['version'] = I('post.version');
            $tj1['mingcheng'] = I('post.mingcheng');
            $tj1['fenxian'] = I('post.fenxian');
            $tj1['fenlei'] = I('post.fenlei');
            $tj1['laiyuan'] = I('post.laiyuan');
            $tj1['bumen'] = I('post.bumen');
            $tj1['jiazhi'] = I('post.jiazhi');
            $tj1['mudi'] = I('post.mudi');
            $tj1['shuru_up'] = I('post.shuru_up');
            $tj1['shuchu_down'] = I('post.shuchu_down');
            $tj1['biaozhun'] = I('post.biaozhun');
            $tj1['pingshen_jibie'] = I('post.pingshen_jibie');
            $tj1['pingshen_fangshi'] = I('post.pingshen_fangshi');
            $tj1['xingshi'] = I('post.xingshi');
            $tj1['liucheng'] = I('post.liucheng');
            $tj1['liucheng_bianzhi'] = I('post.liucheng_bianzhi');
            $tj1['liucheng_shenhe'] = I('post.liucheng_shenhe');
            $tj1['liucheng_biaoshen'] = I('post.liucheng_biaoshen');
            $tj1['liucheng_huiqian'] = I('post.liucheng_huiqian');
            $tj1['liucheng_shending'] = I('post.liucheng_shending');
            $tj1['liucheng_pizhun'] = I('post.liucheng_pizhun');
            $tj1['address'] = I('post.address');
            $tj1['cunfang_address'] = I('post.cunfang_address');
            $tj1['moban_cunfang_address'] = I('post.moban_cunfang_address');
            


           // if($this->model->create($tj1))
           if($Jiaofu->create($tj1))
            {
                // $this->model->where($tj)->save();
                $Jiaofu->where($tj)->save();
                $result['success'] = 1;
                $this->ajaxReturn($result, "json");
            }
            else
            {
                $result['success'] = 0;
                $this->ajaxReturn($result, "json");
            }
        }

        public function jfw_add()
        {
            $bianhao = I('post.bianhao');

            // $this->model = D('jiaofus');
            // $finded = $this->model->where("bianhao=$bianhao and if_delete=0")->find();

            // $Jiaofu = M("Jiaofus", '', 'mysql://test:123456@192.168.10.30/wechat#utf8');
            $Jiaofu = $this->createModel("Jiaofus");
            $finded = $Jiaofu->where("bianhao=$bianhao and if_delete=0")->find();
            if($finded)
            {
                $result['success'] = -1;
                $this->ajaxReturn($result, "json");
            }
            else
            {
                $tj1['bianhao'] = I('post.bianhao');
                $tj1['version'] = I('post.version');
                $tj1['mingcheng'] = I('post.mingcheng');
                $tj1['fenxian'] = I('post.fenxian');
                $tj1['fenlei'] = I('post.fenlei');
                $tj1['laiyuan'] = I('post.laiyuan');
                $tj1['bumen'] = I('post.bumen');
                $tj1['jiazhi'] = I('post.jiazhi');
                $tj1['mudi'] = I('post.mudi');
                $tj1['shuru_up'] = I('post.shuru_up');
                $tj1['shuchu_down'] = I('post.shuchu_down');
                $tj1['biaozhun'] = I('post.biaozhun');
                $tj1['pingshen_jibie'] = I('post.pingshen_jibie');
                $tj1['pingshen_fangshi'] = I('post.pingshen_fangshi');
                $tj1['xingshi'] = I('post.xingshi');
                $tj1['liucheng'] = I('post.liucheng');
                $tj1['liucheng_bianzhi'] = I('post.liucheng_bianzhi');
                $tj1['liucheng_shenhe'] = I('post.liucheng_shenhe');
                $tj1['liucheng_biaoshen'] = I('post.liucheng_biaoshen');
                $tj1['liucheng_huiqian'] = I('post.liucheng_huiqian');
                $tj1['liucheng_shending'] = I('post.liucheng_shending');
                $tj1['liucheng_pizhun'] = I('post.liucheng_pizhun');
                $tj1['address'] = I('post.address');
                $tj1['cunfang_address'] = I('post.cunfang_address');
                $tj1['moban_cunfang_address'] = I('post.moban_cunfang_address');

                // if($this->model->create($tj1))
                if($Jiaofu->create($tj1))
                {
                    // $this->model->add();
                    $Jiaofu->add();
                    $result['success'] = 1;
                    $this->ajaxReturn($result, "json");
                }
                else
                {
                    $result['success'] = 0;
                    $this->ajaxReturn($result, "json");
                }
            }

            $this->display();
        }

        public function jfw_delete()
        {
            $id = I('get.vid');
            // $this->model = D('jiaofus');
            // $result = $this->model->where("id=$id")->setField('if_delete', 1);
            // $Jiaofu = M("Jiaofus", '', 'mysql://test:123456@192.168.10.30/wechat#utf8');
            $Jiaofu = $this->createModel("Jiaofus");
            $Jiaofu->where("id=$id")->setField('if_delete', 1);
            $result['success'] = 1;
            $this->ajaxReturn($result, "json");
        }

        // -----------------------------------------------------------------------------------
        // -----------------------------------技术文档----------------------------------------
        // -----------------------------------------------------------------------------------
        public function JSindex()
        {
            // $this->model = D('jishus');
            // $jishus = $this->model->where("if_delete = 0")->order('id')->select();
            // $Jishu = M("Jishus", '', 'mysql://test:123456@192.168.10.30/wechat#utf8');
            $Jishu = $this->createModel("Jishus");
            $jishus = $Jishu->where("if_delete = 0")->order('id')->select();
            // $jishus = $Jishu->order('id')->select();
            $this->assign('jishus', $jishus);
            $this->display();   
        }


        public function js_edit()
        {
            $tj['id'] = I('post.idTijiao');


            // $this->model = D('jishus');
            // $result = $this->model->where($tj)->find();
            // $Jishu = M("Jishus", '', 'mysql://test:123456@192.168.10.30/wechat#utf8');
            $Jishu = $this->createModel("Jishus");

            $tj1['filename'] = I('post.filename');
            $tj1['version'] = I('post.version');
            $tj1['shenqian_bianzhi'] = I('post.shenqian_bianzhi');
            $tj1['shenqian_jiaodui'] = I('post.shenqian_jiaodui');
            $tj1['shenqian_shenhe'] = I('post.shenqian_shenhe');
            $tj1['shenqian_biaoshen'] = I('post.shenqian_biaoshen');
            $tj1['shenqian_huiqian'] = I('post.shenqian_huiqian');
            $tj1['shenqian_shending'] = I('post.shenqian_shending');
            $tj1['shenqian_pizhun'] = I('post.shenqian_pizhun');
            $tj1['guize'] = I('post.guize');
            $tj1['geshiyaoqiu1'] = I('post.geshiyaoqiu1');
            $tj1['geshiyaoqiu2'] = I('post.geshiyaoqiu2');
            $tj1['geshiyaoqiu3'] = I('post.geshiyaoqiu3');
            $tj1['geshiyaoqiu4'] = I('post.geshiyaoqiu4');
            $tj1['geshiyaoqiu5'] = I('post.geshiyaoqiu5');
            $tj1['tianxieyaoqiu1'] = I('post.tianxieyaoqiu1');
            $tj1['tianxieyaoqiu2'] = I('post.tianxieyaoqiu2');
            $tj1['tianxieyaoqiu3'] = I('post.tianxieyaoqiu3');
            $tj1['tianxieyaoqiu4'] = I('post.tianxieyaoqiu4');
            $tj1['tianxieyaoqiu5'] = I('post.tianxieyaoqiu5');
            $tj1['tianxieyaoqiu6'] = I('post.tianxieyaoqiu6');
            $tj1['liuchengyaoqiu1'] = I('post.liuchengyaoqiu1');
            $tj1['liuchengyaoqiu2'] = I('post.liuchengyaoqiu2');
            $tj1['liuchengyaoqiu3'] = I('post.liuchengyaoqiu3');
            $tj1['liuchengyaoqiu4'] = I('post.liuchengyaoqiu4');
            $tj1['liuchengyaoqiu5'] = I('post.liuchengyaoqiu5');
            $tj1['laiyuan'] = I('post.laiyuan');
            $tj1['date'] = I('post.date');
            $tj1['lianjie'] = I('post.lianjie');


            


           // if($this->model->create($tj1))
           if($Jishu->create($tj1))
            {
                // $this->model->where($tj)->save();
                $Jishu->where($tj)->save();
                $result['success'] = 1;
                $this->ajaxReturn($result, "json");
            }
            else
            {
                $result['success'] = 0;
                $this->ajaxReturn($result, "json");
            }
        }

        public function js_add()
        {
            $id = I('post.id');

            // $this->model = D('jishus');
            $Jishu = $this->createModel("Jishus");
            // $finded = $this->model->where("id=$id and if_delete=0")->find();
            $finded = $Jishu->where("id=$id and if_delete=0")->find();
            if($finded)
            {
                $result['success'] = -1;
                $this->ajaxReturn($result, "json");
            }
            else
            {
                $tj1['id'] = I('post.id');
                $tj1['filename'] = I('post.filename');
                $tj1['version'] = I('post.version');
                $tj1['shenqian_bianzhi'] = I('post.shenqian_bianzhi');
                $tj1['shenqian_jiaodui'] = I('post.shenqian_jiaodui');
                $tj1['shenqian_shenhe'] = I('post.shenqian_shenhe');
                $tj1['shenqian_biaoshen'] = I('post.shenqian_biaoshen');
                $tj1['shenqian_huiqian'] = I('post.shenqian_huiqian');
                $tj1['shenqian_shending'] = I('post.shenqian_shending');
                $tj1['shenqian_pizhun'] = I('post.shenqian_pizhun');
                $tj1['guize'] = I('post.guize');
                $tj1['geshiyaoqiu1'] = I('post.geshiyaoqiu1');
                $tj1['geshiyaoqiu2'] = I('post.geshiyaoqiu2');
                $tj1['geshiyaoqiu3'] = I('post.geshiyaoqiu3');
                $tj1['geshiyaoqiu4'] = I('post.geshiyaoqiu4');
                $tj1['geshiyaoqiu5'] = I('post.geshiyaoqiu5');
                $tj1['tianxieyaoqiu1'] = I('post.tianxieyaoqiu1');
                $tj1['tianxieyaoqiu2'] = I('post.tianxieyaoqiu2');
                $tj1['tianxieyaoqiu3'] = I('post.tianxieyaoqiu3');
                $tj1['tianxieyaoqiu4'] = I('post.tianxieyaoqiu4');
                $tj1['tianxieyaoqiu5'] = I('post.tianxieyaoqiu5');
                $tj1['tianxieyaoqiu6'] = I('post.tianxieyaoqiu6');
                $tj1['liuchengyaoqiu1'] = I('post.liuchengyaoqiu1');
                $tj1['liuchengyaoqiu2'] = I('post.liuchengyaoqiu2');
                $tj1['liuchengyaoqiu3'] = I('post.liuchengyaoqiu3');
                $tj1['liuchengyaoqiu4'] = I('post.liuchengyaoqiu4');
                $tj1['liuchengyaoqiu5'] = I('post.liuchengyaoqiu5');
                $tj1['laiyuan'] = I('post.laiyuan');
                $tj1['date'] = I('post.date');
                $tj1['lianjie'] = I('post.lianjie');

                // if($this->model->create($tj1))
                if($Jishu->create($tj1))
                {
                    // $this->model->add();
                    $Jishu->add();
                    $result['success'] = 1;
                    $this->ajaxReturn($result, "json");
                }
                else
                {
                    $result['success'] = 0;
                    $this->ajaxReturn($result, "json");
                }
            }

            $this->display();
        }

        public function js_delete()
        {
            $id = I('get.vid');
            // $this->model = D('jishus');
            $Jishu = $this->createModel("Jishus");
            // $result = $this->model->where("id=$id")->setField('if_delete', 1);
            $Jishu->where("id=$id")->setField('if_delete', 1);
            $result['success'] = 1;
            $this->ajaxReturn($result, "json");
        }


        // 公共的创建模型的函数
        public function createModel($modelName)
        {
            $Mmodel = M($modelName, '', 'mysql://huangtao:123456@192.168.10.20/wechat#utf8');
            return $Mmodel;
        }


    }