<?php 
session_start();
$page = "0I2.php";
$_SESSION["page"] = $page;
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>

<div class="center">	
<div class="top"><h3>Welcome</h3></div>
<div class="box">

<p>Thank you for volunteering your time to assist in our research!</p>  
In the interest of SCIENCE we ask for your <u>complete and undivided attention</u> during this session. We can’t tell you why – as it may influence our results.  At the conclusion of your session we will tell you about the purpose of the study. </p>

<p>This session consists of multiple tasks presented one after the other in a specific order. You must complete the tasks in the order presented, and must not return to a previous page, nor try to open any other window other than the study. <a style="text-decoration:none; cursor:default">Do not try to skip forward or back at any time.</a></p>

<p>In a moment, I will ask you to put on the headphones at your workstation, and adjust them until they are comfortable.  Once you put on your headphones, please leave them on for the duration of the experiment. </p>


<p>To ensure accurate results, please: </p>
<ol>
	<li>Read all instructions <i>carefully</i> </li>
	<li>Avoid touching the mouse or keyboard unless directed to do so </li>
</ol>

<p>If you have questions at any time, please raise your hand and the experimenter will assist you. </p>

<form method="post" id="next_page" action="main.php">
	<input type="radio" id="1" class="ready" name="ready" />
	<label for="1">I am ready to begin</label> <br> 
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

