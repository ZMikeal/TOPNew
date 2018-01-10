<?php
/**
 * Created by PhpStorm.
 * User: zhangtong02
 * Date: 2017/12/12
 * Time: 17:21
 */

namespace Home\Controller;
use Home\Controller\BaseController;

class RateYController extends BaseController
{
    public function _initialize()
    {
        if (!session('?admin')) {
            $this->redirect('login/login');
            exit;
        }
        if (session('admin.id_level') == 2) {
            $this->redirect('planjhy/index');
            exit;
        }
        if (session('admin.id_level') == 1) {
            $this->redirect('plansuper/index');
            exit;
        }
    }
    //科级评员工年终分数
    public function grade_finalyear_staff()
    {
            $staff_condition['year']        = session('admin.year');
            $staff_condition['']

            $chief_condition['quarter']     = 4;
            $chief_condition['year']        = session('admin.year_sys')-1;

    }


}