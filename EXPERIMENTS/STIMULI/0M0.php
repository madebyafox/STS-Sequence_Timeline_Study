<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0M0.php";
?>

<!-- //INCLUDES -->
<?php 
include('includes/header.php');
require_once('includes/functions_dev.php');

$q_num = $_SESSION["mem"]+1;
$_SESSION["mem"] = $q_num;

echo $q_num;
$question = "";

$getQ = "SELECT * from questions WHERE id=".$q_num;
$getA = "SELECT * from answers WHERE questionID=".$q_num;

try
{
	
	$results = $conn->query($getQ);
	$questions = $results->fetchAll(PDO::FETCH_ASSOC);	
	foreach ($questions as $stuff)
	{
		$question =  $stuff["text"]; 
	} 
	
	$results = $conn->query($getA);
	$answers = $results->fetchAll(PDO::FETCH_ASSOC);

}
catch (Exception $e)
{
	echo $e->getMessage();
}

?>

<div class="center">
	<div class="top">
		<h3>Deliberation</h3> 
	</div>

	<div class="box">
	<form method="post" id="next_page" action="main.php">
								
	<?php echo $question;?>
	<br><br>
	<?php
		for ($i = 0; $i < count($answers); $i++)
		{
			echo '<input type ="radio" class="normal" name="answer" value = "'.$answers[$i]["id"].'"';
			echo ' id="'.$i.'"/>';
			echo '<label for="'.$i.'">';
			echo $answers[$i]["text"];
			echo '</label>';	
		}	
	?>  
		

	</div>

	<div class = "bottom">
		<button type = "submit" class="next inactive"> Next</button>
		<input type = "hidden" name = "q_num" <?php echo 'value="'.$q_num.' ">' ?>
	</form>
	</div>
</div> 

<script> //var page = "0V4";
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

