<?php include('../config.php');
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Đăng Nhập CMS NT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

 		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="dist/assets/css/pages/login/classic/login-649d8.css" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
				<!--begin::Global Theme Styles(used by all pages)-->
		<link href="dist/assets/plugins/global/plugins.bundle49d8.css" rel="stylesheet" type="text/css" />
		<link href="dist/assets/plugins/custom/prismjs/prismjs.bundle49d8.css" rel="stylesheet" type="text/css" />
		<link href="dist/assets/css/style.bundle49d8.css?v=7.2.8" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="dist/assets/css/themes/layout/header/base/light49d8.css" rel="stylesheet" type="text/css" />
		<link href="dist/assets/css/themes/layout/header/menu/light49d8.css" rel="stylesheet" type="text/css" />
		<link href="dist/assets/css/themes/layout/brand/dark49d8.css" rel="stylesheet" type="text/css" />
		<link href="dist/assets/css/themes/layout/aside/dark49d8.css" rel="stylesheet" type="text/css" />
		  <script src="../src/scripts/sweetalert.min.js"></script>
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-6 login-signin-on login-signin-on d-flex flex-column-fluid" id="kt_login">
				<div class="d-flex flex-column flex-lg-row flex-row-fluid text-center" style="background-image: url(dist/assets/media/bg/bg-3.jpg?v=1);">
					<!--begin:Aside-->
					<div class="d-flex w-100 flex-center p-15">
						<div class="login-wrapper">
							<!--begin:Aside Content-->
							<div class="text-dark-75">
								<a href="#">
									<img src="dist/assets/media/logos/logo-letter-13.png?v=1" class="max-h-75px" alt="" />
								</a>
								<h3 class="mb-8 mt-22 font-weight-bold">JOIN OUR GREAT COMMUNITY</h3>
								<p class="mb-15 text-muted font-weight-bold">Hệ thống api hàng đầu Việt Nam.</p>
								<a href="//fgocheat.net"><button type="button" class="btn btn-outline-primary btn-pill py-4 px-9 font-weight-bold">Contact</button></a>
							</div>
							<!--end:Aside Content-->
						</div>
					</div>
					<!--end:Aside-->
					<!--begin:Divider-->
					<div class="login-divider">
						<div></div>
					</div>
					<!--end:Divider-->
					<!--begin:Content-->
					<div class="d-flex w-100 flex-center p-15 position-relative overflow-hidden">
						<?php

						if (isset($_POST["submit"]))
						{
							$username = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['username']))));
							$password = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['password']))));
							$password = md5($password);
							if ($username == "" || $password =="") 
							{
								echo '<script type="text/javascript">swal("Lỗi", " Không được để trống tên đăng nhập hoặc mật khẩu", "error");
								setTimeout(function(){ location.href = "login.php" },2000);</script>';
							}
							else
							{
								$sql = "SELECT * FROM `users` WHERE `username` = '".$username."' AND `password` = '".$password."' AND `level` = 'admin'  ";
								$query = mysqli_query($ketnoi,$sql);
								$num_rows = mysqli_num_rows($query);

								if ($num_rows == 0) 
								{
									echo '<script type="text/javascript">swal("Lỗi", " Thông tin đăng nhập không chính xác !!!", "error");
									setTimeout(function(){ location.href = "" },2000);</script>';
									die();
								}
								else
								{
									
									$_SESSION['admin'] = $username;
									echo '<script type="text/javascript">swal("Thành Công","Đăng Nhập Thành Công","success");
										setTimeout(function(){ location.href = "index.php" },10);</script>';
								}
							}
						}
						?> 
						<div class="login-wrapper">
							<!--begin:Sign In Form-->
							<div class="login-signin">
								<div class="text-center mb-10 mb-lg-20">
									<h2 class="font-weight-bold">Sign In</h2>
									<p class="text-muted font-weight-bold">Enter your username and password</p>
								</div>
								<form class="form text-left" action="" method="post">
								    <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf-token'];?>" />
									<div class="form-group py-2 m-0">
										<input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="text" placeholder="Username" name="username" autocomplete="off" />
									</div>
									<div class="form-group py-2 border-top m-0">
										<input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="Password" placeholder="Password" name="password" />
									</div>
									<div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-5">
										<div class="checkbox-inline">
											<label class="checkbox m-0 text-muted font-weight-bold">
											<input type="checkbox" name="remember" />
											<span></span>Remember me</label>
										</div>
										<a href="//fgocheat.net" id="kt_login_forgot" class="text-muted text-hover-primary font-weight-bold">Contact</a>
									</div>
									<div class="text-center mt-15">
										<button type="submit" name="submit" class="btn btn-primary btn-pill shadow-sm py-4 px-9 font-weight-bold">Sign In</button>
									</div>
								</form>
							</div>
							<!--end:Sign In Form-->
							
						</div>
					</div>
					<!--end:Content-->
				</div>
			</div>
			<!--end::Login-->
		</div>
<!-- /.login-box -->

<!-- jQuery -->
		<script>var HOST_URL = "";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="dist/assets/plugins/global/plugins.bundle49d8.js?v=7.2.8"></script>
		<script src="dist/assets/plugins/custom/prismjs/prismjs.bundle49d8.js?v=7.2.8"></script>
		<script src="dist/assets/js/scripts.bundle49d8.js?v=7.2.8"></script>
		<!--end::Global Theme Bundle-->
		<script src="dist/assets/js/pages/custom/login/login-general49d8.js?v=7.3.3"></script>

</body>