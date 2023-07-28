<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0Zz.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3 style="text-align:center;">Debrief</h3>
			
		</div>

		<!-- <div class="box"> -->
			
  	<p>
		Thank you very much for your participation in this study. This debriefing will tell you more about it, what you did, and why.  </p>

<p style="color:#c5001f"> 		It is really important that you do not discuss this experiment with other students who might participate after you. They must participate in the same way as you did, without any knowledge of what the experiment entails, or the reasoning behind it.</p>

	<p>	<b><u>What did we do?</u></b><br>
		You have just listened to an argument in a civil litigation trial, and completed a series of tasks to test your memory of the events you were presented.  In the video of the lawyer’s argument, you saw a timeline, oriented either horizontally or vertically.  Some of you saw a horizontal timeline, where the information was either shown from left to right or right to left.  Others saw a vertical timeline, the information was either shown from top to bottom or bottom to top.  You were also asked to reconstruct the sequence of events of the traffic accident, and select an orientation and direction for the flow of information.  </p>

	<p>	<b><u>Why did we do it?</u></b><br>
		Previous research suggests that humans possess remarkable flexibility in the ways we utilize spatial metaphors for conceptualizing time.  One of the most common metaphors is the use of a timeline to represent the order of a sequence of events.  We want to see the extent to which individuals can adapt to different visual presentations of timelines when making judgments in a legal case.  Our goal is to determine if timelines oriented in ways inconsistent with reading direction might result in reduced memory performance, and therefore errors in reasoning.  </p>

<p><b>	<u>	What do we expect to find?</u></b><br>
		First, we expect to find that individuals presented with timelines oriented consistent to reading direction (horizontal-left to right) have the best performance in memory tasks and the fewest errors in causal reasoning.  We expect that individuals presented with timelines in the vertical orientation have poorer performance, but better than those who viewed timelines presented opposite to reading direction (horizontal-right to left).  We have based our hypotheses on the idea that spatial representations of time are constructed in working memory, and that cognitive effort is required to integrate representations that differ from the cultural norm of reading direction.  </p>

<p><b>	<u>	Why is it important?</u></b><br>
		In litigation law, lawyers must describe a sequence of events to judge and jury while making a persuasive argument as to the cause of an alleged wrongdoing.  Temporal sequence – the order of events – is the most basic requirement for causation.  Increasingly, lawyers are turning to graphical representations in the courtroom, such as animated PowerPoint presentations, to support their arguments.  We think it is important to understand the influence of timelines on memory, comprehension and decision making of jurors. </p>

<p>	 <i>	If you would like to receive a copy of the results of the study, or have any further questions, please contact the researchers.  Primary Researcher: Amy Fox : amyraefox@gmail.com       &nbsp  &nbsp  &nbsp      Faculty Advisor : Dr. Martin van den Berg: mvandenberg@csuchico.edu. </i></p>
 
<p>	<b>	Thank you so much for your participation. We hope you enjoyed participating in this study as much as we enjoyed developing it.</b></p>
</p>	

<p style="color:#c5001f">Please quietly leave your workstation, and notify the experimenter that you have completed the study.</p>		

		<div class = "bottom">
<br><br><br><br>
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

