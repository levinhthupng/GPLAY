<?php
require_once('../../head.php');
?>
    <title>Tiên Kiếm Vấn Đạo GM Tools | <?= $site['site_tenweb']; ?></title>
<?php require_once('../../sidebar.php'); ?>
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7930717041744833"
            crossorigin="anonymous"></script>
    <!-- ads18 -->
    <ins class="adsbygoogle"
         style="display:block; text-align:center;"
         data-ad-client="ca-pub-7930717041744833"
         data-ad-slot="2015150245"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Tiên Kiếm Vấn Đạo GM Tools</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">GM Tools</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tiên Kiếm Vấn Đạo Tools Full Vật Phẩm</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Default Basic Forms Start -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7930717041744833"
            crossorigin="anonymous"></script>
    <!-- ads19 -->
    <ins class="adsbygoogle"
         style="display:block; text-align:center;"
         data-ad-client="ca-pub-7930717041744833"
         data-ad-slot="7064468386"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <div class="row" style="text-align: center;justify-content: center;">
    <div class="center col-md-2 col-sm-12">
        <ins class="adsbygoogle"
             style="display:block; text-align:center;"
             data-ad-client="ca-pub-7930717041744833"
             data-ad-slot="7064468386"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <div class="center col-md-6 col-sm-12">
        <div class="card-box mb-30">
            <div class="pd-20">
                <div class="alert alert-info mt-2 intro-box" style="text-align: center;" role="alert">
                    <i class="fa fa-bell"></i> TIÊN KIẾM VẤN ĐẠO H5 <i class="fa fa-bell"></i>
                </div>
                <ins class="adsbygoogle"
                     style="display:block; text-align:center;"
                     data-ad-layout="in-article"
                     data-ad-format="fluid"
                     data-ad-client="ca-pub-7930717041744833"
                     data-ad-slot="1642124461"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <div class="alert alert-danger mt-2 intro-box" style="text-align: center;" role="alert">
                    <i class="fa fa-bell"></i>- Tools Số lượng ít đủ dùng. <i class="fa fa-bell"></i> </br>
                    <i class="fa fa-bell"></i>- Vật phẩm nào dùng được thì tools số lượng nhiều, trường hợp không dùng
                    được mà tools số lượng lớn bị lỗi Admin không chịu trách nhiệm. <i class="fa fa-bell"></i> </br>
                    <i class="fa fa-bell"></i>- Nếu server Reopen AE vui lòng bấm mua lại tools để được kích hoạc lại
                    tools miễn phí. Lưu ý: Thông tin phải trùng với thông tin trong lịch sử mua tools.<i
                        class="fa fa-bell"></i>
                </div>
                <ins class="adsbygoogle"
                     style="display:block; text-align:center;"
                     data-ad-layout="in-article"
                     data-ad-format="fluid"
                     data-ad-client="ca-pub-7930717041744833"
                     data-ad-slot="9081630787"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <form id="GMTools" method="post">

                    <div class="form-group">
                        <label for="" class="control-label">Chọn Sever:</label>
                        <select class="custom-select form-control" name="qu" id="qu" required="">
                            <option value="">-- Sever Game --</option>
                            <option value="1">S1-G100K</option>
                            <option value="2">S2-G100K</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nhập ID - (Ví dụ : 100001):</label> <br>
                        <input type="text" id="uid" name="uid" class="form-control is-valid">
                    </div>
                    <div class="alert alert-danger mt-2 intro-box" style="text-align: center;" role="alert">
                        <i class="fa fa-bell"></i> Nạp Free <i class="fa fa-bell"></i>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Chọn Vật Phẩm:</label>
                        <select class="selectpicker form-control show-tick" id="chargeid" name="chargeid"
                                data-live-search="true" data-size="5">
                            <option value="">-- Chọn Vật Phẩm --</option>
                            <?php
                            $file = fopen("./user/payid.txt", "r");
                            while(!feof($file))
                            {
                                $line=fgets($file);
                                $txts=explode(';',$line);
                                if(count($txts)==2){
                                    echo '<option value="'.$txts[0].'">'.$txts[1].'</option>';
                                }
                            }
                            fclose($file);
                            ?>
                        </select>
                    <div class="form-group">
                        <label for="" class="control-label">Nhập Số Lượng:</label> <br>
                        <input type="text" id="chargenum" name="chargenum" class="form-control is-valid">
                    </div>
                    </div>
                    <ins class="adsbygoogle"
                         style="display:block; text-align:center;"
                         data-ad-client="ca-pub-7930717041744833"
                         data-ad-slot="9679857588"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <div class="form-group">
                        <button class="btn g100k btn-danger" id="NapFree" name="NapFree" type="button"><i
                                class="fa fa-credit-card"></i> Nạp Free
                        </button>
                    </div>
                    <ins class="adsbygoogle"
                         style="display:block; text-align:center;"
                         data-ad-layout="in-article"
                         data-ad-format="fluid"
                         data-ad-client="ca-pub-7930717041744833"
                         data-ad-slot="9907627297"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <ins class="adsbygoogle"
                         style="display:block; text-align:center;"
                         data-ad-layout="in-article"
                         data-ad-format="fluid"
                         data-ad-client="ca-pub-7930717041744833"
                         data-ad-slot="7956251378"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <div class="alert alert-success mt-2 intro-box" style="text-align: center;" role="alert">
                        <i class="fa fa-bell"></i> Gửi Vật Phẩm <i class="fa fa-bell"></i>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Chọn Vật Phẩm:</label>
                        <select class="selectpicker form-control show-tick" id="mailid" name="mailid"
                                data-live-search="true" data-size="5">
                            <option value="">-- Chọn Vật Phẩm --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nhập Số Lượng:</label> <br>
                        <small style="color:red;" id="infogm"></small>
                        <input type="text" id="mailnum" name="mailnum" class="form-control is-valid">
                    </div>
                    <ins class="adsbygoogle"
                         style="display:block; text-align:center;"
                         data-ad-client="ca-pub-7930717041744833"
                         data-ad-slot="8092838979"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>

                    <div class="form-group">
                        <button class="btn btn-success g100k" id="SendMail" name="SendMail" type="button"><i
                                class="fa fa-credit-card"></i> Gửi Vật Phẩm
                        </button>
                    </div>
                    <script async
                            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7930717041744833"
                            crossorigin="anonymous"></script>
                    <!-- ads20 -->
                    <ins class="adsbygoogle"
                         style="display:block; text-align:center;"
                         data-ad-client="ca-pub-7930717041744833"
                         data-ad-slot="2371940131"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </form>
            </div>

        </div>
    </div>
    <div class="center col-md-2 col-sm-12">
        <ins class="adsbygoogle"
             style="display:block; text-align:center;"
             data-ad-client="ca-pub-7930717041744833"
             data-ad-slot="8749919294"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <div id="loading">
        <img src="/assets/img/2000x2000-gif3.gif">
    </div>
<script src="/gm-tools/tien-kiem-van-dao/g100k.js?time=<? echo $t;?>"></script>
<?php require_once('../../foot.php'); ?>