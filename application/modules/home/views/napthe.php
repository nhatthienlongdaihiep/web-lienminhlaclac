<div class="c-section text-center danhsach_acc">
    <div class="container text-center">
		<?php echo form_open(site_url('home/ajax_napthe'), 'id="fnapthe_mega"');?>
		<select name="telcoCode" class="my_select no_padding" required>
					<option value="VTT">Thẻ Vietel</option>
					<option value="VMS">Thẻ Mobifone</option>
					<option value="VNP">Thẻ Vinaphone</option>
					<option value="ONC">Thẻ Oncash</option> 
					<option value="MGC">Thẻ Megacard</option>
					<option value="FPT">Thẻ Gate</option>
					<option value="ZING">Thẻ ZING</option> 
					
				</select>
</br>
	
		<input name="cardSerial" class="my_select no_padding" placeholder="Số seri" style="max-width: 140px" required/>
	        <input name="cardPin" class="my_select no_padding" placeholder="Mã thẻ" style="max-width: 140px" required/>

		<input name="ma_bao_mat" class="my_select no_padding" placeholder="Nhập mã bên cạnh" style="max-width: 140px" required/> 				<img class="my_select" style="margin-top: 10px; width: 100px; padding: 0" src="<?php echo site_url();?>/captcha/CaptchaSecurityImages.php?height=28" id="captcha"/>
		<button class="my_button">NẠP NGAY</button>
		<?php echo form_close();?>
		<br/>
		<div class="label label-success" id="msg_success_napthe_mega"></div>
		<div class="label label-danger" id="msg_err_napthe_mega"></div>
		<div id="loading_napthe_mega" style="display: none;"><img src="<?php echo site_url();?>img/loading.gif" style="width: 50px; border: 0;"/> &nbsp;Xin mời chờ...</div>	
	
	</div>
</div>

<script>
	$(document).ready(function() {
		 // nap the
		$("#fnapthe_mega").ajaxForm({
			dataType : 'json',
			url: '<?php echo site_url('home/ajax_napthe');?>',
			beforeSubmit : function() {
				$("#loading_napthe_mega").show();
			},
			success: function(data) {
				if(data.code == 0) {
					$("#fnapthemega").resetForm();
					$("#msg_success_napthe_mega").html(data.msg);
					$("#msg_err_napthe_mega").html('');
					$("#user_credit").html(data.user_credit);
					var delay = 3000; //Your delay in milliseconds
					setTimeout(function(){ window.location = '<?php echo site_url();?>' }, delay);
				}
				else {
					$("#msg_err_napthe_mega").html(data.msg);
					$("#msg_success_napthe_mega").html('');
				}
				$("#loading_napthe_mega").hide();
				$("#captcha_mega").attr('src', 'captcha/CaptchaSecurityImages.php?' + Math.random());
			}
		});
	});
</script>