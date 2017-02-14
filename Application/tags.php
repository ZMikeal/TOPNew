return array(
 //'module_init'=>('app\\common\\behavior\\Token'),
 'view_filter'=>array('Behavior\TokenBuildBehavior'),
 //'app_end'=>['app\\common\\behavior\\Token'],
 'token'=>array(
        'token_on'=>true,
        'token_name'=>'__hash__',
        'token_on'=>'md5',
        'token_on'=>true,
            )
);
