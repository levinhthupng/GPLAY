<?php require_once('../head.php');?>
<title>PayPal | <?=$site['site_tenweb'];?></title>
<?php require_once('../sidebar.php');?>
<div class="mobile-menu-overlay"></div>
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>PayPal</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Nạp Tiền</a></li>
                                <li class="breadcrumb-item active" aria-current="page">PayPal</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            
            <div class="row"> 
                <div class="col-lg-7"> 
                    <div class="card-box mb-30"> 
                    <div class="pd-20"> 
                        <h3 class="text-blue">PayPal</h3> 
                        <div class="alert alert-info mt-2" role="alert">
                            <i class="fa fa-bell"></i> 1USD = 25000VND 
                        </div> 
                        <div id="smart-button-container">
    <div style="text-align: center"><label for="description"> </label><input type="text" name="descriptionInput" id="description" maxlength="127" value=""></div>
      <p id="descriptionError" style="visibility: hidden; color:red; text-align: center;">Please enter a description</p>
    <div style="text-align: center"><label for="amount"> </label><input name="amountInput" type="number" id="amount" value="" ><span> USD</span></div>
      <p id="priceLabelError" style="visibility: hidden; color:red; text-align: center;">Please enter a price</p>
    <div id="invoiceidDiv" style="text-align: center; display: none;"><label for="invoiceid"> </label><input name="invoiceid" maxlength="127" type="text" id="invoiceid" value="" ></div>
      <p id="invoiceidError" style="visibility: hidden; color:red; text-align: center;">Please enter an Invoice ID</p>
    <div style="text-align: center; margin-top: 0.625rem;" id="paypal-button-container"></div>
  </div>
  <script src="https://www.paypal.com/sdk/js?client-id=Ae2VRbKHGKBO0a--4VOiJokPW3zw5RScyPz1eYror3EsHVDzM5-ZpEFgWMOw_OSa1LQ8YhKUMn66HCKl&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
  <script>
  function initPayPalButton() {
    var description = document.querySelector('#smart-button-container #description');
    var amount = document.querySelector('#smart-button-container #amount');
    var descriptionError = document.querySelector('#smart-button-container #descriptionError');
    var priceError = document.querySelector('#smart-button-container #priceLabelError');
    var invoiceid = document.querySelector('#smart-button-container #invoiceid');
    var invoiceidError = document.querySelector('#smart-button-container #invoiceidError');
    var invoiceidDiv = document.querySelector('#smart-button-container #invoiceidDiv');

    var elArr = [description, amount];

    if (invoiceidDiv.firstChild.innerHTML.length > 1) {
      invoiceidDiv.style.display = "block";
    }

    var purchase_units = [];
    purchase_units[0] = {};
    purchase_units[0].amount = {};

    function validate(event) {
      return event.value.length > 0;
    }

    paypal.Buttons({
      style: {
        color: 'gold',
        shape: 'rect',
        label: 'paypal',
        layout: 'vertical',
        
      },

      onInit: function (data, actions) {
        actions.disable();

        if(invoiceidDiv.style.display === "block") {
          elArr.push(invoiceid);
        }

        elArr.forEach(function (item) {
          item.addEventListener('keyup', function (event) {
            var result = elArr.every(validate);
            if (result) {
              actions.enable();
            } else {
              actions.disable();
            }
          });
        });
      },

      onClick: function () {
        if (description.value.length < 1) {
          descriptionError.style.visibility = "visible";
        } else {
          descriptionError.style.visibility = "hidden";
        }

        if (amount.value.length < 1) {
          priceError.style.visibility = "visible";
        } else {
          priceError.style.visibility = "hidden";
        }

        if (invoiceid.value.length < 1 && invoiceidDiv.style.display === "block") {
          invoiceidError.style.visibility = "visible";
        } else {
          invoiceidError.style.visibility = "hidden";
        }

        purchase_units[0].description = description.value;
        purchase_units[0].amount.value = amount.value;

        if(invoiceid.value !== '') {
          purchase_units[0].invoice_id = invoiceid.value;
        }
      },

      createOrder: function (data, actions) {
        return actions.order.create({
          purchase_units: purchase_units,
        });
      },

      onApprove: function (data, actions) {
        return actions.order.capture().then(function (orderData) {

          // Full available details
          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

          // Show a success message within this page, e.g.
          const element = document.getElementById('paypal-button-container');
          element.innerHTML = '';
          element.innerHTML = '<h3>Thank you for your payment!</h3>';

          // Or go to another URL:  actions.redirect('thank_you.html');
          
        });
      },

      onError: function (err) {
        console.log(err);
      }
    }).render('#paypal-button-container');
  }
  initPayPalButton();
  </script>
                        </div>
                </div> 
                <div class="col-lg-5"> 
                    <div class="card-box mb-30"> 
                        <div class="pd-20"> 
                            <h5>Lưu ý</h5>
                            <h5>
                                <ul style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; outline: 0px; border: 0px; list-style-position: inside; font-family: roboto, Arial, Tahoma, sans-serif, arial, Helvetica; font-size: 14px;">
                                    <li style="padding: 0px; margin: 0px; outline: 0px; border: 0px;">
                                        <font color="#ff0000"><b>Chiết khấu thẻ là <?=$site_ck_card;?>%</b></font>
                                    </li>
                                </ul>
                            </h5>
                            <ul style="padding: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; outline: 0px; border: 0px; list-style-position: inside; font-family: roboto, Arial, Tahoma, sans-serif, arial, Helvetica; font-size: 14px;">
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