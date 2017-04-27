<h1><?php echo $title;?></h1>
<hr>
<?php echo form_open($this->uri->uri_string(),'class=""');?>
	<div class="form-group">
		<label for="time_id">Khung giờ cho thuê</label>
		<br/>
		<select name='time_id'>
			<option value='0'>Chọn 1 Khung giờ</option>
			<?php if($time) foreach ($time as $k => $vl) { ?>
			<option value='<?=$vl->id?>' > <?=$vl->time_name?> </option>
			<?php } ?>
		</select>

	</div>
	<div class="form-group">
		<label for="acc_id">Acc cho thuê</label>
		<br/>
		<select name='acc_id'>
			<option value='0'>Chọn 1 Acc</option>
			<?php if($acc) foreach ($acc as $k => $vl) { ?>
			<option value='<?=$vl->acc_id?>' > <?=$vl->acc_name?> </option>
			<?php } ?>
		</select>

	</div>
	<div class="form-group">
		<label for="hired_price">Giá cho thuê</label>
		<input type="text" class="form-control" id="hired_price" placeholder="" name="hired_price" required >
	</div>
	<div class="form-group">
		<input class="form-control btn btn-success" type="submit" value="OK" >
	</div>
</form>