<?php
	define('db_host','localhost');		/* database hostname */
	define('db_user','root');			/* database username */
	define('db_pass','');				/* database password */
	define('db_name','facebookstats');	/* database name */

	/* initialize database connection */
	$sql = new mysqli(db_host,db_user,db_pass,db_name);
?>