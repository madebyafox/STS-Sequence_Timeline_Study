<!-- //VARIABLE DECLARATIONS -->
<?php 
$site_name = "STS1-ARF"; 
?>

<!--
                     _        _                     __          
                    | |      | |                   / _|         
 _ __ ___   __ _  __| | ___  | |__  _   _   __ _  | |_ _____  __
| '_ ` _ \ / _` |/ _` |/ _ \ | '_ \| | | | / _` | |  _/ _ \ \/ /
| | | | | | (_| | (_| |  __/_| |_) | |_| || (_| |_| || (_) >  < 
|_| |_| |_|\__,_|\__,_|\___(_)_.__/ \__, (_)__,_(_)_| \___/_/\_\
                                     __/ |                      
                                    |___/    
-->

<!-- //HTML HEADERS -->
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title><?php echo $site_name ;?></title>
 <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro|Droid+Sans|Slabo+27px|Oxygen' rel='stylesheet' type='text/css'>
 <script src="includes/jquery-2.1.1.js"></script>
 <link type="text/css" rel="stylesheet" href="css/style.css" />
 
 <script type='text/javascript' src='includes/jquery-2.1.1.js'></script>
 <script type='text/javascript' src='js/jquery.simplemodal.js'></script>
 <script type='text/javascript' src='js/basic.js'></script>
 
 
 
</head>

<body>

<script type='text/javascript'>
	document.onkeydown = checkKey;
	stuff = "<?php $_SESSION ?> "; 
	function checkKey(e)
	{
 		 e = e || window.event;
		 if (e.keyCode == 40)
		{
		  var session = eval('(<?php echo json_encode($_SESSION)?>)');
		  console.log(session);			 
		}
	}
	</script>
		
	