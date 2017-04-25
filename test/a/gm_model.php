<?php  

class gm_model extends CI_Model{
	public function friendly_url($title){
		$aPattern = array (
            "a" => "á|à|ạ|ả|ã|ă|ắ|ằ|ặ|ẳ|ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Á|À|Ạ|Ả|Ã|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ",
            "o" => "ó|ò|ọ|ỏ|õ|ô|ố|ồ|ộ|ổ|ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ó|Ò|Ọ|Ỏ|Õ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ",
            "e" => "é|è|ẹ|ẻ|ẽ|ê|ế|ề|ệ|ể|ễ|É|È|Ẹ|Ẻ|Ẽ|Ê|Ế|Ề|Ệ|Ể|Ễ",
            "u" => "ú|ù|ụ|ủ|ũ|ư|ứ|ừ|ự|ử|ữ|Ú|Ù|Ụ|Ủ|Ũ|Ư|Ứ|Ừ|Ự|Ử|Ữ",
            "i" => "í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ",
            "y" => "ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ",
            "d" => "đ|Đ",
        );
        while(list($key,$value) = each($aPattern))
        {
            $title = @ereg_replace($value, $key, $title);
        }
		$title = strtr(
			$title,
			'`!"$%^&*()-+={}[]<>;:@#~,./?|' . "\r\n\t\\",
			'                             ' . '    '
		);
		$title = strtr($title, array('"' => '', "'" => ''));


		$title = preg_replace('/[^a-zA-Z0-9_ -]/', '', $title);

		$title = preg_replace('/[ ]+/', '-', trim($title));

		return strtr($title, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
	}	
	
	function int_to_string($number){
		
		return $number;
	
	}
}