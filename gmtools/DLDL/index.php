<?php
require_once('../../head.php');
include_once './user/config.php';
?>
    <title>Tân Đấu La | GM Tools | <?= $site['site_tenweb']; ?></title>
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
                    <h4>Tân Đấu La GM Tools</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">GM Tools</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tân Đấu La Tools Full Vật Phẩm</li>
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
                    <div class="alert alert-info mt-2" style="text-align: center;" role="alert">
                        <i class="fa fa-bell"></i> TÂN ĐẤU LA <i class="fa fa-bell"></i>
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
                    <div class="alert alert-danger mt-2" style="text-align: center;" role="alert">
                        <i class="fa fa-bell"></i>- Tools Số lượng ít đủ dùng. <i class="fa fa-bell"></i> </br>
                        <i class="fa fa-bell"></i>- Vật phẩm nào dùng được thì tools số lượng nhiều, trường hợp không
                        dùng được mà tools số lượng lớn bị lỗi Admin không chịu trách nhiệm. <i
                                class="fa fa-bell"></i> </br>
                        <i class="fa fa-bell"></i>- Nếu server Reopen AE vui lòng bấm mua lại tools để được kích hoạc
                        lại tools miễn phí. Lưu ý: Thông tin phải trùng với thông tin trong lịch sử mua tools.<i
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
                            <label for="" class="control-label">Nhập Tên Tài Khoản Game:</label> <br>
                            <input type="text" id="uid" name="uid" class="form-control is-valid">
                        </div>
                        <div class="alert alert-danger mt-2" style="text-align: center;" role="alert">
                            <i class="fa fa-bell"></i> Nạp Free <i class="fa fa-bell"></i>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Chọn Vật Phẩm:</label>
                            <select class="selectpicker form-control show-tick" id="chargetype" name="chargetype"
                                    data-live-search="true" data-size="5">
                                <option value="">-- Chọn Vật Phẩm --</option>
                                <?php
                                $file_path = "yuanbao.txt";

                                // Kiểm tra sự tồn tại và khả năng đọc tệp
                                if (file_exists($file_path) && is_readable($file_path)) {
                                    $file = fopen($file_path, "r");
                                    if ($file) {
                                        // Đọc từng dòng của file
                                        while (($line = fgets($file)) !== false) {
                                            // Phân tách dữ liệu bằng dấu ";"
                                            $txts = explode(';', $line);

                                            // Kiểm tra mảng có chứa ít nhất 2 phần tử
                                            if (count($txts) >= 2) {
                                                // Xử lý chuỗi đầu vào để tránh lỗi
                                                $title = htmlspecialchars(trim($txts[0])); // Dữ liệu hiển thị
                                                $value = htmlspecialchars(trim($txts[1])); // Dữ liệu giá trị

                                                // Xuất ra option
                                                echo '<option value="' . $value . '" title="' . $title . '">' . $title . '</option>';
                                            }
                                        }
                                        fclose($file); // Đóng file sau khi sử dụng
                                    } else {
                                        echo '<option value="">Không thể mở file</option>';
                                    }
                                } else {
                                    echo '<option value="">File không tồn tại hoặc không đọc được</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Nhập Số Lượng:</label> <br>
                            <small style="color:red;" id="infogm"></small>
                            <input type="text" id="chargenum" name="chargenum" class="form-control is-valid">
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
                            <button class="btn g100k btn-danger form-control" id="NapFree" name="NapFree" type="button"><i
                                        class="fa fa-credit-card"></i> Nạp Free
                            </button>
                        </div>
                        <div class="form-group">
                            <button class="btn g100k btn-danger form-control" id="closeinfo" name="closeinfo" type="button"><i
                                        class="fa fa-credit-card"></i> Tắt Hướng Dẫn
                            </button>
                        </div>
                        <div class="form-group">
                            <button class="btn g100k btn-danger form-control" id="manvip" name="manvip" type="button"><i
                                        class="fa fa-credit-card"></i> VIP 20
                            </button>
                        </div>

                        <div class="form-group">
                            <button class="btn g100k btn-danger form-control" id="yijian" name="yijian" type="button"><i
                                        class="fa fa-credit-card"></i> Level 120
                            </button>
                        </div>

                        <script async
                                src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7930717041744833"
                                crossorigin="anonymous"></script>
                        <ins class="adsbygoogle"
                             style="display:block; text-align:center;"
                             data-ad-layout="in-article"
                             data-ad-format="fluid"
                             data-ad-client="ca-pub-7930717041744833"
                             data-ad-slot="9907627297"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                        <div class="form-group">
                            <button class="btn g100k btn-danger form-control" id="ClearBag" name="ClearBag" type="button"><i
                                        class="fa fa-credit-card"></i> Xóa Ba Lô
                            </button>
                        </div>
                        <div class="form-group">
                            <button class="btn g100k btn-danger form-control" id="clearrolemail" name="clearrolemail" type="button"><i
                                        class="fa fa-credit-card"></i> Xóa Thư
                            </button>
                        </div>
                        <div class="form-group">
                            <button class="btn g100k btn-danger form-control" id="clearresource" name="clearresource"
                                    type="button"><i
                                        class="fa fa-credit-card"></i> Xóa Kim Tệ
                            </button>
                        </div>
                        <div class="form-group">
                            <button class="btn g100k btn-danger form-control" id="clearstone" name="clearstone" type="button">
                                <i
                                        class="fa fa-credit-card"></i> Xóa Hồn Cốt
                            </button>
                        </div>
                        <div class="form-group">
                            <button class="btn g100k btn-danger form-control" id="clearherb" name="clearherb" type="button"><i
                                        class="fa fa-credit-card"></i> Xóa Tiên Phẩm
                            </button>
                        </div>
                        <script async
                                src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7930717041744833"
                                crossorigin="anonymous"></script>
                        <ins class="adsbygoogle"
                             style="display:block; text-align:center;"
                             data-ad-layout="in-article"
                             data-ad-format="fluid"
                             data-ad-client="ca-pub-7930717041744833"
                             data-ad-slot="7956251378"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                        <div class="alert alert-success mt-2" style="text-align: center;" role="alert">
                            <i class="fa fa-bell"></i> Gửi Vật Phẩm - Tools VIP <i class="fa fa-bell"></i>
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
                            <button  class="btn g100k btn-success form-control" id="SendMail" name="SendMail"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Gửi Vật Phẩm
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="yijianpff" name="yijianpff"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Mở Ngoại Hình
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="yijianchenghao"
                                    name="yijianchenghao" type="button">
                                <i class="fa fa-credit-card"></i> Gửi Danh Hiệu Và Avata
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="ptyj" name="ptyj"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Vượt Tất Cả Ải Phó Bản
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="yijiansz" name="yijiansz"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Vượt Tất Cả Ải Hải Thần Đảo
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="yijianjs" name="yijianjs"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Vượt Tất Cả Ải Kim Chúc Chi Thành
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="yjhs" name="yjhs"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Gửi Tất Cả Tướng
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="yijiantp" name="yijiantp"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Tướng Max Level
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="yijiantp2" name="yijiantp2"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Gửi Toàn Bộ Ám Khí
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="yijianhl" name="yijianhl"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Gửi Toàn Bộ Hồn Linh
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="jyyj" name="jyyj"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Vượt Tất Cả Phó Bản Tinh Anh
                            </button>
                        </div>
                        <div class="form-group">
                            <button  class="btn g100k btn-success form-control" id="ssyj" name="ssyj"
                                    type="button">
                                <i class="fa fa-credit-card"></i> Vượt Tất Cả Phó Bản Sử Thi
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
    </div>
    <div id="loading">
        <img src="/assets/img/2000x2000-gif3.gif">
    </div>
    <script src="/gm-tools/dau-la-dai-luc/g100k.js?time=<? echo $t;?>"></script>
 <?php require_once('../../foot.php'); ?>