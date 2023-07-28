<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0J2q.php";
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
		
		
	<p>A cyclist is allowed to enter a crosswalk on a "Walk" or flashing "Don't Walk"    signal.</p>	
	<input type ="radio" class="normal" id="1" name="traffic1" value="1"/>
	<label for="1">true</label>
	<input type ="radio" class="normal" id="2" name="traffic1" value="0"/>
	<label for="2">false</label>
			
	<br>
	
	<p>A driver/bicyclist is allowed to wear headphones if they are not covering both ears.</p>	
	<input type ="radio" class="normal" id="3" name="traffic2" value="1"/>
	<label for="3">true</label>
	<input type ="radio" class="normal" id="4" name="traffic2" value="0"/>
	<label for="4">false</label>
	
	<p>A driver is not allowed to use a cell phone for text messaging while driving</p>	
	<input type ="radio" class="normal" id="5" name="traffic3" value="1"/>
	<label for="5">true</label>
	<input type ="radio" class="normal" id="6" name="traffic3" value="0"/>
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

