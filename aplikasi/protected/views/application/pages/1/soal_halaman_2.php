	<div class="row"><div class="col-md-8">
		<h1>Halaman 2</h1>
		<br/>
		<form id="form" method="POST" action="page?view=1.finish">
						<ol>
				  <li>Tanggal berapa hut RI?
					<div>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal6" value="17"> 17
						</label>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal6" value="23"> 23
						</label>
						<label class="radio-inline">
						  <input class= "jawaban" type="radio" name="soal6"  value="31"> 31
						</label>
					</div>
				  </li>
				  <br/>

				  <li>Hari sebelum hari senin?
					<div>
						<input type="text" name="soal7"  class="form-control" placeholder="">
					</div>
				  </li>
					<br/>

				</ol>
							
			<input type="submit" class="btn btn-primary"></submit>		
			<input type="hidden" name="skor1" value="<?php echo $skor1; ?>">
						
</form>						
			
			</div>  <!--//col-md8 -->
			
			
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Info tes</h3>
					</div>
					<div class="panel-body">
						Skor bagian 1: <?php echo $skor1;?><br/>
						
					</div>
				</div>
			</div>
