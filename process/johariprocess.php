<?php
	include_once("dbman.php");
	include_once("util.php");

	// store johari window result information
	$players 	= isset($_POST['players'])?json_decode($_POST['players']):"";
	$my_features = isset($_POST['myFeatures'])?json_decode($_POST['myFeatures']):"";
	$your_features = isset($_POST['yourFeatures'])?json_decode($_POST['yourFeatures']):"";
    $features = isset($_POST['features'])?$_POST['features']:"";

    // keys
    $test_key = "";
    $member_keys = array();

    if($players == "" || $my_features == "" || $your_features  == "" || $features == ""){
    	exit;
    }

	try {
	    $conn = DBManager::getConnection();
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    // check duplication
	    while(true){
			$test_key = get_key_string(); 
	    	$sql = $conn->prepare("SELECT * FROM johari_tests WHERE test_key = :key");
	    	$sql->bindParam(":key", $key);
	    	$sql->execute();
	    	if(!$sql->fetch()){
	    		break;
	    	}
	    }

	    // add test data
	    $sql = $conn->prepare("INSERT INTO johari_tests values (null, :test_key, :features)");
	    $sql->bindParam(":test_key", $test_key);
	    $sql->bindParam(":features", $features);
	    $sql->execute();

	    // add players data
	    for($i=0; $i<count($players); $i++) {
	    	$member_key = get_key_string();
	    	$cookie_key = get_key_string();
	    	array_push($member_keys, '"'.$member_key.'"');

	    	$mf = "[" . implode("," ,$my_features[$i]) . "]";
	    	$yf = "[" . implode("," ,$your_features[$i]) . "]";

		    $sql = $conn->prepare("INSERT INTO johari_members values (null, :test_key, :member_key, :cookie_key, :name, :my_features, :your_features)");
		    $sql->bindParam(":test_key", $test_key);
		    $sql->bindParam(":member_key", $member_key);
		    $sql->bindParam(":cookie_key", $cookie_key);
		    $sql->bindParam(":name", $players[$i]);
		    $sql->bindParam(":my_features", $mf);
		    $sql->bindParam(":your_features", $yf);
		    $sql->execute();
	    }

	    $member_keys_string = implode(",", $member_keys);

	     echo "{\"test_key\": \"$test_key\", \"member_keys\": [$member_keys_string]}";
	}catch(PDOException $e){
		$message = $e->getMessage();
    	echo "{\"error\": \"$message\"}";
    }
?>