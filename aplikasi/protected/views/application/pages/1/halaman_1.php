<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Bootstrap core CSS -->


				<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/bootstrap.min.css" />
  </head>

  <body>
	
    <div class="container">

			<br/>
	<div class="row"><div class="col-md-8">
		<h1>Halaman 1</h1>
		<br/>

		<form id="form" method="POST" action="page?view=1.halaman_2">

							<ol>
				  <li>Berapa 1 + 1 ?
					<div>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal1" value="1"> 1
						</label>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal1" value="2"> 2
						</label>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal1"  value="3"> 3
						</label>
					</div>
				  </li>
				  <br/>
				   <li>Berapa 4 / 2 ?
					<div>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal2" value="1"> 1
						</label>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal2" value="2"> 2
						</label>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal2"  value="3"> 3
						</label>
					</div>
				  </li>
				  <br/>
				  <li>Apakah kependekan dari Komisi Pemberantasan Korupsi?
					<div>
						<input type="text" name="soal3"  class="jawaban form-control" placeholder="">
					</div>
				  </li>
					<br/>
					
				  <li>Apakah ibukota dari Jawa barat ?
					<div>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal4" value="Jakarta"> Jakarta
						</label>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal4" value="Bandung"> Bandung
						</label>

						</div>
				  </li>
					<br/>
				  <li>Siapakah saja dibawah ini yang merupakan presiden Indonesia?
					<div>
						<label class="checkbox-inline">
						  <input class= "jawaban_ganda" type="checkbox" name="soal5holder[]" value="soekarno"> Soekarno
						</label>
						<label class="checkbox-inline">
						  <input type="checkbox" class= "jawaban_ganda" name="soal5holder[]" value="soeharto"> Soeharto
						</label>
						<label class="checkbox-inline">
						  <input class= "jawaban_ganda" type="checkbox"  name="soal5holder[]" value="jokowi"> Jokowi
						</label>
						</div>
				  </li>
					<br/>

				</ol>
		
		
		
		
		
				<input type="hidden"  name="soal1" id="soal1" value="">
				<input type="hidden"  name="soal2" id="soal2" value="">
				<input type="hidden"  id="soal3" name="soal3" value="">
				<input type="hidden"  id="soal4" name="soal4" value="">
						<input type="hidden"  id="soal_5_holder" name="soal5" value="">

		
		
		
		
		
						<input type="submit" class="btn btn-primary"></submit>		
						
</form>						

			</div>  <!--//col-md8 -->
			

			<div class="col-md-4">
					<div class="panel panel-primary">
					
					  <div class="panel-heading">
    <h3 class="panel-title">Sisa waktu</h3>
  </div>
  <div class="panel-body">
		<span id="timer"></span> detik</div>
  </div>
			</div>
			
			</div>
			

	

    </div><!-- /.container -->

	
	<div class="test">
	
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/css/test.js"></script>



  </body>
</html>
