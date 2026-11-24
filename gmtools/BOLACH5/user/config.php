<?php
error_reporting(0);
$PZ = array(
	'DB_HOST'=>'167.71.205.84',// 服务器地址
	'DB_NAME'=>'cdks',// CDK库
	'DB_QU'=>'1001',// CDK库
	'DB_GAME'=>'sq_s1001',// 游戏数据库
	'DB_USER'=>'hk20',// 用户名
	'DB_PWD'=>'12082001Lvt',// 密码
	'DB_PORT'=>'3306',// 端口
	'DB_CHARSET'=>'utf8',// 数据库字符集
);

$gm_code = "061294";//gm授权码


$gmcode='g100k';
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
?>  