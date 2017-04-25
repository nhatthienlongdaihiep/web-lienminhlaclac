<h1><?php echo $title;?></h1>
<hr>
<?php echo form_open($this->uri->uri_string(),'class=""');?>
	<div class="form-group">
		<label for="acc_name">Tên tài khoản</label>
		<input type="text" class="form-control" id="acc_name" placeholder="" name="acc_name" required value="<?php echo $acc->acc_name;?>">
	</div>
	<div class="form-group">
		<label for="acc_pass">Auth key</label>
		<input type="text" class="form-control" id="acc_pass" placeholder="" name="acc_pass" required value="<?php echo $acc->acc_pass;?>">
	</div>
	<div class="form-group">
		<input class="form-control btn btn-success" type="submit" value="OK" >
	</div>
</form>