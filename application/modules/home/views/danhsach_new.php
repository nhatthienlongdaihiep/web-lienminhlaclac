<?php 
function cmp($a, $b){
	$ae = $a[count($a)-1]->h_stop_time;
	$be = $b[count($b)-1]->h_stop_time;
	if ($ae == $be) {
		return 0;
	}
	return ($ae < $be) ? -1 : 1;
}
?>
<div class="hr"></div>

<!-- BEGIN OF LOAD DANH SACH THUE ======================== -->
<div id="main" class="c-section text-center danhsach_acc">
	<div class="container">
		<div class="" id="dangthue">
			<div class="dangthue_content">
			</div>
		</div>		
		<span style="color:#fff;font-size:30px;"><br>Tài khoản đang được sử dụng </span>
		<span style="color:#fff;font-size:16px;"><br>( Ấn "Đặt trước" - khi tới giờ thì nhận key trong mục "Đã thuê" )</span>
		<div class="row">
			<div class="col-sm-3" id="acc_22">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 22</strong></span>
						<div class="acc_stt">Khung giờ: 10:00 - 12:00 <br>Bắt đầu thuê đc lúc 10:00 26/04<br></div> 
						<form action="<?=PATH_URL?>home/thuengay_new" class="ajax_form" method="post" accept-charset="utf-8">				
							<input type="hidden" name="goi_id" value="3">
							<input type="hidden" name="acc_id" value="18">
							<input type="hidden" name="tgian" value="0">
							<select name="goi" class="my_select" required>
								<option value="10000"> 10.000đ/2h &nbsp;&nbsp; </option>
							</select>
							<button type="submit" class="my_button">Đặt trước</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-3" id="acc_31">
				<div class="acc_border">
					<div class="acc_inline" style="background: #084808">
						<div class="pull-left trangthai">Đang chờ</div>
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 31</strong></span>
						<div class="acc_stt">
							<a href="http://localhost/lienminhlaclac/home/dathue">Click vào đây để xem chi tiết thời gian Bắt đầu và Kết thúc.</a>
						</div> 
						<button class="my_button">Đã có người đặt</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3" id="acc_17">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 22</strong></span>
						<div class="acc_stt">Khung giờ: 10:00 - 12:00 <br>Bắt đầu thuê đc lúc 10:00 26/04<br></div> 
						<form action="http://localhost/lienminhlaclac/home/thuengay" class="ajax_form" method="post" accept-charset="utf-8">				
							<input type="hidden" name="acc_id" value="22">
							<input type="hidden" name="tgian" value="1478102686">
							<select name="goi" class="my_select" required="">
								<option value="10000"> 10.000đ/2h &nbsp;&nbsp; </option>
							</select>
							<button type="submit" class="my_button">Đặt trước</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-3" id="acc_29">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 29</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 23:44 02/11<br></div>
						<form action="http://localhost/lienminhlaclac/home/thuengay" class="ajax_form" method="post" accept-charset="utf-8">				
							<input type="hidden" name="acc_id" value="29">
							<input type="hidden" name="tgian" value="1478104168">
							<select name="goi" class="my_select" required="">
								<option value="0"> 5,000đ/3h &nbsp;&nbsp;</option>
								<option value="1"> 10,000đ/7h &nbsp;&nbsp;</option>
								<option value="2"> 15,000đ/10.5h &nbsp;&nbsp; </option>
								<option value="3"> 20,000đ/14h &nbsp;&nbsp; </option>
								<option value="4"> 30,000đ/24h &nbsp;&nbsp; </option>
								<option value="5"> 60,000đ/48h &nbsp;&nbsp; </option>
							</select>
							<button type="submit" class="my_button">Đặt trước</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-3" id="acc_28">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 28</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 23:45 02/11<br></div> 
						<form action="http://localhost/lienminhlaclac/home/thuengay" class="ajax_form" method="post" accept-charset="utf-8">
							<input type="hidden" name="acc_id" value="28">
							<input type="hidden" name="tgian" value="1478104213">
							<select name="goi" class="my_select" required="">
								<option value="0"> 5,000đ/3h &nbsp;&nbsp;</option>
								<option value="1"> 10,000đ/7h &nbsp;&nbsp;</option>
								<option value="2"> 15,000đ/10.5h &nbsp;&nbsp; </option>
								<option value="3"> 20,000đ/14h &nbsp;&nbsp; </option>
								<option value="4"> 30,000đ/24h &nbsp;&nbsp; </option>
								<option value="5"> 60,000đ/48h &nbsp;&nbsp; </option>
							</select>
							<button type="submit" class="my_button">Đặt trước</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-3" id="acc_7">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 7</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 23:52 02/11<br></div> 
						<form action="http://localhost/lienminhlaclac/home/thuengay" class="ajax_form" method="post" accept-charset="utf-8">
							<input type="hidden" name="acc_id" value="7">
							<input type="hidden" name="tgian" value="1478104665">
							<select name="goi" class="my_select" required="">
								<option value="0"> 5,000đ/3h &nbsp;&nbsp;</option>
								<option value="1"> 10,000đ/7h &nbsp;&nbsp;</option>
								<option value="2"> 15,000đ/10.5h &nbsp;&nbsp; </option>
								<option value="3"> 20,000đ/14h &nbsp;&nbsp; </option>
								<option value="4"> 30,000đ/24h &nbsp;&nbsp; </option>
								<option value="5"> 60,000đ/48h &nbsp;&nbsp; </option>
							</select>
							<button type="submit" class="my_button">Đặt trước</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3" id="acc_6">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 6</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 01:45 03/11<br></div> 
						<form action="http://localhost/lienminhlaclac/home/thuengay" class="ajax_form" method="post" accept-charset="utf-8">				
							<input type="hidden" name="acc_id" value="6">
							<input type="hidden" name="tgian" value="1478111453">
							<select name="goi" class="my_select" required="">
								<option value="0"> 5,000đ/3h &nbsp;&nbsp;</option>
								<option value="1"> 10,000đ/7h &nbsp;&nbsp;</option>
								<option value="2"> 15,000đ/10.5h &nbsp;&nbsp; </option>
								<option value="3"> 20,000đ/14h &nbsp;&nbsp; </option>
								<option value="4"> 30,000đ/24h &nbsp;&nbsp; </option>
								<option value="5"> 60,000đ/48h &nbsp;&nbsp; </option>
							</select>
							<button type="submit" class="my_button">Đặt trước</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-3" id="acc_23">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 23</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 02:23 03/11<br></div> 
						<form action="http://localhost/lienminhlaclac/home/thuengay" class="ajax_form" method="post" accept-charset="utf-8">
							<input type="hidden" name="acc_id" value="23">
							<input type="hidden" name="tgian" value="1478113737">
							<select name="goi" class="my_select" required="">
								<option value="0"> 5,000đ/3h &nbsp;&nbsp;</option>
								<option value="1"> 10,000đ/7h &nbsp;&nbsp;</option>
								<option value="2"> 15,000đ/10.5h &nbsp;&nbsp; </option>
								<option value="3"> 20,000đ/14h &nbsp;&nbsp; </option>
								<option value="4"> 30,000đ/24h &nbsp;&nbsp; </option>
								<option value="5"> 60,000đ/48h &nbsp;&nbsp; </option>
							</select>
							<button type="submit" class="my_button">Đặt trước</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-3" id="acc_4">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 4</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 02:41 03/11<br></div> 
						<button class="my_button">Đã có người đặt</button>
					</div>
				</div>
			</div>

			<div class="col-sm-3" id="acc_14">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 14</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 02:52 03/11<br></div> 
						<button class="my_button">Đã có người đặt</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3" id="acc_11">
				<div class="acc_border">
					<div class="acc_inline" style="background: #084808">
						<div class="pull-left trangthai">Đang chờ</div>
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 11</strong></span>
						<div class="acc_stt"><a href="http://localhost/lienminhlaclac/home/dathue">Click vào đây để xem chi tiết thời gian Bắt đầu và Kết thúc.</a></div> 
						<button class="my_button">Đã có người đặt</button>
					</div>
				</div>
			</div>
			<div class="col-sm-3" id="acc_34">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+1 Giờ chơi sáng</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 34</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 05:13 03/11<br></div> 
						<button class="my_button">Đã có người đặt</button>
					</div>
				</div>
			</div>
			<div class="col-sm-3" id="acc_21">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+1 Giờ chơi sáng</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 21</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 05:49 03/11<br></div> 
						<form action="http://localhost/lienminhlaclac/home/thuengay" class="ajax_form" method="post" accept-charset="utf-8">
							<input type="hidden" name="acc_id" value="21">
							<input type="hidden" name="tgian" value="1478126056">
							<select name="goi" class="my_select" required="">
								<option value="0"> 5,000đ/3h &nbsp;&nbsp;</option>
								<option value="1"> 10,000đ/7h &nbsp;&nbsp;</option>
								<option value="2"> 15,000đ/10.5h &nbsp;&nbsp; </option>
								<option value="3"> 20,000đ/14h &nbsp;&nbsp; </option>
								<option value="4"> 30,000đ/24h &nbsp;&nbsp; </option>
								<option value="5"> 60,000đ/48h &nbsp;&nbsp; </option>
							</select>
							<button type="submit" class="my_button">Đặt trước</button>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-3" id="acc_15">
				<div class="acc_border">
					<div class="acc_inline">
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 15</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 16:44 03/11<br></div> 
						<button class="my_button">Đã có người đặt</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3" id="acc_20">
				<div class="acc_border">
					<div class="acc_inline">
						<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>
						<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản 20</strong></span>
						<div class="acc_stt">Còn lại: <span class="countdown_time">00:00:00</span> <br>+15phút chờ đổi key<br>Thuê đc lúc 23:54 04/11<br></div> 
						<button class="my_button">Đã có người đặt</button>
					</div>
				</div>
			</div>
		</div>

		<div class="clearfix"></div>
		<p class="text-justify" id="hwid_la_gi" style="margin-top: 40px"></p>
	</div>
</div>

<!-- END OF LOAD DANH SACH THUE ======================== -->
 
<script type="text/javascript">
$(document).ready(function(){
	$(".ajax_form").each(function(){
		var frm = $(this);
		frm.submit(function (ev) {
			
			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				dataType: 'json',
				success: function (e) {
				   swal({title: e.title, text: e.mess, type: e.stt, html:true},function(){ 
					   window.location.href = '<?php echo site_url('home/dathue');?>';
				   }
				   );
				}
			});
			ev.preventDefault();
		});
		
	});
	
	$("#hwid").click(function() {
	event.preventDefault();
	 $('body').animate({
		scrollTop: $("#hwid_la_gi").offset().top - 80
	 }, 500);
	});
});
</script>
