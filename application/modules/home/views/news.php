<div id="main" class="c-section text-justify">
    <div class="container">
    <div class="row">
		<div class="col-md-12">
			<?php foreach($news AS $n){ ?>
				<div class="news_item" id="news_<?php echo $n->n_id;?>">
					<div class="col-md-5">
					<?php $url = $this->gm_model->friendly_url($n->n_title);?>
						<a href="<?php echo site_url('view/'.$n->n_id.'-'.$url.'.html');?>">
						<img src="<?php echo $n->n_image;?>" style="width: 100%" alt="<?php echo $n->n_title;?>"/>
						</a>
					</div>
					<div class="col-md-7">
					<h2><a href="<?php echo site_url('view/'.$n->n_id.'-'.$url.'.html');?>"><?php echo $n->n_title;?></a></h2>
					<div class="extra_info">Thời gian: <?php echo date("H:i d/m/Y", $n->n_time);?>. Sửa lần cuối: <?php echo date("H:i d/m/Y", $n->n_last_edit);?>
					</div>
					<div class="description"><?php echo $n->n_description;?></div>
					</div>
				</div>
				<div class="clearfix"></div>
			<?php } ?>
		</div> 
	</div>
</div>
</div>