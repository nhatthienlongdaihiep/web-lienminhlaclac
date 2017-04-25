<div id="main" class="c-section">
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<header class="c-section__header">
				<h2 class="c-section__title u-text-gradient text-center">Đăng nhập hoặc đăng ký</h2>
			</header>
			<?php if(!empty($this->session->flashdata('login_notice'))){
				echo '<p class="text-center">'.$this->session->flashdata('login_notice').'</p>';
			} ?>
			
			<?php echo form_open(site_url('home/dangnhap_tk'), 'class="form-horizontal"');?>
			<div class="form-group">
				<label for="user_login" class="col-sm-3 control-label">Tên đăng nhập</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control"  maxlength="50" name="user_login" id="user_login" placeholder="Ví dụ: GStar">
				</div>
			</div>
			<div class="form-group" id="tenthat" style="display: none;">
				<label for="user_name" class="col-sm-3 control-label">Tên của bạn</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control"  maxlength="50" name="user_name" id="user_name" placeholder="Ví dụ: Trần Thành Công">
				</div>
			</div>
			<div class="form-group">
				<label for="user_name" class="col-sm-3 control-label">Mật khẩu</label>
				<div class="col-sm-9">
				  <input type="password" class="form-control" name="user_password" id="user_name">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
				<button type="submit" class="btn btn-default col-sm-12">Đăng nhập/Đăng ký</button>
				</div>
			</div>
			<?php echo form_close(); ?>
			<p class="text-center">
			Bạn chỉ cần nhập tài khoản và mật khẩu để đăng nhập<br/>
			Nếu đăng nhập sai và chưa có ai sử dụng tên tài khoản này thì sẽ tự động đăng ký mới.
			</p>
		</div>
		<div class="col-md-4">
			<header class="c-section__header">
				<h2 class="c-section__title u-text-gradient text-center">Dùng TK Facebook</h2>
			</header>
			<div class="text-justify" style="color: red">Chức năng này dành cho các thành viên trước ngày 26/5 đăng nhập vào tài khoản của mình. Nếu bạn không đăng nhập được bằng tài khoản FB mà trong
tài khoản đó vẫn còn tiền. Hãy tạo tài khoản (bằng form phía bên cạnh) và nhắn tin cho chúng tôi bằng khung chat bên dưới. Nội dung ghi tên FB, tên tài khoản mới để mình cộng lại tiền vào tài khoản mới.</div>
			<a  href="<?php echo site_url('home/dangnhap_fb');?>" title="Đăng nhập bằng tài khoản FB"><img src="<?php echo site_url();?>style/img/fblogin.png" alt="Facebook login" width="100%"/></a>
		</div>
	</div>
</div>
</div>