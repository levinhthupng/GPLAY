<?php 
$active3 = "active";
include('head.php');
?>
<?php include('nav.php');?>

<?php
if (isset($_GET['delete'])) 
{
    $delete = $_GET['delete'];

    $create = mysqli_query($ketnoi,"DELETE FROM `category` WHERE `id` = '".$delete."' ");

    if ($create)
    {
      echo '<script type="text/javascript">swal("Thành Công","Xóa thành công","success");setTimeout(function(){ location.href = "chuyen-muc.php" },500);</script>'; 
    }
    else
    {
      echo '<script type="text/javascript">swal("Lỗi","Lỗi máy chủ","error");setTimeout(function(){ location.href = "chuyen-muc.php" },1000);</script>'; 
    }
}
?>

					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">SEVER GAME</h1>
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
										<li class="breadcrumb-item text-muted">DASHBOARD</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-dark">SEVER GAME</li>
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
												<!--end::Svg Icon-->Add Sever</button>
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
															<h2 class="fw-bolder">Add Sever</h2>
															<!--end::Modal title-->
															<!--begin::Close-->
															<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
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
															<form id="kt_modal_add_user_form" class="form" action="" method="post">
																<!--begin::Scroll-->
																<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
																	<!--begin::Input group-->
																	<!--end::Input group-->
																	<!--begin::Input group-->
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">TÊN GAME:</label>
																		<input type="text" name="title" class="form-control is-valid mb-3 mb-lg-0" />
																	</div>
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">MÃ GAME</label>
																		<input type="text" name="code" class="form-control is-valid mb-3 mb-lg-0" />
																	</div>
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">LOẠI GAME</label>
																		<select class="form-select form-select-solid form-select-lg fw-bold" name="pin">
																			<option value="Kiếm Hiệp">Kiếm Hiệp</option>
																			<option value="Thẻ Bài">Thẻ Bài</option>
																			<option value="H5">H5</option>
																		</select>						
																	</div>
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">INFO GM</label>
																		<input type="text" name="badge" class="form-control is-valid mb-3 mb-lg-0" value="GM TOOLS : Nhập ......."/>
																	</div>
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">LINK GM</label>
																		<input type="text" name="linkgm" class="form-control is-valid mb-3 mb-lg-0"/>
																	</div>
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">LINK DOWLOAD</label>
																		<input type="text" name="linkdowload" class="form-control is-valid mb-3 mb-lg-0"/>
																	</div>
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">IMG</label>
																		<input type="text" name="img" class="form-control is-valid mb-3 mb-lg-0" value="/assets/img/..." />
																	</div>
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">Display</label>
																		<select class="form-select form-select-solid form-select-lg fw-bold" name="display">
																			<option value="show">show</option>
																			<option value="hide">hide</option>
																		</select>
																	</div>
																	<div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">Giá:</label>
																		<input type="number" name="money" class="form-control is-valid mb-3 mb-lg-0" />
																	</div>
																	<!--end::Input group-->
																	<!--begin::Input group-->
																	<div class="fv-row mb-7">
																		<!--begin::Label-->
																		<label class="required fw-bold fs-6 mb-2">NOTE:</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="text" name="note" class="form-control is-valid mb-3 mb-lg-0" placeholder="" value="Free ....." />
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
																	<button type="submit" name="btn_submit" class="btn btn-primary" data-kt-users-modal-action="btn_submit">
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

                                                <?php
													if (isset($_POST["btn_submit"]))
													{
													  $create = mysqli_query($ketnoi,"INSERT INTO `category` SET 
														`title` = '".$_POST['title']."',
														`note` = '".$_POST['note']."',
														`badge` = '".$_POST['badge']."',
														`pin` = '".$_POST['pin']."',
														`money` = '".$_POST['money']."',
														`display` = '".$_POST['display']."',
														`gmtools` = '".$_POST['linkgm']."',
														`dowload` = '".$_POST['linkdowload']."',
														`img` = '".$_POST['img']."',
														`code` = '".$_POST['code']."'  ");

													  if($create)
													  {
														echo '<script type="text/javascript">Swal.fire("Thành Công","Thêm Thành Công","success");
																setTimeout(function(){ location.href = "" },1000);</script>';
													  }
													  else
													  {
														echo '<script type="text/javascript">Swal.fire("Lỗi","Lỗi máy chủ","error");</script>'; 
													  }
													}

												?>
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
													<th class="min-w-50px">MÃ GAME</th>
													<th class="min-w-50px">TÊN GAME</th>
													<th class="min-w-50px">LOẠI</th>
													<th class="min-w-125px">ĐÃ BÁN</th>
													<th class="min-w-125px">TỔNG TIỀN</th>
													<th class="min-w-125px">DISPLAY</th>
													<th class="text-end min-w-100px">ACTIONS</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="text-gray-600 fw-bold">
												<?php
												$result = mysqli_query($ketnoi,"SELECT * FROM `category` ORDER BY id desc ");
												while($row = mysqli_fetch_assoc($result))
												{
												?>
												<!--begin::Table row-->
												<tr>
													<td><?=$row['id'];?></td>
													<td><?=$row['code'];?></td>
													<td><?=$row['title'];?></a></td>
													<td><?=$row['pin'];?></td>
													<td><?=mysqli_fetch_assoc($ketnoi->query("SELECT COUNT(*) FROM `orders` WHERE `codegame` = '".$row['code']."' AND `user` IS NOT NULL  ")) ['COUNT(*)']; ?>
														GM TOOLS</td>
													<td><?=format_cash(mysqli_fetch_assoc($ketnoi->query("SELECT SUM(`xutru`) AS `sum` FROM `orders` WHERE `codegame` = '".$row['code']."' AND `user` IS NOT NULL  "))['sum']); ?>
														VND</td>
													<td>
														<?php
														  if ($row['display'] == 'hide')
														  {
															echo '<span class="badge bg-danger">ẨN</span>';
														  }
														  if ($row['display'] == 'show')
														  {
															echo '<span class="badge bg-success">HIỂN THỊ</span>';
														  }
														?>
													</td>
													<td class="text-end">
														<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon svg-icon-5 m-0">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon--></a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="edit-chuyen-muc.php?id=<?=$row['id'];?>" class="menu-link px-3">Edit</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="chuyen-muc.php?delete=<?=$row['id'];?>" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu-->
													</td>
													<!--end::Action=-->
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

<?php include('foot.php');?>