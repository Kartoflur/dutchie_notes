<?php
	$dsn = "mysql:host=localhost:3306;dbname=it110";															//pag connect ni sa database nga naa sa phpmysql
	$user = "root";
	$password = "";

	$pdo = new PDO($dsn, $user, $password);

	if(!$pdo){
		echo "Failed to connect to our mySQL database";
		exit();
	}
	//kani nga part kay diri ibutang ang information sa database nga i-connect pareha ra ang function sa PDO ug mysql_connect, pero ang PDO kay mas naay portability amongst differnet databases
	//taraw backup ra ning mysql_connect nga naa sa ubnos kung dili muconnect ang PDO nga naa taas
	$servername = "localhost";
    $username = "root";
    $password = "";
    $database = "it110";
    $port = "3306";
    $con=mysqli_connect($servername, $username, $password, $database);

    if(!$con)
    {
        die(' Please Check Your Connection'.mysqli_error($con));
    }



?>
