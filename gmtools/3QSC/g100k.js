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
                url: '/gm-tools/3q-soai-ca/user/load_items.php', // Link đến file PHP xử lý
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
            extraParam = "&type=mail"; // Tham số cho nút khác
        } else if (buttonId === "AddXu") {
            extraParam = "&type=AddXu"; // Tham số mặc định
        } else if (buttonId === "ClearBag") {
            extraParam = "&type=clearbag"; // Tham số mặc định
        }

        // Disable button khi bắt đầu xử lý
        button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...');

        // Thu thập dữ liệu từ form và thêm tham số
        const formData = $("#GMTools").serialize() + extraParam;
        $.ajax({
            url: "/gm-tools/3q-soai-ca/user/gmquery.php",
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