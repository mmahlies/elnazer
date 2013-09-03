<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Gravity in jQuery</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
		<link href="http://wathba.dx.am/CI/application/views/template/displayQuestion/css/style.css" rel="stylesheet" type="text/css" media="screen" />
		<script src="http://wathba.dx.am/CI/application/views/template/displayQuestion/js/jquery-1.7.2.js" type="text/javascript"></script>
		<script src="http://wathba.dx.am/CI/application/views/template/displayQuestion/js/jquery.easing.1.3.js" type="text/javascript"></script>
		
		<link href='http://wathba.dx.am/CI/application/views/template/displayQuestion/css/gravity.css' rel='stylesheet' type='text/css' />
		<script type="text/javascript">
		
var Gravity = {
		
init: function() {
		
	$("#air .block_container").css({
		height: $("#air").outerHeight() + "px"
	});
		
	$(".handle").mouseenter(function(i) {
		//animate the cutting of the string
		$(this).animate({
			height: "20px"
		},1000, function(){
			var id = $(this).attr('value');
			var current = $("#"+id).html();
			var c = $.trim(current);
			//alert(current);
			var ans = $("#tt").attr('value');
			//alert(ans);
			//alert(c);
			//var current = $("#"+id).html();
			if(ans == c || c=="") {
				var qID = $("#id").attr('value');
				$.getJSON("http://wathba.dx.am/CI/index.php?compete/addQuestionToUser/"+qID,function(result){});
				if (confirm('Correct :) would you like to try another question?')) 
					window.location = "http://wathba.dx.am/CI/index.php?compete/scienceHouseRegular";
				else window.location = "http://wathba.dx.am/CI/index.php?elnazer/home"; 
			}
			
			else{	
				$.post("http://wathba.dx.am/CI/index.php?elnazer/addToUserQuestion", {'q':id},
				function(data){
					alert(data);
				}
				);
				if (confirm('wrong answer, would you like to try another question?')) 
					window.location = "http://wathba.dx.am/CI/index.php?compete/scienceHouseRegular";
				else window.location = "http://wathba.dx.am/CI/index.php?elnazer/home"; 
			}	
			
		});
		var block = $(this).parent().next();
		
		var yposBlock = $(block).position()['top'] - $("#air").position()['top'];
		var fallDist = ($("#air").outerHeight() - yposBlock) - $(block).outerHeight();
			
		//let the block fall
		$(block).stop().animate({
			marginTop: fallDist+"px"
		}, {
			duration: 1000,
			easing: "easeOutBounce"
		});
	});
	
	},
	
	reset: function() {
		$(".handle").stop().animate({
			height: "50px"
		},{
			duration: 1000,
			easing: "easeInElastic"
		});
		
		$(".block").stop().animate({
			marginTop: "0px"
		},{
			duration: 1000,
			easing: "easeInBounce"
		});
	}

}

$(document).ready(function(){
	Gravity.init();
});
		
		</script>
	</head>
	
	<body>
	
	
		<div style='padding: 15px;'>
		
			<div class='content'>
				<p id='question'><?php echo $question_body;?></p>
				
				<p><a href="http://wathba.dx.am/CI/index.php?elnazer/home">Go To your profile</a></p>
				
				<div id="air">
					<div style='padding-left: 100px;' class="block_container">
						<div class="block">
							(1)
						</div>
						<div class='handle_wrap' >
							<div class="handle" value = '1'>
								&nbsp;
							</div>
						</div>
						<div class="block" id = '1'>
							<?php echo $answer1;?>
						</div>
					</div>
					
					<div style='padding-left: 100px' class='block_container'>
						<div class="block" id = '2'>
							(2)
						</div>
						<div class='handle_wrap'>
							<div class="handle">
								&nbsp;
							</div>
						</div>
						<div class="block" value = '2'>
							<?php echo $answer2;?>
						</div>
					</div>
					
					<div style='padding-left: 100px' class='block_container'>
						<div class="block">
							(3)
						</div>
					<div class='handle_wrap'>
							<div class="handle" value = '3'>
								&nbsp;
							</div>
						</div>
						<div class="block" id = '3'>
							<?php echo $answer3;?>
						</div>
					</div>


					<div style='padding-left: 100px; top:20px' class='block_container'>
						<div class="block" >
							(4)
						</div>
						<div class='handle_wrap'>
							<div class="handle" value = '4'>
								&nbsp;
							</div>
						</div>
						<div class="block" id = '4'>
							<?php echo $answer4;?>
						</div>
					</div>
				</div>
				<div id="ground">
					&nbsp;
				</div>
				
				<br />

			</div>
			
		</div>
<input type = 'hidden' id = 'id' value = "<?php echo $question_id;?>">
<input type = 'hidden' id = 'tt' value = "<?php echo $true_answer;?>">

	</body>
</html>
