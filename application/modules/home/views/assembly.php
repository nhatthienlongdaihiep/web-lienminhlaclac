<div id="main" class="c-section text-left assembly_view">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4 col-sm-12">
                <img class="ass_img" src="<?php echo $ass->ass_image;?>" alt="<?php echo $ass->ass_title;?>" />
				
            </div>
            <div class="col-md-8 col-sm-12">
                <h2><?php echo $ass->ass_title;?></h2>
				<?php if($ass->ass_active == 1){ ?>
					<a class="col-xs-12 text-center" href="<?php echo site_url('home/mua_nick/'.$ass->ass_id.'');?>" style="background: #821428; padding: 10px 0;">
						<span class="glyphicon glyphicon-download-alt"></span> <?php echo number_format($ass->ass_github);?>đ Mua ngay
					</a>
				<?php }  else { ?>
					<a class="col-xs-12 text-center" style="background: #821428; padding: 10px 0;">
						<span class="glyphicon glyphicon-download-alt"></span> <?php echo number_format($ass->ass_github);?>đ Đã bán
					</a>
				<?php } ?>
            </div>
			
        </div>
		<div class="clearfix"></div>
		<br/>
		<hr/>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?php echo $ass->ass_content;?>
	
        </div>
        <div class="col-md-4">
			<h2>Có thể bạn sẽ thích</h2>
            <ul class="random_assemblies">
            <?php foreach($random_ass AS $ass){?>
                <li>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <a class="" href="<?php echo site_url('home/nick/'.$ass->ass_id.'');?>">
                                <img class="ass_img" src="<?php echo $ass->ass_image;?>" />
                            </a>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <h3>
                                <a class="" href="<?php echo site_url('home/nick/'.$ass->ass_id.'');?>">
                                    <?php echo $ass->ass_title;?>
                                </a>
                            </h3>
                        </div>
                    </div>
                </li>
            <?php } ?>
            </ul>
        </div>
    </div>
</div>