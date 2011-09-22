<?php

//after you send the pass, you have to set something that identifies who a person and has a "yes, I've logged in" token. Allows movement between //pages and allows automatic logging in (use cookies). But store session data on the server (name, password, user settings, etc). Set a cookie //session and and have it refer to a session entry in the database. Pages can now validate a person's login without having them log in again. 
//know joins and foreign keys

$name = urldecode($_POST["name"]);
$pass = urldecode($_POST["pass"]);
$action = urldecode($_POST["action"]);
$hash = urldecode($_POST["hash"]);

//test the hash
if($hash == md5($pass."MitchellPavel5"))
{
	//echo "Success";
	load_con_db();
	if($action == "register") func_register($name, $pass);
	if($action == "login") func_login($name, $pass);
	
}
else
{
	//echo "Failure";
	//echo $hash." vs ".md5($pass."MitchellPavel5");
}


//echo $name." ".$pass." ".$action;


//load connection and db
function load_con_db()
{
	//load connection
	$con = mysql_connect('localhost', 'root', '123');
	if(!$con)
	{
		die ("could not connect: " . mysql_error());
	}

	//load db
	mysql_select_db("my_db", $con);

	//create table if none available
	//login_table_setup();
}


function func_register($name, $pass)
{
	mysql_query("INSERT INTO login_ids (LoginName, LoginPass) VALUES ('$name', '$pass')");
}

function func_login($name, $pass)
{
	//difference between query failed ($query returns false) and 
	//number of rows returned is zero (mysql_num_rows($query) == 0) due to lack of entries found
	$query = mysql_query("SELECT LoginName, LoginPass, P_Id FROM login_ids WHERE LoginName='$name' AND LoginPass='$pass'");
	$row = mysql_fetch_array($query);
		
	//print_r($row);
	
	if(mysql_num_rows($query) != 0)
	{
		echo " Entry found: ".$row[2];
		$Id = $row[2];
	}
	else 
	{
		echo " Entry not found!";
	}
			
}



//session_start();
//session_destroy();


function login_table_setup()
{
	$sql="SELECT login_ids FROM infromation_schema.tables WHERE table_schema = 'my_db' AND table_name = 'login_ids'";
	if(!mysql_query($sql, $con))
	{
		$sql="CREATE TABLE login_ids
			(
			P_Id int NOT NULL AUTO_INCREMENT,
			LoginName varchar(20),
			LoginPass varchar(20),
			PRIMARY KEY (P_Id)
			)";
		mysql_query($sql, $con);
	}
}

?>

