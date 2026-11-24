<?php
	function login_post($url, $cookie, $post){
	$ch = curl_init(); //khởi tạo curlModule 
	curl_setopt($ch, CURLOPT_URL, $url); //Đăng nhập vào địa chỉ đã gửi 
	curl_setopt($ch, CURLOPT_HEADER, 0); //Có hiển thị thông tin tiêu đề hay không 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Có tự động hiển thị thông tin trả về hay không 
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); //Thiết trí cookieThông tin được lưu trong thư mục được chỉ định 
	curl_setopt($ch, CURLOPT_POST, 1); //qua POSTGửi qua 
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));//thông tin cần thực hiện 
	curl_exec($ch); //thực hiện CURL
	curl_close($ch);
	}
	function mail_post($url, $cookie, $post){
	$ch = curl_init(); //khởi tạocurlModule
	curl_setopt($ch, CURLOPT_URL, $url); //Đăng nhập vào địa chỉ đã gửi 
	curl_setopt($ch, CURLOPT_HEADER, 0); //Có hiển thị thông tin tiêu đề hay không 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Có tự động hiển thị thông tin trả về hay không 
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);//Thiết trícookieThông tin được lưu trong thư mục được chỉ định 
	curl_setopt($ch, CURLOPT_POST, 1); //quaPOSTGửi qua 
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));//thông tin cần thực hiện 
	curl_exec($ch); //thực hiệnCURL
	curl_close($ch);
	}
	$quarr=array(
		'1'=>array(
			'ip'=>'167.71.193.69',
			'user'=>'hk20',
			'pswd'=>'12082001Lvt',
			'db'=>'qj_h5_1001',
			'srvid'=>'1001',
		),
		'2'=>array(
			'ip'=>'167.71.193.69',
			'user'=>'hk20',
			'pswd'=>'12082001Lvt',
			'db'=>'qj_h5_1002',
			'srvid'=>'1002',
		),
		'3'=>array(
			'ip'=>'167.71.193.69',
			'user'=>'hk20',
			'pswd'=>'12082001Lvt',
			'db'=>'qj_h5_1003',
			'srvid'=>'1003',
		),	
		'4'=>array(
			'ip'=>'167.71.193.69',
			'user'=>'hk20',
			'pswd'=>'12082001Lvt',
			'db'=>'qj_h5_1004',
			'srvid'=>'1004',
		),	
		'5'=>array(
			'ip'=>'167.71.193.69',
			'user'=>'hk20',
			'pswd'=>'12082001Lvt',
			'db'=>'qj_h5_1005',
			'srvid'=>'1005',
		),	
		'6'=>array(
			'ip'=>'167.71.193.69',
			'user'=>'hk20',
			'pswd'=>'12082001Lvt',
			'db'=>'qj_h5_1006',
			'srvid'=>'1006',
		),	
		'7'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'hk20',
			'pswd'=>'12082001Lvt',
			'db'=>'qj_h5_1007',
			'srvid'=>'1007',
		),	
		'8'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'ybbzycom66',
			'db'=>'qj_h5_1008',
			'srvid'=>'1008',
		),	
		'9'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'ybbzycom66',
			'db'=>'qj_h5_1009',
			'srvid'=>'1009',
		),	
		'10'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'ybbzycom66',
			'db'=>'qj_h5_1010',
			'srvid'=>'1010',
		),	
		'11'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'ybbzycom66',
			'db'=>'qj_h5_1011',
			'srvid'=>'1011',
		),
		'12'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'ybbzycom66',
			'db'=>'qj_h5_1012',
			'srvid'=>'1012',
		),
	); 
