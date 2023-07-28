<?php

//CREATE A USER
$insertUser = "INSERT INTO users (username, session, eGroup, created, updated) VALUES (:username, :session, :group, :created, :updated)";

//UPDATE THE LAST GROUP
$updateGroup = "UPDATE master SET lastGroup=:lastGroup, updated=:updated WHERE id=1";

//UPDATE PAGE PROGRESS
$insertProgress = "INSERT INTO progress (userID, pageID, updated) VALUES
	(:userID, :pageID, :updated )";


//UPDATE USERS TABLE WITH CONSENT, COMPLETE
$updateConsent = "UPDATE users SET consent=:consent, updated=:updated WHERE id=(:userID)";
$updateComplete = "UPDATE users SET complete=:complete, updated=:updated WHERE id=(:userID)";


//DEMOGRAPHICS RECORD
$insertDemo 		= "INSERT INTO demos (user_id, username, created, updated) VALUES (:userID, :username, :created, :updated)";
$updateMajor		= "UPDATE demos SET major=:major, updated=:updated WHERE user_id=(:userID) and id=(:demoID)"; 
$updateYear			= "UPDATE demos SET year=:year, updated=:updated WHERE user_id=(:userID) and id=(:demoID)"; 
$updateGender		= "UPDATE demos SET gender=:gender, updated=:updated WHERE user_id=(:userID) and id=(:demoID)"; 
$updateBike			= "UPDATE demos SET bike=:bike, updated=:updated WHERE user_id=(:userID) and id=(:demoID)"; 
$updateCar			= "UPDATE demos SET car=:car, updated=:updated WHERE user_id=(:userID) and id=(:demoID)"; 
$updateAccident	= "UPDATE demos SET accident=:accident, updated=:updated WHERE user_id=(:userID) and id=(:demoID)"; 
$updateEthnicity= "UPDATE demos SET ethnicity=:ethnicity, updated=:updated WHERE user_id=(:userID) and id=(:demoID)"; 
$updateNativeLang= "UPDATE demos SET n_lang=:language, updated=:updated WHERE
user_id=(:userID) and id=(:demoID)";
$updateOtherLangSpeak= "UPDATE demos SET o_lang_fluent=:speaklang, updated=:updated WHERE
user_id=(:userID) and id=(:demoID)";
$updateOtherLangStudy= "UPDATE demos SET o_lang_study=:studylang, updated=:updated WHERE
user_id=(:userID) and id=(:demoID)";
$updateAge		= "UPDATE demos SET age=:age, updated=:updated WHERE user_id=(:userID) and id=(:demoID)"; 


//SCTS 
$updateSCT1 = "UPDATE users SET sct1=:sct1, updated=:updated WHERE id=(:userID)";
$updateSCT2 = "UPDATE users SET sct2=:sct2, updated=:updated WHERE id=(:userID)";


//SELECT QUESTION 
$getQ = "SELECT * from questions SET id=:q_num";

//SAVE MEMORY TEST ANSWER ANSWER
$insertAnswer = "INSERT INTO memorys (userID, questionID, answerID, correct, updated) VALUES (:userID, :questionID, :answerID, :correct, :updated)";

//INSERT POSITIONS OF SVG CIRCLES
$insertPos = "INSERT INTO sequences (userID, eventID, x, y, page, created) VALUES
(:userID, :eventID, :x, :y, :page, :created)";

$insertPath = "INSERT INTO paths (userID, eventID, x, y, seconds, page, created) VALUES
(:userID, :eventID, :x, :y, :seconds, :page, :created)";

//INSERT VERDICT
$insertVerdict = "INSERT INTO decisions (userID, finding) VALUES
(:userID, :finding)";
$updateJustification= "UPDATE decisions SET justification=:justification WHERE
userID=(:userID) and id=(:decisionID)";
$updateConfidence= "UPDATE decisions SET confidence=:confidence WHERE
userID=(:userID) and id=(:decisionID)";
$updateResponsibility= "UPDATE decisions SET p_responsibility=:responsibility WHERE userID=(:userID) and id=(:decisionID)";
$insertLaterality = "INSERT INTO laterality (userID, writing, throwing, brushing, spoon, mouse, score) VALUES
(:userID, :writing, :throwing, :brushing, :spoon, :mouse, :score)";


//insert reasoning score
$updateReasoning = "INSERT into reasonings SET user_id=:user, dir=:dir, rule=:rule, score=:score, notes=:notes";

?>