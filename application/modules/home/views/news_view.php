<div id="main" class="c-section text-left assembly_view ">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4 col-sm-12">
                <img class="ass_img" src="<?php echo $news->n_image;?>" alt="<?php echo $news->n_title;?>" />
				
            </div>
            <div class="col-md-8 col-sm-12">
                <h2><?php echo $news->n_title;?></h2>
                <p class="n_description"><?php echo $news->n_description;?></p>

            </div>
			
        </div>
		<div class="clearfix"></div>
		<br/>
		<hr/>
    </div>
    <div class="row">
        <div class="col-md-8 text-justify">
            <?php echo $news->n_content;?>
			<br/><br/><br/>
			<h3>Để lại bình luận của bạn</h3>
			<div class="fb-comments" data-href="<?php echo site_url().$this->uri->uri_string();?>" data-width="100%" data-colorscheme="dark" data-numposts="5"></div>
        </div>
        <div class="col-md-4">
            <ul class="random_assemblies">
            <?php foreach($random_news AS $news){?>
                <li>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <a class="" href="<?php echo site_url('view/'.$news->n_id.'-'.$this->gm_model->friendly_url($news->n_title).'.html');?>">
                                <img class="ass_img" src="<?php echo $news->n_image;?>" alt="<?php echo $news->n_title;?>"/>
                            </a>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <h3>
                                 <a class="" href="<?php echo site_url('view/'.$news->n_id.'-'.$this->gm_model->friendly_url($news->n_title).'.html');?>">
                                   <?php echo $news->n_title;?>
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