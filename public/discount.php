<?php 
require_once('../head.php');
include('../session.php');
?>
	<title>Discount |
		<?=$site['site_tenweb'];?>
	</title>
	<?php require_once('../sidebar.php');?>
			<div class="mobile-menu-overlay"></div>
			<div class="main-container">
				<div class="pd-ltr-20 xs-pd-20-10">
					<div class="min-height-200px">
						<div class="page-header">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="title">
										<h4>Discount</h4> 
									</div>
									<nav aria-label="breadcrumb" role="navigation">
										<ol class="breadcrumb">
											<li class="breadcrumb-item"><a href="/">Home</a></li>
											<li class="breadcrumb-item active" aria-current="page">Discount</li>
										</ol>
									</nav>
								</div>
							</div>
						</div>
						<div class="card-box mb-30">
							<div class="pd-20">
								<h4 class="text-blue h4">CODE DISCOUNT</h4> </div>
							<div class="pd-20 card-box height-100-p">
								<table class="table hover multiple-select-row data-table nowrap">
									<thead>
										<tr>
											<th>STT</th>
											<th>CODE</th>
											<th>DISCOUNT</th>
											<th>TRẠNG THÁI</th>
											<th>THỜI GIAN</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                        $i = 0;
                                        $result = $ketnoi->query("SELECT * FROM `discount` WHERE `user` = '".$user['username']."' ORDER BY id desc ");
                                        while( $row = $result->fetch_assoc() ){
                                        ?>
											<tr>
												<td>
													<?=$i;?>
														<?php $i++;?>
												</td>
												<td><span class="badge badge-danger"><?=$row['code'];?></span></td>
												<td><?=$row['discount'];?>%</td>
												<td><?if($row['sudung'] == '0') { echo"Chưa Sử Dụng"; } else { echo("Đã Sử Dụng");}
												?></td>
												<td><span class="badge badge-dark"><?=$row['createdate'];?></span></td>
											</tr>
											<?php }?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- Export Datatable End -->
					</div>
					<?php require_once('../foot.php');?>