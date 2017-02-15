<?php
return array(
//*************************************数据库设置*********************************
'DB_TYPE'   => 'mysql', // 数据库类型
'DB_HOST'   => 'localhost', // 服务器地址
'DB_NAME'   => 'topnew', // 数据库名
'DB_USER'   => 'root', // 用户名
'DB_PWD'    => 'nzlgipe1@rn', // 密码
'DB_PORT'   => 3306, // 端口
'DB_PARAMS' =>  array(), // 数据库连接参数
//'DB_PREFIX' => '', // 数据库表前缀 
'DB_CHARSET'=> 'utf8', // 字符集
'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志

//***********************************SESSION设置**********************************
 'SESSION_OPTIONS'         	  =>  array(
 	    'name'                =>  'admin',
        'expire'              =>  24*3600*1,                       	//SESSION保存1天
        'use_trans_sid'       =>  1,                               //跨页传递
        'use_only_cookies'    =>  0,                               //是否只开启基于cookies的session的会话方式
    ),

//***********************************表单命令**********************************
        // 'TOKEN_ON'=>true,
        // 'TOKEN_NAME'=>'__hash__',
        // 'TOKEN_TYPE'=>'md5',
        // 'TOKEN_RESET'=>true,
);



// return array(
//  //'module_init'=>('app\\common\\behavior\\Token'),
//  'view_filter'=>array('Behavior\TokenBuildBehavior'),
//  //'app_end'=>['app\\common\\behavior\\Token'],
//  'token'=>array(
//         'token_on'=>true,
//         'token_name'=>'__hash__',
//         'token_on'=>'md5',
//         'token_on'=>true,
//             )
// );