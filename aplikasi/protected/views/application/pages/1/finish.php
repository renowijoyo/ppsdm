<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap.min.css" />
  </head>

  <body>
	
    <div class="container">






<?php
	$skor2 = 0;
	$skor1 = $_POST['skor1'];


if (isset($_POST['soal6']) && ($_POST['soal6'] == '17'))
	$skor2++;
if (isset($_POST['soal7']) && (strtolower($_POST['soal7']) == 'minggu'))
	$skor2++;
	
?>	
	
	
	
	
	
	
	
	
	
	
	
	
	<div class="row"><div class="col-md-8">
			<h1>Terima Kasih</h1>
			
			</div>  <!--//col-md8 -->
			
			
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Info tes</h3>
					</div>
					<div class="panel-body">
						Skor bagian 1: <?php echo $skor1;?><br/>
						Skor bagian 2: <?php echo $skor2;?><br/>
					
					</div>
				</div>
			</div>
			
	<a href=".."><button type="button" id="" class="btn btn-primary">Kembali</button></a>
	
	
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/test.js"></script>
	
  </body>
</html>
