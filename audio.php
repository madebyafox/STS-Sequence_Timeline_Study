<?php session_start(); ?>

<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "audio.php";
?>

<!-- //INCLUDES -->
<?php 
include('includes/header.php'); 
?>

<audio autoplay loop>
  <source src="img/acheck.mp3" type="audio/mpeg">
Your browser does not support the audio element.
</audio>

<div class="center">	
	<div class="top"></div>
	<div class="box">
		<h2 style="padding-left:75px;">Can you hear the audio playing through your headphones?</h2>
		
		<h2 style="padding-left:75px;">If not, please raise your hand for assistance.  Otherwise, please enter the passcode in the space below.</h2>
		
<br><br><br>		
		<form method="post" id="next_page" action="main.php">
				<h4> Passcode:  &nbsp
					<input type="text" id ="passcode" name="passcode" >
				</h4>
				
	</div> <!--box!-->
	<div class = "bottom">
		<button type = "submit" class="next inactive">Next</button>
			<p style="color:red"><?php if (isset($_SESSION["error"])){echo 				$_SESSION["error"];}
		unset($_SESSION["error"]);?>	</p>
		
		</form>

</div> <!--bottom!-->
</div> <!--center!-->
<?php include('includes/footer.php'); ?>


<script> // var page = "0I1";
$(document).ready(function(){
 $('input').change(function() { 
  var val = $(this).val();
  if ((val != "") && (val != "No")) {
   $(".next").removeClass('inactive');
   $(".exitlink").hide();
  } else if (val == "No") {
   $(".next").addClass('inactive');
   $(".exitlink").show();
  } else {
   $(".next").addClass('inactive');
   $(".exitlink").hide();
  }
 });
})
</script>
