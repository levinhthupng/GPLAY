$(document).ready(function () {
    // Ẩn loading ban đầu
    $('#loading').hide();
    // Gửi AJAX request khi người dùng click vào dropdown
    $('#mailid').on('show.bs.select', function () {
        // Kiểm tra xem đã tải item chưa, nếu chưa thì tải
        if ($('#mailid').find('option').length === 1) {
            // Hiển thị "loading" khi bắt đầu tải
            $('#loading').show();

            // Gửi AJAX request đến `load_items.php`
            $.ajax({
                url: '/gm-tools/dau-la-dai-luc/user/load_items.php', // Link đến file PHP xử lý
                method: 'GET',
                success: function (response) {
                    // Kiểm tra xem dữ liệu có hợp lệ không
                    if (response) {
                        // Thêm các item vào dropdown
                        $('#mailid').append(response);
                        $('#mailid').selectpicker('refresh');
                    } else {
                        cuteToast({
                            type: "error",
                            message: "Items Not Found !!!",
                            timer: 2500
                        });
                    }
                    // Ẩn loading khi hoàn thành
                    $('#loading').hide();
                },
                error: function () {
                    cuteToast({
                        type: "error",
                        message: "Failed to load items. !!!",
                        timer: 2500
                    });
                    $('#loading').hide();
                }
            });
        }
    });
});

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
            extraParam = "&type=clearbag"; // Tham số mặc định
        } else if (buttonId === "manvip") {
            extraParam = "&type=manvip"; // Tham số mặc định
        } else if (buttonId === "closeinfo") {
            extraParam = "&type=closeinfo"; // Tham số mặc định
        } else if (buttonId === "yijian") {
            extraParam = "&type=yijian"; // Tham số mặc định
        } else if (buttonId === "clearrolemail") {
            extraParam = "&type=clearrolemail"; // Tham số mặc định
        } else if (buttonId === "clearresource") {
            extraParam = "&type=clearresource"; // Tham số mặc định
        } else if (buttonId === "clearstone") {
            extraParam = "&type=clearstone"; // Tham số mặc định
        } else if (buttonId === "clearherb") {
            extraParam = "&type=clearherb"; // Tham số mặc định
        } else if (buttonId === "yijianpff") {
            extraParam = "&type=yijianpff"; // Tham số mặc định
        } else if (buttonId === "yijianchenghao") {
            extraParam = "&type=yijianchenghao"; // Tham số mặc định
        } else if (buttonId === "ptyj") {
            extraParam = "&type=ptyj"; // Tham số mặc định
        } else if (buttonId === "yijiansz") {
            extraParam = "&type=yijiansz"; // Tham số mặc định
        } else if (buttonId === "yijianjs") {
            extraParam = "&type=yijianjs"; // Tham số mặc định
        } else if (buttonId === "yjhs") {
            extraParam = "&type=yjhs"; // Tham số mặc định
        } else if (buttonId === "yijiantp") {
            extraParam = "&type=yijiantp"; // Tham số mặc định
        } else if (buttonId === "yijiantp2") {
            extraParam = "&type=yijiantp2"; // Tham số mặc định
        } else if (buttonId === "yijianhl") {
            extraParam = "&type=yijianhl"; // Tham số mặc định
        } else if (buttonId === "jyyj") {
            extraParam = "&type=jyyj"; // Tham số mặc định
        } else if (buttonId === "ssyj") {
            extraParam = "&type=ssyj"; // Tham số mặc định
        }

        // Disable button khi bắt đầu xử lý
        button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...');

        // Thu thập dữ liệu từ form và thêm tham số
        const formData = $("#GMTools").serialize() + extraParam;

        $.ajax({
            url: "/gm-tools/dau-la-dai-luc/user/gmquery.php",
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