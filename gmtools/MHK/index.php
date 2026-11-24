<?php
require_once('../../head.php');
?>
    <title>Man Hoang Ký H5 GM Tools | <?= $site['site_tenweb']; ?></title>
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
                    <h4>Man Hoang Ký H5 GM Tools</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">GM Tools</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Man Hoang Ký H5 Tools Full Vật Phẩm</li>
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
                    <i class="fa fa-bell"></i> MAN HOANG KÝ H5 <i class="fa fa-bell"></i>
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
                        <label for="" class="control-label">Nhập Tên Tài Khoản Game:</label> <br>
                        <input type="text" id="uid" name="uid" class="form-control is-valid">
                    </div>
                    <div class="alert alert-danger mt-2" style="text-align: center;" role="alert">
                        <i class="fa fa-bell"></i> Nạp Free <i class="fa fa-bell"></i>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Chọn Vật Phẩm:</label>
                        <select class="selectpicker form-control show-tick" id="charetype" name="charetype"
                                data-live-search="true" data-size="5">
                            <option value="">-- Chọn Vật Phẩm --</option>
                            <?php
                            // Đọc file free.txt
                            $file = fopen("./user/free.txt", "r");
                            while (!feof($file)) {
                                $line = fgets($file);
                                $txts = explode(';', $line);
                                echo '<option value="' . htmlspecialchars($txts[0]) . '">' . htmlspecialchars($txts[1]) . '</option>';
                            }
                            fclose($file);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nhập Số Lượng:</label> <br>
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
                        <button class="btn btn-danger g100k" id="NapFree" name="NapFree" type="button"><i
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
                    <div class="form-group">
                        <button class="btn btn-warning g100k" id="ClearBag" name="ClearBag" type="button"><i
                                    class="fa fa-credit-card"></i> Xóa Ba Lô
                        </button>
                    </div>
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
                        <i class="fa fa-bell"></i> Gửi Vật Phẩm <i class="fa fa-bell"></i>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Chọn Vật Phẩm:</label>
                        <select class="selectpicker form-control show-tick" name="mailid"
                                data-live-search="true" data-size="5">
                            <option value="">-- Chọn Vật Phẩm --</option>
                            <?php
                            // Kiểm tra file tồn tại trước khi mở
                            $file_path = "./user/item.txt";
                            if (file_exists($file_path) && is_readable($file_path)) {
                                $file = fopen($file_path, "r"); // Mở file
                                while (($line = fgets($file)) !== false) { // Đọc từng dòng
                                    // Tách dữ liệu dòng đọc được
                                    $txts = explode(';', $line);
                                    // Đảm bảo mảng có ít nhất 2 phần tử
                                    if (count($txts) >= 2) {
                                        $value = htmlspecialchars(trim($txts[0])); // Xử lý giá trị value
                                        $label = htmlspecialchars(trim($txts[1])); // Xử lý văn bản hiển thị
                                        echo '<option value="' . $value . '">' . $label . '</option>';
                                    }
                                }
                                fclose($file); // Đóng file
                            } else {
                                echo '<option value="">Không thể đọc file item.txt</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nhập Số Lượng:</label> <br>
                        <input type="text" name="mailnum" class="form-control is-valid">
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
                    <div class="alert alert-info mt-2" style="text-align: center;" role="alert">
                        <i class="fa fa-bell"></i> Cộng Xu <i class="fa fa-bell"></i>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nhập Số Xu:</label> <br>
                        <small style="color:red;" id="infogm"></small>
                        <input type="text" name="coin" class="form-control is-valid">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-info g100k" id="AddXu" name="AddXu" type="button"><i
                                    class="fa fa-credit-card"></i> Cộng Xu
                        </button>
                    </div>
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
    <script>
        $(document).ready(function () {
            // Lắng nghe sự kiện click trên các nút
            $("button.g100k").click(function (e) {
                e.preventDefault();
                const button = $(this); // Lấy nút được nhấn
                const buttonId = button.attr("id"); // Lấy ID của nút
                let extraParam = "";

                // Lưu nội dung gốc của nút
                const originalContent = button.html();

                // Thay đổi tham số dựa trên ID của nút
                if (buttonId === "NapFree") {
                    extraParam = "&type=charge"; // Tham số cho nút NapFree
                } else if (buttonId === "SendMail") {
                    extraParam = "&type=daoju"; // Tham số cho nút khác
                } else if (buttonId === "AddXu") {
                    extraParam = "&type=AddXu"; // Tham số mặc định
                } else if (buttonId === "ClearBag") {
                    extraParam = "&type=ClearItem"; // Tham số mặc định
                }

                // Disable button khi bắt đầu xử lý
                button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...');

                // Thu thập dữ liệu từ form và thêm tham số
                const formData = $("#GMTools").serialize() + extraParam;

                $.ajax({
                    url: "https://g100k.net/gmtools/MHK/user/gmquery.php",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    cache: false,
                    beforeSend: function () {
                        $("#loading").show();
                    },
                    success: function (data) {
                        cuteToast({
                            type: data.type,
                            message: data.msg,
                            timer: 2500
                        });

                        if (data.status === 0) {
                            $("#loading").hide();
                        } else {
                            setTimeout(() => {
                                location.href = data.url;
                            }, 2500);
                            $("#loading").hide();
                        }
                    },
                    error: function () {
                        cuteToast({
                            type: "error",
                            message: "Server Bảo Trì !!!",
                            timer: 2500
                        });
                        $("#loading").hide();
                    },
                    complete: function () {
                        // Enable lại nút và khôi phục nội dung nút
                        button.prop("disabled", false).html(originalContent);
                    }
                });
            });
        });
    </script>
<?php require_once('../../foot.php'); ?>