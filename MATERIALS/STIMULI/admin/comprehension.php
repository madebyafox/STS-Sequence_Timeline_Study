<?php 

include('../includes/functions_dev.php');

//get all participants from users
//get the memory responses
//sum the last response given for each question
//save the total to the db users table
// if user score is not present throw flag
// if user is missing Q throw flag

// get all participants from the memory table

$cScore = 0 ;
$cQuestion = 0;

$getU = "SELECT id from users" ;

//GET THE USERS
try
{
	$results = $conn->query($getU);
	$users = $results->fetchAll(PDO::FETCH_ASSOC);	
	//print_r ($users);
}
catch (Exception $e)
{
	echo $e->getMessage();
}

foreach ($users as $stuff)
	{
		$cSubject =  $stuff["id"]; 
		
		try
		{
			$getR = "SELECT * from memorys WHERE userID=".$cSubject;
			$results = $conn->query($getR);
			$memorys = $results->fetchAll(PDO::FETCH_ASSOC);	
			
			$totalScore=0;
			$currQuestion = 0;
			$error = 0;
			
			foreach ($memorys as $item)
			{
				$correct = $item["correct"];
				$question = $item["questionID"];

				if ($question == $currQuestion +1)
				{
					// echo "this is question ".$question."score is ".$totalScore."<br>";
					$currQuestion = $question;
					$totalScore = $totalScore+$correct;	
				}
				else 
				{ 
					$error = "dirty";
				}
			}
			// only do something if the error indicator is blank
			
			if($error <> 0)
			{
				echo "User ID: ".$cSubject;
				echo "current total: ".$totalScore;	
				//$end = $totalScore."problem";
				echo "error code ".$end."<br>";
			}
			
			else if ($currQuestion <> 25)
			{
				echo "User ID: ".$cSubject;
				echo "current total: ".$totalScore;	
				//$end = $totalScore."incomplete";
				echo "error code ".$end."<br>";
				
			}
			else if ($error == 0)
			{
				echo "User ID: ".$cSubject;
				echo "current total: ".$totalScore;	
				$end = $totalScore;
				echo "error code ".$end."<br>";
				
			}
			
			if ($end <> null)
			{
				$updateC = "UPDATE users SET comprehension=:comprehension WHERE id=(:userID)";
				
				try{
					
					$q = $conn->prepare($updateC);
					$q->execute(array( ':comprehension'=>$end,
													 ':userID'=>$cSubject
												 )); 	 
					}
				catch (Exception $e)
					{ echo $e->getMessage();}		
				
			}
			
			
			
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}



?>