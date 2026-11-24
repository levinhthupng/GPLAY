
<?php include('head.php');?>
<?php include('nav.php');?>
<?php
if (isset($_GET['id'])) 
{
    $id = $_GET['id'];
}

$AADDCC = mysqli_query($ketnoi,"SELECT * FROM `category` WHERE `id` = '".$id."' ");
while ($row = mysqli_fetch_array($AADDCC) ) 
{

?>
<?php
if (isset($_POST["submit"]))
{
  $create = mysqli_query($ketnoi,"UPDATE `category` SET 
    `title` = '".$_POST['title']."',
    `note` = '".$_POST['note']."',
    `badge` = '".$_POST['badge']."',
    `pin` = '".$_POST['pin']."',
    `money` = '".$_POST['money']."',
    `display` = '".$_POST['display']."',
    `gmtools` = '".$_POST['linkgm']."',
    `dowload` = '".$_POST['linkdowload']."',
    `img` = '".$_POST['img']."',
    `baotri` = '".$_POST['baotri']."',
    `code` = '".$_POST['code']."' WHERE `id` = '".$id."' ");

  if($create)
  {
    echo '<script type="text/javascript">Swal.fire("Thành Công","Save Thành Công","success");
            setTimeout(function(){ location.href = "chuyen-muc.php" },1000);</script>';
  }
  else
  {
    echo '<script type="text/javascript">Swal.fire("Lỗi","Lỗi máy chủ","error");</script>'; 
  }
}

?>

<?php $check_taikhoanconlai = mysqli_fetch_assoc(mysqli_query($ketnoi, "SELECT COUNT(*) FROM `taikhoan` WHERE `code` = '".$row['code']."' AND `username` IS NULL ")) ['COUNT(*)']; ?>

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
											<h3 class="fw-bolder m-0">EDIT LIST GAME</h3>
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
													<label class="col-lg-4 col-form-label required fw-bold fs-6">TÊN GAME:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="title"  value="<?=$row['title'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">MÃ GAME:</label>
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
													<label class="col-lg-4 col-form-label required fw-bold fs-6">LOẠI GAME:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="pin"  value="<?=$row['pin'];?>" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">INFO GM:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="badge" value="<?=$row['badge'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">LINK GM:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="linkgm" value="<?=$row['gmtools'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">LINK DOWLOAD:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="linkdowload" value="<?=$row['dowload'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">IMG:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="img" value="<?=$row['img'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Giá:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="money"  value="<?=$row['money'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">NOTE:</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" class="form-control is-valid" name="note" value="<?=$row['note'];?>"/>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Display</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="display" aria-label="Select a Country" data-control="select2" data-placeholder="" class="form-select form-select-solid form-select-lg fw-bold">
															<option value="<?=$row['display'];?>"><?=$row['display'];?></option> 
															<option value="show">show</option>
															<option value="hide">hide</option>
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Bảo Trì</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="baotri" aria-label="Select a Country" data-control="select2" data-placeholder="" class="form-select form-select-solid form-select-lg fw-bold">
															<option value="<?=$row['baotri'];?>"><?=$row['baotri'];?></option> 
															<option value="ON">ON</option>
															<option value="OFF">OFF</option>
														</select>
													</div>
													<!--end::Col-->
												</div>
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