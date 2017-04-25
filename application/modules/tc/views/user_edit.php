<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>
<div class="col-md-11">
    <div class="main-content col-content radius bg-white">
        <h1 class="text-center"><?php echo $title;?></h1>
        <hr/>
        <?php echo form_open($this->uri->uri_string(), 'role="form" class="form-horizontal"'); ?>
        <div class="form-group">
            <label for="user_id" class="col-md-2 control-label">User ID:</label>
            <div class="col-md-10">
                 <strong class="form-control" style="border: none"> <?php echo $user->user_id; ?></strong>
            </div>
        </div>
        <div class="form-group">
            <label for="user_name" class="col-md-2 control-label">Username:</label>
            <div class="col-md-10">
                <strong class="form-control" style="border: none"><?php echo $user->user_name; ?></strong>
            </div>
        </div>
		<div class="form-group">
            <label for="sogio" class="col-md-2 control-label">Số giờ thuê:</label>
            <div class="col-md-10">
				<strong class="form-control" style="border: none"> <?php echo $user->user_sogio; ?></a></strong>
            </div>
        </div>
		<div class="form-group">
            <label for="user_name" class="col-md-2 control-label">Facebook:</label>
            <div class="col-md-10">
                <strong class="form-control" style="border: none"><a href="https://www.facebook.com/<?php echo $user->user_fb_id; ?>" target="_blank">
				<img src="http://graph.facebook.com/<?php echo $user->user_fb_id; ?>/picture?type=square" />
				<?php echo $user->user_name; ?></a></strong>
            </div>
        </div>

        
		
		<div class="form-group">
            <label for="user_credit" class="col-md-2 control-label">Số tiền có</label>
            <div class="col-md-10">
                <input type="number" name="user_credit" class="form-control" value="<?php echo $user->user_credit;?>"/>
            </div>
        </div>
		
		<div class="form-group">
            <label for="user_no" class="col-md-2 control-label">Số tiền nợ: </label>
            <div class="col-md-10">
                <input type="number" name="user_no" class="form-control" value="<?php echo $user->user_no;?>"/>
            </div>
        </div>
		
		<div class="form-group">
            <label for="cat_cat_id" class="col-md-2 control-label">Mật khẩu mới:</label>
            <div class="col-md-10">
                <input type="text" name="user_password" class="form-control" placeholder="Bỏ trống nếu ko đổi" />
            </div>
        </div>
		
        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                <?php echo form_submit('submit', 'Lưu', 'class="btn btn-danger"  style="width: 100%"'); ?>
            </div>
        </div>
		
		
        <?php echo form_close();?>
		

		<table class="table">
		<thead>
			<tr>
				<th width="70px">Số TT</th>
				<th>ID</th>
				<th>Cộng/trừ</th>
				<th width="100px">Số tiền</th>
				<th>Nội dung</th>
				<th>Thời gian</th>
			</tr>
		</thead>
		<tbody>
			<?php $stt = 0; foreach($logs AS $l) : $stt++; ?>
				<tr>
					<td><?php echo $stt;?></td>
					<td><?php echo $l->c_id;?></td>
					<td><?php if($l->c_updown == 0) {echo '-';} elseif($l->c_updown == 1) {echo '+';} else {echo '?';}?></td>
					<td><?php echo number_format($l->c_amount);?></td>
					<td><?php echo $l->c_notice;?></td>
					<td><?php echo date("d/m/Y H:i:s", $l->c_time);?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
		</table>

    </div>
</div>
