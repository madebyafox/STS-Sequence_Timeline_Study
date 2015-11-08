<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0J3q.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top"></div>

		<div class="box">
	<form method="post" id="next_page" action="main.php">
		<p style="color:red">
			<?php if (isset($_SESSION["error"])) 
						{ echo $_SESSION["error"];
							unset($_SESSION["error"]);}
			?>
		</p>
		
		
	<p>The defendant (Mr. Johnson) claims that the plaintiff (Mr. Woodward) was partially or wholy responsible for his own injuries. </p>	
	<input type ="radio" class="normal" id="1" name="evidence1" value="1"/>
	<label for="1">true</label>
	<input type ="radio" class="normal" id="2" name="evidence1" value="0"/>
	<label for="2">false</label>
			
	<br>
	
	<p>Each side must prove that their claim is true beyond a <u>reasonable doubt</u></p>	
	<input type ="radio" class="normal" id="3" name="evidence2" value="1"/>
	<label for="3">true</label>
	<input type ="radio" class="normal" id="4" name="evidence2" value="0"/>
	<label for="4">false</label>
	
	<p>In making my decision, I should just assume that each witness and party to the accident was telling the truth in their testimony</p>	
	<input type ="radio" class="normal" id="5" name="evidence3" value="1"/>
	<label for="5">true</label>
	<input type ="radio" class="normal" id="6" name="evidence3" value="0"/>
	<label for="6">false</label>
		
		</div>

		<div class = "bottom">
	
			
		<button type = "submit" class="next inactive ">Next</button>
	</form>
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
<?php include('includes/footer.php'); ?>

