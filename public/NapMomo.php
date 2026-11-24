<?php 
require_once('../head.php');
include('../session.php');
?>
<title>Nạp MOMO | <?=$site['site_tenweb'];?></title>
<?php require_once('../sidebar.php');?>

<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Nạp Momo</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Nạp Tiền</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Momo</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Default Basic Forms Start -->
           <div class="pd-20 card-box mb-30">
        <div class="clearfix">
            <h4 class="text-blue h4">Recharge Momo</h4>
        </div>
        <?php $result = $ketnoi->query("SELECT * FROM `momo` WHERE `username` = '".$user['username']."' AND `status` = 'xuly' ORDER BY id desc");
                if(mysqli_num_rows($result)==0){ ?>
        <div class="wizard-content">
            <form class="tab-wizard wizard-circle wizard vertical" id="creeate_momo_Submit" method="post">
                <h5>Create QR</h5>
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nhập số tiền cần nạp :</label>
                                <input type="text" class="form-control" name="amount_momo"/>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 2 -->
                <h5>Waiting Payment</h5>
                <section>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-8 mb-30">
                            <div class="card card-box">
                                <div class="card-header text-center">QR CODE</div>
                                <div class="card-body">
                                    <center>
                                        <div id="qrcode"></div>
                                    </center>
                                    <center>
                                        <i class="fa fa-spinner fa-spin"></i>
                                        <span id="countdown"><b style="color:orange"></b></span> </p>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-30">
                            <div class="card card-box">
                                <div class="card-header text-center">G100K</div>
                                <div class="card-body">
                                    <h5 class="card-title">Information Payment</h5>
                                    <?php $result = $ketnoi->query("SELECT * FROM `momov2` WHERE `username` = '".$user['username']."' ORDER BY id desc LIMIT 1"); $row = $result->fetch_assoc();  ?>
                                    <p><i class="fa fa-university" aria-hidden="true"></i> <span style="padding-left: 5px;">Hình thức thanh toán: </span> <br>
                                        <span style="padding-left: 25px;word-break: keep-all;">Momo</span> </p>
                                    <p><i class="fa fa-credit-card" aria-hidden="true"></i> <span style="padding-left: 5px;">Số tài khoản(Click to copy)</span> <br>
                                        <span onclick="copytk()" data-clipboard-target="#copyStk" class="copytk" id="copyStk" style="padding-left: 25px;word-break: keep-all;"><b style="color:#28a745"><?=$site['site_sdt_momo']; ?></b></span> </p>
                                    <p><i class="fa fa-user" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Chủ tài khoản</span> <br>
                                        <span style="padding-left: 25px;word-break: keep-all;"><b style="color: red;"><?=$site_ten_momo; ?></b></span> </p>
                                    <p>
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Nội dung chuyển khoản(Click to copy)</span> <br>
                                        <span onclick="copynd()" data-clipboard-target="#copyNoiDung" class="copynd" id="copyNoiDung" style="padding-left: 25px;word-break: keep-all;"></span>
                                    </p>
                                    <p><i class="fa fa-barcode" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Trạng thái <i class="fa fa-spinner fa-spin"></i> </span> <br>
                                        <span id="status_payment" style="padding-left: 25px;word-break: break-all;"><b style="color:orange">Đang chờ thanh toán</b></span> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
            </form>
        </div>
        <? } else { ?>
        <div class="row clearfix">
                        <div class="col-sm-12 col-md-8 mb-30">
                            <div class="card card-box">
                                <div class="card-header text-center">QR CODE</div>
                                <div class="card-body">
                                    <center>
                                        <?php $result = $ketnoi->query("SELECT * FROM `momo` WHERE `username` = '".$user['username']."' AND `status` = 'xuly' ORDER BY id desc");
                                                $rs = mysqli_fetch_assoc($result);
                                                $input_amount = $rs['input_amount'];
                                                $request_id = $rs['request_id']; 
                                                echo("<img src='https://chart.googleapis.com/chart?cht=qr&chl=2%7C99%7C".$site['site_sdt_momo']."%7CLE%20VINH%20THUONG%7Cphuoc.dx%40oude.edu.vn%7C0%7C0%7C".$input_amount."%7C".$request_id."%7Ctransfer_myqr&chs=180x180&choe=UTF-8&chld=L|2' alt='qr code'>");
                                        ?>
                                    </center>
                                    <center>
                                        <i class="fa fa-spinner fa-spin"></i>
                                        <span id="status_payment"><b style="color:orange">5:00</b></span> </p>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 mb-30">
                            <div class="card card-box">
                                <div class="card-header text-center">G100K</div>
                                <div class="card-body">
                                    <h5 class="card-title">Information Payment</h5>
                                    <p><i class="fa fa-university" aria-hidden="true"></i> <span style="padding-left: 5px;">Hình thức thanh toán: </span> <br>
                                        <span style="padding-left: 25px;word-break: keep-all;">Momo</span> </p>
                                    <p><i class="fa fa-credit-card" aria-hidden="true"></i> <span style="padding-left: 5px;">Số tài khoản(Click to copy)</span> <br>
                                        <span onclick="copytk()" data-clipboard-target="#copyStk" class="copytk" id="copyStk" style="padding-left: 25px;word-break: keep-all;"><b style="color:#28a745"><?=$site['site_sdt_momo']; ?></b></span> </p>
                                    <p><i class="fa fa-user" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Chủ tài khoản</span> <br>
                                        <span style="padding-left: 25px;word-break: keep-all;"><b style="color: red;">LÊ VĨNH THƯƠNG</b></span> </p>
                                    <p>
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Nội dung chuyển khoản(Click to copy)</span> <br>
                                        <span onclick="copynd()" data-clipboard-target="#copyNoiDung" class="copynd" id="copyNoiDung" style="padding-left: 25px;word-break: keep-all;">
                                            <?php $result = $ketnoi->query("SELECT * FROM `momo` WHERE `username` = '".$user['username']."' AND `status` = 'xuly' ORDER BY id desc");
                                                $rs = mysqli_fetch_assoc($result);
                                                $request_id = $rs['request_id']; 
                                                echo("<b style='color: blue;'>$request_id</b>");
                                            ?>
                                        </span>
                                    </p>
                                    <p><i class="fa fa-barcode" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Trạng thái <i class="fa fa-spinner fa-spin"></i> </span> <br>
                                        <span id="status_payment" style="padding-left: 25px;word-break: break-all;"><b style="color:orange">Đang chờ thanh toán</b></span> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <? }?>
    </div>
    <script type="text/javascript">

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('95889a064938e39c8363', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('G100K');
    channel.bind('RechargeMomo', function(data) {
      console.log(data.message);
      cuteToast({
            type: data.type,
            message: data.message,
            timer: 2500
        });
        setTimeout(function() {
                        location.href = data.url
                    }, 2500);
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
    $("#create_momo_Next").click(function(e) {
        var firstForm = $("#creeate_momo_Submit").serialize();
        $.ajax({
            url: "https://g100k.net/model/create_invoice.php",
            type: 'POST',
            data: firstForm,
            dataType: 'json',
            mimeType: "multipart/form-data",
            //contentType: false,
            success: function(data) {
                var sotien = data.amount;
                var request_id = data.request_id;
                var qr_code = "<img src='https://chart.googleapis.com/chart?cht=qr&chl=2%7C99%7C0387557750%7CLE%20VINH%20THUONG%7Cphuoc.dx%40oude.edu.vn%7C0%7C0%7C"+sotien+"%7C"+request_id+"%7Ctransfer_myqr&chs=180x180&choe=UTF-8&chld=L|2' alt='qr code'>";
                var comment = "<b style='color: blue;'>"+request_id+"</b>";
                $("#qrcode").html(qr_code);
                $("#copyNoiDung").html(comment);
                if (data.status == 0) {
                    cuteToast({
                        type: data.type,
                        message: data.msg,
                        timer: 2500
                    });
                    setTimeout(function() {
                        location.href = data.url
                    }, 2500);
                    $("#loading").hide();
                } else {
                     cuteToast({
                        type: data.type,
                        message: data.msg,
                        timer: 2500
                    });
                    
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                cuteToast({
                        type: "error",
                        message: "Có lỗi trong quá trình thực hiện",
                        timer: 2500
                });
                $("#loading").hide();
            }
        });
        //e.preventDefault();
    });

});
</script>
<script>
function countdown() {
    var seconds = 300;
    var countdownTimer = setInterval(function() {
        var minutes = Math.floor(seconds / 60);
        var remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }
        document.getElementById("countdown").innerHTML = minutes + ":" + remainingSeconds;
        if (seconds === 0) {
            clearInterval(countdownTimer);
            setTimeout(function() {
             location.href = "/pay/momo/"
            }, 2500);
        } else {
            seconds--;
        }
    }, 1000);
}
countdown();

</script>

            <!-- Export Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">LỊCH SỬ NẠP MOMO</h4>
                    <?php $result = $ketnoi->query("SELECT * FROM `momo` ORDER BY id desc "); ?>
                </div>
             <div class="pd-20 card-box height-100-p">
                <div class="table-responsive">
                    <table class="table hover multiple-select-row data-table nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th>MÃ GD</th>
                                <th>Nội Dung</th>
                                <th>SDT</th>
                                <th>Tên</th>
                                <th>THỰC NHẬN</th>
                                <th>THỜI GIAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$i = 0;
$result = mysqli_query($ketnoi,"SELECT * FROM `momo` WHERE `username` = '".$user['username']."' AND `status` = 'hoantat' ORDER BY id desc ");
while($row = mysqli_fetch_assoc($result)){ ?>
                            <tr>
                                <td><?=$i;?> <?php $i++;?></td>
                                <td><span class="badge badge-danger"><?=$row['tranId'];?></span></td>
                                <td><span class="badge badge-info"><?=$row['comment'];?></span></td>
                                <td><?=$row['partnerId'];?></td>
                                <td><span class="badge badge-warning"><?=$row['partnerName'];?></span></td>
                                <td><span class="badge badge-success"><?=format_cash($row['amount']);?>đ</span></td>
                                <td><span class="badge badge-dark"><?=$row['time'];?></span></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- Export Datatable End -->
        </div>


        <?php require_once('../foot.php');?>