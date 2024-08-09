<?php

//Chaine de connexion sql server
function connectSqlsrv() {
	$sql_dns ="sqlsrv:Server=localhost,1433;Database=AP3";
	$sql_username ="";
	$sql_password="";

	try{
		$cnx = new PDO($sql_dns, $sql_username, $sql_password );
	}
	catch (Exception $e){
		echo ($e->getMessage());
	}

	return $cnx;
}

?>