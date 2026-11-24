<div class="list-group">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel" style="color:red; text-">Timeline</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body">
                <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                        <?php $noti = $ketnoi->query("SELECT * FROM `thongbao` ORDER BY id desc ");
                                    while ($row = mysqli_fetch_array($noti)) 
                                { ?>
                            <div class="vertical-timeline-item vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in">
                                        <i class="badge badge-dot badge-dot-xl badge-<?=$row['status'];?>"> </i>
                                    </span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title text-<?=$row['status'];?>"><?=$row['title'];?></h4>
                                        <p><?=$row['content'];?></p>
                                        <span class="vertical-timeline-element-date"><?=$row['createdate'];?></span>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div> 
             </div>
          </div>
       </div>
    </div>
    <script type="text/javascript">
    $(window).on('load', function() {
        $('#exampleModal').modal('show');
    });
    </script>
    <div class="row">
        <?php while ($row = mysqli_fetch_array($result)) { ?>
        <div class="col-md-6"> 
            <div class="blog-list"> 
                <ul> 
                    <li> 
                        <div class="row no-gutters shadow border-radius-10 post-box-custom"> 
                            <div class="col-lg-4 col-md-12 col-sm-12"> 
                                <div class="p-2 text-center"> 
                                <? if($row['baotri'] == "ON") { ?>
                                    <img src="<?=$row['img'];?>" class="border-radius-10 avatar-baotri avatar-sm me-3"  alt="xd">
                                <? } else { ?>
                                    <img src="<?=$row['img'];?>" class="border-radius-10 avatar avatar-sm me-3"  alt="xd">
                                <? } ?>
                                </div> 
                            </div> 
                            <div class="col-lg-8 col-md-12 col-sm-12"> 
                                <div class="blog-caption"> 
                                    <h5 class="text-center border-radius-10">
                                        <a href="#">
                                            <span class="badge rounded-pill bg-warning text-dark "><?=$row['title'];?></span>
                                            <? if($row['baotri'] == "ON") { ?>
                                            <span class="badge bg-danger text-dark"> <i class="bi bi-tools icon-custom"></i> BẢO TRÌ</span>
                                            <? } ?>
                                        </a>
                                    </h5> 
                                    <div class="blog-by"> <p style="font-weight: bold;" class="mb-0"> 
                                        <i class="bi bi-shield-check icon-custom"></i> 
                                        <span>Mã Game: </span> 
                                        <span><?=$row['code'];?></span> </p> 
                                        <p style="font-weight: bold;" class="mb-0">
                                        <i class="bi bi-shield-check icon-custom"></i> 
                                        <span>Mô Tả: </span> 
                                        <span><?=$row['note']?></span> </p> 
                                        <p style="font-weight: bold;" class="mb-0">
                                        <i class="bi bi-shield-check icon-custom"></i> 
                                        <span class="badge bg-info text-dark"><?=$row['badge']?></span> </p> 
                                        
                                    </div> 
                                </div> 
                            </div> 
                            <div class="col-lg-12 col-md-12 col-sm-12 p-2">
                                <? if($row['baotri'] == "ON") { ?>
                                <div class="btn-list text-center">
									<a  type="button" class="btn btn btn-dark intro-box" disabled="true">Tải APK <i class="fa fa-android"></i></a>
									 <? if($row['ios'] == "1") { ?>
									
									<? } else {?>
									<a type="button"  class="btn btn-success intro-box" >Tải IOS <i class="fa fa-apple" aria-hidden="true"></i></a>
									<? } ?>
									<a type="button"  class="btn btn-danger intro-box">Tools GM <i class="fa fa-cogs" aria-hidden="true"></i></a>
									<a type="button"  class="btn btn-warning intro-box">Mua Tools <i class="fa fa-credit-card" aria-hidden="true"></i></a>

								</div>
                                <? } else {?>
                                <div class="btn-list text-center ">
									<a href="<?=$row['dowload'];?>" type="button" class="btn btn btn-dark intro-box" >Tải APK <i class="fa fa-android"></i></a>
									 <? if($row['ios'] == "1") { ?>
									
									<? } else {?>
									<a type="button" href="<?=$row['ios'];?>" class="btn btn-success intro-box" >Tải IOS <i class="fa fa-apple" aria-hidden="true"></i></a>
									<a type="button" href="<?=$row['ipa'];?>" class="btn btn-info intro-box" >Tải IPA <i class="fa fa-apple" aria-hidden="true"></i></a>
									<? } ?>
									<a type="button" href="<?=$row['gmtools'];?>" class="btn btn-danger intro-box">Tools GM <i class="fa fa-cogs" aria-hidden="true"></i></a>
									<a type="button" href="/mua-tools" class="btn btn-warning intro-box">Mua Tools <i class="fa fa-credit-card" aria-hidden="true"></i></a>

								</div>
                                <? } ?>
                            </div> 
                        </div> 
                    </li> 
                </ul>
            </div> 
        </div>
        <?php }?>
    </div>
</div>