<?php 
require_once('../head.php');
include('../session.php');
?>
<title>Danh Sách Đơn Hàng | <?=$site['site_tenweb'];?></title>
<?php require_once('../sidebar.php');?>
<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Lịch sử mua Tools</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Lịch sử mua Tools</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">LỊCH SỬ MUA GM TOOLS</h4>
                    <?php $result = $ketnoi->query("SELECT * FROM `orders` ORDER BY id desc "); ?>
                </div>
                <div class="pd-20 card-box height-100-p">
                    <table class="table hover multiple-select-row data-table nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th>MÃ GAME</th>
                                <th>TÊN GAME</th>
                                <th>TÀI KHOẢN</th>
                                <th>SERVER</th>
                                <th>SỐ TIỀN</th>
                                <th>THỜI GIAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $querryy = $ketnoi->query("SELECT * FROM `orders` WHERE `user` = '".$user['username']."' ORDER BY id desc ");
while ($row = mysqli_fetch_array($querryy)) 
{
?>
                            <tr>
                                <td><?=$i;?></td>
                                <td><b><?=$row['codegame'];?></b></td>
                                <td><span class="badge badge-warning"><b><?=$row['game'];?></b></span></td>
                                <td><span class="badge badge-info"><b><?=$row['acc'];?></b></span></td>
                                <td><span class="badge badge-success"><b>S<?=$row['sever'];?>-G100K</b></span></td>
                                <td><span class="badge badge-danger"><?=format_cash($row['xutru']);?>đ</span></td>
                                <td><span class="badge badge-dark"><?=$row['createTime'];?></span></td>
                            </tr>

                            <?php 
$i++; 
}?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Export Datatable End -->



        <?php require_once('../foot.php');?>