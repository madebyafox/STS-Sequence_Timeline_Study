<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0V8.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Voir Dire</h3> 
		</div>

		<div class="box">
		<form method="post" id="next_page" action="main.php">
								
			What is your native language? 
			<br><br>
			<input type ="radio" class="normal" name="n_lang" value = "english" id="1"/>  
			<label for="1">English</label> 
			<input type ="radio" class="normal" name="n_lang" value = "spanish" id="2"/> 
			<label for="2">Spanish</label> 
			<input type ="radio" class="normal" name="n_lang" value = "french" id="3"/>  	
			<label for="3">French</label>
			<input type ="radio" class="normal" name="n_lang" value = "german" id="4"/> 
			<label for="4">German</label>
			<input type ="radio" class="normal" name="n_lang" value = "arabic" id="5"/>  	
			<label for="5">Arabic</label>
			<input type ="radio" class="normal" name="n_lang" value = "hindi" id="6"/>  	
			<label for="6">Hindi</label>
			<input type ="radio" class="normal" name="n_lang" value = "mandarin" id="7"/>  	
			<label for="7">Mandarin</label>
			<input type ="radio" class="normal" name="n_lang" value = "korean" id="8"/>  	
			<label for="8">Korean</label>	
			<input type ="radio" class="normal" name="n_lang" value = "other" id="9"/>  	
			<label for="9">Other</label>
		</div>

		<div class = "bottom">
			<button type = "submit" class="next inactive">Next</button>
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

