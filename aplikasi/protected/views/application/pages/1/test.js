	var myarray = [];

$(".jawaban").change(function(){
	var temp = document.getElementById(this.name);
	temp.value=this.value;
	//alert(this.name + ' : ' + this.value);

});

$("form").submit(function(){

		clearTimeout(timeoutTimer);
		clearInterval(clock);
		document.getElementById("timer").innerHTML=time_left-1000;

var all = $(".jawaban_ganda:checked");
var array_values = [];

	$(all).each(function(index,elem){
	
		array_values.push($(elem).val()	);
	});

		var th = array_values.join(',');
		$('#soal_5_holder').val(th);

		$(".jawaban").attr('disabled', true);
		$(".jawaban_ganda").attr('disabled', true);

		return true;
});

	var time_left = 5000;
	document.getElementById("timer").innerHTML=time_left/1000;
	var timeoutTimer = setTimeout(function(){timeOut()},time_left);
	var clock=setInterval(function(){myTimer()},1000);

	function myTimer()
	{
		time_left = time_left - 1000;
		document.getElementById("timer").innerHTML=time_left/1000;
	}

	function timeOut()
	{
		clearTimeout(timeoutTimer);
		clearInterval(clock);
		document.getElementById("timer").innerHTML=time_left-1000;

var all = $(".jawaban_ganda:checked");
var array_values = [];

	$(all).each(function(index,elem){
	
		array_values.push($(elem).val()	);
	});

		var th = array_values.join(',');
		$('#soal_5_holder').val(th);

		$(".jawaban").attr('disabled', true);
		$(".jawaban_ganda").attr('disabled', true);

	}
