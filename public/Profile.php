<?php 
require_once('../head.php');
include('../session.php');
?>
<title>Profile | <?=$site['site_tenweb'];?></title>
<?php require_once('../sidebar.php');?>
<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="title">
                            <h4>Profile</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-photo">
                            <img src="/vendors/images/3136455.png" alt="" class="avatar-photo">
                        </div>
                        <h5 class="text-center h5 mb-0"><?=$user['username'];?></h5>
                        <p class="text-center text-muted font-14"><?php if($user['level'] == 'admin') { ?> 
									      <img src="/img/S10_VIP.gif" />
									<?php } else if($user['level'] == '1') { ?> 
									      <img src="/img/S8_VIP.gif" />      
									<?php } else if($user['level'] == '2') { ?> 
									      <img src="/img/S9_VIP.gif" />      
									<?php } else { ?>
									        <img src="/img/S7_VIP.gif" /> 
									<?php } ?></p>
                        <div class="profile-info">
                            <h5 class="mb-20 h5 text-blue">THÔNG TIN CÁ NHÂN</h5>
                            <ul>
                                <li>
                                    <span>Địa Chỉ Email:</span>
                                    <?=$user['email'];?>
                                </li>
                                <li>
                                    <span>IP Đăng Nhập:</span>
                                    <?=$user['ip'];?>
                                </li>
                                <li>
                                    <span>Thời Gian Đăng Ký:</span>
                                    <?=$user['createdate'];?>
                                </li>
                                <li>
                                    <span>Số Dư:</span>
                                    <?=format_cash($user['money']);?>đ
                                </li>
                                <li>
                                    <span>Chức Vụ:</span>
                                    <?if($user['level'] == 'admin') {;?>
                                    Administrator
                                    <? } else if($user['level'] == '1'){ ?>
                                    Thành Fan Cứng
                                    <? } else { ?>
                                    Thành Viên Thường
                                     <? }?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                    <div class="card-box height-100-p overflow-hidden">
                        <div class="profile-tab height-100-p">
                            <div class="tab height-100-p">
                                <ul class="nav nav-tabs customtab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Nhật
                                            ký</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#setting" role="tab">Đổi mật
                                            khẩu</a>
                                    </li>
                                    <?php if($user['verify'] == 0) { ?>
                                    <li class="nav-item active">
                                        <a class="nav-link" data-toggle="tab" href="#email" role="tab">Xác minh Email</a>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <div class="tab-content">
                                    <!-- Timeline Tab start -->
                                    <div class="tab-pane fade show active" id="timeline" role="tabpanel">
                                        <div class="pd-20">
                                            <table class="table hover multiple-select-row nowrap">
                                                <thead>
                                                    <tr>
                                                        <th class="table-plus datatable-nosort">STT</th>
                                                        <th>NHẬT KÝ</th>
                                                        <th>THỜI GIAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; $result = $ketnoi->query("SELECT * FROM `log` WHERE `username` = '".$user['username']."' ORDER BY id desc"); while($row = $result->fetch_assoc() ){ ?>
                                                    <tr>
                                                        <td><span class="badge badge-danger"><?=$i;?>
                                                                <?php $i++;?></span></td>
                                                        <td><?=$row['content'];?></td>
                                                        <td><span
                                                                class="badge badge-dark"><?=$row['createdate'];?></span>
                                                        </td>
                                                    </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Timeline Tab End -->
                                    <!-- Setting Tab start -->
                                    <div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
                                        <div class="profile-setting">
                                            <form id="ChangePass">
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-12">
                                                        <div class="form-group">
                                                            <label>Mật khẩu hiện tại</label>
                                                            <input class="form-control form-control-lg" type="password"
                                                                name="password" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Mật khẩu mới</label>
                                                            <input class="form-control form-control-lg" type="password"
                                                                name="newpassword" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nhập lại mật khẩu mới</label>
                                                            <input class="form-control form-control-lg" type="password"
                                                                name="repassword" required>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <button id="ChangePass" type="submit"
                                                                class="btn btn-primary">Cập Nhật</button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Setting Tab End -->
                                    <!-- Setting Tab start -->
                                    <div class="tab-pane fade height-100-p" id="email" role="tabpanel">
                                        <div class="profile-setting">
                                            <form id="VerifyMail">
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-12">
                                                        <div class="form-group">
                                                            <label>Email:</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                name="email" value="<?=$user['email'];?>" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Mã Xác Minh</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                name="maotp" >
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <button id="btnSendMail" type="submit" 
                                                                class="btn btn-primary">Gửi Mã</button>
                                                            <button id="btnVerifyMail" type="submit"
                                                                class="btn btn-primary">Xác Minh</button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Setting Tab End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
				$("#ChangePass").submit(function (e) {   
					var firstForm = $("#ChangePass").serialize();
					$.ajax({
						url: "https://g100k.net/model/ChangePass.php",
						type: 'POST',
						data: firstForm,
						dataType: 'json',
						mimeType: "multipart/form-data",
						//contentType: false,
						cache: false,
						processData: false,
						beforeSubmit: function () {
							$("#loading").show();
						},
						success: function (data) {                     
							if (data.status == 0) {
								cuteToast({type: data.type,message: data.msg,timer: 2500});
								$("#loading").hide();                               
							}
							else {
							    cuteToast({type: data.type,message: data.msg,timer: 2500});
							    setTimeout(function(){ location.href = "" },2500);
								$("#loading").hide();
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
						    cuteToast({type: data.type,message: "Có lỗi trong quá trình thực hiện",timer: 2500});
							$("#loading").hide();
						}
					});
					e.preventDefault();
				});
		
			});
			$(document).ready(function () {
				$("#btnSendMail").click(function (e) {   
					var firstForm = $("#VerifyMail").serialize();
					$.ajax({
						url: "https://g100k.net/model/SendOTPMail.php",
						type: 'POST',
						data: firstForm,
						dataType: 'json',
						mimeType: "multipart/form-data",
						//contentType: false,
						cache: false,
						processData: false,
						beforeSubmit: function () {
							$("#loading").show();
						},
						success: function (data) {                     
							if (data.status == 0) {
								cuteToast({type: data.type,message: data.msg,timer: 2500});
								$("#loading").hide();                               
							}
							else {
							    cuteToast({type: data.type,message: data.msg,timer: 2500});
								$("#loading").hide();
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
						    cuteToast({type: data.type,message: "Có lỗi trong quá trình thực hiện",timer: 2500});
							$("#loading").hide();
						}
					});
					e.preventDefault();
				});
		
			});
			$(document).ready(function () {
				$("#btnVerifyMail").click(function (e) {   
					var firstForm = $("#VerifyMail").serialize();
					$.ajax({
						url: "https://g100k.net/model/VerifyMail.php",
						type: 'POST',
						data: firstForm,
						dataType: 'json',
						mimeType: "multipart/form-data",
						//contentType: false,
						cache: false,
						processData: false,
						beforeSubmit: function () {
							$("#loading").show();
						},
						success: function (data) {                     
							if (data.status == 0) {
								cuteToast({type: data.type,message: data.msg,timer: 2500});
								$("#loading").hide();                               
							}
							else {
							    cuteToast({type: data.type,message: data.msg,timer: 2500});
							    setTimeout(function(){ location.href = "" },2500);
								$("#loading").hide();
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
						    cuteToast({type: data.type,message: "Có lỗi trong quá trình thực hiện",timer: 2500});
							$("#loading").hide();
						}
					});
					e.preventDefault();
				});
		
			});
        </script>

        <?php require_once('../foot.php');?>