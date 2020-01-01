<?php
include('sequel.php');

// database configuration
$dbtype     = "sqlite";
$dbhost     = "localhost";
$dbname     = "STS_design";
$dbuser     = "root";
$dbpass     = "root";
$username = 'ARF_APP';
$date = date('Y/m/d H:i:s');
// date_default_timezone_set('America/Los_Angeles');
$conn = "";

//CREATE DATABASE CONNECTION 
try
{
		$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass); 
	 	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	 	$conn->exec("SET NAMES 'utf8'");
}
catch (Exception $e)
{
		echo "Could not connect to the database.";
		exit;
}



function userExist()
{
	if (empty($_SESSION["user"]))
		{	return false;}
	else return true;
}

function savePage()
{
	global $conn, $date, $insertProgress;
	
	try
	{
		$sql = $insertProgress;
		$q = $conn->prepare($sql);
		$q->execute(array(':userID'=>$_SESSION["user"],
									  ':pageID'=>$_SESSION["page"],
										':updated'=>$date));
	}
	catch (Exception $e)
	{ echo $e->getMessage();}

}

function saveAnswer($qnumber,$answer)
{
	global $conn, $date, $insertAnswer;
	
	try
	{
		
		//FIRST get the truth value of the selected answer
		$value = "";
		$sql = "SELECT correct FROM answers WHERE id=$answer AND questionID=$qnumber";
		$correct = $conn->query($sql);
		$correct = $correct->fetchAll(PDO::FETCH_ASSOC);	
		foreach ($correct as $me)
		{
			$value = $me["correct"]; 
		} 
		
		//NOW insert the answer with truth value in the memory table
		$sql = $insertAnswer;
		$q = $conn->prepare($sql);
		$q->execute(array(':userID'=>$_SESSION["user"],
									  ':questionID'=>$qnumber,
										':answerID'=>$answer,
										':correct'=>$value,
										':updated'=>$date));
	}
	catch (Exception $e)
	{ echo $e->getMessage();}
}



?>
