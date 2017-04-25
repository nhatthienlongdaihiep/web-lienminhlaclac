<h1><?php echo $title;?></h1>
<hr>
<?php echo form_open($this->uri->uri_string(),'class=""');?>
	<div class="form-group">
		<label for="acc_name">Tên khung giờ</label>
		<input type="text" class="form-control" id="time_name" placeholder="" name="time_name" required value="<?=$time->time_name?>">
	</div>
	<div class="form-group">
		<label for="acc_name">Giờ bắt đầu</label>
		<input type="text" class="form-control" id="time_start" placeholder="" name="time_start" required value="<?=$time->time_start?>">
	</div>
	<div class="form-group">
		<label for="acc_name">Giờ kết thúc</label>
		<input type="text" class="form-control" id="time_end" placeholder="" name="time_end" required value="<?=$time->time_end?>">
	</div>
	<div class="form-group">
		<input class="form-control btn btn-success" type="submit" value="OK" >
	</div>
</form>

<script type="text/javascript">

$(document).ready(function(){
	console.log('sdadas');
})

</script>