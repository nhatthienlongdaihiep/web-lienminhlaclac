<div class="c-section c-section--no-padding c-section--no-gradient c-section--bg-updates" style="padding-bottom: 18px; margin-bottom: -1px">
<div class="container">
<br>
<?php if(!empty($this->session->flashdata('error'))){
	echo $this->session->flashdata('error');
	}?>
<?php echo form_open($this->uri->uri_string());?>
	<div class="form-group">
		<label for="username">Tên tài khoản ở web cũ</label>
		<input type="text" class="form-control" id="username" placeholder="Tên tài khoản ở web cũ" name="username" required>
	</div>
	<div class="form-group">
		<label for="password">Mật khẩu ở web cũ</label>
		<input type="password" class="form-control" id="password" placeholder="Mật khẩu ở web cũ" name="password" required>
	</div>
	
	<div class="form-group">
		<input type="submit" class="form-control btn btn-danger" value="Nhận tiền">
	</div>
</form>
</div>
</div>
