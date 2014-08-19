<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bootstrap core CSS -->
 
  </head>

  <body>
	
    <div class="container">

        <h1>Dummy tes untuk PPSDM Portal</h1>


        <p class="lead">Apabila telah siap silahkan klik tombol lanjut dibawah</p>
		
			<?php 
			echo Yii::app()->baseUrl; 
			echo "<br/>";
			echo dirname(Yii::app()->request->scriptFile);
			echo '<br/>';
			echo Yii::app()->basePath;
			?>
	<a href="page?view=1.halaman_1"><button type="button" class="btn btn-primary">Lanjut</button></a>
	

    </div><!-- /.container -->


	
	
	
	
	
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/test.js"></script>
  </body>
</html>
