<?php 
require_once('../head.php');
include('../session.php');
?>
<title>Nạp Thẻ | <?=$site['site_tenweb'];?></title>
<?php require_once('../sidebar.php');?>
<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Nạp Thẻ Cào</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Nạp Tiền</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thẻ Cào</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            
            <div class="row"> 
                <div class="col-lg-7"> 
                    <div class="card-box mb-30"> 
                    <div class="pd-20"> 
                        <h3 class="text-blue">Nạp thẻ cào</h3> 
                        <div class="alert alert-info mt-2" role="alert">
                            <i class="fa fa-bell"></i> Sau khi nạp thẻ, chờ 1-15s, nếu tiền vẫn không được cộng hãy liên hệ với Shop! 
                        </div> 
                        <form id="ChargeCard" method="POST">
                        <div class="form-group"> 
                            <label for="" class="control-label">Nhà Mạng:</label> 
                            <select class="custom-select form-control" name="loaithe" required=""> 
                                <option value="">-- Loại thẻ --</option> 
                                <option value="VIETTEL"> VIETTEL</option> 
                                <option value="VINAPHONE"> VINAPHONE</option> 
                                <option value="MOBIFONE"> MOBIFONE</option> 
                                <option value="ZING"> ZING</option> 
                                <option value="VNMOBI"> VNMOBI</option> 
                            </select> 
                        </div> 
                        <div class="form-group"> 
                            <label for="" class="control-label">Mệnh Giá:</label> 
                            <select class="custom-select form-control" name="menhgia" id="menhgia" required=""> 
                                <option value="">-- Mệnh giá --</option> 
                                <option value="10000">10,000đ</option> 
                                <option value="20000">20,000đ</option> 
                                <option value="30000">30,000đ</option> 
                                <option value="50000">50,000đ</option> 
                                <option value="100000">100,000đ</option> 
                                <option value="200000">200,000đ</option> 
                                <option value="300000">300,000đ</option> 
                                <option value="500000">500,000đ</option> 
                                <option value="1000000">1,000,000đ</option> 
                            </select> 
                        </div> 
                        <div class="form-group"> 
                                <label for="" class="control-label">Serial:</label> 
                                <input type="text" name="seri" class="form-control is-valid">
                        </div> 
                        <div class="form-group"> 
                                    <label for="" class="control-label">Mã Thẻ:</label> 
                                        <input type="text" name="pin" class="form-control is-valid"> 
                            </div> 
                        <div class="form-group"> 
                                            <label for="" class="control-label">Thực nhận:</label> 
                                            <input type="hidden" id="chietkhau" value="<?=$site_ck_card;?>" class="form-control"> 
                                            <b id="ketqua" style="color:red;">0</b><b style="color:red;">đ</b> 
                                </div> 
                        <button type="submit" name="btnNapCard" class="btn btn-success btn-lg btn-block">NẠP TIỀN</button> 
                    </div> 
                    </form>
                        </div>
                </div> 
                <div class="col-lg-5"> 
                    <div class="card-box mb-30"> 
                        <div class="pd-20"> 
                            <h5>Lưu ý</h5>
                            <h5>
                                <ul>
                                    <li style="padding: 0px; margin: 0px; outline: 0px; border: 0px;">
                                        <font color="#ff0000"><b>Chiết khấu thẻ là <?=$site_ck_card;?>%</b></font>
                                    </li>
                                </ul>
                            </h5>
                            <ul>
                                <li style="padding: 0px; margin: 0px; outline: 0px; border: 0px;">
                                    <font color="#ff0000"><b>Hệ thống xử lý 5s 1 thẻ.</b></font>
                                </li>
                                <li style="padding: 0px; margin: 0px; outline: 0px; border: 0px;">
                                    <font color="#ff0000"><b>Vui lòng gửi đúng mệnh giá, sai mệnh giá thực nhận mệnh giá bé nhất.</b></font>
                                </li>
                            </ul> 
                        </div> 
                    </div> 
                </div>
            </div>
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">LỊCH SỬ NẠP THẺ CÀO</h4>
                        <?php $result = $ketnoi->query("SELECT * FROM `cards` ORDER BY id desc "); ?>
                    </div>
                    <div class="pd-20 card-box height-100-p">
                        <div class="table-responsive">
                            <table class="table hover multiple-select-row data-table nowrap">
                                <thead>
                                    <tr>
                                        <th class="sorting_asc">STT</th>
                                        <th>SERI</th>
                                        <th>PIN</th>
                                        <th>LOẠI THẺ</th>
                                        <th>MỆNH GIÁ</th>
                                        <th>THỰC NHẬN</th>
                                        <th>THỜI GIAN</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>GHI CHÚ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 0;
                                        $result = $ketnoi->query("SELECT * FROM `cards` WHERE `username` = '".$user['username']."' ORDER BY id desc ");
                                        while( $row = $result->fetch_assoc() ){
                                        ?>
                                    <tr>
                                        <td><?=$i;?> <?php $i++;?></td>
                                        <td><?=$row['seri'];?></td>
                                        <td><?=$row['pin'];?></td>
                                        <td><span class="badge badge-danger"><?=$row['loaithe'];?></span></td>
                                        <td><?=format_cash($row['menhgia']);?></td>
                                        <td><?=format_cash($row['thucnhan']);?></td>
                                        <td><span class="badge badge-dark"><?=$row['createdate'];?></span></td>
                                        <td><?=status($row['status']);?></td>
                                        <td><?=$row['note'];?></td>
                                    </tr>
                                        <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Export Datatable End -->
                <!-- Export Datatable End -->
             </div>
<script type="text/javascript">

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('95889a064938e39c8363', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('G100K');
    channel.bind('card', function(data) {
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
    					$(document).ready(function () {
            				$("#ChargeCard").submit(function (e) {   
            					var firstForm = $("#ChargeCard").serialize();
            					$.ajax({
            						url: "https://g100k.net/model/NapCard.php",
            						type: 'POST',
            						data: firstForm,
            						dataType: 'json',
            						mimeType: "multipart/form-data",
            						//contentType: false,
            						cache: false,
            						processData: false,
            						beforeSubmit: function () {
            							$("#loading").show();
            						},
            						success: function (data) {                     
            							if (data.status == 0) {
            								cuteToast({type: data.type,message: data.msg,timer: 2500});
            								$("#loading").hide();                               
            							}
            							else {
            							    cuteToast({type: data.type,message: data.msg,timer: 2500});
            							    setTimeout(function(){ location.href = "" },2500);
            								$("#loading").hide();
            							}
            						},
            						error: function (xhr, ajaxOptions, thrownError) {
            						    cuteToast({type: data.type,message: "Có lỗi trong quá trình thực hiện",timer: 2500});
            							$("#loading").hide();
            						}
            					});
            					e.preventDefault();
            				});
            		
            			});
					</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
$('#menhgia').on('change',function(){
    var menhgia=$('#menhgia').val();
    var ck=<?=$site_ck_card;?>;
    var ketqua=menhgia-menhgia*ck/100;$('#ketqua').html(ketqua.toString().replace(/(.)(?=(\d{3})+$)/g,'$1,'));
});
</script>
<?php require_once('../foot.php');?>