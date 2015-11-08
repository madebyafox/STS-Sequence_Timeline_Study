<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$page = "0I3.php";
$_SESSION["page"] = $page;
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>

<div class="center">	
<div class="top"><h3>Hello, Juror!</h3></div>
<div class="box">
<p> You are going to play the role of a <b>juror on a civil trial </b> involving a traffic accident.</p>  
<ol>
	<li>First you will complete a short demographic survey. 
<li> You will then listen to a recording of one of the lawyers examining a witness. 
<li>You will then complete a memory test to measure your memory and comprehension of the case. 
<li>Finally you will be asked to make a decision on the case. 
</ol>
<p>This will require all of your attention, and considerable effort.  You may find some tasks challenging!  Do not give up; try your best, and remain focused. We are counting on you to show <u>the best of your abilities</u>, and are very thankful for your thoughtful participation. </p>

<form method="post" id="next_page" action="main.php">
			<label><i> I will be playing the role of a &nbsp   </i> 
					<input type="text" name="check_role">
			</label>
			
</div>

<div class = "bottom">
		<button type = "submit" class="next inactive">Next</button>
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

<?php include('includes/footer.php'); ?>
