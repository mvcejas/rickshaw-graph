<?php
	date_default_timezone_set('UTC');
	require 'config.php';	

	$json = array();
	$current_fans = $sql->query("SELECT fans FROM rtmfanpages ORDER BY dateadded DESC LIMIT 1,1")->fetch_object()->fans;
	$q1 = $sql->query("SELECT DISTINCT(pagename) FROM rtmfanpages WHERE pagename!='' ORDER BY pagename ASC");	
	while(list($pagename) = $q1->fetch_row()){
		$data1 = array();
		$data2 = array();

		if(isset($_GET['date'])){
			$date = $_GET['date'];
			$query = "SELECT dateadded,fans FROM rtmfanpages WHERE pagename='$pagename' AND DATE_FORMAT(dateadded,'%Y-%m-%d')='$date' ORDER BY dateadded ASC";
		}
		else{
			$query = "SELECT dateadded,fans FROM rtmfanpages WHERE pagename='$pagename' ORDER BY dateadded DESC LIMIT 500";
		}

		$q2 = $sql->query($query) or die($sql->error);
		while(list($timestamp,$fans) = $q2->fetch_row()){
			array_push($data1,array('x'=>strtotime($timestamp),'y'=>(int)$fans));
		}
		array_push($json,array('name'=>"$pagename - cumulative",'data'=>$data1));

		$q2 = $sql->query($query);
		while(list($timestamp,$fans) = $q2->fetch_row()){			
			array_push($data2,array('x'=>strtotime($timestamp),'y'=>((int)$fans - $current_fans)));
			$current_fans = (int) $fans;		
		}
		array_push($json,array('name'=>"$pagename - new",'data'=>$data2));
	}

	header('content-type: application/json');
	echo json_encode($json);
	
?>