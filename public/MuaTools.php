<?php 
require_once('../head.php');
include('../session.php');
?>
<title>Mua GM Tools | <?=$site['site_tenweb'];?></title>
<?php require_once('../sidebar.php');?>
<?php $result = $ketnoi->query("SELECT * FROM `category` WHERE `display` = 'show'"); ?>
<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Mua GM Tools</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Mua Tools</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mua GM Tools Full Vật Phẩm</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
            <!-- Default Basic Forms Start -->
        <div class="row"> 
            <div class="col-md-8 col-sm-12"> 
                <div class="card-box mb-30"> 
                <div class="pd-20"> 
                    <div class="alert alert-info mt-2" role="alert">
                        <i class="fa fa-bell"></i> Nhập đúng tên Nhân Vật, ID Nhân Vật hoặc tên Tài Khoản, nếu không biết hãy liên hệ Admin để được hỗ trợ 
                    </div> 
                    <form id="MuaTools" method="post">
                    <div class="form-group"> 
                        <label for="" class="control-label">Chọn Game:</label> 
                        <select class="custom-select form-control" name="tengame" id="tengame" required="" onchange="checkinfo(this)"> 
                            <option value="">-- Game Opening --</option>
                            <?php while ($row = mysqli_fetch_array($result)) { 
                                        if($row['baotri'] == 'OFF') {?>
                            <option value="<?=$row['code'];?>"><?=$row['title'];?></option>
                            
                            <?php } }?>
                        </select>
                    </div> 
                <div class="form-group"> 
                    <label for="" class="control-label">Chọn Sever:</label> 
                    <select class="custom-select form-control" name="idsever" id="idsever" required=""> 
                        <option value="">-- Sever Game --</option> 
                    </select> 
                </div> 
                <div class="form-group"> 
                        <label for="" class="control-label">Nhập Thông Tin GM TOOLS:</label> <br>
                        <small style="color:red;" id="infogm"></small>
                        <input type="text" name="roleid" class="form-control is-valid"> 
                </div> 
            </div>
            </div> 
                                <div class="p-2 text-center"> 
                                    <img src="/upload/g100k.png" class="border-radius-10 avatar avatar-sm me-3" id="img" alt="xd">
                                </div> 
            </div>
            <div class="col-md-4 col-sm-12"> 
                <div class="card-box mb-30 pd-20"> 
                    <h5 class="text-center">Kiểm tra & Thanh toán</h5> 
                    <div class="card-body mt-2 text-center"> 
                        <p>Tổng tiền: <span style="color:red;font-weight:500" id="tongtien" name="tongtien">0</span> </p> 
                        <div class="form-group mt-2"> 
                            <input type="text" id="codedis" name="codedis" class="form-control mb-2" onkeyup="discount()"  value="Mã giảm giá (Nếu có)" disabled="true">
                            <input type="text" id="codedishide" name="codedishide" class="form-control mb-2" hidden="true">
                            <small style="color:red;" id="dis"></small>
                            </div> 
                            <button name="payment" class="btn btn-success" id="payment"><i class="fa fa-credit-card"></i> Thanh Toán </button>
                        </div> 
                        
                    </div> 
                    <div class="card-box mb-30 pd-20"> 
                        <h5 class="text-center">Cam kết</h5> 
                        <div class="card-body mt-2"> 
                            <p><i class="fa fa-check mr-2" style="color: yellowgreen;"></i> Cập nhật tools trong vòng 3s</p> 
                            <p><i class="fa fa-check mr-2" style="color: yellowgreen;"></i> 1 Nhân Vật/ 1 Tools</p> 
                            <p><i class="fa fa-check mr-2" style="color: yellowgreen;"></i> Tools không giới hạn số lượng</p> 
                            <p><i class="fa fa-check mr-2" style="color: yellowgreen;"></i> Vật phẩm nào dùng được thì tools số lượng nhiều, trường hợp không dùng được mà tools số lượng lớn bị lỗi Admin không chịu trách nhiệm</p> 
                            <p><i class="fa fa-check mr-2" style="color: yellowgreen;"></i> Có thể yêu cầu hỗ trợ khi Tools bị lỗi</p> 
                        </div> 
                    </div> 
                </div> 
            </div>
            </form>
            <div id="loading" >
                <img src="/assets/img/2000x2000-gif3.gif">
            </div>
            
</div>
<script type="text/javascript">
(function () {
  let currentToken = 0;

  // Hiển thị hoặc ẩn overlay
  function toggleLoading(show = true) {
    const overlay = document.getElementById('loadingOverlay');
    if (!overlay) return;
    overlay.style.display = show ? 'flex' : 'none';
  }

  function postText(url, data) {
    return $.post(url, data).then(
      (r) => (typeof r === "string" ? r : String(r)),
      (xhr) => {
        const msg = xhr?.responseText || "Lỗi kết nối máy chủ";
        return $.Deferred().reject(new Error(msg)).promise();
      }
    );
  }

  function fillServers(selectEl, count) {
    let n = parseInt(count, 10);
    if (!Number.isFinite(n) || n < 1) n = 1;
    if (n > 5000) n = 5000;

    selectEl.options.length = 0;
    const fragment = document.createDocumentFragment();
    for (let i = 1; i <= n; i++) {
      const option = document.createElement("option");
      option.value = String(i);
      option.textContent = `S${i}-G100K`;
      fragment.appendChild(option);
    }
    selectEl.appendChild(fragment);
  }

  window.checkinfo = function(obj) {
    const tongtien = document.getElementById('tongtien');
    const infogm = document.getElementById('infogm');
    const img = document.getElementById('img');
    const idsever = document.getElementById('idsever');
    const codedis = document.getElementById('codedis');
    const value = obj?.value || '';

    const token = ++currentToken;
    if (codedis) codedis.disabled = true;

   $("#loading").show(); // 🔹 Bật loading

    const reqMoney = postText('/api/checkinfo.php', { tengame: value, check: 'money' });
    const reqBadge = postText('/api/checkinfo.php', { tengame: value, check: 'badge' });
    const reqNumServer = postText('/api/checkinfo.php', { tengame: value, check: 'num_server' });
    const reqImg = postText('/api/checkinfo.php', { tengame: value, check: 'img' });

    reqMoney.then((r) => {
      if (token !== currentToken) return;
      tongtien.innerHTML = r;
    }).catch(() => tongtien.innerHTML = '—');

    reqBadge.then((r) => {
      if (token !== currentToken) return;
      infogm.textContent = `*${r}`;
    }).catch(() => infogm.textContent = '*—');

    reqNumServer.then((r) => {
      if (token !== currentToken) return;
      fillServers(idsever, r);
    }).catch(() => fillServers(idsever, 1));

    reqImg.then((r) => {
      if (token !== currentToken) return;
      const url = String(r || '').trim();
      if (url) {
        img.src = url;
        img.classList.remove('hidden');
      } else img.classList.add('hidden');
    }).catch(() => img.classList.add('hidden'));

    // 🔹 Khi tất cả request hoàn tất (thành công hoặc lỗi)
    Promise.allSettled([reqMoney, reqBadge, reqNumServer, reqImg]).then(() => {
      if (token !== currentToken) return;
      $("#loading").hide(); // 🔹 Tắt loading
      if (codedis) codedis.disabled = false;
    });
  };
})();

function discount() {
    var dis = document.getElementById('dis');
    const codedis = document.getElementById('codedis');
    $('#codedishide').val($('#codedis').val());
    $(function() {
        dis.innerHTML = "Đang Kiểm Tra ........";
        $.post('/api/checkdiscount.php', {
            codedis: $('#codedis').val()
        }, function(r) {
            if (r == 1) {
                dis.innerHTML = 'Code Không Hợp Lệ Vui Lòng Nhập Lại !!';
            } else if (r != 1) {
                dis.innerHTML = r.toString();
                cuteToast({
                    type: "info",
                    message: r.toString(),
                    timer: 2500
                });
                var tongtien = $('#tongtien').html().replace('.', '');
                $.post('/api/discount.php', {
                    codedis: $('#codedis').val(),
                    tongtien: tongtien
                }, function(r) {
                    if (r == 2) {
                        $('#tongtien').html(('#tongtien').val());
                    } else {
                        codedis.disabled = true;
                        $('#tongtien').html(r);
                    }
                });
            }
        });
    });

}
</script>
<script>
    $(document).ready(function() {
        $("#MuaTools").submit(function(e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: "https://g100k.net/model/mua-tools.php",
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $("#loading").show();
                },
                success: function(data) {
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
<?php require_once('../foot.php');?>