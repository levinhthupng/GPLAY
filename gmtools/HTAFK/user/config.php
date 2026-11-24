<?php
error_reporting(0);
$PZ = array(
	'DB_HOST'=>'178.128.127.134',// 服务器地址
	'DB_USER'=>'hk20',// 用户名
	'DB_PWD'=>'12082001Lvt',// 密码
	'DB_PORT'=>'3306'
);

$d_gmrz = 'lyzwlkj.vip';//gm认证码
$d_name = '风暴币';//货币名称
$d_rmb = '1000'; //新人送的快乐币
$d_flwp = array(array(3, 1, 10000000),array(22, 1, 200000000),array(5, 1, 8000000));
// 新角色福利领取给与的物品.
$d_daywp = array(array(22, 1, 50000000),array(39052, 1, 50),array(10001, 1, 20000),array(3, 1, 100000));
// 角色每日福利领取给与的物品.

if($qu == 1){
    $d_zone = 1;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_1';                      //数据库名称
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9001;

}elseif($qu == 2){
    $d_zone = 2;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_2';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9002;
}elseif($qu == 3){
    $d_zone = 3;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_3';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9003;
}elseif($qu == 4){
    $d_zone = 4;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_4';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9004;
}elseif($qu == 5){
    $d_zone = 5;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_5';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9005;
}elseif($qu == 6){
    $d_zone = 6;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_6';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9006;
}elseif($qu == 7){
    $d_zone = 7;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_7';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9007;
}elseif($qu == 8){
    $d_zone = 8;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_8';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9008;
}elseif($qu == 9){
    $d_zone = 9;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_9';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9009;
}elseif($qu == 10){
    $d_zone = 10;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_10';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9010;
}elseif($qu == 11){
    $d_zone = 11;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_11';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9011;
}elseif($qu == 13){
    $d_zone = 13;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_13';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9013;
}elseif($qu == 14){
    $d_zone = 14;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_14';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9014;
}elseif($qu == 15){
    $d_zone = 15;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_15';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9015;
}elseif($qu == 16){
    $d_zone = 16;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_16';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9016;
}elseif($qu == 17){
    $d_zone = 17;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_17';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9017;
}elseif($qu == 18){
    $d_zone = 18;
    $d_plat = 'local';
    $d_ssdb = 'sszg_local_18';
    $d_keys = '713493d68fead22e15dbf0fc4d7b24ad';  // 服务器key
    $d_port = 9018;
}else{
    die('区服错误');
}

function Order_id(){
    static $ORDERSN=array();
    $ors=date('ymd').substr(time(),-5).substr(microtime(),2,5);
    if (isset($ORDERSN[$ors])){
        $ORDERSN[$ors]++;
    }else{
        $ORDERSN[$ors]=1;
    }
    return $ors.str_pad($ORDERSN[$ors],2,'0',STR_PAD_LEFT);
}


function erls($module, $method, $format = '', $args = array(),$d_plat,$d_keys,$d_port) {
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!$socket) return array('success' => false, 'message' => 'create_conn_failed');
    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec"=>2, "usec"=>0));
    socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec"=>2, "usec"=>0));
    $conn = socket_connect($socket, '178.128.127.134', $d_port);
    if (!$conn) return array('success' => false, 'message' => 'connect_failed');
    socket_write($socket, "web_conn---------------");
    $time = time();
    if (trim($format) === '') { 
        $data = array($d_plat, $time, md5($d_plat.$time.$d_keys), $format, $module, $method);
    } else {
        $data = array($d_plat, $time, md5($d_plat.$time.$d_keys), $format, $module, $method, $args);
    }
    $data = json_encode($data);
    socket_write($socket, pack('n', strlen($data)));
    socket_write($socket, $data);
    $recvData = '';
    while ($r = socket_recv($socket, $bufs, 1024, 0)) {
        $recvData .= $bufs;
    }
    socket_close($socket);
    if (json_last_error() !== JSON_ERROR_NONE) return array('success' => false, 'message' => '返回数据不是json格式');
    return json_decode($recvData, true);
}
?>