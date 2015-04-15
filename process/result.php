<?php
	include_once("dbman.php");
	// store johari window result information
	$key 	= isset($_POST['key'])?$_POST['key']:"";

    if($key == ""){
    	exit;
    }

	try {
	    $conn = DBManager::getConnection();
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = $conn->prepare("SELECT players, my_features, your_features, features FROM johari_results WHERE keyparam = :key");
	    $sql->bindParam(":key", $key);
	    $sql->execute();
	    $result = $sql->fetch(PDO::FETCH_ASSOC);
	    if($result){
	    	echo "{
	    		\"players\": {$result['players']},
	    		\"myFeatures\": {$result['my_features']},
	    		\"yourFeatures\": {$result['your_features']},
	    		\"features\": {$result['features']}
	    	}";
		}else{
    		echo "{\"error\": \"結果が表示できません\"}";
		}
	}catch(PDOException $e){
		$message = $e->getMessage();
    	echo "{\"error\": \"$message\"}";
    }
?>