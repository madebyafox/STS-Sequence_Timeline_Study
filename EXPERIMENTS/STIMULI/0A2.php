<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0A2.php";
?>
<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>

	<div class = "center">
		<div class = "top"><h3>Arguments	</h3></div>

		<div class="box">
	<h2	style="padding-left:75px;">
	Now you are going to listen to the testimony of a police officer who responded to the accident.  
	</h2> 
	<h2 style="padding-left:75px;">The testimony will last for 14 minutes. </h2>
	<h2	style="padding-left:75px;">
	The female voice you will hear belongs to a laywer.  The male voice belongs to the police officer. 
	</h2>
	
	<h2	style="padding-left:75px; color:#c5001f;">
Pay careful attention. You will be asked to render a judgement after hearing the testimony. 	</h2>

	<p style="padding-left:75px; font-size:20px ">
		<br><br><i>
		You <u>will not</u> be allowed to pause, rewind or review the video at any time. <br>
		You <u>will</u> be tested on your comprehension of the contents.  
	</i><p>
			
		</div>

	<div class = "bottom">
		<form method="post" id="next_page" action="main.php">
			<button type = "submit" class="next  ">Next</button>
		</form>
		<p style="color:red"><?php if (isset($_SESSION["error"])){echo 				$_SESSION["error"];}
	unset($_SESSION["error"]);?>	</p>
	</div>

</div>
<script> 
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
</body>
</html>
