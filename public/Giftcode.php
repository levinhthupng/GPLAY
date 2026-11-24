<?php 
require_once('../head.php');
include('../session.php');
?>
<title>Giftcode | <?=$site['site_tenweb'];?></title>
<?php require_once('../sidebar.php');?>
			<div class="mobile-menu-overlay"></div>
			<div class="main-container">
				<div class="pd-ltr-20 xs-pd-20-10">
					<div class="min-height-200px">
						<div class="page-header">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="title">
										<h4>Giftcode</h4> 
									</div>
									<nav aria-label="breadcrumb" role="navigation">
										<ol class="breadcrumb">
											<li class="breadcrumb-item"><a href="/">Home</a></li>
											<li class="breadcrumb-item active" aria-current="page">Giftcode</li>
										</ol>
									</nav>
								</div>
							</div>
						</div>
						<!-- Default Basic Forms Start -->
						<div class="pd-20 card-box mb-30">
							<div class="clearfix">
								<div class="pull-left">
									<h4 class="text-blue h4">GIFTCODE</h4>
									
								</div>
							</div>
							<form id="Giftcode">
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label">Nhập Giftcode:</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control is-valid" type="text" name="code" placeholder="Vui lòng nhập Giftcode vào đây" required> 
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-12 col-md-2 col-form-label"></label>
									<div class="col-sm-12 col-md-10">
										<button type="submit" id="btnSubmit" class="btn btn-primary">Xác Nhận</button>
									</div>
								</div>
							</form>
							<div id="loading">
                                <img src="/assets/img/2000x2000-gif3.gif">
                            </div>
						</div>
						<!-- Export Datatable start -->
						<div class="card-box mb-30">
							<div class="pd-20">
								<h4 class="text-blue h4">LỊCH SỬ SỬ DỤNG GIFTCODE</h4> </div>
							<div class="pd-20 card-box height-100-p">
								<table class="table hover multiple-select-row data-table nowrap">
									<thead>
										<tr>
											<th>STT</th>
											<th>GIFTCODE</th>
											<th>MONEY</th>
											<th>THỜI GIAN</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                            $i = 0;
                                            $result = $ketnoi->query("SELECT * FROM `log_giftcode` WHERE `username` = '".$user['username']."' ORDER BY id desc ");
                                            while( $row = $result->fetch_assoc() ){
                                            ?>
											<tr>
												<td>
													<?=$i;?>
														<?php $i++;?>
												</td>
												<td><span class="badge badge-danger"><?=$row['code'];?></span></td>
												<td>
													<?=format_cash($row['money']);?>
												</td>
												<td><span class="badge badge-dark"><?=$row['createdate'];?></span></td>
											</tr>
											<?php }?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- Export Datatable End -->
					</div>
					<script type="text/javascript">
    					$(document).ready(function () {
    					    
            				$("#Giftcode").submit(function (e) {   
            				    $('#btnSubmit').html('<i class="fa fa-spinner"></i> ĐANG XỬ LÝ').prop('disabled',
                                true);
                                $("#loading").show();
            					var firstForm = $("#Giftcode").serialize();
            					$.ajax({
            						url: "https://g100k.net/model/Giftcode.php",
            						type: 'POST',
            						data: firstForm,
            						dataType: 'json',
            						mimeType: "multipart/form-data",
            						//contentType: false,
            						cache: false,
            						processData: false,

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
            						$('#btnSubmit').html('Đăng ký').prop('disabled', false);
            						},
            						error: function (xhr, ajaxOptions, thrownError) {
            						    cuteToast({type: data.type,message: "Có lỗi trong quá trình thực hiện",timer: 2500});
            						    $('#reg_submit').html('Đăng ký').prop('disabled', false);
            							$("#loading").hide();
            						}
            					});
            					e.preventDefault();
            				});
            		
            			});
					</script>
					<?php require_once('../foot.php');?>