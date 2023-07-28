<?php session_start(); 
$_SESSION["page"] = "0A3.php";
include('includes/header.php'); 

$stim = $_SESSION["group"];



?>

	<div class = "center">

		<div class="box">
			<video id = "stimulus"  width="750" height="600" autoplay="autoplay">
 		 	<?php echo "<source src='img/".$stim.".mp4' type='video/mp4'/>
"?>
	 		</video>
		</div>

		<div class = "bottom" style="background:none">
			<form method="post" name = "myform" id="next_page" action="main.php">
			<button id="next" type = "submit" class="next inactive ">Next</button>
			</form>
		</div>
	</div>

<script>
  var video = document.getElementsByTagName('video')[0];
  video.onended = function(e) 
	{
    $(".next").removeClass('inactive');
	};
	
	document.onkeypress = keyPress;

	function keyPress(e){
	 	var x = e || window.event;
	  var key = (x.keyCode || x.which);	    
			if(key == 97 || key == 65){
				alert("skipping stimulus");
				document.myform.submit();
	    }
	 }
	
</script>
</body>
</html>
