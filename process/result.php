<?php
	include_once("dbman.php");
	// store johari window result information
	$test_key 	 = isset($_POST['test_key'])?$_POST['test_key']:"";
	$member_key = isset($_POST['member_key'])?$_POST['member_key']:"";

    if($test_key == "" && $member_key == ""){
    	die;
    }

	try {
		$features;

	    $conn = DBManager::getConnection();
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    $sql = $conn->prepare("SELECT features FROM johari_tests WHERE test_key = :test_key");
	    $sql->bindParam(":test_key", $test_key);
	    $sql->execute();
	    $result = $sql->fetch(PDO::FETCH_ASSOC);

	    if($result){
	    	$features = $result["features"];
	    }else{
    		echo "{\"error\": \"結果が表示できません\"}";
    		die;
	    }


	    $sql = $conn->prepare("SELECT name, my_features, your_features FROM johari_members WHERE test_key = :test_key and member_key = :member_key");
	    $sql->bindParam(":test_key", $test_key);
	    $sql->bindParam(":member_key", $member_key);
	    $sql->execute();
	    $result = $sql->fetch(PDO::FETCH_ASSOC);
	    if($result){
	    	echo "{
	    		\"players\": [\"{$result['name']}\"],
	    		\"myFeatures\": {$result['my_features']},
	    		\"yourFeatures\": {$result['your_features']},
	    		\"features\": $features
	    	}";
		}else{
    		echo "{\"error\": \"結果が表示できません\"}";
    		die;
		}
	}catch(PDOException $e){
		$message = $e->getMessage();
    	echo "{\"error\": \"$message\"}";
    	die;
    }
?>