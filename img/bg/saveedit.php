<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$result = mysql_query("UPDATE `acc` SET `" . $_POST["column"] . "` = '".strip_tags($_POST["editval"])."', `acc_stt` = 'ROI' WHERE  `acc_id`=".$_POST["acc_id"]);

?>