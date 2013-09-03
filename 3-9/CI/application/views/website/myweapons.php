<html>
<head>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/start/jquery-ui.css" />
 

 <style>
#content{ 
width:	600px; 
top:	30px;
position:	absolute;
}
body{
background-image: linear-gradient(bottom, rgb(129,168,209) 23%, rgb(148,141,196) 62%, rgb(132,144,194) 81%);
background-image: -o-linear-gradient(bottom, rgb(129,168,209) 23%, rgb(148,141,196) 62%, rgb(132,144,194) 81%);
background-image: -moz-linear-gradient(bottom, rgb(129,168,209) 23%, rgb(148,141,196) 62%, rgb(132,144,194) 81%);
background-image: -webkit-linear-gradient(bottom, rgb(129,168,209) 23%, rgb(148,141,196) 62%, rgb(132,144,194) 81%);

}

.trueAnswerMarker{
	color: blue;
}

#questionBody{
	font-size: 23;
}

#questionSuccess{
	position: absolute;
	right:	10px;
	color: green;
}
#questionFailed{
	position: absolute;
	right:	30px;
	color: red;

}

 </style>
 
 
 <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 <script src="../../js/jquery-ui.custom.js"></script>  
	<script id = "template" type = "text/x-handlebars-template">			
			<div> 
			 <a id = "questionBody" href = "#"> {{question_body}} </a> 
			<label id = "questionSuccess">{{questionSuccess}}</label>
			<label id = "questionFailed">{{questionFailed}}</label>
			
			</div>
				<div>
					<ul>
					 <li> {{answer1}} </li>
					 <li> {{answer2}} </li>
					 <li> {{answer3}} </li>
					 <li> {{answer4}} </li>
					</ul>
					<div style = "float:left; color: blue;" >true answer : {{true_answer}}</div> 
				</div>			
			
	</script>
    <script type = "text/javascript">		
		$(function getWeapons(){					
			$.ajax({
			     url:"http://wathba.dx.am/CI/index.php/elnazer/getWeapons",			     
				 dataType :"json",
			     success:function (result) {						 					
						template = $.trim( $('#template').html() );
								$.each(result, function(ind, obj){							
									var temp =	template.replace( /{{question_body}}/ig , obj.question_body)
										.replace( /{{answer1}}/ig , obj.answer1)
										.replace( /{{answer2}}/ig , obj.answer2)
										.replace( /{{answer3}}/ig , obj.answer3)
										.replace( /{{answer4}}/ig , obj.answer4)
										.replace( /{{questionSuccess}}/ig , obj.successed)
										.replace( /{{questionFailed}}/ig , obj.failed)
										.replace( /{{true_answer}}/ig , obj.true_answer);
									$('#content').append(temp);
									//$("li:contains( " + obj.true_answer + ")").addClass('trueAnswerMarker');
								}); 
				},
				complete: function(){
					$('#content').accordion({collapsible : true});
				}
	     });
			
      });
	            
	</script>
</head>
<body >  
<a href='http://wathba.dx.am/CI/index.php/elnazer/home'>Home</a>
<div id = "content" >
</div>

</body>

</html>