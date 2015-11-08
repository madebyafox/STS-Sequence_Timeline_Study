<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0A1.php";
?>
<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>

	<div class = "center">
		<div class = "top"><h3 style="	font-family: 'Slabo 27px', serif;
">Woodward v. Johnson	</h3>
		</div>

		<div class="box">
			<p style="font-family: 'Slabo 27px', serif;  font-size:28px;">
				On June 26, 2014, Elliot Johnson drove into an intersection in Manassas, 				Virgina.  At the same time, Michael Woodward crossed through the intersection on 				a bicycle. The two collided.  The plaintiff Michael Woodward was injured and the 				defendant Elliot Johnson suffered damage to his vehicle. 
			</p>

			<p style="font-family: 'Slabo 27px', serif;  font-size:28px;">
The plaintiff Mr. Woodward (cyclist) is suing the defendant Mr. Johnson (motorist) for negligence.  The defendant is claiming an affirmative defense asserting that the plaintiff’s injuries were caused in whole or in part by the plaintiff’s own negligence.</p>

<form method="post" id="next_page" action="main.php">
					<label><i> The plaintiff's last name is &nbsp &nbsp </i> 
					<input type="text" name="check_plaintiff"></label>
		</div>

	<div class = "bottom">
		<button type = "submit" class="next inactive ">Next</button>
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
