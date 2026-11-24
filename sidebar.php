<body class="header-dark sidebar-dark">
<?php 
//    if(empty($_SESSION['username']))
//    {
//        die('<script type="text/javascript">setTimeout(function(){ location.href = "/login/" },0);</script>');
//    }
?>
<?php
    if ($site['site_baotri'] == 'ON')
    {
        echo '<script type="text/javascript">swal("Thông Báo", "Hệ thống đang bảo trì định kỳ, xin quý khách vui lòng quay lại sau.", "warning");</script>';
        die();
    } 
    if ($user['banned'] == 1)
    {
        echo '<script type="text/javascript">swal("Thông Báo", "Tài khoản đã bị khóa!", "warning");
        setTimeout(function(){ location.href = "/log-out/" },3000);</script>';
        die();
    } 
?>



    <div class="header" style="background:<?=$site['color'];?>">
        <div class="header-left">
            <div class="menu-icon dw dw-menu"></div>
            <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
            <div class="header-search" style="background:<?=$site['color'];?>">
                <form action="/" method="post">
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input type="text" class="form-control search-input" name="btnTimTaiKhoan"
                            placeholder="Tìm game...">
                    </div>
                </form>
            </div>
        </div>
        <div class="header-right">
            <div class="user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                        <i class="icon-copy dw dw-notification"></i>
                        <span class="badge notification-active"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="notification-list mx-h-350 customscroll">
                            <ul>
                                <?php $i = 0; $show_logs = $ketnoi->query("SELECT * FROM `thongbao` ORDER BY id desc"); while($row = $show_logs->fetch_assoc() ){ ?>
                                <li>
                                    <a>
                                        <img src="/vendors/images/news.png" alt="<?=$row['content'];?>">
                                        <h3><?=$row['title'];?></h3>
                                        <p><?=$row['content'];?></p>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($_SESSION['username']) { ?>
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon avatar">
                            <img src="/vendors/images/3136455.png" alt="">
                        </span>
                        <span class="user-name"><?=$user['username'];?> 
									<?php if($user['level'] == 'admin') { ?> 
									      <img src="/img/S10_VIP.gif" />
									<?php } else if($user['level'] == '1') { ?> 
									      <img src="/img/S8_VIP.gif" />      
									<?php } else if($user['level'] == '2') { ?> 
									      <img src="/img/S9_VIP.gif" />      
									<?php } else { ?>
									        <img src="/img/S7_VIP.gif" /> 
									<?php } ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="/profile/"><i class="dw dw-user1"></i> <span class="mtext">Số Dư:<?=format_cash($user['money']);?>đ</span></a>
                        <a class="dropdown-item" href="/profile/"><i class="dw dw-user1"></i> Trang Cá Nhân</a>
                        <a class="dropdown-item" href="/support/"><i class="dw dw-help"></i> Hỗ Trợ</a>
                        <a class="dropdown-item" href="/log-out/"><i class="dw dw-logout" ></i> Đăng Xuất</a>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="github-link"> 
            <a href="" target="_blank"><img src="/vendors/images/github.svg" alt=""></a> 
            </div>
        </div>
    </div>
    <div class="left-side-bar" style="background:<?=$site['color'];?>">
        <div class="brand-logo">
            <a href="/">
                <img src="<?=$site['site_logo'];?>" alt="<?=$site_tenweb;?>"  class="sieuthicode-logo mr-2">
                <img src="/assets/img/g100k.webp" class="black_logo w-[130px] md:min-w-[150px] h-[40px] " alt="G100K.NET SERVER GMAE FULL TOOLS">
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li>
                        <a href="/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-house-1"></span><span class="mtext"><?=$lang['side1'];?></span>
                        </a>
                    </li>
                    <?php if(($_SESSION['username']))
                       { ?>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-shopping-cart"></span><span
                                class="mtext"><?=$lang['side2'];?></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="/mua-tools">Mua GM Tools Full Vật Phẩm</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-money-2"></span><span class="mtext"><?=$lang['side3'];?></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="/pay/card/">Nạp Bằng Thẻ Cào Auto</a></li>
                            <!--<li><a href="/pay/momo/">Nạp Bằng MOMO Auto</a></li>-->
                            <li><a href="/pay/bank/">Nạp ATM, MOMO Auto</a></li>
                           <!--<li><a href="/pay/paypal/">Paypal & Debit Card và Credit Card</a></li>-->
                        </ul>
                    </li>
                    <li>
                        <a href="/history/orders/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-shopping-bag1"></span>
                            <span class="mtext"><?=$lang['side4'];?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/giftcode/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-gift"></span>
                            <span class="mtext"><?=$lang['side6'];?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/discount/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-analytics1"></span>
                            <span class="mtext"><?=$lang['side7'];?></span>
                        </a>
                    </li>
                <!--    <li>
                        <a href="/affiliate-manager/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-analytics1"></span>
                            <span class="mtext"><?=$lang['side7'];?></span>
                        </a>
                    </li> -->
                    <li>
                        <a href="/support/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-support"></span>
                            <span class="mtext"><?=$lang['side8'];?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=$site['facebook'];?>" target="_blank" class="dropdown-toggle no-arrow">
                            <span class="micon fa fa-facebook"></span>
                            <span class="mtext"><?=$lang['side9'];?></span>
                        </a>
                    </li>
                    <?php } else { ?>
                    <li>
                        <a href="/login/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-support"></span>
                            <span class="mtext">Đăng Nhập</span>
                        </a>
                    </li>
                    <li>
                        <a href="/register/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-support"></span>
                            <span class="mtext">Đăng Ký</span>
                        </a>
                    </li>
                    <?php }?>
                    <?php if($user['level'] == 'admin'){ ?>
                    <li>
                        <a href="/admin/" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-settings2"></span>
                            <span class="mtext">Quản Trị Website</span>
                        </a>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div class="hotline-phone-ring-wrap"> 
        <div class="hotline-phone-ring"> 
            <div class="hotline-phone-ring-circle"></div> 
            <div class="hotline-phone-ring-circle-fill"></div> 
            <div class="hotline-phone-ring-img-circle"> 
                <a href="tel:038.755.7750" class="pps-btn-img"> 
                    <img src="/img/icon-call-nh.png" alt="Gọi điện thoại" width="50"> </a> 
            </div> 
        </div> 
        <div class="hotline-bar"> 
            <a href="tel:038.755.7750"> 
            <span class="text-hotline">038.755.7750</span></a> 
        </div> 
</div>