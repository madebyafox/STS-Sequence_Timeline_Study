<?php 
session_start();
include('includes/functions_dev.php');
include('includes/sequel.php');

//DEFINE THE ARRAY FOR FINAL POSITIONS
$position = array();

//DEFINE NUMBER OF QUESTIONS
$number_of_questions = 25;

//STORE THE ORDER OF PAGES
$next_page = "";
$decline_page = "0I4.php";
$pages = array(
	"index.php",
	"audio.php",
	"0I1.php",
	"0I2.php",
	"0I3.php",
	"0V0.php",
	"0V1.php",
	"0V2.php",
	"0V3.php",
	"0V4.php",
	"0V5.php",
	"0V6.php",
	"0V7.php",
	"0V8.php",
	"0V9.php",
	"0V10.php",
	"0V11.php",
	"0Vs.php",
	"draggyplaceholder.html",
	"0Vz.php",
	"0A0.php",
	"0A1.php",
	"0A2.php",
	"0A3.php",
	"0A4.php",
	"0E1.php",
	"0E2.php",
	"0E3.php",
	"0E4.php",
	"0E5.php",
	"0E6.php",
	"0E8.php",
	"0E9.php",
	"0D0.php",
	"0J1.php",
	"0J2.php",
	"0J2q.php",
	"0J3.php",
	"0J3q.php",
	"0D1.php",
	"0M0.php",
	"0D2.php",
	"0Ds.php",
	"draggyplaceholder.html",
	"0D3.php",
	"0Dv.php",
	"0Dr.php",
	"0Dj.php",
	"0Dc.php",
	"0L0.php",
	"0Dz.php",
	"0Zz.php",
	"last placeholder"
		
);

//GET PAGE TO KNOW WHICH FORM 
$last_page = $_SESSION["page"];

//DECIDE WHAT THE NEXT PAGE IS
for ($i=0; $i< count($pages); $i++)
{
	if ($last_page == $pages[$i])
 	{
 		$next_page = $pages[$i+1];
 	}
}

//////////////////////////////////////////////////////////
// page specific processing
/////////////////////////////////////////////////////////
//IF ON START PAGE, CHECK SESSION VALUE: INDEX.PHP
if ($last_page == "index.php")
{
	try{
 	 	
 	 	$_SESSION["session"]= $_POST["session_name"]; //set session name
 
 		if (!userExist()) { //user doesn't exist
		
			// echo "session user doesnt exist so insert into db--";
			
			$lg = "SELECT * FROM master WHERE id = 1";
			$lastGroup="";
			$a = $conn->query($lg);
			$a = $a->fetchAll(PDO::FETCH_ASSOC);	
			foreach ($a as $stuff)
			{$lastGroup = $stuff["lastGroup"]; } 
			
			//VALIDATE LAST GROUP IS GOOD VALUE
			switch ($lastGroup)
			{
				case 0: 
					$group = 1;
				break;
				
				case 1;
					$group = 2;
				break;
				
				case 2;
					$group = 3;
				break;
				
				case 3;
					$group = 4;
				break;
				
				case 4;
					$group = 1;
				break;
				
				default:
					echo "ERROR: INVALID LAST GROUP";
					return;
				break;
			}	
			
			$sql = $insertUser;
			$q = $conn->prepare($sql);
	 		$q->execute(array(':username'=>$username,
	 									 ':session'=>$_SESSION["session"],
		 								 ':created'=>$date,
										 ':group'=>$group,
		 								 ':updated'=>$date));
	 		$last_id = $conn->lastInsertId();	
			
			$sql = $updateGroup;
			$q = $conn->prepare($sql);
	 		$q->execute(array(':lastGroup'=>$group,
		 								 ':updated'=>$date));			
			
									
	 		$_SESSION["user"]=$last_id; //SET SESSION USER USER.ID
			$_SESSION["group"]=$group; //SET SESSION USER GROUP.NUM
 		}
 	 	savePage();
		header("Location:".$next_page);
	 	return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}		
}
////////////////////////////////////////////////////////////////////////0I2
elseif ($last_page == "audio.php")
{
	$passcode = $_POST["passcode"];
	if (strcasecmp($passcode, "memory") != 0)
	{
		$_SESSION["error"]= "Please try again"; 
		header("Location: audio.php");
	}		
	else {
		header("Location:".$next_page);
	}
	savePage();
	return;
}
////////////////////////////////////////////////////////////////////////0I1
elseif ($last_page == "0I1.php")
{
		/*SET SESSION CONSENT AND NEXT PAGE*/
 	 	$consent = $_POST["consent"];

	try{
		/*SAVE CONSENT TO DB*/
		$sql = $updateConsent;
		$q = $conn->prepare($sql);
		$q->execute(array(':consent'=>$consent,
											 ':userID'=>$_SESSION["user"],
			 								 ':updated'=>$date));
		
	 	if ($consent == "decline")
		 { header("Location:".$decline_page);}
		else {header("Location:".$next_page); } 
		
		savePage();
		return;
	}										 
	catch (Exception $e)
	{ echo $e->getMessage();}										 
}
////////////////////////////////////////////////////////////////////////0I2
elseif ($last_page == "0I2.php")
{
 	 header("Location:".$next_page);
	 savePage();
	 return;
}
////////////////////////////////////////////////////////////////////////0I3
elseif ($last_page == "0I3.php")
{
	
		$jurorCheck = $_POST["check_role"];
		
		if ((strcasecmp($jurorCheck, "juror") != 0) && (strcasecmp($jurorCheck, "juror on a civil trial")!=0))
		{
			$_SESSION["error"]= "Please try again"; 
			header("Location: 0I3.php");
		}		
		else {
			header("Location:".$next_page);
		}
		savePage();
		return;
}
///////VOIR DIRE////////////////////////////////////////////////////////0V0
elseif ($last_page == "0V0.php")
{
		/*CHECK TO SEE IF DEMOGRAPHIC SURVEY EXISTS FOR THIS USER*/
	  try{
			$sql = "SELECT ID from demos where user_id =".$_SESSION["user"];
			$q = $conn->query($sql) or die("failed");
			$r = $q->fetch(PDO::FETCH_ASSOC);
		}
		catch (Exception $e)
		{ echo $e->getMessage();}		
		
		//IF THE DEMO SURVEY DOESN'T EXIST, CREATE IT		
		if(!$r) 
		{		
			try{
				// echo "no results";
				$sql = $insertDemo;
				$q = $conn->prepare($sql);
				$q->execute(array( ':userID'=>$_SESSION["user"],
												   ':username'=>$username,
					 								 ':created'=>$date,
												 	 ':updated'=>$date,
												 )); 	 
		 		$last_id = $conn->lastInsertId();							
		 	 	$_SESSION["demo"]=$last_id; //SET SESSION DEMO.ID 
			}
			catch (Exception $e)
			{ echo $e->getMessage();}			
		}

		/*ONLY PROCEED TO NEXT PAGE IF DEMOGRAPHIC SURVEY ID IS SET*/
		if (isset($_SESSION["demo"]))
		{
		  header("Location:".$next_page);
			savePage();
			return;
		}
}
//WHAT IS YOUR MAJOR////////////////////////////////////////////////////0V1
elseif ($last_page == "0V1.php")
{
	try{	
		$u_major = $_POST["major"];
		
		$sql = $updateMajor;
		$q = $conn->prepare($sql);
		$q->execute(array( ':major'=>$u_major,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 )); 	 
	  header("Location:".$next_page);
	 	savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}		
}	
//WHAT IS YOUR YEAR/////////////////////////////////////////////////////0V2
elseif ($last_page == "0V2.php")
{
	try{	
		$u_year = $_POST["year"];
		$sql = $updateYear;
		$q = $conn->prepare($sql);
		$q->execute(array( ':year'=>$u_year,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 )); 	 
	  header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}		

}
//WHAT IS YOUR GENDER///////////////////////////////////////////////////0V3
elseif ($last_page == "0V3.php")
{
		$u_gender = $_POST["sex"];
		$sql = $updateGender;
		$q = $conn->prepare($sql);
		$q->execute(array( ':gender'=>$u_gender,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 )); 	 
		header("Location:".$next_page);
		savePage();
		return;
}
//BIKE INVOLVEMENT//////////////////////////////////////////////////////0V4
elseif ($last_page == "0V4.php")
{
	try{
		$u_bike = $_POST["bike"];
		$sql = $updateBike;
		$q = $conn->prepare($sql);
		$q->execute(array( ':bike'=>$u_bike,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 )); 	 
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}		
}	
//CAR INVOLVEMENT //////////////////////////////////////////////////////0V5
elseif ($last_page == "0V5.php")
{
	try{
		$u_car = $_POST["car"];
		$sql = $updateCar;
		$q = $conn->prepare($sql);
		$q->execute(array( ':car'=>$u_car,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 )); 	 
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}		
}
//ACCIDENT INVOLVEMENT /////////////////////////////////////////////////0V6
elseif ($last_page == "0V6.php")
{
	try{
		$u_accident = $_POST["accident"];
		$sql = $updateAccident;
		$q = $conn->prepare($sql);
		$q->execute(array( ':accident'=>$u_accident,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 )); 	 
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}		
}
//ETHNICITY/////////////////////////////////////////////////////////////0V7
elseif ($last_page == "0V7.php")
{
	try{
		$u_ethnicity = $_POST["ethnicity"];
		$sql = $updateEthnicity;
		$q = $conn->prepare($sql);
		$q->execute(array( ':ethnicity'=>$u_ethnicity,
										 ':updated'=>$date,
										 ':userID'=>$_SESSION["user"],
									 	 ':demoID'=>$_SESSION["demo"]
									 )); 	 
 	 header("Location:".$next_page);
	 savePage();
	 return;
 }
catch (Exception $e)
{ echo $e->getMessage();}		
}	
//NATIVE LANG///////////////////////////////////////////////////////////0V8
elseif ($last_page == "0V8.php")
{
	try{
		$u_native_lang = $_POST["n_lang"];
		$sql = $updateNativeLang;
		$q = $conn->prepare($sql);
		$q->execute(array( ':language'=>$u_native_lang,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 )); 	 
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}		
}		
//WHAT ARE YOUR OTHER LANGS ////////////////////////////////////////////0V9
elseif ($last_page == "0V9.php")
{
	$u_otherSpeak = $_POST["o_lang_fluent"];
	$u_otherStudy = $_POST["o_lang_study"];
	
	try{
		$sql = $updateOtherLangSpeak;
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare($sql);
		$q->execute(array( ':speaklang'=>$u_otherSpeak,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 ));	
										 
										 
	   $sql = $updateOtherLangStudy;
	 	 $q = $conn->prepare($sql);
	 	 $q->execute(array( ':studylang'=>$u_otherStudy,
	 	 											 ':updated'=>$date,
	 	 											 ':userID'=>$_SESSION["user"],
	 	 										 	 ':demoID'=>$_SESSION["demo"]
	 	 									));		 
			savePage();
			header("Location:".$next_page);
			return;
										 										 
		}
		catch (Exception $e)
		{ echo $e->getMessage();}					 
}
//WHAT IS YOUR AGE ////////////////////////////////////////////////////0V10
elseif ($last_page == "0V10.php")
{
	$u_age = $_POST["age"];
	
	try{
		$sql = $updateAge;
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare($sql);
		$q->execute(array( ':age'=>$u_age,
											 ':updated'=>$date,
											 ':userID'=>$_SESSION["user"],
										 	 ':demoID'=>$_SESSION["demo"]
										 ));	
			savePage();
			header("Location:".$next_page);
			return;
										 										 
		}
		catch (Exception $e)
		{ echo $e->getMessage();}					 
}
//TIMELINE.INTRO///////////////////////////////////////////////////////0V11
elseif ($last_page == "0V11.php")
{
	header("Location:".$next_page);
	savePage();
	return;
}
//TIMELINE.CHOICE///////////////////////////////////////////////////////0Vs
elseif ($last_page == "0Vs.php")
{
	$u_sct1 = $_POST["sct1"];	
	
	try{
 
			$sql = $updateSCT1;
			$q = $conn->prepare($sql);
	 		$q->execute(array(':sct1'=>$u_sct1,
												':updated'=>$date,
	 									    ':userID'=>$_SESSION["user"]
		 								 ));
	 	
 		
		/*SET NEXT PAGE BASED ON SCT1 CHOICE*/
		if ($u_sct1 == "lr" ) 	{ header("Location: trafficLR.php");savePage(); return;}
		elseif($u_sct1 == "rl" ){ header("Location: trafficRL.php");savePage(); return;}
		elseif($u_sct1 == "bt" ){ header("Location: trafficBT.php");savePage(); return;}
		elseif($u_sct1 == "tb" ){ header("Location: trafficTB.php");savePage(); return;}
		else {echo "error no choice of SCT1"; return;}	
	}
	catch (Exception $e)
	{ echo $e->getMessage();}		
}
//LR TRAFFIC TIMELINE/////////////////////////////////////////////trafficLR
elseif ($last_page == "trafficLR.php")
{	
	header("Location: 0Vz.php");
	savePage(); 
	return;
}
//RL TRAFFIC TIMELINE/////////////////////////////////////////////trafficRL
elseif ($last_page == "trafficRL.php")
{
	header("Location: 0Vz.php"); 		
	savePage(); 
	return;
}
//TB TRAFFIC TIMELINE/////////////////////////////////////////////trafficTB
elseif ($last_page == "trafficTB.php")
{
	header("Location: 0Vz.php"); 		
	savePage(); 
	return;
}
//BT TRAFFIC TIMELINE/////////////////////////////////////////////trafficBT
elseif ($last_page == "trafficBT.php")
{
	header("Location: 0Vz.php"); 		
	savePage(); 
	return;
}
//VOIR DIRE CONCLUSION /////////////////////////////////////////////////0Vz
elseif ($last_page == "0Vz.php")
{
	header("Location:".$next_page);
	savePage(); 
	return;
}	
//ARGUMENTS.INTRO///////////////////////////////////////////////////////0A0
elseif ($last_page == "0A0.php")
{
		header("Location:".$next_page);
		savePage(); 
		return;
}	
//CASE.INTRO////////////////////////////////////////////////////////////0A1
elseif ($last_page == "0A1.php")
{
		$plaintiffCheck = $_POST["check_plaintiff"];
		if ($plaintiffCheck != ("Woodward")) {
		$_SESSION["error"]= "Please try again"; 
		//	echo $error_message;
			header("Location: 0A1.php");
		}		
		else {
			// echo "A OK";
			header("Location:".$next_page);
		}
		savePage(); 
		return;
}
//CASE.VIDEO.INTRO//////////////////////////////////////////////////////0A2
elseif ($last_page == "0A2.php")
{
	header("Location:".$next_page);
	savePage();
	return;
}
//CASE.VIDEO.STIMULUS///////////////////////////////////////////////////0A3
elseif ($last_page == "0A3.php")
{
	header("Location:".$next_page);
	savePage();
	return;
}	
//CASE.EVIDENCE.INSTRUCTIONS////////////////////////////////////////////0A4
elseif ($last_page == "0A4.php")
{
	header("Location:".$next_page);
	savePage();
	return;
}
//CASE.EVIDENCE.1////crosswalk instructions ////////////////////////////0E1
elseif ($last_page == "0E1.php")
{
	header("Location:".$next_page);
	savePage();
	return;
}				
//CASE.EVIDENCE.2///////////////////////////////////////////////////////0E2
elseif ($last_page == "0E2.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//CASE.EVIDENCE.3///////////////////////////////////////////////////////0E3
elseif ($last_page == "0E3.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//CASE.EVIDENCE.4///////////////////////////////////////////////////////0E4
elseif ($last_page == "0E4.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//CASE.EVIDENCE.5///////////////////////////////////////////////////////0E5
elseif ($last_page == "0E5.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//CASE.EVIDENCE.6///////////////////////////////////////////////////////0E6
elseif ($last_page == "0E6.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//CASE.EVIDENCE.7///////////////////////////////////////////////////////0E7
elseif ($last_page == "0E7.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//CASE.EVIDENCE.8///////////////////////////////////////////////////////0E8
elseif ($last_page == "0E8.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//CASE.EVIDENCE.9///////////////////////////////////////////////////////0E9
elseif ($last_page == "0E9.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//DELIBERATIONS.TITLE //////////////////////////////////////////////////0D0
elseif ($last_page == "0D0.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}
//JURY INSTRUCTIONS.INTRO //////////////////////////////////////////////0J1
elseif ($last_page == "0J1.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}	
//JURY INSTRUCTIONS.TRAFFIC STATUTES////////////////////////////////////0J2
elseif ($last_page == "0J2.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}		
//JURY INSTRUCTIONS.TRAFFIC TEST///////////////////////////////////////0J2q
elseif ($last_page == "0J2q.php")
{
		
	$u_walk = 			$_POST["traffic1"];
	$u_headphones = $_POST["traffic2"];
	$u_texting = 		$_POST["traffic3"];
	
	if ($u_walk != 0)	{
		$_SESSION["error"]= "Please try again";
		header("Location:0J2q.php");
		return;
  }
	else if ($u_headphones != 1)	{
		$_SESSION["error"]= "Please try again";
		header("Location:0J2q.php");
		return;
  }
	else if ($u_texting != 1)	{
		$_SESSION["error"]= "Please try again";
		header("Location:0J2q.php");
		return;
  }
	else {
		header("Location:".$next_page);
		savePage();
		return;
	}
}	
//JURY INSTRUCTIONS.EVIDENCE INSTRUCTIONS //////////////////////////////0J3
elseif ($last_page == "0J3.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}	
//JURY INSTRUCTIONS.EVIDENCE TEST//////////////////////////////////////0J3q
elseif ($last_page == "0J3q.php")
{
		
	$u_defense = 		$_POST["evidence1"];
	$u_burden = 		$_POST["evidence2"];
	$u_testimony = 	$_POST["evidence3"];
	
	if ($u_defense != 1)	{
		$_SESSION["error"]= "Please try again";
		header("Location:0J3q.php");
		return;
  }
	else if ($u_burden != 0)	{
		$_SESSION["error"]= "Please try again";
		header("Location:0J3q.php");
		return;
  }
	else if ($u_testimony != 0)	{
		$_SESSION["error"]= "Please try again";
		header("Location:0J3q.php");
		return;
  }
	else {
		header("Location:".$next_page);
		savePage();
		return;
	}
}
//MEMORY.INTRO /////////////////////////////////////////////////////////0D1
elseif ($last_page == "0D1.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}				
//MEMORY TEST////// ////////////////////////////////////////////////////0M0
elseif ($last_page == "0M0.php")
{
		$qnumber = $_POST["q_num"];	
		$answer = $_POST["answer"];	
		
		saveAnswer($qnumber,$answer);
		
		if ($qnumber < $number_of_questions)
		{
			header("Location: 0M0.php");
			savePage();
			return;
		}
		else 
		{	$_SESSION["mem"] = 0;
			header("Location:".$next_page);
			savePage();
			return;
		}		
}			
//TIMELINE INTRO////////////////////////////////////////////////////////0D2
elseif ($last_page == "0D2.php")
{
		header("Location:".$next_page);
		savePage();
		return;
}			
//TIMELINE. DIRECTION SELECT ///////////////////////////////////////////0Ds
elseif ($last_page == "0Ds.php")
{
		$u_sct2 = $_POST["sct2"];
	
		try{
				$sql = $updateSCT2;
				$q = $conn->prepare($sql);
				$q->execute(array( ':sct2'=>$u_sct2,
													 ':updated'=>$date,
													 ':userID'=>$_SESSION["user"]
				 )); 
				 
		 		/*SET NEXT PAGE BASED ON SCT2 CHOICE*/ 		
				if ($u_sct2 == "lr" ) 	{ header("Location: caseLR.php");	savePage(); return;}
		 		elseif($u_sct2 == "rl" ){ header("Location: caseRL.php");	savePage(); return;}
		 		elseif($u_sct2 == "bt" ){ header("Location: caseBT.php");	savePage(); return;}
		 		elseif($u_sct2 == "tb" ){ header("Location: caseTB.php");	savePage(); return;}
		 		else {echo "error no choice of SCT2"; return;}		
				 
		}	 
		catch (Exception $e)
		{ echo $e->getMessage();}	
}
//CASE  TIMELINE///////////////////////caseBT || caseBT || caseLR || caseRL
elseif ( ($last_page == "caseLR.php" )  || 
				 ($last_page == "caseRL.php" )  || 
				 ($last_page == "caseTB.php" )  || 
				 ($last_page == "caseBT.php" )  )
{

		//HANDLE FINAL POSITIONS
		$u_pos = $_POST["pos"];
		$e_pos = explode(",", $u_pos[0]);
		//print_r($e_pos);
		
		//ITERATE THROUGH FINAL POSITIONS OF SVG CIRCLES
		for ($i=0; $i<count($e_pos)-1; $i=$i+3)
		{
			$id = 	$e_pos[$i];
			$x = 		$e_pos[($i+1)];
			$y =		$e_pos[($i+2)];

			try{
			// print_r($position[$iterator][0]);
			$sql = $insertPos;
			$q = $conn->prepare($sql);
			$q->execute(array(':userID'=>$_SESSION["user"],
			 									':eventID'=>$id,
			 								  ':x'=>$x,
			 									':y'=>$y,
												':page'=>$_SESSION["page"],
											  ':created'=>$date
			 									));
			}
			catch (Exception $e)
			{ echo $e->getMessage();}	
			
		}

		// //HANDLE PATH POSITIONS
		$u_path = $_POST["path"];
		$e_path = explode(",", $u_path[0]);
		//print_r($e_path);

		//ITERATE THROUGH PATH POSITIONS OF SVG CIRCLES
		for ($i=0; $i<count($e_path)-1; $i=$i+4)
		{
			$id = 	$e_path[$i];
			$x = 		$e_path[($i+1)];
			$y =		$e_path[($i+2)];
			$seconds =	$e_path[($i+3)];

			try{
				$sql = $insertPath;
				$q = $conn->prepare($sql);
				$q->execute(array(':userID'=>$_SESSION["user"],
			 								  ':eventID'=>$id,
			 								  ':x'=>$x,
												':y'=>$y,
												':seconds'=> $seconds,
												':page'=>$_SESSION["page"],
											  ':created'=>$date
			 									));
			}
			catch (Exception $e)
			{ echo $e->getMessage();}	
		}
		
		header("Location: 0D3.php");
		savePage();
		return;
		
}
//VERDICT INTRO/////////////////////////////////////////////////////////0D3
elseif ($last_page == "0D3.php")
{
	header("Location:".$next_page);
	savePage();
	return;
}
//VERDICT DECISION /////////////////////////////////////////////////////0Dv
elseif ($last_page == "0Dv.php")
{
	$u_verdict = $_POST["verdict"];
	
	try{
		$sql = $insertVerdict;
		$q = $conn->prepare($sql);
		$q->execute(array(':userID'=>$_SESSION["user"],
									  ':finding'=>$u_verdict
	 									));
		$_SESSION["decision"] = $conn->lastInsertId();			
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}
}
//VERDICT RESPONSIBILITY ///////////////////////////////////////////////0Dr
elseif ($last_page == "0Dr.php")
{
	$p_resp = $_POST["responsibility"];

	try{
		$sql = $updateResponsibility;
		$q = $conn->prepare($sql);
		$q->execute(array(':userID'=>$_SESSION["user"],
									  ':responsibility'=>100-$p_resp,
										':decisionID' =>$_SESSION["decision"]
	 									));
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}

}
//VERDICT JUSTIFICATION ////////////////////////////////////////////////0Dj
elseif ($last_page == "0Dj.php")
{
	$u_just = $_POST["justification"];

	try{
		$sql = $updateJustification;
		$q = $conn->prepare($sql);
		$q->execute(array(':userID'=>$_SESSION["user"],
									  ':justification'=>$u_just,
	 									':decisionID' =>$_SESSION["decision"]
									));
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}

}
//VERDICT CONFIDENCE////////////////////////////////////////////////////0Dc
elseif ($last_page == "0Dc.php")
{
	$u_conf = $_POST["confidence"];

	try{
		$sql = $updateConfidence;
		$q = $conn->prepare($sql);
		$q->execute(array(':userID'=>$_SESSION["user"],
									  ':confidence'=>$u_conf,
										':decisionID' =>$_SESSION["decision"]
	 									));
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}
}
//LATERALITY TEST  /////////////////////////////////////////////////////0L0
elseif ($last_page == "0L0.php")
{
	
	$u_writing = $_POST["writing"];
	$u_throwing = $_POST["throwing"];
	$u_brushing = $_POST["brushing"];
	$u_spoon = $_POST["spoon"];
	$u_mouse = $_POST["mouse"];
	$total = array($u_writing,$u_throwing,$u_brushing,$u_spoon,$u_mouse);
	$score = 0;
	
	foreach ($total as $val)
	{
		switch ($val)
		{
				case "AL":
						$score = $score - 100;
						break;
				case "UL":
						$score = $score - 50;  
						break;
				case "E":
						$score = $score - 0; 
						break;
				case "UR":
						$score = $score + 50;		
						break;
				case "AR":
						$score = $score + 100; 
						break;
			}
	 }
	 
	$score = $score / 5;
	try{
		$sql = $insertLaterality;
		$q = $conn->prepare($sql);
		$q->execute(array(':userID'=>$_SESSION["user"],
										':writing'=> $u_writing,
										':throwing'=> $u_throwing,
										':brushing'=> $u_brushing,
										':spoon' => $u_spoon,
										':mouse' => $u_mouse,
										':score' => $score
	 									));
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}
}
//STUDY CONGRATZ ///////////////////////////////////////////////////////0Dz
elseif ($last_page == "0Dz.php")
{
	try{
		$sql = $updateComplete;
		$q = $conn->prepare($sql);
		$q->execute(array(':userID'=>$_SESSION["user"],
									  ':complete'=>1,
										'updated'=>$date
	 									));
		header("Location:".$next_page);
		savePage();
		return;
	}
	catch (Exception $e)
	{ echo $e->getMessage();}
}
//STUDY DEBRIEF ////////////////////////////////////////////////////////0Zz
elseif ($last_page == "0Zz.php")
{
	header("Location:".$next_page);
	return;
}

?>