
<?php include('head.php');?>
<?php include('nav.php');?>
<?php
if (isset($_GET['username'])) 
{
    $usernamer = $_GET['username'];
}

$AADDCC = mysqli_query($ketnoi,"SELECT * FROM `users` WHERE `username` = '".$usernamer."' ");
while ($row = mysqli_fetch_array($AADDCC) ) 
{
  if (isset($_POST["btn_submit"])) 
  {

   
    $fullname = $_POST["fullname"]; 
    $banned = $_POST["banned"]; 
    $level = $_POST["level"];
    $ck = $_POST["ck"]; 


    mysqli_query($ketnoi,"UPDATE `users` SET 
    `banned` = '$banned',
    `level`= '$level',
    `ck` = '$ck',
    `fullname` = '$fullname' WHERE `username` = '".$usernamer."' ");

    mysqli_query($ketnoi,"INSERT INTO `log` SET 
              `content`= 'Thay đổi thông tin tài khoản bởi Admin ".$_SESSION['admin']."',
              `createdate` = now(),
              `username`= '".$row['username']."' ");

    echo '<script type="text/javascript">Swal.fire("Thành Công","Save Thành Công","success");
    setTimeout(function(){ location.href = "" },500);</script>';
      
  }

?>
<?php
if(isset($_POST['btn_congtien']))
{
    $sotien = $_POST['sotien'];
    $content = $_POST['content'];


    $create = mysqli_query($ketnoi,"UPDATE `users` SET `money`=`money`+ '$sotien', `total_nap` = `total_nap` + '$sotien' WHERE `username`='".$row['username']."'");

    $create = mysqli_query($ketnoi,"INSERT INTO `log` SET 
              `content`= 'Cộng ".number_format($sotien, 0, '.', '.')." từ ".$_SESSION['admin'].", lý do ".$content."',
              `createdate` = now(),
              `username`= '".$row['username']."' ");

    if ($create)
    {
       echo '<script type="text/javascript">Swal.fire("Thành Công","Cộng tiền thành công","success");
            setTimeout(function(){ location.href = "" },1000);</script>';
    }
    else
    {
      echo '<script type="text/javascript">Swal.fire("Lỗi","Lỗi máy chủ","error");
            setTimeout(function(){ location.href = "" },2000);</script>';
    }       
}
if(isset($_POST['btn_payment']))
{
    $sotien = $_POST['sotien'];
    $content = $_POST['content'];


    $create = mysqli_query($ketnoi,"UPDATE `users` SET `money`=`money`+ '$sotien'  WHERE `username`='".$row['username']."'");

    $create = mysqli_query($ketnoi,"INSERT INTO `log` SET 
              `content`= 'Cộng ".number_format($sotien, 0, '.', '.')." từ ".$_SESSION['admin'].", lý do ".$content."',
              `createdate` = now(),
              `username`= '".$row['username']."' ");

    if ($create)
    {
       echo '<script type="text/javascript">Swal.fire("Thành Công","Cộng tiền thành công","success");
            setTimeout(function(){ location.href = "" },1000);</script>';
    }
    else
    {
      echo '<script type="text/javascript">Swal.fire("Lỗi","Lỗi máy chủ","error");
            setTimeout(function(){ location.href = "" },2000);</script>';
    }       
}
if(isset($_POST['btn_trutien']))
{
    $sotien = $_POST['sotien'];
    $content = $_POST['content'];


    $create = mysqli_query($ketnoi,"UPDATE `users` SET `money`=`money`- '$sotien' WHERE `username`='".$row['username']."'");

    $create = mysqli_query($ketnoi,"INSERT INTO `log` SET 
              `content`= 'Trừ ".number_format($sotien, 0, '.', '.')." từ ".$_SESSION['admin'].", lý do ".$content."',
              `createdate` = now(),
              `username`= '".$row['username']."' ");

    if ($create)
    {
       echo '<script type="text/javascript">Swal.fire("Thành Công","Trừ tiền thành công","success");
            setTimeout(function(){ location.href = "" },1000);</script>';
    }
    else
    {
      echo '<script type="text/javascript">Swal.fire("Lỗi","Lỗi máy chủ","error");
            setTimeout(function(){ location.href = "" },2000);</script>';
    }
}
?>

						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								<!--begin::Navbar-->
								<!--end::Navbar-->
								<!--begin::Basic info-->
								<div class="card mb-5 mb-xl-10">
									<!--begin::Card header-->
									<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
										<!--begin::Card title-->
										<div class="card-title m-0">
											<h3 class="fw-bolder m-0">THÀNH VIÊN</h3>
										</div>
										<!--end::Card title-->
									</div>
									<!--begin::Card header-->
									<!--begin::Content-->
									<div id="kt_account_profile_details" class="collapse show">
										<!--begin::Form-->
										<form id="kt_account_profile_details_form" class="form" enctype="multipart/form-data" action="" method="post">
											<!--begin::Card body-->
											<div class="card-body border-top p-9">											
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Username</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" value="<?=$row['username'];?>"  disabled/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" value="<?=$row['email'];?>"  disabled/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Số Dư</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" value="<?php echo number_format($row['money'], 0, '.', '.');?>đ"  disabled />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Ngày Đăng Ký</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid"  value="<?=$row['createdate'];?>"  disabled/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">IP Đăng Nhập</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" name="site_tukhoa" class="form-control is-valid" value="<?=$row['ip'];?>"  disabled />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Full Name</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="fullname" value="<?=$row['fullname'];?>" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Chiết Khấu Đại Lý</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-invalid" name="ck" value="<?=$row['ck'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Banned</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="banned" aria-label="Select a Country" data-control="select2" data-placeholder="" class="form-select form-select-solid form-select-lg fw-bold">
															<option value="<?=$row['banned'];?>">
															  <?php
															  if($row['banned'] == "0"){ echo 'Hoạt động';}
															  if($row['banned'] == "1"){ echo 'Banned';}
															  ?>  
															</option> 
															<option value="0">Hoạt động</option>
															<option value="1">Banned</option>
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Rank (admin = Quản Trị Website)</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="level" value="<?=$row['level'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
											</div>
											<!--end::Card body-->
											<!--begin::Actions-->
											<div class="card-footer d-flex justify-content-end py-6 px-9">
												<button name="btn_submit" type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
											</div>
											<!--end::Actions-->
										</form>
										<!--end::Form-->
									</div>
									<!--end::Content-->
								</div>	
								
								
								<!--begin::Sign-in Method-->
								<div class="card mb-5 mb-xl-10">
									<!--begin::Card header-->
									<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
										<div class="card-title m-0">
											<h3 class="fw-bolder m-0">PAYMENT</h3>
										</div>
									</div>
									<!--end::Card header-->
									<!--begin::Content-->
									<div id="kt_account_signin_method" class="collapse show">
										<!--begin::Card body-->
										<div class="card-body border-top p-9">
											<!--begin::Email Address-->
											<div class="d-flex flex-wrap align-items-center">
												<!--begin::Label-->
												<div id="kt_signin_email">
													<div class="fs-6 fw-bolder mb-1">THÊM TIỀN</div>
													<div class="fw-bold text-gray-600">+ VND</div>
												</div>
												<!--end::Label-->
												<!--begin::Edit-->
												<div id="kt_signin_email_edit" class="flex-row-fluid d-none">
													<!--begin::Form-->
													<form id="kt_signin_change_email" class="form" novalidate="novalidate" action="" method="post">
														<div class="row mb-6">
															<div class="col-lg-6 mb-4 mb-lg-0">
																<div class="fv-row mb-0">
																	<label for="emailaddress" class="form-label fs-6 fw-bolder mb-3">Số Tiền Cộng</label>
																	<input type="number" class="form-control is-valid" id="emailaddress" name="sotien" />
																</div>
															</div>
															<div class="col-lg-6">
																<div class="fv-row mb-0">
																	<label for="confirmemailpassword" class="form-label fs-6 fw-bolder mb-3">Ghi chú</label>
																	<input type="text" class="form-control is-valid" name="content" id="confirmemailpassword" />
																</div>
															</div>
														</div>
														<div class="d-flex">
															<button  type="submit" name="btn_congtien" class="btn btn-primary me-2 px-6">Add Money </button>
															<button  type="submit" name="btn_payment" class="btn btn-primary me-2 px-6">Update Money</button>
															<button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
														</div>
													</form>
													<!--end::Form-->
												</div>
												<!--end::Edit-->
												<!--begin::Action-->
												<div id="kt_signin_email_button" class="ms-auto">
													<button class="btn btn-light btn-active-light-primary">+ VND</button>
												</div>
												<!--end::Action-->
											</div>
											<!--end::Email Address-->
											<!--begin::Separator-->
											<div class="separator separator-dashed my-6"></div>
											<!--end::Separator-->
											<!--begin::Password-->
											<div class="d-flex flex-wrap align-items-center mb-10">
												<!--begin::Label-->
												<div id="kt_signin_password">
													<div class="fs-6 fw-bolder mb-1">TRỪ TIỀN</div>
													<div class="fw-bold text-gray-600">- VND</div>
												</div>
												<!--end::Label-->
												<!--begin::Edit-->
												<div id="kt_signin_password_edit" class="flex-row-fluid d-none">
													<!--begin::Form-->
													<form id="kt_signin_change_password" class="form" novalidate="novalidate" action="" method="post">
														<div class="row mb-1">
															<div class="col-lg-6">
																<div class="fv-row mb-0">
																	<label for="currentpassword" class="form-label fs-6 fw-bolder mb-3">Số Tiền Trừ</label>
																	<input type="number" class="form-control is-invalid" name="sotien" id="currentpassword" />
																</div>
															</div>
															<div class="col-lg-6">
																<div class="fv-row mb-0">
																	<label for="newpassword" class="form-label fs-6 fw-bolder mb-3">Ghi chú</label>
																	<input type="text" class="form-control is-valid" name="content" id="newpassword" />
																</div>
															</div>
														</div>
														<div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>
														<div class="d-flex">
															<button id="kt_password_submit" type="submit" class="btn btn-primary me-2 px-6" name="btn_trutien">Update Money</button>
															<button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
														</div>
													</form>
													<!--end::Form-->
												</div>
												<!--end::Edit-->
												<!--begin::Action-->
												<div id="kt_signin_password_button" class="ms-auto">
													<button class="btn btn-light btn-active-light-primary">- VND</button>
												</div>
												<!--end::Action-->
											</div>
											<!--end::Password-->

										</div>
										<!--end::Card body-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Sign-in Method-->
                                
                                
                                <!--begin::Card-->
								<div class="card card-flush">
									<!--begin::Card header-->
									<div class="card-header mt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<h3 class="card-label">ACTIVITY LOG
											</h3>
										</div>
										<div class="card-toolbar">
											
											
										</div>
										<!--end::Card title-->
										<!--begin::Card toolbar-->
										<!--end::Card toolbar-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table align-middle table-row-dashed  fs-6 gy-5 mb-0" id="kt_permissions_table">
											<!--begin::Table head-->
											<thead>
												<!--begin::Table row-->
												<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
													<th class="min-w-125px">STT</th>
													<th class="min-w-250px">Username</th>
													<th class="min-w-125px">Content</th>
													<th class="text-end min-w-100px">Time</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="fw-bold text-gray-600">
											    <?php 
                                                  $i = 0;
                                                  $A12A6 = mysqli_query($ketnoi,"SELECT * FROM `log` WHERE `username` = '".$row['username']."' ORDER BY id desc limit 0, 1000 ");
                                                  while ($row1 = mysqli_fetch_array($A12A6) ) 
                                                  {?>
												<tr>
													<!--begin::Name=-->
													<td><?=$i;?> <?php $i++;?></td>
													<!--end::Name=-->
													<!--begin::Assigned to=-->
													<td>
														<a href="edit-thanh-vien.php?username=<?=$row1['username'];?>" class="badge badge-light-primary fs-7 m-1"> <?=$row1['username'];?></a>
													</td>
													<!--end::Assigned to=-->
													<!--begin::Created Date-->
													<td><?=$row1['content'];?></td>
													<!--end::Created Date-->
													<!--begin::Action=-->
													<td class="text-end">
														<!--begin::Update-->
														<?=$row1['createdate'];?>
														<!--end::Delete-->
													</td>
													<!--end::Action=-->
												</tr>
												<?php }?>
											</tbody>
											<!--end::Table body-->
										</table>
										<!--end::Table-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
	
<?php }?>
<?php include('foot.php');?>
