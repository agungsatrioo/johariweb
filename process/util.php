<?php

	function get_key_string(){
		return substr(base_convert(md5(uniqid()), 16, 36), 0, 16);
	}

?>