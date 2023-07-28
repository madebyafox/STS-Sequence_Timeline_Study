<?php 

include('../includes/functions_dev.php');
include('../includes/sequel.php');

/* EVENT CODES
1  T1	11:45 AM 
2  T2	11:46 AM
3  T3	11:58 AM
4  T4	12:00 PM
5  T5	12:03 PM
6  T6	12:08 PM
7  T7	12:09 PM
8  M1	MOTORIST receives call 
9  M2	MOTORIST receives text
10 M3	MOTORIST slows down
11 M4	MOTORIST enters intersection
12 M5	MOTORIST sees cyclist
13 M6	MOTORIST vigorously brakes
14 M7	MOTORIST places call
15 C1	CYCLIST receives call
16 C2	CYCLIST enters intersection
17 C3	CYCLIST sees motorist
18 C4	CYCLIST's call ends
19 SG	Crosswalk solid WALK
20 SR	Crosswalk solid DON'T WALK 
21 SY	Crosswalk flashing DON'T WALK
22 LR	light turns red
23 LG	light turns green
24 LY	light turns yellow
25 X	bell tower rings
26 Z1	collision
27 Z2	911 call
28 Z3	police arrive
END EVENT CODES */

$buffer = 6;
$dir = 0;
$score=0;

//*********GET ALL USERS**********//
$getU = "SELECT id from users" ;
try
{
	$results = $conn->query($getU);
	$users = $results->fetchAll(PDO::FETCH_ASSOC);	
	//print_r ($users);
	
	foreach ($users as $stuff)
		{

			$cSubject =  $stuff["id"]; 
			echo "<br> Trying user: ".$cSubject;
			
			//quick, get the finding from the findings table
			try
			{
				$getF = "SELECT finding, p_responsibility from decisions WHERE userID =".$cSubject ;
				$results = $conn->query($getF);
				$findings = $results->fetchAll(PDO::FETCH_ASSOC);	
				$decision = $findings[0]["finding"];
				$plaintiff = $findings[0]["p_responsibility"];
				echo $decision;
			}
			catch (Exception $e)
				{	echo $e->getMessage();}
			
			try
			{
				//POPULATE THE ARRAY OF EVENTS 
				$getS = "SELECT eventID,x,y,page from sequences WHERE userID =".$cSubject ;
				$results = $conn->query($getS);
				$seqs = $results->fetchAll(PDO::FETCH_ASSOC);	
				//print_r ($seqs);
	
				//set the direction variable
				if (empty($seqs) == 0) 
				{
						$dir = $seqs[0];
						$dir = $dir["page"];
						$dir = getDirection($dir);
						//echo $dir;
	
		  			if(count($seqs) != 28) echo "ERROR IN ROW COUNT";
						else 
						{
							$score = 0;
							$score = calcReasoning($cSubject,$score,$dir,$seqs,$decision,$plaintiff);
							echo "<BR>---- FINAL SCORE: ".$score." ----</BR>";
							
							$updateR = "UPDATE users SET reasoning=:reasoning WHERE id=(:userID)";
							try
							{
								$q = $conn->prepare($updateR);
								$q->execute(array( ':reasoning'=>$score,
																 ':userID'=>$cSubject)); 	 
							}
							catch (Exception $e)
							{ echo $e->getMessage();}		
								
						}
					}
					else echo "No sequence for user: ".$cSubject;	
			} 
			catch (Exception $e)
			{
				echo $e->getMessage();
			}
		}
}

catch (Exception $e)
{
	echo $e->getMessage();
}


function calcReasoning($cSubject,$score,$dir,$seqs,$decision,$plaintiff)
{
	
	$b_score = 1;
	$t_score = 3;
	$l_score = 2;
	$p_score = 1;
	$b_score = 1;
	$s_score = 2;
	$c_score = 3;
	
	
	//calculate basic scores [4,5,6,9,10]
	$score = $score + $b_score*rule4($seqs,$dir);
	$score = $score + $b_score*rule5($seqs,$dir);
	$score = $score + $b_score*rule6($seqs,$dir);
	$score = $score + $b_score*rule9($seqs,$dir);
  $score = $score + $b_score*rule10($seqs,$dir);
	
	
	//calculate time score [0]
	$score = $score + $t_score*rule0($seqs,$dir);
	
	//calculate light and signal scores [1,2,3]
	$score = $score + $l_score*rule1($seqs,$dir);
	$score = $score + $l_score*rule2($seqs,$dir);
	$score = $score + $l_score*rule3($seqs,$dir);
	
	//calculate text/phone record scores [7,8]
	$score = $score + $p_score*rule7($seqs,$dir);
	$score = $score + $p_score*rule8($seqs,$dir);
	
	//calculate behavior scores [11M,11C]
	$score = $score + $b_score*rule11M($seqs,$dir);
	$score = $score + $b_score*rule11C($seqs,$dir);
	
	//calculate who ran lights [MLight, CSignal,Consist]
	if ($decision = "D")
	{
		//evaluate color of light when motorist entered
		$light = rule_MLight	($seqs,$dir);
		switch ($light)
		{
			case "GREEN":
				$score = $score + $s_score;
				writeScore($cSubject,"MLight",$s_score,$dir,"FOR D: M had green");
			
				break;
	
			case "RED":
				$score = $score + 0;
				writeScore($cSubject,"MLight",0,$dir,"FOR D: M had red");
			
				break;
	
			case "YELLOW":
				$score = $score + 1;
				writeScore($cSubject,"MLight",1,$dir,"FOR D: M had yellow");
			
				break;
	
			default:
				$score = $score + 0;
				writeScore($cSubject,"MLight",0,$dir,"FOR D: no light before enter");
			
				break;
		}
		$signal = rule_CLight($seqs,$dir);
		switch ($signal)
		{
			case "GREEN":
				$score = $score + 0;
				writeScore($cSubject,"CSignal",0,$dir,"FOR M: C on WALK");
			
				break;
	
			case "RED":
				$score = $score + $s_score;
				writeScore($cSubject,"CSignal",$s_score,$dir,"FOR M: C on DON'TWALK");
			
				break;
	
			case "YELLOW":
				$score = $score + 1;
				writeScore($cSubject,"CSignal",1,$dir,"FOR M: C on FLASHING");
			
				break;
	
			default:
				$score = $score + 0;
				writeScore($cSubject,"CSignal",0,$dir,"FOR M: no light before enter");
			
				break;
		}
		if ($plaintiff >= 50)
		{
			$score = $score + $c_score;
			writeScore($cSubject,"consist",$c_score,$dir,"");
		}
	}
	else if ($decision = "P")
	{
		//evaluate color of light when motorist entered
		$light = rule_MLight($seqs,$dir);
		switch ($light)
		{
			case "GREEN":
				$score = $score + 0;
				writeScore($cSubject,"MLight",0,$dir,"FOR P: M on green");
			
				break;
	
			case "RED":
				$score = $score + $s_score;
				writeScore($cSubject,"MLight",$s_score,$dir,"FOR P: M on red");
			
				break;
	
			case "YELLOW":
				$score = $score + 1;
				writeScore($cSubject,"MLight",1,$dir,"FOR P: M on yellow");
			
				break;
	
			default:
				$score = $score + 0;
				writeScore($cSubject,"MLight",0,$dir,"FOR P: no light before enter");
			
				break;
		}
		$signal = rule_CLight($seqs,$dir);
		switch ($signal)
		{
			case "GREEN":
				$score = $score + $s_score;
				writeScore($cSubject,"CSignal",$s_score,$dir,"FOR P: C on WALK");
			
				break;
	
			case "RED":
				$score = $score + 0;
				writeScore($cSubject,"CSignal",0,$dir,"FOR P: C on DON'TWALK");
			
				break;
	
			case "YELLOW":
				$score = $score + 1;
				writeScore($cSubject,"CSignal",1,$dir,"FOR P: C on FLASHING");
			
				break;
	
			default:
				$score = $score + 0;
				writeScore($cSubject,"CSignal",0,$dir,"FOR P: no light before enter");
			
				break;
		}
		if ($plaintiff <= 50)
		{
			$score = $score + $c_score;
			writeScore($cSubject,"consist",$c_score,$dir,"");
		
		}
	}
	
	return $score;
}


function writeScore($user, $rule, $score, $dir, $notes)
//note: does not update score, writes a new record to db each time it is run
//should delete all previous records from db before running
{
		global $conn;
		global $updateReasoning;
		//echo $updateReasoning;
		try
		{
			$q = $conn->prepare($updateReasoning);
			$q->execute(array( ':user'=>$user,
										 ':rule'=>$rule,
										 ':score'=>$score,
										 ':dir'=>$dir,
										  ':notes'=>$notes
									 )); 	 
		}
		catch (Exception $e)
		{ echo $e->getMessage();}		
	}


//MOTORIST LIGHT--------------------------------------
//WHAT LIGHT DID THE MOTORIST ENTER ON?
//22 LR	light turns red
//23 LG	light turns green
//24 LY	light turns yellow
//11 M4	MOTORIST enters intersection
//26 Z1	collision
//----------------------------------------------------		
function rule_MLight($seqs,$dir)
{	
	global $buffer;	
	global $cSubject;
	
	$LG_M4 =   happenedWhen($seqs[22]["x"],
										  		$seqs[22]["y"],
								  	 		 	$seqs[10]["x"],
										 		 	$seqs[10]["y"],
										 		 	$dir);
	$LR_M4 =   happenedWhen($seqs[21]["x"],
										  		$seqs[21]["y"],
								  	 		 	$seqs[10]["x"],
										 		 	$seqs[10]["y"],
										 		 	$dir);
	$LY_M4 =   happenedWhen($seqs[23]["x"],
										  		$seqs[23]["y"],
								  	 		 	$seqs[10]["x"],
										 		 	$seqs[10]["y"],
										 		 	$dir);											
		
		$notes = "red: ".$LR_M4." yellow: ".$LY_M4." green: ".$LG_M4;
		
		$array = [$LG_M4, $LR_M4, $LY_M4,-8000];
		print_r($array);
		
		$negative = array_filter($array, function ($v) {
		  return $v < 0;
		});
		print_r($negative);
		
		$min = max($negative);
		echo $min;
		
		switch ($min)
		{
			case -8000 : 
				$word = "invalid";
			break;
			
			case $LG_M4 : 
				$word = "GREEN";
			break;
			
			case $LR_M4 : 
				$word = "RED";
			break;
			
			case $LY_M4 : 
				$word = "YELLOW";
			break;				
		}
		
					
	  $notes = $min." IS ".$word." IS SMALLEST OF ".$notes;
	//	writeScore($cSubject,"MLight",0,$dir,$notes);
		return $word;
		
}
			
//CYCLIST SIGNAL--------------------------------------
//WHAT SIGNAL DID THE CYCLIST ENTER ON?
//19 SG	Crosswalk solid WALK
//20 SR	Crosswalk solid DON'T WALK 
//21 SY	Crosswalk flashing DON'T WALK
//16 C2	CYCLIST enters intersection
//26 Z1	collision
//----------------------------------------------------		
function rule_CLight($seqs,$dir)
{	
	global $buffer;	
	global $cSubject;
	
	$LG_M4 =   happenedWhen($seqs[18]["x"],
										  		$seqs[18]["y"],
								  	 		 	$seqs[15]["x"],
										 		 	$seqs[15]["y"],
										 		 	$dir);
	$LR_M4 =   happenedWhen($seqs[19]["x"],
										  		$seqs[19]["y"],
								  	 		 	$seqs[15]["x"],
										 		 	$seqs[15]["y"],
										 		 	$dir);
	$LY_M4 =   happenedWhen($seqs[20]["x"],
										  		$seqs[20]["y"],
								  	 		 	$seqs[15]["x"],
										 		 	$seqs[15]["y"],
										 		 	$dir);											
		
		$notes = "red: ".$LR_M4." yellow: ".$LY_M4." green: ".$LG_M4;
		
		$array = [$LG_M4, $LR_M4, $LY_M4,-8000];
		print_r($array);
		
		$negative = array_filter($array, function ($v) {
		  return $v < 0;
		});
		print_r($negative);
		
		$min = max($negative);
		echo $min;
		
		switch ($min)
		{
			case -8000 : 
				$word = "invalid";
			break;
			
			case $LG_M4 : 
				$word = "GREEN";
			break;
			
			case $LR_M4 : 
				$word = "RED";
			break;
			
			case $LY_M4 : 
				$word = "YELLOW";
			break;				
		}
		
					
	  $notes = $min." IS ".$word." IS SMALLEST OF ".$notes;
		//writeScore($cSubject,"CSignal",0,$dir,$notes);
		return $word;
		
}
					
//RULE 0 ------TIME----------------------------------
//Time	Time proceeds from earlier to later	
//T1>T2>T3>T4>T5>T6>T7
//1  T1	11:45 AM 
//2  T2	11:46 AM
//3  T3	11:58 AM
//4  T4	12:00 PM
//5  T5	12:03 PM
//6  T6	12:08 PM
//7  T7	12:09 PM
//----------------------------------------------------
function rule0($seqs,$dir)
{	
	echo "<br>RULE 0: Time	Time proceeds from earlier to later	<br>";
	global $buffer;	
	global $cSubject;
	//(LR > LG > LY) gets 2 points
	// or (LG > LY > LR) gets 1 point
  // or (LY > LR > LG) gets 1 point
	
	$T1_T2 = happenedWhen( $seqs[0]["x"],
												 $seqs[0]["y"],
										  	 $seqs[1]["x"],
												 $seqs[1]["y"],
												 $dir);
	$T2_T3 = happenedWhen( $seqs[1]["x"],
												 $seqs[1]["y"],
										  	 $seqs[2]["x"],
												 $seqs[2]["y"],
												 $dir);
	$T3_T4 = happenedWhen( $seqs[2]["x"],
												 $seqs[2]["y"],
												 $seqs[3]["x"],
												 $seqs[3]["y"],
												 $dir);			
	$T4_T5 = happenedWhen( $seqs[3]["x"],
												 $seqs[3]["y"],
												 $seqs[4]["x"],
												 $seqs[4]["y"],
												 $dir);	
	$T5_T6 = happenedWhen( $seqs[4]["x"],
												 $seqs[4]["y"],
												 $seqs[5]["x"],
												 $seqs[5]["y"],
												 $dir);											 							 
 	$T6_T7 = happenedWhen( $seqs[5]["x"],
 												 $seqs[5]["y"],
 												 $seqs[6]["x"],
 												 $seqs[6]["y"],
 												 $dir);			
	if ($T1_T2 < 0 && $T2_T3 < 0 && $T3_T4 < 0 && $T4_T5 < 0 && $T5_T6 < 0 && $T6_T7 < 0) 
	{
		writeScore($cSubject,0,1,$dir,"");
		echo "time in order";
		return 1;
	}
	{		
		writeScore($cSubject,0,0,$dir,"");
		echo "!! NO POINTS !!"; 
		return 0;}
}

//RULE 1 ------TRAFFIC SIGNALS------------------------
//Traffic lights cycle from red to green to yellow
//(LR > LG > LY) || (LG > LY > LR) || (LY > LR > LG)
//22 LR	light turns red
//23 LG	light turns green
//24 LY	light turns yellow
//----------------------------------------------------
function rule1($seqs,$dir)
{	
	echo "<br>RULE 1: Traffic lights cycle from red to green to yellow<br>";
	global $buffer;	
	global $cSubject;
	//(LR > LG > LY) gets 2 points
	// or (LG > LY > LR) gets 1 point
  // or (LY > LR > LG) gets 1 point
	
	$redgreen = happenedWhen($seqs[21]["x"],
												 $seqs[21]["y"],
										  	 $seqs[22]["x"],
												 $seqs[22]["y"],
												 $dir);
	$greenyellow = happenedWhen($seqs[22]["x"],
												 $seqs[22]["y"],
										  	 $seqs[23]["x"],
												 $seqs[23]["y"],
												 $dir);
	$yellowred = happenedWhen($seqs[23]["x"],
												 $seqs[23]["y"],
												 $seqs[21]["x"],
												 $seqs[21]["y"],
												 $dir);											 
	if ($redgreen < 0 && $greenyellow < 0) 
	{
		echo "3 red-green-yellow";
		writeScore($cSubject,1,1,$dir,"r-g-y");
		return 1;
	}
	
	else if ($greenyellow < 0 && $yellowred < 0)
	{
		echo "2 green-yellow-red";
		writeScore($cSubject,1,1,$dir,"g-y-r");
		return 1;
	}
	
	else if ($yellowred < 0 && $redgreen < 0)
	{
	  echo "1 yellow-red-green";
		writeScore($cSubject,1,1,$dir,"y-r-g");
		
	return 1;
	}
	else 
	{echo "!! NO POINTS !!"; 
		writeScore($cSubject,1,0,$dir,"");
		return 0;}
}

//RULE 2 ------PEDESTRIAN SIGNALS---------------------
//Pedestrian lights cycle from walk to flashing to don't walk
//(SR > SG > SY) || (SG > SY > SR) || (SY > SR > SG)
//19 SG	Crosswalk solid WALK
//20 SR	Crosswalk solid DON'T WALK 
//21 SY	Crosswalk flashing DON'T WALK
//----------------------------------------------------
function rule2($seqs,$dir)
{	
	echo "<br>RULE 2: Pedestrian lights cycle from walk to flashing to don't walk<br>";
	global $buffer;	
	global $cSubject;
	//(SR > SG > SY) || (SG > SY > SR) || (SY > SR > SG)
	$redgreen = happenedWhen($seqs[19]["x"],
												 $seqs[19]["y"],
										  	 $seqs[18]["x"],
												 $seqs[18]["y"],
												 $dir);
	$greenyellow = happenedWhen($seqs[18]["x"],
												 $seqs[18]["y"],
										  	 $seqs[20]["x"],
												 $seqs[20]["y"],
												 $dir);
	$yellowred = happenedWhen($seqs[20]["x"],
												 $seqs[20]["y"],
												 $seqs[19]["x"],
												 $seqs[19]["y"],
												 $dir);											 
	if ($redgreen < 0 && $greenyellow < 0) 
	{ echo "2 don't walk - walk - flashing";
		writeScore($cSubject,2,1,$dir,"r-g-y");
		return 1;
	}
	
	else if ($greenyellow < 0 && $yellowred < 0)
	{ echo "1 walk-flashing-don't walk";
		writeScore($cSubject,2,1,$dir,"g-y-r");
		return 1;
	}
	
	else if ($yellowred < 0 && $redgreen < 0)
	{ echo "3 flashing-don't walk-walk";
		writeScore($cSubject,2,1,$dir,"y-r-g");
		return 1;
	}
	else 
	{echo "!! NO POINTS !!"; 
		writeScore($cSubject,2,0,$dir,"");
	 return 0;}
	

} 

//RULE 3 ------PEDESTRIAN - TRAFFIC SIGNALS ----------
//How Traffic & Lights signal together	Experiential	Inference
//	LR	SG	SY	SR	LG
//	SG	SY	SR	LG	LR
//	SY	SR	LG	LR	SG
//	SR	LG	LR	SG	SY
//	LG	LR	SG	SY	SR
//22 LR	light turns red
//23 LG	light turns green
//24 LY	light turns yellow
//19 SG	Crosswalk solid WALK
//20 SR	Crosswalk solid DON'T WALK 
//21 SY	Crosswalk flashing DON'T WALK
//----------------------------------------------------
function rule3($seqs,$dir)
{	
	echo "<br>RULE 3: How pedestrian signals interact with traffic signals<br>";
	global $buffer;	
	global $cSubject;
	$LR_SG = happenedWhen( $seqs[21]["x"],
												 $seqs[21]["y"],
										  	 $seqs[18]["x"],
												 $seqs[18]["y"],
												 $dir);												 
	$SG_SY = happenedWhen( $seqs[18]["x"],
												 $seqs[18]["y"],
										  	 $seqs[20]["x"],
												 $seqs[20]["y"],
												 $dir);
	$SY_SR = happenedWhen( $seqs[20]["x"],
												 $seqs[20]["y"],
												 $seqs[19]["x"],
												 $seqs[19]["y"],
												 $dir);		
	$SR_LG = happenedWhen( $seqs[19]["x"],
												 $seqs[19]["y"],
												 $seqs[22]["x"],
												 $seqs[22]["y"],
												 $dir);		
	$LG_LR = happenedWhen( $seqs[22]["x"],
												 $seqs[22]["y"],
												 $seqs[21]["x"],
												 $seqs[21]["y"],
												 $dir);			
												 
	echo 	"LR_SG = ".$LR_SG;						
	echo  "SR_LG = ".$SR_LG;					 								 							 									 
	if      ($LR_SG <= 0 && $SG_SY < 0 && $SY_SR < 0  && $SR_LG <= 0) 
	{ echo "1 red - walk - flashing - don't walk - green";
		writeScore($cSubject,3,1,$dir,"1");
		return 1;
	}
	else if ($SG_SY < 0 && $SY_SR < 0 && $SR_LG <= 0 && $LG_LR < 0) 
	{ echo "2 walk - flashing - don't walk - green - red";
		writeScore($cSubject,3,1,$dir,"2");
		return 1;
	}
	else if ($SY_SR < 0 && $SR_LG  <= 0 && $LG_LR < 0 && $LR_SG <= 0) 
	{ echo "3 flashing - don't walk - green - red - walk";
		writeScore($cSubject,3,1,$dir,"3");
		return 1;
	}
	else if ($SR_LG <= 0 && $LG_LR  < 0 && $LR_SG <= 0 && $SG_SY < 0) 
	{ echo "4 don't walk - green - red - walk - flashing";
		writeScore($cSubject,3,1,$dir,"4");		
		return 1;
	}
	else if ($LG_LR < 0 && $LR_SG <= 0 && $SG_SY < 0 && $SY_SR < 0) 
	{ echo "5 green - red - walk - flashing - don't walk";
		writeScore($cSubject,3,1,$dir,"5");
		return 1;
	}
	else if ($LR_SG >= -2 && $LR_SG <= 2 && $SR_LG >= -2 && $SR_LG <= 2 ) 
	{ echo "6 change simultaneous";
		writeScore($cSubject,3,1,$dir,"simultaneous");
		return 1;
	}
	else 
	{echo "!! NO POINTS !!"; 
	 writeScore($cSubject,3,0,$dir,"");
	 return 0;}
} 

//RULE 4 ------PHONE CALLS-------------------------------
//Phone calls must begin before they can end
//Experiential	Inference	(C1 > C4)
//15 C1	CYCLIST receives call
//18 C4	CYCLIST's call ends
//----------------------------------------------------
function rule4($seqs,$dir)
{	
	echo "<br>RULE 4: Phone calls must begin before they can end<br>";
	global $buffer;	
	global $cSubject;
	$time = happenedWhen($seqs[14]["x"],
									 $seqs[14]["y"],
							  	 $seqs[17]["x"],
									 $seqs[17]["y"],
									 $dir);
	if ($time < 0 )	//motorist sees cyclist before braking
	{	
		echo "1 call began then ended";
		writeScore($cSubject,4,1,$dir,"");
		return 1;
	}
	else 
	{echo "!! NO POINTS !!"; 
	 $notes = $time." pixels after";
	 writeScore($cSubject,4,0,$dir,$notes);
	 return 0;}
}

//RULE 5 ------911 POLICE ARRIVE ----------------------
//911 is called BEFORE the police arrive
// Z2 < Z3
//27 Z2	911 call
//28 Z3	police arrive
//----------------------------------------------------
function rule5 ($seqs,$dir)
{
	echo "<br>RULE 5: 911 is called BEFORE the police arrive<br>";
	global $buffer;	
	global $cSubject;
	$time = happenedWhen($seqs[26]["x"],
										$seqs[26]["y"],
										$seqs[27]["x"],
										$seqs[27]["y"],			
										$dir);
	echo $time;
	if ($time < 0)	
	{	
		echo " -- 911 call before police arrive";
		writeScore($cSubject,5,1,$dir,"");
		return 1;
	}
	else 
	{echo "!! NO POINTS !!"; 
 	 $notes = $time." pixels after";
	 writeScore($cSubject,5,0,$dir,$notes);
		return 0;}
}

//RULE 6 ------COLLISION TIMING ----------------------
//The bell tower rings RIGHT BEFORE the collision
//Testimony	Memory	(X < Z1 )
//25 X	bell tower rings
//26 Z1	collision
//----------------------------------------------------
function rule6 ($seqs,$dir)
{
	echo "<br>RULE 6: The bell tower rings right before the collision<br>";
	global $buffer;	
	global $cSubject;
	$time = happenedWhen($seqs[24]["x"],
										$seqs[24]["y"],
										$seqs[25]["x"],
										$seqs[25]["y"],			
										$dir);
	echo $time;
	if ($time > -75  && $time <= 0)	//just before
	{	
		echo " -- bell tower before collision";
		writeScore($cSubject,6,1,$dir,"");
		return 1;
	}
	else 
	{echo "!! NO POINTS !!"; 
  	 $notes = $time." pixels after";
		 writeScore($cSubject,6,0,$dir,$notes);
		return 0;}
}

//RULE 7 ------MOTORIST CALLS/TEXTS ------------------
//The motorist received a call, then received a text, then got in a collision
//then made a phone call
// M1 < M2 < Z1 < M7
//8  M1	MOTORIST receives call 
//9  M2	MOTORIST receives text
//26 Z1	collision
//14 M7	MOTORIST places call
//----------------------------------------------------
function rule7 ($seqs,$dir)
{
	echo "<br>RULE 7: The motorist received call-received text-collision-made call<br>";
	global $buffer;	
	global $cSubject;

	$M1_M2 = happenedWhen( $seqs[7]["x"],
												 $seqs[7]["y"],
										  	 $seqs[8]["x"],
												 $seqs[8]["y"],
												 $dir);
	$M2_Z1 = happenedWhen( $seqs[8]["x"],
												 $seqs[8]["y"],
										  	 $seqs[25]["x"],
												 $seqs[25]["y"],
												 $dir);
	$Z1_M7 = happenedWhen( $seqs[25]["x"],
												 $seqs[25]["y"],
												 $seqs[13]["x"],
												 $seqs[13]["y"],
												 $dir);		
							 									 	
	if      ($M1_M2 < 0 && $M2_Z1 < 0 && $Z1_M7 < 0 )
	{ echo "MOTORIST CALLS IN ORDER";
		writeScore($cSubject,7,1,$dir,"");
		return 1;
	}

	else 
	{echo "!! NO POINTS !!"; 
		 writeScore($cSubject,7,0,$dir,"");
		return 0;}
}

//RULE 8 ------CYCLIST CALLS/TEXTS ------------------
//CYCLIST receives call, collision, call ends
//15 C1	CYCLIST receives call
//26 Z1	collision
//18 C4	CYCLIST's call ends
// C1 < Z1 < C4 
//----------------------------------------------------
function rule8 ($seqs,$dir)
{
	echo "<br>RULE 8: The CYCLIST receives call, collision, call endsbr>";
	global $buffer;	
	global $cSubject;
	
	$C1_Z1 = happenedWhen( $seqs[14]["x"],
												 $seqs[14]["y"],
										  	 $seqs[25]["x"],
												 $seqs[25]["y"],
												 $dir);
	$Z1_C4 = happenedWhen( $seqs[25]["x"],
												 $seqs[25]["y"],
										  	 $seqs[17]["x"],
												 $seqs[17]["y"],
												 $dir);	
							 									 	
	if      ($C1_Z1 < 0 && $Z1_C4 <= 0 )
	{ echo "MOTORIST CALLS IN ORDER";
		writeScore($cSubject,8,1,$dir,"");
		return 1;
	}

	else 
	{echo "!! NO POINTS !!"; 
		 writeScore($cSubject,8,0,$dir,"");
		return 0;}
}

//RULE 9 ------Intersection-Collision----------------
//Both parties enter the intersection before the collsision
//Experiential	Inference	
//M4 > Z1 && C2 > Z1
//16 C2	CYCLIST enters intersection
//11 M4	MOTORIST enters intersection
//26 Z1	collision
//----------------------------------------------------
function rule9($seqs,$dir)
{	
	echo "<br>RULE 9: Both enter intersection before collision<br>";
	global $buffer;	
	global $cSubject;
	$M4_Z1 = happenedWhen($seqs[10]["x"],
									  		$seqs[10]["y"],
							  	 		 	$seqs[25]["x"],
									 		 	$seqs[25]["y"],
									 		 	$dir);
	$C2_Z1 = happenedWhen($seqs[15]["x"],
									  		$seqs[15]["y"],
							  	 		 	$seqs[25]["x"],
									 		 	$seqs[25]["y"],
									 		 	$dir);
	
	if ($M4_Z1 <= 0 && $C2_Z1 <= 0)	
	{	
		writeScore($cSubject,9,1,$dir,"");
		echo "both enter intersection before collision";
		return 1;
	}
	else 
		{echo "!! NO POINTS !!"; 
			writeScore($cSubject,9,0,$dir,"");
			return 0;}
}

//RULE 10 ------Motorist signal behavior -------------------
//Motorist signal behavior	
//MT: he (1) saw red (2) slowed down then (3) saw green light then (4) entered intersection	
//(LR > M3 > LG > M4)
//22 LR	light turns red
//23 LG	light turns green
//10 M3	MOTORIST slows down
//11 M4	MOTORIST enters intersection
//----------------------------------------------------
function rule10($seqs,$dir)
{	
	echo "<br>RULE 10: Motorist behavior:red, slowed, green, entered<br>";
	global $buffer;	
	global $cSubject;
	$LR_M3 = happenedWhen($seqs[21]["x"],
									  		$seqs[21]["y"],
							  	 		 	$seqs[9]["x"],
									 		 	$seqs[9]["y"],
									 		 	$dir);
	$M3_LG = happenedWhen($seqs[9]["x"],
									  		$seqs[9]["y"],
							  	 		 	$seqs[22]["x"],
									 		 	$seqs[22]["y"],
									 		 	$dir);
	$LG_M4 = happenedWhen($seqs[22]["x"],
									  		$seqs[22]["y"],
							  	 		 	$seqs[10]["x"],
									 		 	$seqs[10]["y"],
									 		 	$dir);											
	if ($LR_M3 <= 0 && $M3_LG <= 0 && $LG_M4 <= 0)	
	{	
		writeScore($cSubject,"10",1,$dir,"");
		echo "(motorist) red - slowed down - green - entered intersection";
		return 1;
	}
	else 
	{echo "!! NO POINTS !!"; 
		writeScore($cSubject,"10",0,$dir,"");
		return 0;}
}

//RULE 11M ------Motorist - cyclist behavior -------------------
//Motorist - cyclist behavior	
//MT: he: (1) entered intersection (2) saw cyclist (3) brakes (4) collision	
//Testimony	Memory	
//(M4 > M5 > M6 > Z1)
//11 M4	MOTORIST enters intersection
//12 M5	MOTORIST sees cyclist
//13 M6	MOTORIST vigorously brakes
//26 Z1	collision
//----------------------------------------------------
function rule11M($seqs,$dir)
{	
	echo "<br>RULE 11M: Motorist - cyclist behavior<br>";
	global $buffer;	
	global $cSubject;
	$M4_M5 = happenedWhen($seqs[10]["x"],
									  		$seqs[10]["y"],
							  	 		 	$seqs[11]["x"],
									 		 	$seqs[11]["y"],
									 		 	$dir);
	$M5_M6 = happenedWhen($seqs[11]["x"],
									  		$seqs[11]["y"],
							  	 		 	$seqs[12]["x"],
									 		 	$seqs[12]["y"],
									 		 	$dir);
	$M6_Z1 = happenedWhen($seqs[12]["x"],
									  		$seqs[12]["y"],
							  	 		 	$seqs[25]["x"],
									 		 	$seqs[25]["y"],
									 		 	$dir);											
	if ( ($M4_M5 <= 0 && $M5_M6 <= 0 && $M6_Z1 <= 0) || ($M4_M5 <= 0 && $M5_M6 >= -5 && $M5_M6 <= 5  && $M6_Z1 <= 0) )	
	{	
		writeScore($cSubject,"11M",1,$dir,"");
		echo "(motorist) entered intersection - sees cyclist - brakes - collision";
		return 1;
	}
	else 
	{echo "!! NO POINTS !!"; 
		writeScore($cSubject,"11M",0,$dir,"");
		return 0;}
}

//RULE 11C ------Cyclist - motorist behavior -------------------
//CT: he (1) entered intersection (2) saw motorist & (3) motorist entered then (4) collision
//Testimony	Memory
//C2 > C3 > M4 > Z1
//16 C2	CYCLIST enters intersection
//17 C3	CYCLIST sees motorist
//11 M4	MOTORIST enters intersection
//26 Z1	collision
//----------------------------------------------------
function rule11C($seqs,$dir)
{
	echo "<br>RULE 11C: Cyclist - motorist behavior<br>";
	global $buffer;
	global $cSubject;

	$C2_C3 = happenedWhen($seqs[15]["x"],
									  		$seqs[15]["y"],
							  	 		 	$seqs[16]["x"],
									 		 	$seqs[16]["y"],
									 		 	$dir);
// $C3_M4 = happenedWhen($seqs[16]["x"],
// 									  		$seqs[16]["y"],
// 							  	 		 	$seqs[10]["x"],
// 									 		 	$seqs[10]["y"],
// 									 		 	$dir);
	$C3_Z1 = happenedWhen($seqs[16]["x"],
									  		$seqs[16]["y"],
							  	 		 	$seqs[25]["x"],
									 		 	$seqs[25]["y"],
									 		 	$dir);
	if ($C2_C3 <= 0 && $C3_Z1 <= 0)
	{
		writeScore($cSubject,"11C",1,$dir,"");

		echo "(cyclist) cyclist enters - cyclist sees motorist - motorist enters - collision";
		return 1;
	}
	else
	{echo "!! NO POINTS !!";
		writeScore($cSubject,"11C",0,$dir,"");
		return 0;}
}

// RULE REMOVED----------------------------------------------
// RULE 12M ------Cyclist must have run the light -------------------
// Cyclist must have run the light
// (1) solid don't walk (2) entered (3) collision
// Testimony	Inference
// SR > C2 > Z1
// 20 SR	Crosswalk solid DON'T WALK
// 16 C2	CYCLIST enters intersection
// 26 Z1	collision
// ----------------------------------------------------
// function rule12M($seqs,$dir)
// {
// 	echo "<br>RULE 12M: Cyclist must have run the light<br>";
// 	global $buffer;
// 	global $cSubject;
// 	$SR_C2 = happenedWhen($seqs[19]["x"],
// 									  		$seqs[19]["y"],
// 							  	 		 	$seqs[15]["x"],
// 									 		 	$seqs[15]["y"],
// 									 		 	$dir);
// 	$C2_Z1 = happenedWhen($seqs[15]["x"],
// 									  		$seqs[15]["y"],
// 							  	 		 	$seqs[25]["x"],
// 									 		 	$seqs[25]["y"],
// 									 		 	$dir);
// 	if ( ($SR_C2<= 0 && $C2_Z1 <= 0) || ($SR_C2 >= -5 && $SR_C2 <= 5 && $C2_Z1 <= 0))
// 	{
// 		writeScore($cSubject,"12M",1,$dir,"");
// 		echo "(motorist) don't walk - cyclist enters - collision";
// 		return 1;
// 	}
// 	else
// 	{echo "!! NO POINTS !!";
// 		writeScore($cSubject,"12M",0,$dir,"");
// 		return 0;}
// }

//RULE REMOVED----------------------------------------------
//RULE 10C ------CYCLIST signal behavior -------------------
//Motorist signal behavior	
//CT: he (1) saw flashing pedestrian (2) saw red light (3) entered intersection	
//Testimony	Memory	
//SY > (while LR) > C2 > LG
//21 SY	Crosswalk flashing DON'T WALK
//22 LR	light turns red
//16 C2	CYCLIST enters intersection
//23 LG	light turns green
//----------------------------------------------------
// function rule10C($seqs,$dir)
// {
// 	echo "<br>RULE 10C: CYCLIST signal behavior<br>";
// 	global $buffer;
// 	global $cSubject;
//
// 	$SY_LR = happenedWhen($seqs[20]["x"],
// 									  		$seqs[20]["y"],
// 							  	 		 	$seqs[21]["x"],
// 									 		 	$seqs[21]["y"],
// 									 		 	$dir);
// 	$LR_C2 = happenedWhen($seqs[21]["x"],
// 									  		$seqs[21]["y"],
// 							  	 		 	$seqs[15]["x"],
// 									 		 	$seqs[15]["y"],
// 									 		 	$dir);
// 	$C2_LG = happenedWhen($seqs[15]["x"],
// 									  		$seqs[15]["y"],
// 							  	 		 	$seqs[22]["x"],
// 									 		 	$seqs[22]["y"],
// 									 		 	$dir);
// 	if ($SY_LR <= 0 && $LR_C2 <= 0 && $C2_LG <= 0)
// 	{
// 		writeScore($cSubject,"10C",1,$dir,"");
//
// 		echo "(cyclist) flashing - light is red - cyclist enters - green";
// 		return 1;
// 	}
// 	else
// 	{echo "!! NO POINTS !!";
// 		writeScore($cSubject,"10C",0,$dir,"");
// 		return 0;}
// }

//RULE REMOVED----------------------------------------------
// //RULE 12C ------Cyclist --- motorist-------------------
// //Motorist must have run the light
// //(1) red (2) entered (3) collision
// //Testimony	Inference
// //LR > M4 > Z1  && M4 > LG
// //22 LR	light turns red
// //11 M4	MOTORIST enters intersection
// //26 Z1	collision
// //23 LG	light turns green
// //----------------------------------------------------
// function rule12C($seqs,$dir)
// {
// 	echo "<br>RULE 12C: Motorist must have run the light<br>";
// 	global $buffer;
// 	global $cSubject;
// 	$LR_M4 = happenedWhen($seqs[21]["x"],
// 									  		$seqs[21]["y"],
// 							  	 		 	$seqs[10]["x"],
// 									 		 	$seqs[10]["y"],
// 									 		 	$dir);
// 	$M4_Z1 = happenedWhen($seqs[10]["x"],
// 									  		$seqs[10]["y"],
// 							  	 		 	$seqs[25]["x"],
// 									 		 	$seqs[25]["y"],
// 									 		 	$dir);
// 	$M4_LG = happenedWhen($seqs[10]["x"],
// 									  		$seqs[10]["y"],
// 							  	 		 	$seqs[22]["x"],
// 									 		 	$seqs[22]["y"],
// 									 		 	$dir);
//
//
//
// 	if ($LR_M4<= 0 && $M4_Z1 <= 0 && $M4_LG <= 0)
// 	{
// 		writeScore($cSubject,"12C",1,$dir,"");
//
// 		echo "(cyclist) red light - motorist enters - collision & not green before motorist";
// 		return 1;
// 	}
// 	else
// 		{echo "!! NO POINTS !!";
// 			writeScore($cSubject,"12C",0,$dir,"");
// 			return 0;}
// }

//--------happenedWhen--------------------------------
// returns < 0 if point 1 is BEFORE point 2
// returns 0 if point 1 equals point 2
// returns > 0 if point 1 is AFTER point 2
//
//based on x,y coordinates of point 1 and point 2
//and direction of timeline
//----------------------------------------------------
function happenedWhen($x1,$y1,$x2,$y2,$dir)
{
	//echo $dir."  ";
	//echo "x1(".$x1. ") y1(". $y1. ") x2(".$x2. ") y2(".$y2.")<br>";
	
	switch ($dir)
	{
		//FOR LR timelines, X1 < X2 means 1 is before 2
		case "LR":
		//	if (abs($x1-$x2) != 0 && abs($x1-$x2) < 3){ echo "close <br>"; return "close";}
			// else if($x1 == $x2) {echo "equal <br>"; return "equal";}
			// else if ($x1 < $x2) {echo "before <br>"; return "before";}
			// else {echo "after <br>"; return "after";}
			return $x1 - $x2;
		break;

		//FOR TB timelines, Y1 > Y2 means 1 is before 2
		case "TB";
			//if (abs($y1-$y2) < 10) return "close";
			//if($y1 == $y2) return "equal";
			//else if ($y1 > $y2) return "before";
			//else return "after";
			return $y1 - $y2;
		break;

		//FOR RL timelines, X1 > X2 means 1 is before 2
		case "RL";
			//if (abs($x1-$x2) < 10) return "close";
			//if($x1 == $x2) return "equal";
			//else if ($x1 > $x2) return "before";
			//else return "after";
			return $x2 - $x1;
		break;

		//FOR BT timelines, Y1 < Y2 means 1 is before 2
		case "BT";
			//if (abs($y1-$y2) < 10) return "close";
			//if($y1 == $y2) return "equal";
			//else if ($y1 < $y2) return "before";
			//else return "after";
			return $y2 - $y1;
		break;
	}
}

//shorten the direction variable
function getDirection($page)
{
	switch ($page)
	{
		case "caseLR.php":
			return "LR";
		break;
		
		case "caseTB.php":
			return "TB";
		break;
		
		case "caseRL.php":
			return "RL";
		break;
		
		case "caseBT.php":
			return "BT";
		break;
		
		default:
			echo "ERROR: INVALID DIRECTION";
			return;
		break;
	}
}

?>