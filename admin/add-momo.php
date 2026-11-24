<?php 
$active7 = "active";
$show2 = "hover show";
include('head.php');
?>
<?php include('nav.php');?>

					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">MOMO</h1>
									<!--end::Title-->
									<!--begin::Separator-->
									<span class="h-20px border-gray-200 border-start mx-4"></span>
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">
											<a href="/" class="text-muted text-hover-primary">HOME</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">PAYMENT</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-dark">MOMO</li>
										<!--end::Item-->
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page title-->
								<!--begin::Actions-->
								<!--end::Actions-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								<!--begin::Card-->
								<div class="card">
									<!--begin::Card header-->
									<div class="card-header border-0 pt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
												<span class="svg-icon svg-icon-1 position-absolute ms-6">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
														<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												<input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search user" />
											</div>
											<!--end::Search-->
										</div>
										<!--begin::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											<!--begin::Toolbar-->
											<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">			
												<!--begin::Add user-->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
														<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->Add Momo</button>
												<!--end::Add user-->
											</div>
											<!--end::Toolbar-->
											<!--begin::Group actions-->
											<!--end::Group actions-->
											<!--begin::Modal - Adjust Balance-->
											<!--end::Modal - New Card-->
											<!--begin::Modal - Add task-->
											<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
												<!--begin::Modal dialog-->
												<div class="modal-dialog modal-dialog-centered mw-650px">
													<!--begin::Modal content-->
													<div class="modal-content">
														<!--begin::Modal header-->
														<div class="modal-header" id="kt_modal_add_user_header">
															<!--begin::Modal title-->
															<h2 class="fw-bolder">Add User</h2>
															<!--end::Modal title-->
															<!--begin::Close-->
															<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
																		<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</div>
															<!--end::Close-->
														</div>
														<!--end::Modal header-->
														<!--begin::Modal body-->
														<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
															<!--begin::Form-->
															<form id="kt_modal_add_user_form" class="form" action="#" method="post">
																<!--begin::Scroll-->
																<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
																	<!--begin::Input group-->
																	<!--end::Input group-->
																	<!--begin::Input group-->
																	<div class="fv-row mb-7">
																		<!--begin::Label-->
																		<label class="required fw-bold fs-6 mb-2">SDT:</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="number" id="phone" name="phone" class="form-control is-valid mb-3 mb-lg-0" placeholder="Full name" value="Emma Smith" />
																		<!--end::Input-->
																	</div>
																	<!--end::Input group-->
																	<!--begin::Input group-->
																	<div class="fv-row mb-7">
																		<!--begin::Label-->
																		<label class="required fw-bold fs-6 mb-2">Pass:</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="password" id="password" name="password" class="form-control is-valid mb-3 mb-lg-0" placeholder="" value="" />
																		<!--end::Input-->
																	</div>
																	<div class="fv-row mb-7" style="display:none">
																		<!--begin::Label-->
																		<label class="required fw-bold fs-6 mb-2">OTP:</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="number" id="otp" name="otp" class="form-control is-valid mb-3 mb-lg-0" placeholder="" value="" />
																		<!--end::Input-->
																	</div>
																	<!--end::Input group-->
																	<!--begin::Input group-->
																	<!--end::Input group-->
																</div>
																<!--end::Scroll-->
																<!--begin::Actions-->
																<div class="text-center pt-15">
																	<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
																	<button type="submit" id="GetOTP" class="btn btn-primary" data-kt-users-modal-action="getotp">GET OTP</button>
																	<button type="submit" id="btnCheckOTP" class="btn btn-primary" data-kt-users-modal-action="btn_submit">
																		<span class="indicator-label">Submit</span>
																		<span class="indicator-progress">Please wait...
																		<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																	</button>
																</div>
																<!--end::Actions-->
															</form>
															
															<!--end::Form-->
														</div>
														<!--end::Modal body-->
													</div>
													<!--end::Modal content-->
												</div>
												<!--end::Modal dialog-->
												
											</div>
											<!--end::Modal - Add task-->
										</div>
										<!--end::Card toolbar-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_permissions_table">
											<!--begin::Table head-->
											<thead>
												<!--begin::Table row-->
												<tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
													<th class="w-10px pe-2">#</th>
													<th class="min-w-50px">PHONE</th>
													<th class="min-w-50px">NAME</th>
													<th class="min-w-50px">SỐ DƯ</th>
													<th class="min-w-50px">EMEI</th>
													<th class="min-w-50px">TRẠNG THÁI</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="text-gray-600 fw-bold">
											<?php
											$result = mysqli_query($ketnoi,"SELECT * FROM `api` ORDER BY id desc");
											while($row = mysqli_fetch_assoc($result))
											{
											?>
												<!--begin::Table row-->
												<tr>
													<td><?=$row['id'];?></td>
													<td><?=$row['phone'];?></td>
													<td><?=$row['name'];?></td>
													<td><?=format_cash($row['balance']);?></td>
													<td><?=$row['imei'];?></td>
													<td><?=$row['status'];?></td>
												</tr>
												<!--end::Table row-->
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
<script>
    $("#GetOTP").on("click", function() {
        $('#GetOTP').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',
            true);
        var myData = {
            action: 'GETOTP',
            sdt: $("#phone").val(),
            pass: $("#password").val(),
        };
        $.post("<?=BASE_URL("ajaxs/client/momo.php");?>", myData,
            function(res) {
                if (res.status == '2') {
                    cuteToast({
                        type: "success",
                        message: res.msg,
                        timer: 5000
                    });
                    document.getElementById("otpinput").style.display = 'block';
                    document.getElementById("GetOTP").style.display = 'none';
                    document.getElementById("btnCheckOTP").style.display = 'block';
                } else {
                    cuteToast({
                        type: "error",
                        message: res.msg,
                        timer: 5000
                    });
                }
                $('#GetOTP').html('Lấy OTP').prop('disabled', false);
            }, "json");

    });
    $("#btnCheckOTP").on("click", function() {
        $('#btnCheckOTP').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',
            true);
        var myOTPData = {
            action: 'CHECKOTP',
            sdt: $("#phone").val(),
            pass: $("#password").val(),
            otp: $("#otp").val()
        };
        $.post("<?=BASE_URL("ajaxs/client/momo.php");?>", myOTPData,
            function(data) {
                if (data.status == '2') {
                    cuteToast({
                        type: "success",
                        message: data.msg,
                        timer: 5000
                    });
                    setTimeout(function() {
                        window.location = "<?=BASE_URL('client/listaccount')?>"
                    }, 1000);
                } else {
                    cuteToast({
                        type: "error",
                        message: data.msg,
                        timer: 5000
                    });
                }
                $('#btnCheckOTP').html('Đăng Nhập').prop('disabled', false);
            }, "json");
    });
</script>
<?php include('foot.php');?>