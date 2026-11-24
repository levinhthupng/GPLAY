
<?php include('head.php');?>
<?php include('nav.php');?>
<?php
if (isset($_GET['id'])) 
{
    $id = $_GET['id'];
}

$AADDCC = mysqli_query($ketnoi,"SELECT * FROM `tainguyen` WHERE `id` = '".$id."' ");
while ($row = mysqli_fetch_array($AADDCC) ) 
{

?>
<?php
if (isset($_POST["submit"]))
{
  $create = mysqli_query($ketnoi,"UPDATE `tainguyen` SET 
    `code` = '".$_POST['code']."',
    `email` = '".$_POST['email']."',
    `password` = '".$_POST['password']."',
    `emailkp` = '".$_POST['emailkp']."',
    `2fa` = '".$_POST['2fa']."',
    `status` = '".$_POST['status']."',
    `vps1` = '".$_POST['vps1']."',
    `sudung1` = '".$_POST['sudung1']."',
    `vps2` = '".$_POST['vps2']."',
    `sudung2` = '".$_POST['sudung2']."' WHERE `id` = '".$id."' ");

  if($create)
  {
    echo '<script type="text/javascript">Swal.fire("Thành Công","Save Thành Công","success");
            setTimeout(function(){ location.href = "tai-nguyen.php" },1000);</script>';
  }
  else
  {
    echo '<script type="text/javascript">Swal.fire("Lỗi","Lỗi máy chủ","error");</script>'; 
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
											<h3 class="fw-bolder m-0">EDIT TÀI NGUYÊN</h3>
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
													<label class="col-lg-4 col-form-label required fw-bold fs-6">CODE:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="code"  value="<?=$row['code'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Email:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="email"  value="<?=$row['email'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Password:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="password"  value="<?=$row['password'];?>" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Email KP:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="emailkp" value="<?=$row['emailkp'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">2FA:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="2fa" value="<?=$row['2fa'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">VPS 1:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="vps1" value="<?=$row['vps1'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">IF VPS1:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="sudung1" value="<?=$row['sudung1'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">VPS 2:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="vps2"  value="<?=$row['vps2'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">IF VPS2:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="sudung2" value="<?=$row['sudung2'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">STATUS</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="status" aria-label="Select a Country" data-control="select2" data-placeholder="" class="form-select form-select-solid form-select-lg fw-bold">
															<option value="<?=$row['status'];?>"><?=$row['status'];?></option> 
															<option value="LIVE">LIVE</option>
															<option value="DIE">DIE</option>
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												
												<!--end::Input group-->
											</div>
											<!--end::Card body-->
											<!--begin::Actions-->
											<div class="card-footer d-flex justify-content-end py-6 px-9">
												<button name="submit" type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
											</div>
											<!--end::Actions-->
										</form>
										<!--end::Form-->
									</div>
									<!--end::Content-->
								</div>	
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
<?php }?>        
<?php include('foot.php');?>