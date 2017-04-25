<div id="main" class="c-section text-center">
    <div class="container">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
	<?php $i=0; foreach($nicks AS $cat) { if(isset($cat[0])){ $i++?>
		<li role="presentation" class="<?php if($i==1){echo 'active';}?>">
            <a href="#rank_<?php echo $cat[0]->cat_id;?>" aria-controls="#rank_<?php echo $cat[0]->cat_id;?>" role="tab" data-toggle="tab">
                Rank <?php echo $cat[0]->cat_title;?>
            </a>
        </li>
	<?php  }} ?>
        
    </ul>

    <div class="row tab-content">
	<?php $i=0; foreach($nicks AS $cat) { if(isset($cat[0])){ $i++?>
        <div role="tabpanel" class="tab-pane fade in <?php if($i==1){echo 'active';}?>" id="rank_<?php echo $cat[0]->cat_id;?>">
            <?php $i = 0; foreach($cat AS $ass){ $i++;
                $url = parse_url($ass->ass_github);
                ?>
                <div class="col-sm-4">
                    <div class="assembly_inline">
                        <a class="" href="<?php echo site_url('home/nick/'.$ass->ass_id.'');?>">
							<img src="<?php echo $ass->ass_image;?>" />
						</a>
						<a href="<?php echo site_url('home/mua_nick/'.$ass->ass_id.'');?>" class="btn btn-danger btn_buy" style="width: 100%; border-radius: 0"><?php echo number_format($ass->ass_github);?>đ - Mua ngay</a>
                        <h3><a class="" href="<?php echo site_url('home/nick/'.$ass->ass_id.'');?>"><?php echo $ass->ass_title;?></a></h3>
                    </div>
                </div>

            <?php if($i%3 == 0){echo '<div class="clearfix"></div>';} } ?>
        </div>
	<?php }} ?>
    </div>
</div>
</div>