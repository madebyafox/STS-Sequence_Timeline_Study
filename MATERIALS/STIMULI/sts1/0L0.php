<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0L0.php";
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>
	<div class="center">
		
		<div class="top">
			<h3>Voir Dire</h3> 
		</div>

		<div class="box">
		<form method="post" id="next_page" action="main.php">
								
Please indicate your preferences in the use of hands in the follow activities			<br><br>
			Writing

			<input type ="radio" class="normal" name="writing" value = "AR" id="5"/>  
			<label class = "spec" for="5">Always Right</label> 
			
			<input type ="radio" class="normal" name="writing" value = "UR" id="4"/> 
			<label class = "spec" for="4">Usually Right</label>
			
			<input type ="radio" class="normal" name="writing" value = "E" id="3"/>  	
			<label class = "spec" for="3">Both Equally</label>
			
			<input type ="radio" class="normal" name="writing" value = "UL" id="2"/>
			<label class = "spec" for="2">Usually Left</label>
			
			<input type ="radio" class="normal" name="writing" value = "AL" id="1"  required="required"/>  
			<label class = "spec" for="1">Always Left</label>
	
			<br><br>
		
			Throwing
			
			<input type ="radio" class="normal" name="throwing" value = "AR" id="10"/>  
			<label class = "spec" for="10">Always Right</label> 
			
			<input type ="radio" class="normal" name="throwing" value = "UR" id="9"/> 
			<label class = "spec" for="9">Usually Right</label>
			
			<input type ="radio" class="normal" name="throwing" value = "E" id="8"/>  	
			<label class = "spec" for="8">Both Equally</label>
			
			<input type ="radio" class="normal" name="throwing" value = "UL" id="7"/>
			<label class = "spec" for="7">Usually Left</label>
			
			<input type ="radio" class="normal" name="throwing" value = "AL" id="6"  required="required"/>  
			<label class = "spec" for="6">Always Left</label>
						
			<br><br>
			
			Brushing Your Teeth
			<input type ="radio" class="normal" name="brushing" value = "AR" id="15"/>  
			<label class = "spec" for="15">Always Right</label>
			
			<input type ="radio" class="normal" name="brushing" value = "UR" id="14"/> 
			<label class = "spec" for="14">Usually Right</label>
			
			<input type ="radio" class="normal" name="brushing" value = "E" id="13"/>  	
			<label class = "spec" for="13">Both Equally</label>
			
			<input type ="radio" class="normal" name="brushing" value = "UL" id="12"/>
			<label class = "spec" for="12">Usually Left</label>
			
			<input type ="radio" class="normal" name="brushing" value = "AL" id="11"  required="required"/>  
			<label class = "spec" for="11">Always Left</label>

						
			<br><br>
			
			
			Using a Spoon
			<input type ="radio" class="normal" name="spoon" value = "AR" id="20"/>  
			<label class = "spec" for="20">Always Right</label> 
			
			<input type ="radio" class="normal" name="spoon" value = "UR" id="19"/> 
			<label class = "spec" for="19">Usually Right</label>

			<input type ="radio" class="normal" name="spoon" value = "E" id="18"/>  	
			<label class = "spec" for="18">Both Equally</label>

			<input type ="radio" class="normal" name="spoon" value = "UL" id="17"/>
			<label class = "spec" for="17">Usually Left</label>
			
			<input type ="radio" class="normal" name="spoon" value = "AL" id="16"  required="required"/>  
			<label class = "spec" for="16">Always Left</label>
			
						
			<br><br>
			Using a Mouse	
			<input type ="radio" class="normal" name="mouse" value = "AR" id="25"/>  
			<label class = "spec" for="25">Always Right</label> 

			<input type ="radio" class="normal" name="mouse" value = "UR" id="24"/> 
			<label class = "spec" for="24">Usually Right</label>

			<input type ="radio" class="normal" name="mouse" value = "E" id="23"/>  	
			<label class = "spec" for="23">Both Equally</label>

			<input type ="radio" class="normal" name="mouse" value = "UL" id="22"/>
			<label class = "spec" for="22">Usually Left</label>

			<input type ="radio" class="normal" name="mouse" value = "AL" id="21"  required="required"/>  
			<label class = "spec" for="21">Always Left</label>

			<br><br>		
		</div>

		<div class = "bottom">
			<button type = "submit" id = "subButton" class="next inactive">Next</button>
			</form>
		</div>
</div>
<script> 


$(document).ready(function(){
	
 $('input').change(function() { 
 	if( !document.getElementById('1').checked  && 
 			!document.getElementById('2').checked  && 
 			!document.getElementById('3').checked  && 
 			!document.getElementById('4').checked  && 
 			!document.getElementById('5').checked )
 	{
 		$(".next").addClass('inactive');
 	}
		
 	if( !document.getElementById('6').checked  && 
 			!document.getElementById('7').checked  && 
 			!document.getElementById('8').checked  && 
 			!document.getElementById('9').checked  && 
 			!document.getElementById('10').checked )
 	{
 		$(".next").addClass('inactive');
 	}
		
 	if( !document.getElementById('11').checked  && 
 			!document.getElementById('12').checked  && 
 			!document.getElementById('13').checked  && 
 			!document.getElementById('14').checked  && 
 			!document.getElementById('15').checked )
 	{
 		$(".next").addClass('inactive');
 	}
		
 	if( !document.getElementById('16').checked  && 
 			!document.getElementById('17').checked  && 
 			!document.getElementById('18').checked  && 
 			!document.getElementById('19').checked  && 
 			!document.getElementById('20').checked )
 	{
 		$(".next").addClass('inactive');
 	}
		
 	if( !document.getElementById('21').checked  && 
 			!document.getElementById('22').checked  && 
 			!document.getElementById('23').checked  && 
 			!document.getElementById('24').checked  && 
 			!document.getElementById('25').checked )
 	{
 		$(".next").addClass('inactive');
 	}
		
		
 	else 
 	{
 		$(".next").removeClass('inactive');
		
 	}
 
 });
})
</script>
<?php include('includes/footer.php'); ?>

