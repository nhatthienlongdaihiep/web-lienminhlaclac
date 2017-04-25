<div class="c-section c-section--no-padding c-section--no-gradient c-section--bg-updates" style="padding-bottom: 18px; margin-bottom: -1px">
<div class="container" style="padding-top: 50px">
	<div class="row">
		<div class="col-md-3" style="display: inline-flex">
			<img src="<?php echo site_url('style/img/68.png');?>" style="width: 100%" />
		</div>
		<div class="col-md-9">
		<div class="col-md-offset-2">
		<?php if($this->session->flashdata('thongbao')){ echo $this->session->flashdata('thongbao');}?>
			<h2>Thể lệ trò chơi</h2>
			- Thời gian tham dự từ 20h tối hôm trước tới 18h tối hôm sau.<br>
			- Mở thưởng lúc 18h30' hàng ngày. Tiền sẽ được tự động cộng vào tài khoản lúc 19h.<br>
			- Bạn có thể chơi nhiều số khác nhau bằng cách đặt cược nhiều lần.</br>
			- Bạn trúng thưởng gấp <?php echo $cf->tile_lo;?> nếu số bạn chọn trùng với 1 trong 27 kết quả xổ số Miền Bắc.<br>
			- Ví dụ: Ghi lô 68 - 1 con = 10k. Nếu kết quả lô có 2 số cuối là 68 thì Tiền thắng: 10k x <?php echo $cf->tile_lo;?> = <?php echo 10*$cf->tile_lo;?>k, nếu có N lần 2 chữ số cuối là 68 thì Tiền thắng là: 10k x <?php echo $cf->tile_lo;?> x N.<br>
			- Kết quả lấy nguồn từ <a href="http://xskt.com.vn" target="_blank" style="color: #f9c850">http://xskt.com.vn</a><br><br>
			</div>
		<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"');?>
			<div class="form-group">
				<label for="g_so" class="col-md-2 control-label">Con số</label>
				<div class="col-md-10">
				  <input type="number" name="g_so" min="0" max="99" class="form-control" id="g_so" placeholder="Chọn 1 số từ 00 đến 99">
				</div>
			</div>
			<div class="hr"></div>
			<div class="form-group">
				<label for="g_tien" class="col-md-2 control-label">Đặt cược</label>
				<div class="col-md-10">
				  <input type="number" class="form-control" name="g_tien" step="1000" min="0" max="<?php echo $this->session->userdata('user_credit');?>" id="g_tien" value="<?php echo $this->session->userdata('user_credit');?>">
				</div>
			</div>

			<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
			  <button type="submit" class="btn btn-danger col-md-12">Ghi lại!</button>
			</div>
			</div>
			</form>					
		</div>
	
	</div>
	<div class="row">
		<div class="col-md-12">
			
		</div>
	</div>
</div>
</div>