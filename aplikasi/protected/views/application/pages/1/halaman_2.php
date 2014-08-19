<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bootstrap core CSS -->
				<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap.min.css" />
  </head>

  <body>
	
    <div class="container">

		
			<?php 
			

				$soal5 = explode(',',$_POST['soal5']);
				//print_r($soal5);
				//print_r($_POST['soal5']) . '</br>';
				
			?>

<?php 
	include 'proses_halaman_1.php';
	if ($skor1 >2)
		include 'soal_halaman_2.php';
	else
		include 'thanks.php';
	
?>
			


    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/test.js"></script>
	
  </body>
</html>
