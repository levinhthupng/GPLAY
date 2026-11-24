<?php 
$active2 = "active";
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
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Order History</h1>
									<!--end::Title-->
									<!--begin::Separator-->
									<span class="h-20px border-gray-200 border-start mx-4"></span>
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">
											<a href="/" class="text-muted text-hover-primary">Home</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">Dashboard</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-dark">Order History</li>
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
								<!--begin::Row-->
								<!--end::Row-->
								<!--begin::Row-->
								<!--end::Row-->
								<!--begin::Card-->
								<div class="card card-flush">
									<!--begin::Card header-->
									<div class="card-header mt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<h3 class="card-label">ORDER HISTORY
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
										<table class="table align-middle table-row-dashed  fs-6 gy-5 mb-0" id="kt_datatable_example_5">
											<!--begin::Table head-->
											<thead>
												<!--begin::Table row-->
												<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
													<th class="min-w-5px">ID</th>
													<th class="min-w-125px">Username</th>
													<th class="min-w-125px">CODE GAME</th>
													<th class="min-w-125px">GAME NAME</th>
													<th class="min-w-125px">ID,NV,TK</th>
													<th class="min-w-125px">SERVER</th>
													<th class="text-end min-w-100px">TIME</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="fw-bold text-gray-600">
											    <?php 
                                                  $i = 0;
                                                  $result = mysqli_query($ketnoi,"SELECT * FROM `orders` ORDER BY id desc ");
													while($row = mysqli_fetch_assoc($result))
												{?>
												<tr>
													<td><?=$i;?> <?php $i++;?></td>
													<td>
														<a href="edit-thanh-vien.php?username=<?=$row['user'];?>" class="badge badge-light-primary fs-7 m-1"> <?=$row['user'];?></a>
													</td>
													<td><span class="badge badge-danger fs-7 m-1"><?=$row['codegame'];?></span></td>
													<td><span class="badge badge-info fs-7 m-1"><?=$row['game'];?></span></td>
													<td><span class="badge badge-warning fs-7 m-1"><?=$row['acc'];?></span></td>
													<td><span class="badge badge-primary fs-7 m-1"><?=$row['sever'];?></span></td>
													<td class="text-end">
														<span class="badge badge-dark fs-7 m-1"><?=$row['createTime'];?></span>
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
<?php include('foot.php');?>