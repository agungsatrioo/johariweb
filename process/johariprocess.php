<?php
	include_once("dbman.php");

	// store johari window result information
	$players 	= isset($_POST['players'])?$_POST['players']:"";
	$my_features = isset($_POST['myFeatures'])?$_POST['myFeatures']:"";
	$your_features = isset($_POST['yourFeatures'])?$_POST['yourFeatures']:"";
    $features = isset($_POST['features'])?$_POST['features']:"";

    if($players == "" || $my_features == "" || $your_features  == "" || $features == ""){
    	exit;
    }

	try {
	    $conn = DBManager::getConnection();
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    // check duplication
	    while(true){
			$key = substr(base_convert(md5(uniqid()), 16, 36), 0, 16);
	    	$sql = $conn->prepare("SELECT * FROM johari_results WHERE keyparam = :key");
	    	$sql->bindParam(":key", $key);
	    	$sql->execute();
	    	if(!$sql->fetch()){
	    		break;
	    	}
	    }


	    $sql = $conn->prepare("INSERT INTO johari_results values (null, :key, :players, :my_features, :your_features, :features)");
	    $sql->bindParam(":key", $key);
	    $sql->bindParam(":players", $players);
	    $sql->bindParam(":my_features", $my_features);
	    $sql->bindParam(":your_features", $your_features);
	    $sql->bindParam(":features", $features);
	    $sql->execute();
	    echo "{\"key\": \"$key\"}";
	}catch(PDOException $e){
		$message = $e->getMessage();
    	echo "{\"error\": \"$message\"}";
    }
?>