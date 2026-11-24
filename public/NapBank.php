<?php 
require_once('../head.php');
include('../session.php');
?>
<title>Nạp Qua Ngân Hàng | <?=$site['site_tenweb'];?></title>
<?php require_once('../sidebar.php');?>
<?php require_once('../cron/AutoVcb.php');?>

<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Nạp Qua Ngân Hàng</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Nạp Tiền</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Nạp Qua Ngân Hàng</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
           <div class="pd-20 card-box mb-30">
        <div class="clearfix">
            <h4 class="text-blue h4">Recharge ATM</h4>
        </div>
        <?php $result = $ketnoi->query("SELECT * FROM `bank_auto` WHERE `username` = '".$user['username']."' AND `status` = 'xuly' ORDER BY id desc");
                if(mysqli_num_rows($result)==0){    
         ?>
        <div class="wizard-content">
            <form class="tab-wizard wizard-circle wizard vertical" id="creeate_momo_Submit" method="post">
                <h5>Create QR</h5>
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nhập số tiền cần nạp :</label>
                                <input type="text" class="form-control" name="amount_amt"/>
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
                                    <p><i class="fa fa-university" aria-hidden="true"></i> <span style="padding-left: 5px;">Hình thức thanh toán: </span> <br>
                                        <span style="padding-left: 25px;word-break: keep-all;">MBBANK (Ngân Hàng Quân Đội)</span> </p>
                                    <p><i class="fa fa-credit-card" aria-hidden="true"></i> <span style="padding-left: 5px;">Số tài khoản(Click to copy)</span> <br>
                                        <span onclick="copytk()" data-clipboard-target="#copyStk" class="copytk" id="copyStk" style="padding-left: 25px;word-break: keep-all;"><b style="color:#28a745"><?=$site_stk;?></b></span> </p>
                                    <p><i class="fa fa-user" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Chủ tài khoản</span> <br>
                                        <span style="padding-left: 25px;word-break: keep-all;"><b style="color: red;">LÊ VĨNH THƯƠNG</b></span> </p>
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
        <? } else { 

        ?>
        <div class="row clearfix">
                        <div class="col-sm-12 col-md-8 mb-30">
                            <div class="card card-box">
                                <div class="card-header text-center">QR CODE</div>
                                <div class="card-body">
                                    <center>
                                        <?php $result = $ketnoi->query("SELECT * FROM `bank_auto` WHERE `username` = '".$user['username']."' AND `status` = 'xuly' ORDER BY id desc");
                                                $rs = mysqli_fetch_assoc($result);
                                                $input_amount = $rs['input_amount'];
                                                $request_id = $rs['request_id']; 
                                                echo('<img src="https://img.vietqr.io/image/MB-88288288288-qr_only.png?amount='.$input_amount.'&addInfo='.$request_id.'" width="100%" style="width: 180px; height: 180px">');
                                        ?>
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
                                    <p><i class="fa fa-university" aria-hidden="true"></i> <span style="padding-left: 5px;">Hình thức thanh toán: </span> <br>
                                        <span style="padding-left: 25px;word-break: keep-all;">MBBANK (Ngân Hàng Quân Đội)</span> </p>
                                    <p><i class="fa fa-credit-card" aria-hidden="true"></i> <span style="padding-left: 5px;">Số tài khoản(Click to copy)</span> <br>
                                        <span onclick="copytk()" data-clipboard-target="#copyStk" class="copytk" id="copyStk" style="padding-left: 25px;word-break: keep-all;"><b style="color:#28a745"><?=$site_stk;?></b></span> </p>
                                    <p><i class="fa fa-user" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Chủ tài khoản</span> <br>
                                        <span style="padding-left: 25px;word-break: keep-all;"><b style="color: red;"><?=$site_ten_momo;?></b></span> </p>
                                    <p>
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                        <span style="padding-left: 5px;">Nội dung chuyển khoản(Click to copy)</span> <br>
                                        <span onclick="copynd()" data-clipboard-target="#copyNoiDung" class="copynd" id="copyNoiDung" style="padding-left: 25px;word-break: keep-all;">
                                            <?php $result = $ketnoi->query("SELECT * FROM `bank_auto` WHERE `username` = '".$user['username']."' AND `status` = 'xuly' ORDER BY id desc");
                                                $rs = mysqli_fetch_assoc($result);
                                                $input_amount = $rs['input_amount'];
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
    channel.bind('RechargeBank<?php echo $user['username']; ?>', function(data) {
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
   <script>
    $(document).ready(function() {
        $("#create_momo_Next").click(function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của nút bấm
            const formData = $("#creeate_momo_Submit").serialize();

            $.ajax({
                url: "https://g100k.net/model/create_invoice_atm.php",
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    const { amount, request_id, status, type, msg, url } = data;
                    var qr_code = '<img src="https://img.vietqr.io/image/MB-88288288288-qr_only.png?amount=' + amount + '&addInfo=' + request_id + '" style="max-width: 180px; width: 100%; height: auto;">';
                    const comment = `<b style='color: blue;'>${request_id}</b>`;

                    $("#qrcode").html(qr_code);
                    $("#copyNoiDung").html(comment);

                    cuteToast({
                        type,
                        message: msg,
                        timer: 2500
                    });

                    if (status == 0) {
                        setTimeout(() => {
                            location.href = url;
                        }, 2500);
                    }
                    $("#loading").hide();
                },
                error: function() {
                    cuteToast({
                        type: "error",
                        message: "Có lỗi trong quá trình thực hiện",
                        timer: 2500
                    });
                    $("#loading").hide();
                }
            });
        });
    });
</script>

<script>
function startCountdown(totalSeconds, displayId, redirectUrl) {
    const display = document.getElementById(displayId);

    // Nếu đã có deadline thì dùng lại, ngược lại tạo mới
    let deadline = localStorage.getItem("countdownDeadline");
    if (!deadline) {
        deadline = Date.now() + totalSeconds * 1000;
        localStorage.setItem("countdownDeadline", deadline);
    } else {
        deadline = parseInt(deadline, 10);
    }

    const timer = setInterval(() => {
        const now = Date.now();
        let diff = Math.floor((deadline - now) / 1000);

        if (diff <= 0) {
            clearInterval(timer);
            display.textContent = "0:00";
            localStorage.removeItem("countdownDeadline");
            setTimeout(() => location.href = redirectUrl, 2500);
            return;
        }

        const minutes = Math.floor(diff / 60);
        const seconds = String(diff % 60).padStart(2, "0");
        display.textContent = `${minutes}:${seconds}`;
    }, 1000);
}

// Gọi countdown 5 phút, hiển thị trong #countdown, hết thì về /pay/bank/
startCountdown(300, "countdown", "/pay/bank/");
</script>
            <!-- Export Datatable start -->
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">LỊCH SỬ NẠP ATM</h4>
                    <?php $result = $ketnoi->query("SELECT * FROM `bank_auto` ORDER BY id desc "); ?>
                </div>
                <div class="pd-20 card-box height-100-p">
                    <table class="table hover multiple-select-row data-table nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th>MÃ GD</th>
                                <th>Nội Dung</th>
                                <th>THỰC NHẬN</th>
                                <th>THỜI GIAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$i = 0;
$result = mysqli_query($ketnoi,"SELECT * FROM `bank_auto` WHERE `username` = '".$user['username']."' AND `status` = 'hoantat' ORDER BY id desc");
while($row = mysqli_fetch_assoc($result)){ ?>
                            <tr>
                                <td><?=$i;?> <?php $i++;?></td>
                                <td><?=$row['tranId'];?></td>
                                <td><?=$row['request_id'];?></td>
                                <td><?=format_cash($row['amount']);?>đ</td>
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