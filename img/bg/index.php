<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$sql = "SELECT * from acc";
$faq = $db_handle->runQuery($sql);

$sql2 = "SELECT * from history LEFT JOIN `user` ON(`user`.`user_id` = `history`.`h_user_id`) LEFT JOIN `acc` ON(`acc`.`acc_id` = `history`.`h_acc_id`) ORDER BY `history`.`h_stt` DESC, `history`.`h_time` DESC LIMIT 0, 200";
$hs = $db_handle->runQuery($sql2);

$sql3 = "SELECT * from user";
$us = $db_handle->runQuery($sql3);
?>
<html>
    <head>
	<meta charset="utf-8" />
	<meta http-equiv="refresh" content="30">
      <title>Lầu 5 góc</title>
		<style>
			body{width:610px;}
			.current-row{background-color:#B24926;color:#FFF;}
			.current-col{background-color:#1b1b1b;color:#FFF;}
			.tbl-qa{width: 100%;font-size:0.9em;background-color: #f5f5f5;}
			.tbl-qa th.table-header {padding: 5px;text-align: left;padding:10px;}
			.tbl-qa .table-row td {padding:10px;background-color: #FDFDFD;}
		</style>
		<script type="text/javascript">
		(function(p,u,s,h){
		p._pcq=p._pcq||[];
		p._pcq.push(['_currentTime',Date.now()]);
		s=u.createElement('script');
		s.type='text/javascript';
		s.async=true;
		s.src='https://cdn.pushcrew.com/js/ff0c926dead1c2c4d62422d3820d00dd.js';
		h=u.getElementsByTagName('script')[0];
		h.parentNode.insertBefore(s,h);
		})(window,document);
		</script>

		
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script>
		// function showEdit(editableObj) {
			// $(editableObj).css("background","#FFF");
		// } 
		
		// function saveToDatabase(editableObj,column,id) {
			// $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
			// $.ajax({
				// url: "saveedit.php",
				// type: "POST",
				// data:'column='+column+'&editval='+editableObj.innerHTML+'&acc_id='+id,
				// success: function(data){
					// $(editableObj).css("background","#FDFDFD");
				// }        
		   // });
		// }
		</script>
    </head>
    <body>		
	   <table class="tbl-qa">
		  <thead>
			  <tr>
				<th  class="table-header" >Acc ID</th>
				<th  class="table-header" >Acc UID</th>
				<th  class="table-header" >Acc name</th>
				<th  class="table-header">Pass</th>
				<th  class="table-header">Aid</th>
				<th  class="table-header">Xem email</th>
				<th  class="table-header">Trạng thái</th>
			  </tr>
		  </thead>
		  <tbody>
		  <?php
		  $coi = 0;
		  foreach($faq as $k=>$v) {
			  if($v['acc_stt'] == 'CHODOIPASS') {
				  $coi = 1;
			  }
		  ?>
			  <tr class="table-row" >
				<td><?php echo $faq[$k]["acc_id"]; ?></td>
				<td><?php echo $faq[$k]["acc_uid"]; ?></td>
				<td><?php echo $faq[$k]["acc_name"]; ?></td>
				<td><?php echo substr($faq[$k]["acc_pass"], 0, 5); ?>...</td>
				<td contenteditable="true" onBlur="saveToDatabase(this,'acc_aid','<?php echo $faq[$k]["acc_id"]; ?>')" onClick="showEdit(this);"><?php echo $faq[$k]["acc_aid"]; ?></td>
				<td><a href="https://mail.google.com/mail/u/<?php echo $faq[$k]["acc_email"]; ?>/#inbox"><?php echo $faq[$k]["acc_email"]; ?></a></td>
		  <td><?php if($faq[$k]["acc_stt"] == 'CHOHWID' && $faq[$k]["acc_time_ready"] <= time()) {echo 'ROI';} else {echo $faq[$k]["acc_stt"];} ?>
		  
		  <?php if($faq[$k]['acc_stt'] == "CHODOIPASS") {

	echo '<a href="https://toollm.com/ilovejoduska.php?n='.$faq[$k]["acc_name"].'&u='.$faq[$k]["acc_uid"].'&a='.$faq[$k]["acc_aid"].'">Đổi pass</a>';
		  }?></td>

			  </tr>
		<?php 
		}
		?>
		  </tbody>
		</table>
		<?php //if($coi == 1){ } ?>
		
		<table class="tbl-qa">
		  <thead>
			  <tr>
				<th  class="table-header">User ID</th>
				<th  class="table-header">Acc ID</th>
				<th  class="table-header">Acc name</th>
				<th  class="table-header">Start</th>
				<th  class="table-header">Stop</th>
				<th  class="table-header">Price</th>
				<th  class="table-header">Status</th>
			  </tr>
		  </thead>
		  <tbody><?php foreach($hs AS $h) : ?>
			<tr>
				<td><?php echo $h['h_user_id']; echo ' - '; echo '<a target="_blank" href="https://www.facebook.com/'.$h['user_fb_id'].'">'.$h['user_name'].'</a>';?></td>
				<td><?php echo $h['acc_id'];?></td>
				<td><?php echo $h['acc_name'];?></td>
				<td><?php echo date("d/m H:i", $h['h_start_time']);?></td>
				<td><?php echo date("d/m/Y H:i", $h['h_stop_time']);?></td>
				<td><?php echo number_format($h['h_price']);?></td>
				<td><?php echo $h['h_stt'];?></td>
			</tr>
			<?php endforeach;?>
		  </tbody>
		  </table>
		  <?php //foreach($us AS $u){
			  // echo '<a href="https://www.facebook.com/'.$u['user_fb_id'].'" target="_blank">'.$u['user_name'].'</a><br/>';
		  // } ?>
    </body>
</html>
