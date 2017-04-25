 
<a href="<?php echo site_url('tc/reset_bxh');?>"  onclick="return  confirm('Bảng xếp hạng tháng sẽ bị reset. Bạn chắc chắn muốn thực hiện thao tác này chứ?')" class="btn btn-danger">Reset bảng xếp hạng tháng</a>
<?php 
echo form_open($this->uri->uri_string());?>
	<div class="form-group">
		<label for="baotri" class="col-md-2 control-label">Bảo trì:</label>
		<div class="col-md-10">
		   <select name="baotri" class="form-control">
			<option value="ko" <?php if($configs->baotri == "ko"){echo 'selected';}?>>Không</option>
			<option value="co" <?php if($configs->baotri == "co"){echo 'selected';}?>>Có</option>
		   </select>
		</div>
	</div>
	
	<div class="form-group">
		<label for="napthe" class="col-md-2 control-label">Hệ thống nạp thẻ:</label>
		<div class="col-md-10">
		   <select name="napthe" class="form-control">
			<option value="gamebank" <?php if($configs->napthe == "gamebank"){echo 'selected';}?>>Gamebank</option>
			<option value="mega" <?php if($configs->napthe == "mega"){echo 'selected';}?>>Mega</option>
		   </select>
		</div>
	</div>
	<div class="form-group">
		<label for="hometitle" class="col-md-2 control-label">Tiêu đề trang chủ:</label>
		<div class="col-md-10">
		   <input name="hometitle" class="form-control" type="text" value="<?php echo $configs->hometitle;?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="stream" class="col-md-2 control-label">Link stream:</label>
		<div class="col-md-10">
		   <input name="stream" class="form-control" type="text" value="<?php echo $configs->stream;?>" />
		   Link là http://talktv.vn/thuesub chỉ cần nhập thuesub. Tắt stream thì bỏ trống.<br><br>
		</div>
	</div>
	
	<div class="form-group">
		<label for="thongbao" class="col-md-2 control-label">Thông báo đầu trang :</label>
		<div class="col-md-10">
		   <input name="thongbao" class="form-control" type="text" value="<?php echo $configs->thongbao;?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="popup_title" class="col-md-2 control-label">Tiêu đề thông báo popup:</label>
		<div class="col-md-10">
		   <input name="popup_title" class="form-control" type="text" value="<?php echo $configs->popup_title;?>" placeholder="Thông báo"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for="popup_content" class="col-md-2 control-label">Nội dung thông báo popup:</label>
		<div class="col-md-10">
		   <input name="popup_content" class="form-control" type="text" value="<?php echo $configs->popup_content;?>" placeholder="Thông báo nội dung"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for="popup_time" class="col-md-2 control-label">Bao nhiêu GIÂY hiện popup 1 lần:</label>
		<div class="col-md-10">
		   <input name="popup_time" class="form-control" type="number" value="<?php echo $configs->popup_time;?>" placeholder="1"/>
		</div>
	</div>
	
	
	<div class="form-group">
		<label for="authnote" class="col-md-2 control-label">Lưu ý AuthKey:</label>
		<div class="col-md-10">
		   <input name="authnote" class="form-control" type="text" value="<?php echo $configs->authnote;?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="hwid" class="col-md-2 control-label">HWID là gì:</label>
		<div class="col-md-10">
		   <input name="hwid" class="form-control" type="text" value="<?php echo $configs->hwid;?>" />
		</div>
	</div>
	
	
	<div class="form-group">
		<label for="tile_lo" class="col-md-2 control-label">Tỉ lệ ăn lô:</label>
		<div class="col-md-10">
		   <input name="tile_lo" class="form-control" type="number" step="0.1" value="<?php echo $configs->tile_lo;?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="duatop" class="col-md-2 control-label">Nội dung đua top:</label>
		<div class="col-md-10">
		   <input name="duatop" class="form-control" type="text" value="<?php echo $configs->duatop;?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="title_hd" class="col-md-2 control-label">Tiêu đề Hướng dẫn :</label>
		<div class="col-md-10">
		   <input name="title_hd" class="form-control" type="text" value="<?php echo $configs->title_hd;?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="title_video" class="col-md-2 control-label">Tiêu đề Video hướng dẫn :</label>
		<div class="col-md-10">
		   <input name="title_video" class="form-control" type="text" value="<?php echo $configs->title_video;?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="hd_youtube" class="col-md-2 control-label">ID video youtube:</label>
		<div class="col-md-10">
		   <input name="hd_youtube" class="form-control" type="text" value="<?php echo $configs->hd_youtube;?>" placeholder="Chỉ viết ID youtube, ví dụ RlmK8l6-YFk"/>
		</div>
	</div>
	<div class="form-group">
		<label for="huongdan" class="col-md-2 control-label"><?php echo form_label('Nội dung', 'huongdan'); ?></label>
		<div class="col-md-10">
			<textarea name="huongdan" class="ckeditor" id="editor1"><?php echo  $configs->huongdan;?></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<label for="tuanthang" class="col-md-2 control-label"><?php echo form_label('Thuê Tuần, Tháng', 'tuanthang'); ?></label>
		<div class="col-md-10">
			<textarea name="tuanthang" class="ckeditor" id="editor2"><?php echo  $configs->tuanthang;?></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<label for="title_cn" class="col-md-2 control-label">Tiêu đề chức năng tool :</label>
		<div class="col-md-10">
		   <input name="title_cn" class="form-control" type="text" value="<?php echo $configs->title_cn;?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="video_cn" class="col-md-2 control-label">ID video chức năng:</label>
		<div class="col-md-10">
		   <input name="video_cn" class="form-control" type="text" value="<?php echo $configs->video_cn;?>" placeholder="Chỉ viết ID youtube, ví dụ RlmK8l6-YFk"/>
		</div>
	</div>
	<div class="form-group">
		<label for="huongdan" class="col-md-2 control-label"><?php echo form_label('Nội dung chức năng tool', 'chucnang'); ?></label>
		<div class="col-md-10">
			<textarea name="chucnang" class="ckeditor" id="editor2"><?php echo  $configs->chucnang;?></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<label for="goi" class="col-md-2 control-label"><?php echo form_label('Gói thuê', 'goi'); ?></label>
		<div class="col-md-10">
			<textarea name="goi" class="form-control"><?php echo  $configs->goi;?></textarea>
		</div>
	</div>
	<div class="clearfix"></div><br><br>
	<div class="form-group">
	
		   <input class="form-control btn btn-success" type="submit" value="OK" />
	</div>
</form>