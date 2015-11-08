<?php session_start(); ?>
<!-- //SET VARIABLES -->
<?php 
$_SESSION["page"] = "0Ds.php";

$scts = ["lr","rl","bt","tb"];
shuffle($scts);
?>

<!-- //INCLUDES -->
<?php include('includes/header.php'); ?>

	<div class = "photohead"></div>
	<div class = "photos">
		<form method="post" id="next_page" action="main.php">
			<audio autoplay >
			  <source src="img/timeline.m4a" type="audio/mpeg">
			Your browser does not support the audio element.
			</audio>
		<?php 
		
		echo "<input type='image' name = 'sct2' value = '".$scts[0]."' src='img/".$scts[0].".png' style='float:left' />";
			
			
		echo "<input type='image' name = 'sct2' value = '".$scts[1]."' src='img/".$scts[1].".png' style='float:left' />";
			
			
			echo "<input type='image' name = 'sct2' value = '".$scts[2]."' src='img/".$scts[2].".png'  style='float:left' />";
			
			
				echo "<input type='image' name = 'sct2' value = '".$scts[3]."' src='img/".$scts[3].".png' style='float:left' />";
			
			?>
		
		</form>
	</div>
</div>

<?php include('includes/footer.php'); ?>
