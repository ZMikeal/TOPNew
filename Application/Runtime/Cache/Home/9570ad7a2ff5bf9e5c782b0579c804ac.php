<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0041)http://v3.bootcss.com/examples/dashboard/ -->
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>topNew</title>

    <!-- Bootstrap core CSS -->
    <link href="/topNew/Public/custom/css/bootstrap.min.css" rel="stylesheet">

    <link href="/topNew/Public/custom/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/topNew/Public/custom/css/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/topNew/Public/custom/css/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="/topNew/Public/custom/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/topNew/Public/custom/css/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/topNew/Public/custom/css/daterangepicker.css" rel="stylesheet">
 
    <link href="/topNew/Public/custom/css/custom.min.css" rel="stylesheet">

    <style type="text/css">

    </style>
</head>

<body>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><img src="/topNew/Public/img/logo.png"><!--  <span>北汽集团</span> --></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="/topNew/Public/custom/images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>欢迎</span>
                <?php if(empty($_SESSION['admin'])): else: ?><h2></h2><?php endif; ?>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3><?php echo ($_SESSION['admin']['username']); ?></h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> 计划管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a>月度计划<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo U('Plan/formmidplan');?>">新建清单</a>
                            </li>
                            <li><a href="<?php echo U('Plan/modmidplan');?>">总结清单</a>
                            </li>
                            <li><a href="<?php echo U('Plan/midplan');?>">查看清单</a>
                            </li>
                          </ul>
                        </li>
                        <li><a>年度计划<span class="fa fa-chevron-down"></span></a>
                         <ul class="nav child_menu">
                            <li><a href="<?php echo U('PlanY/formmidplan');?>">新建清单</a>
                            </li>
                            <li><a href="<?php echo U('PlanY/modmidplan');?>">总结清单</a>
                            </li>
                            <li><a href="<?php echo U('PlanY/midplan');?>">查看清单</a>
                            </li>
                          </ul>
                        </li>
                    </ul>
                  </li>
                  <?php if($_SESSION['admin']['id_level']!= 3): ?><li><a><i class="fa fa-edit"></i> 绩效总评 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    <li><a>确认计划<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo U('Performance/Planconfirm');?>">月度计划确认</a>
                            </li>
                            <li><a href="<?php echo U('Performance/PlanconfirmY');?>">年度计划确认</a>
                            </li>
                          </ul>
                    </li>
                    <li><a>计划评分<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo U('Performance/PlangradeM');?>">月度计划评分</a>
                            </li>
                            <li><a href="<?php echo U('Performance/PlangradeS');?>">季度计划评分</a>
                            </li>
                            <li><a href="<?php echo U('Performance/PlangradeY');?>">年度计划评分</a>
                            </li>
                          </ul>
                    </li>
                    <li><a>绩效评分<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo U('Performance/Planconfirm');?>">月度绩效</a>
                            </li>
                            <li><a href="<?php echo U('Performance/PlanconfirmY');?>">年度绩效</a>
                            </li>
                          </ul>
                    </li>
                    </ul>
                  </li><?php endif; ?>
                  <li><a><i class="fa fa-desktop"></i> 综合查询 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('index/index1');?>">清单查询</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> 账户管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('user/pass');?>">修改密码</a></li>
                      <li><a href="<?php echo U('User/index');?>">修改个人信息</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> 扩展功能 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('index/index1');?>">供应商评价</a></li>
                      <li><a href="<?php echo U('index/index1');?>">资料在线浏览</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-clone"></i>帮助 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('index/index1');?>">使用帮助</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
         <!--      <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div> -->

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo U('Login/loginout');?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="/topNew/Public/custom/images/img.jpg" alt=""><?php if(empty($_SESSION['admin'])): else: echo ($_SESSION['admin']['username']); endif; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                   <!--  <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li> -->
                    <li><a href="<?php echo U('Login/loginout');?>"><i class="fa fa-sign-out pull-right"></i> 注销</a></li>
                  </ul>
                </li>

               <!--  <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="/topNew/Public/custom/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="/topNew/Public/custom/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="/topNew/Public/custom/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="/topNew/Public/custom/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> -->
                <li class="">
                 <a class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">当前时间为： <?php echo ($_SESSION['admin']['year_sys']); ?> 年 <?php echo ($_SESSION['admin']['month_sys']); ?> 月 </a>
                </li>
                <li class="">
                 <a class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">当前版本：1.0.1</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>


          
<style type="text/css">
.column-title{
  text-align: center;
}
</style>

<div class="right_col" role="main">
              <div class="row">
<form id="postForm" name="postForm" action="<?php echo U('Plan/addmplan');?>" method="post" class="form-horizontal">
<?php if($_SESSION['admin']['id_level']== 5): ?><div class="x_panel">
                  <div class="x_title">
                    <h2>清单计划 （时间:<?php echo ($_SESSION['admin']['year']); ?>年<?php echo ($_SESSION['admin']['month']); ?>月）</h2>
                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
<table id="tb" class="table table-striped jambo_table bulk_action" style="text-align:center;height:100%;">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">工作类型</th>
                            <th class="column-title">工作分类</th>
                            <th class="column-title">工作事项</th>
                            <th class="column-title">计划完成时间 </th>
                            <th class="column-title">权重 </th>
                            <th class="column-title">工作内容及目标/交付物 </th>
                            <th class="column-title no-link last" ><span class="nobr">是否延续</span></th>
                          </tr>
                        </thead>

                        <tbody>

                        <?php $__FOR_START_1630842725__=1;$__FOR_END_1630842725__=11;for($j=$__FOR_START_1630842725__;$j < $__FOR_END_1630842725__;$j+=1){ if(!empty($list1)): ?><tr class="even pointer">
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_type]" class="form-control">                 
                                    <option value="部门重点工作" >部门重点工作</option>    
                            </select>
                            </td>
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_classify]" class="form-control">
                                    <option value="重点工作" <?php if($list1[$j-1]['plan_classify'] == '重点工作'): ?>selected="selected"<?php endif; ?>>重点工作</option>
                                    <option value="常规工作" <?php if($list1[$j-1]['plan_classify'] == '常规工作'): ?>selected="selected"<?php endif; ?>>常规工作</option>
                            </select></td>
                            <td class=" ">
                              <textarea name="gongchengxiangmu[]" id="gongchengxiangmu[]" placeholder="" style="text-align:left;"><?php echo ($list1[$j-1]["plan_name"]); ?></textarea>
                            </td>
                            <td class=" ">
                              <input type="text" class="data" name="wanchengriqi[]" placeholder="First Name" aria-describedby="inputSuccess2Status2" value="<?php echo ($list1[$j-1]["plan_closingdate"]); ?>">
                            </td>
                            <td class=" ">
                              <input type="text" name="quanzhong[]" style="width:50px;" maxlength="3" id="quanzhong[]" value="<?php echo ($list1[$j-1]["plan_weight"]); ?>">
                            </td>
                            <td class=" ">
                              <textarea name="gongzuoneirong[]" id="gongzuoneirong[]" placeholder="" style="width:300px; "><?php echo ($list1[$j-1]["plan_content"]); ?></textarea>
                            </td>
                            <td class=" last">
                            <select name="plan[<?php echo ($j); ?>][if_continue]" class="form-control" >
                                    <option value="1" <?php if($list1[$j-1]['if_continue'] == 1): ?>selected="selected"<?php endif; ?>>是</option>
                                    <option value="0" <?php if($list1[$j-1]['if_continue'] == 0): ?>selected="selected"<?php endif; ?>>否</option>
                            </select>
                            </td>
                          </tr><?php endif; ?>
                        <?php if(empty($list1)): ?><tr class="even pointer" id="a<?php echo ($j); ?>">
                            <td class=" ">
                            
                            <select name="plan[<?php echo ($j); ?>][plan_type]" class="form-control">                 
                                    <option value="部门重点工作" >部门重点工作</option>    
                            </select>
                            </td>
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_classify]" class="form-control">
                                    <option value="重点工作" <?php if($list[$j-1]['plan_classify'] == '重点工作'): ?>selected="selected"<?php endif; ?>>重点工作</option>
                                    <option value="常规工作" <?php if($list[$j-1]['plan_classify'] == '常规工作'): ?>selected="selected"<?php endif; ?>>常规工作</option>
                            </select>
                            </td>
                            <td class=" ">
                              <textarea name="gongchengxiangmu[]" id="gongchengxiangmu[]" placeholder="" style="text-align:left;"><?php echo ($list[$j-1]["plan_name"]); ?></textarea>
                               <input type="hidden" value="<?php echo ($list[$j-1]["id"]); ?>" name="id[]">
                            </td>
                            <td class=" ">
                              <!-- <input type="date" name="wanchengriqi[]" id="wanchengriqi[]" value="<?php echo ($list[$j-1]["plan_closingdate"]); ?>"> -->

                              <input type="text" class="data" name="wanchengriqi[]" placeholder="First Name" aria-describedby="inputSuccess2Status2" value="<?php echo ($list[$j-1]["plan_closingdate"]); ?>">
                            </td>
                            <td class=" ">
                              <input type="text" name="quanzhong[]" style="width:50px;" maxlength="3" id="quanzhong[]" value="<?php echo ($list[$j-1]["plan_weight"]); ?>">
                            </td>
                            <td class=" ">
                              <textarea name="gongzuoneirong[]" id="gongzuoneirong[]" placeholder="" style="width:300px; "><?php echo ($list[$j-1]["plan_content"]); ?></textarea>
                            </td>
  
                            <td class=" last">
                            <select name="plan[<?php echo ($j); ?>][if_continue]" class="form-control" >
                                    <option value="1" <?php if($list[$j-1]['if_continue'] == 1): ?>selected="selected"<?php endif; ?>>是</option>
                                    <option value="0" <?php if($list[$j-1]['if_continue'] == 0): ?>selected="selected"<?php endif; ?>>否</option>
                            </select>
                            </td>
                          </tr><?php endif; } ?>
                      <?php $__FOR_START_23598698__=11;$__FOR_END_23598698__=16;for($j=$__FOR_START_23598698__;$j < $__FOR_END_23598698__;$j+=1){ if(!empty($listt1)): ?><tr class="even pointer">
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_type]" class="form-control">                 
                                    <option value="能力建设" >能力建设</option>    
                            </select>
                            </td>
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_classify]" class="form-control">
                                    <option value="重点工作" <?php if($listt1[$j-11]['plan_classify'] == '重点工作'): ?>selected="selected"<?php endif; ?>>重点工作</option>
                                    <option value="常规工作" <?php if($listt1[$j-11]['plan_classify'] == '常规工作'): ?>selected="selected"<?php endif; ?>>常规工作</option>
                            </select></td>
                            <td class=" ">
                              <textarea name="gongchengxiangmu[]" id="gongchengxiangmu[]" placeholder="" style="text-align:left;"><?php echo ($listt1[$j-11]["plan_name"]); ?></textarea>
                              <input type="hidden" value="<?php echo ($listt1[$j-11]["id"]); ?>" name="id[]">
                            </td>
                            <td class=" ">
                              <input type="text" class="data" name="wanchengriqi[]" placeholder="First Name" aria-describedby="inputSuccess2Status2" value="<?php echo ($listt1[$j-11]["plan_closingdate"]); ?>">
                            </td>
                            <td class=" ">
                              <input type="text" name="quanzhong[]" style="width:50px;" maxlength="3" id="quanzhong[]" value="<?php echo ($listt1[$j-11]["plan_weight"]); ?>">
                            </td>
                            <td class=" ">
                              <textarea name="gongzuoneirong[]" id="gongzuoneirong[]" placeholder="" style="width:300px; "><?php echo ($listt1[$j-11]["plan_content"]); ?></textarea>
                            </td>
                            <td class=" last">
                            <select name="plan[<?php echo ($j); ?>][if_continue]" class="form-control" >
                                    <option value="1" <?php if($listt1[$j-11]['if_continue'] == 1): ?>selected="selected"<?php endif; ?>>是</option>
                                    <option value="0" <?php if($listt1[$j-11]['if_continue'] == 0): ?>selected="selected"<?php endif; ?>>否</option>
                            </select>
                            </td>
                          </tr><?php endif; ?>
                      <?php if(empty($listt1)): ?><tr class="even pointer">
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_type]" class="form-control">                 
                                    <option value="能力建设" >能力建设</option>    
                            </select>
                            </td>
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_classify]" class="form-control">
                                    <option value="重点工作" <?php if($listt[$j-11]['plan_classify'] == '重点工作'): ?>selected="selected"<?php endif; ?>>重点工作</option>
                                    <option value="常规工作" <?php if($listt[$j-11]['plan_classify'] == '常规工作'): ?>selected="selected"<?php endif; ?>>常规工作</option>
                            </select></td>
                            <td class=" ">
                              <textarea name="gongchengxiangmu[]" id="gongchengxiangmu[]" placeholder="" style="text-align:left;"><?php echo ($listt[$j-11]["plan_name"]); ?></textarea>
                              <input type="hidden" value="<?php echo ($listt[$j-11]["id"]); ?>" name="id[]">
                            </td>
                            <td class=" ">
                              <input type="text" class="data" name="wanchengriqi[]" placeholder="First Name" aria-describedby="inputSuccess2Status2" value="<?php echo ($listt[$j-11]["plan_closingdate"]); ?>">
                            </td>
                            <td class=" ">
                              <input type="text" name="quanzhong[]" style="width:50px;" maxlength="3" id="quanzhong[]" value="<?php echo ($listt[$j-11]["plan_weight"]); ?>">
                            </td>
                            <td class=" ">
                              <textarea name="gongzuoneirong[]" id="gongzuoneirong[]" placeholder="" style="width:300px; "><?php echo ($listt[$j-11]["plan_content"]); ?></textarea>
                            </td>
                            <td class=" last">
                            <select name="plan[<?php echo ($j); ?>][if_continue]" class="form-control" >
                                    <option value="1" <?php if($listt[$j-11]['if_continue'] == 1): ?>selected="selected"<?php endif; ?>>是</option>
                                    <option value="0" <?php if($listt[$j-11]['if_continue'] == 0): ?>selected="selected"<?php endif; ?>>否</option>
                            </select>
                            </td>
                          </tr><?php endif; } ?>
                      </tbody>
                      </table>
                       <input class="btn btn-success" type="button" value="提交" onclick="fn1()" style="margin-left:40%;width:10%;">
                      </div></div><?php endif; ?>
<?php if($_SESSION['admin']['id_level']!= 5): ?><!--上级表-->
 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>上级:<?php echo ($_SESSION['admin']['user_leader']); ?> 的计划表</h2>
                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <?php if(empty($list2)): ?><table class="table">

                  <h3>还没有任何计划！</h3>

                  </table><?php endif; ?>
                  <?php if(!empty($list2)): ?><table class="table" style="text-align:center;">
                      <thead>
                        <tr>
                          <th style="text-align:center;">工作类型</th>
                          <th style="text-align:center;">工作分类</th>
                          <th style="text-align:center;">工作事项</th>
                          <th style="text-align:center;">计划完成时间</th>
                          <th style="text-align:center;">权重</th>
                          <th style="text-align:center;">工作内容及目标/交付物</th>
                          <th style="text-align:center;">是否延续</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php if(is_array($list2)): $i = 0; $__LIST__ = $list2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><tr>
                          <td><?php echo ($vv["plan_type"]); ?></td>
                          <td><?php echo ($vv["plan_classify"]); ?></td>
                          <td><?php echo ($vv["plan_name"]); ?></td>
                          <td><?php echo ($vv["plan_closingdate"]); ?></td>
                          <td><?php echo ($vv["plan_weight"]); ?></td>
                          <td><?php echo ($vv["plan_content"]); ?></td>
                          <td><?php if($vv["if_continue"] == 1): ?>是<?php else: ?>否<?php endif; ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                      </tbody>
                    </table><?php endif; ?>
                  </div>
                </div>
  </div><!--上级表结束-->

  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>清单计划 （时间:<?php echo ($_SESSION['admin']['year']); ?>年<?php echo ($_SESSION['admin']['month']); ?>月）</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">

                  <?php if(empty($list2)): ?><table class="table table-striped jambo_table bulk_action" style="text-align:center;height:100%;">
                  <tr class="headings">
                  <p><strong>因您上级领导暂未提交本月计划，本月计划暂无法填写，请等待。</strong></p>
                  </tr>
                  </table><?php endif; ?>
                  <?php if(!empty($list2)): ?><table id="tb" class="table table-striped jambo_table bulk_action" style="text-align:center;height:100%;">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">工作类型</th>
                            <th class="column-title">工作分类</th>
                            <th class="column-title">工作事项</th>
                            <th class="column-title">计划完成时间 </th>
                            <th class="column-title">权重 </th>
                            <th class="column-title">工作内容及目标/交付物 </th>
                            <?php if(($_SESSION['admin']['id_level']== 3) and ($_SESSION['admin']['user_type']== '专业员工')): ?><th class="column-title">VSE姓名 </th><?php endif; ?>
                            <th class="column-title no-link last" >是否延续</th>
                          </tr>
                        </thead>
                     <tbody>
                        <?php $__FOR_START_384811638__=1;$__FOR_END_384811638__=8;for($j=$__FOR_START_384811638__;$j < $__FOR_END_384811638__;$j+=1){ ?><tr class="even pointer">
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_type]" class="form-control">                 
                                    <option value="科室工作" <?php if($list[$j-1]['plan_type'] == '科室工作'): ?>selected="selected"<?php endif; ?>>科室工作</option>
                                    <option value="项目工作" <?php if($list[$j-1]['plan_type'] == '项目工作'): ?>selected="selected"<?php endif; ?>>项目工作</option>        
                                 </select>
                            </td>
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_classify]" class="form-control">
                                    <option value="重点工作" <?php if($list[$j-1]['plan_classify'] == '重点工作'): ?>selected="selected"<?php endif; ?>>重点工作</option>
                                    <option value="常规工作" <?php if($list[$j-1]['plan_classify'] == '常规工作'): ?>selected="selected"<?php endif; ?>>常规工作</option>
                                 </select></td>
                            <td class=" ">
                              <textarea name="gongchengxiangmu[]" id="gongchengxiangmu[]" placeholder="" style="text-align:left;"><?php echo ($list[$j-1]["plan_name"]); ?></textarea>
                               <input type="hidden" value="<?php echo ($list[$j-1]["id"]); ?>" name="id[]">
                            </td>
                            <td class=" ">

                              <input type="text" class="data" name="wanchengriqi[]" placeholder="First Name" aria-describedby="inputSuccess2Status2" value="<?php echo ($list[$j-1]["plan_closingdate"]); ?>">
                            </td>
                            <td class=" ">
                              <input type="text" name="quanzhong[]" style="width:50px;" maxlength="3" id="quanzhong[]" value="<?php echo ($list[$j-1]["plan_weight"]); ?>">
                            </td>
                            <td class=" ">
                              <textarea name="gongzuoneirong[]" id="gongzuoneirong[]" placeholder="" style="width:300px; "><?php echo ($list[$j-1]["plan_content"]); ?></textarea>
                            </td>
                            <?php if(($_SESSION['admin']['id_level']== 3) and ($_SESSION['admin']['user_type']== '专业员工')): ?><td class="">
                              <select name="plan[<?php echo ($j); ?>][plan_leader]">
                              <option value=""><?php echo ($_SESSION['admin']['user_leader']); ?></option>
                              <?php if(is_array($vse)): $i = 0; $__LIST__ = $vse;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["vse"]); ?>" <?php if($list[$j-1]['plan_leader'] == $vo[vse]): ?>selected="selected"<?php endif; ?>><?php echo ($vo["vse"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                              </select>
                            </td><?php endif; ?>
                            <td class=" last">
                            <select name="plan[<?php echo ($j); ?>][if_continue]" class="form-control" >
                                    <option value="1" <?php if($list[$j-1]['if_continue'] == 1): ?>selected="selected"<?php endif; ?>>是</option>
                                    <option value="0" <?php if($list[$j-1]['if_continue'] == 0): ?>selected="selected"<?php endif; ?>>否</option>
                            </select>
                            </td>
                          </tr><?php } ?>    
                     <?php $__FOR_START_24892077__=8;$__FOR_END_24892077__=10;for($j=$__FOR_START_24892077__;$j < $__FOR_END_24892077__;$j+=1){ ?><tr class="even pointer">
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_type]" class="form-control">                 
                                    <option value="改善创新项" >改善创新项</option>    
                            </select>
                            </td>
                            <td class=" ">
                            <select name="plan[<?php echo ($j); ?>][plan_classify]" class="form-control">
                                    <option value="重点工作" <?php if($listt[$j-8]['plan_classify'] == '重点工作'): ?>selected="selected"<?php endif; ?>>重点工作</option>
                                    <option value="常规工作" <?php if($listt[$j-8]['plan_classify'] == '常规工作'): ?>selected="selected"<?php endif; ?>>常规工作</option>
                            </select></td>
                            <td class=" ">
                              <textarea name="gongchengxiangmu[]" id="gongchengxiangmu[]" placeholder="" style="text-align:left;"><?php echo ($listt[$j-8]["plan_name"]); ?></textarea>
                              <input type="hidden" value="<?php echo ($listt[$j-8]["id"]); ?>" name="id[]">
                            </td>
                            <td class=" ">
                              <input type="text" class="data" name="wanchengriqi[]" placeholder="First Name" aria-describedby="inputSuccess2Status2" value="<?php echo ($listt[$j-8]["plan_closingdate"]); ?>">
                            </td>
                            <td class=" ">
                              <input type="text" name="quanzhong[]" style="width:50px;" maxlength="3" id="quanzhong[]" value="<?php echo ($listt[$j-8]["plan_weight"]); ?>">
                            </td>
                            <td class=" ">
                              <textarea name="gongzuoneirong[]" id="gongzuoneirong[]" placeholder="" style="width:300px; "><?php echo ($listt[$j-8]["plan_content"]); ?></textarea>
                            </td>
                            <?php if(($_SESSION['admin']['id_level']== 3) and ($_SESSION['admin']['user_type']== '专业员工')): ?><td class="">
                              <select name="plan[<?php echo ($j); ?>][plan_leader]">
                              <option value=""><?php echo ($_SESSION['admin']['user_leader']); ?></option>
                              <?php if(is_array($vse)): $i = 0; $__LIST__ = $vse;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["vse"]); ?>" <?php if($list[$j-1]['plan_leader'] == $vo[vse]): ?>selected="selected"<?php endif; ?>><?php echo ($vo["vse"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                              </select>
                            </td><?php endif; ?>
                            <td class=" last">
                            <select name="plan[<?php echo ($j); ?>][if_continue]" class="form-control" >
                                    <option value="1" <?php if($listt[$j-8]['if_continue'] == 1): ?>selected="selected"<?php endif; ?>>是</option>
                                    <option value="0" <?php if($listt[$j-8]['if_continue'] == 0): ?>selected="selected"<?php endif; ?>>否</option>
                            </select>
                            </td>
                          </tr><?php } ?>    
                     </tbody>
                      </table>
                       <input class="btn btn-success" type="button" value="提交" onclick="fn()" style="margin-left:40%;width:10%;"><?php endif; ?>
                      
                    </div>
                  </div>
                     
</div>
</div><?php endif; ?>
</div>
</div>
                    
        <footer>
          <div class="pull-right">
              
          </div>
          <div class="clearfix"></div>
        </footer>
      </div>
    </div>
    <script src="/topNew/Public/custom/js/jquery.min.js"></script>
    <!--<script src="/topNew/Public/custom/jquery.min.js"></script>-->
    <script src="/topNew/Public/custom/js/bootstrap.min.js"></script>
    <script src="/topNew/Public/custom/js/custom.min.js"></script>
   <script src="/topNew/Public/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/topNew/Public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- /gauge.js -->
     <script src="/topNew/Public/custom/js/moment.min.js"></script>
              <script src="/topNew/Public/custom/js/daterangepicker.js"></script>
               <script type="text/javascript">
                  $('.data').daterangepicker({
                    //language:"zh-CN",
                    singleDatePicker: true,
                    singleClasses: "picker_4"
                  }, function(start, end, label) {
                   // console.log(start.toISOString(), end.toISOString(), label);
                  
                  });
               </script>     
  </body>
</html>
 
<script type="text/javascript">
  function fn()
  {
      var gongchengxiangmu=document.getElementsByName('gongchengxiangmu[]');
      var wanchengriqi=document.getElementsByName('wanchengriqi[]');
      var quanzhong=document.getElementsByName('quanzhong[]');
      var gongzuoneirong=document.getElementsByName('gongzuoneirong[]');
      //var planleader=document.getElementsByName('plan_leader[]');
      var zongquanzhong=0;
      var zongquanzhong1=10;
      var zongquanzhong2=0;
      //alert(zongquanzhong);
      var xx = new Array(6);
      //alert(gongchengxiangmu.length);
      for(var i=1;i<=7;i++)
      {
        if(gongchengxiangmu[i-1].value!="")
            {
              var dd=0;
              if(wanchengriqi[i-1].value=="")
              {
                alert("请在第"+i+"行填写完成日期");
                dd=1;
                return false;
              }
              if(quanzhong[i-1].value=="")
              {
                alert("请在第"+i+"行填写工作权重");
                dd=1;
                return false;
              }
              if(gongzuoneirong[i-1].value=="")
              {
                alert("请在第"+i+"行填写工作内容和交付物");
                dd=1;
                return false;
              }
               
              if(dd==0)
              {
                zongquanzhong+=parseInt(quanzhong[i-1].value);
                 xx[i-1]=i;
              }
            }
      }
      for(var i=8;i<=9;i++)
      {
        if(gongchengxiangmu[i-1].value!="")
            {
              var dd1=0;
              if(wanchengriqi[i-1].value=="")
              {
                alert("请在第"+i+"行填写完成日期");
                dd1=1;
                return false;
              }
              if(quanzhong[i-1].value=="")
              {
                alert("请在第"+i+"行填写工作权重");
                dd1=1;
                return false;
              }
              if(gongzuoneirong[i-1].value=="")
              {
                alert("请在第"+i+"行填写工作内容和交付物");
                dd1=1;
                return false;
              }
               
              if(dd1==0)
              {
                zongquanzhong2+=parseInt(quanzhong[i-1].value);
                 xx[i-1]=i;
              }
            }
      }
      if(zongquanzhong!=0)
      {
        if(zongquanzhong!=100)
       {
        alert("部门重点工作的总权重和为"+zongquanzhong+",不是100，请调整权重！");
        return false;
       }
      }
       if(zongquanzhong2!=0)
      {
        if(zongquanzhong2!=10)
       {
        alert("改善创新项的总权重和为"+zongquanzhong1+",不是10，请调整权重！");
        return false;
       }
       if(zongquanzhong==100&&zongquanzhong2==10)
       {
        //alert(xx[1]);
        document.getElementById("postForm").submit();
       }
      }
      if(zongquanzhong2==0)
      {
       if(zongquanzhong==100)
       {
        //alert(xx[1]);
        document.getElementById("postForm").submit();
       }
      }
      
      

  }
   function fn1()
  {
      var gongchengxiangmu=document.getElementsByName('gongchengxiangmu[]');
      var wanchengriqi=document.getElementsByName('wanchengriqi[]');
      var quanzhong=document.getElementsByName('quanzhong[]');
      var gongzuoneirong=document.getElementsByName('gongzuoneirong[]');
      //var planleader=document.getElementsByName('plan_leader[]');
      var zongquanzhong=0;
      var zongquanzhong1=10;
      //alert(zongquanzhong);
      var xx = new Array(6);
      //alert(gongchengxiangmu.length);
      for(var i=1;i<=15;i++)
      {
        if(gongchengxiangmu[i-1].value!="")
            {
              var dd=0;
              if(wanchengriqi[i-1].value=="")
              {
                alert("请在第"+i+"行填写完成日期");
                dd=1;
                return false;
              }
              if(quanzhong[i-1].value=="")
              {
                alert("请在第"+i+"行填写工作权重");
                dd=1;
                return false;
              }
              if(gongzuoneirong[i-1].value=="")
              {
                alert("请在第"+i+"行填写工作内容和交付物");
                dd=1;
                return false;
              }
               
              if(dd==0)
              {
                zongquanzhong+=parseInt(quanzhong[i-1].value);
                 xx[i-1]=i;
              }
            }
      }
      if(zongquanzhong!=0)
      {
        if(zongquanzhong!=100)
       {
        alert("部门重点工作的总权重和为"+zongquanzhong+",不是100，请调整权重！");
        return false;
       }
      }
       if(zongquanzhong1!=0)
      {
        if(zongquanzhong1!=10)
       {
        alert("改善创新项的总权重和为"+zongquanzhong1+",不是10，请调整权重！");
        return false;
       }
       if(zongquanzhong==100&&zongquanzhong1==10)
       {
        //alert(xx[1]);
        document.getElementById("postForm").submit();
       }
      }
      

  }
  function gs(){

  }
  window.onload = function()
        {
            
        }
</script>