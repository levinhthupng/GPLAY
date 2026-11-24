
<?php require_once('../head.php'); ?>
<title>Đăng Nhập | <?=$site['site_tenweb'];?></title>



<body class="login-page" style="background: linear-gradient(-135deg,#c850c0,#4158d0);">
	<?php require_once('../model/DangNhap.php');?>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
			    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7930717041744833"
                     crossorigin="anonymous"></script>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-format="autorelaxed"
                     data-ad-client="ca-pub-7930717041744833"
                     data-ad-slot="2563511829"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
				<div class="col-md-6 col-lg-7">
					<img src="/vendors/images/g100k.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center" style="color:<?=$site['color'];?>">Đăng Nhập Khách Hàng</h2>
						</div>
						<form action="" method="POST">
							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg is-valid" name="username" placeholder="Username hoặc Email" required="">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg is-valid" name="password" placeholder="**********" required="">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="row pb-30">
								<div class="col-6">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1">
										<label class="custom-control-label" for="customCheck1">Lưu mật khẩu</label>
									</div>
								</div>
								<div class="col-6">
									<div class="forgot-password"><a href="/forgot-password/">Quên mật khẩu ?</a></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<input class="btn btn-primary btn-lg btn-block" type="submit" name="btnDangNhap" value="Đăng Nhập">
									</div>
									<div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
									<div class="input-group mb-0">
										<a class="btn btn-outline-primary btn-lg btn-block" href="/register/">Tạo Tài Khoản</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7930717041744833"
         crossorigin="anonymous"></script>
    <!-- ads17 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7930717041744833"
         data-ad-slot="4629876739"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
	<!-- js -->
	<script src="/vendors/scripts/core.js"></script>
	<script src="/vendors/scripts/script.min.js"></script>
	<script src="/vendors/scripts/process.js"></script>
	<script src="/vendors/scripts/layout-settings.js"></script>
</body>
</html>