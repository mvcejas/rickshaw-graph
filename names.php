<?php
	require 'config.php';

	$json = array();

	$q1 = $sql->query("SELECT DISTINCT(pagename) FROM rtmfanpages WHERE pagename!='' ORDER BY pagename DESC");	
	while(list($pagename) = $q1->fetch_row()){
		$json[] = "$pagename - new";
		$json[] = "$pagename - cumulative";		
	}

	header('content-type: application/json');
	echo json_encode($json);
	
?>