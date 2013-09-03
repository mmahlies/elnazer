<html>

<?php
		
		echo"<form method='post' action='http://wathba.dx.am/CI/index.php/compete/round' >";
		foreach ($questions as $q)
		{
			$qID = $q['question_id'];
			$answer1 = $q['answer1'];
			$answer2 = $q['answer2'];
			$answer3 = $q['answer3'];
			$answer4 = $q['answer4'];
			echo $q['question_body']. "<br/>";
			
			echo"<input type = 'radio' name=$qID value='$answer1'  >" .$q['answer1'];
			echo"<input type = 'radio' name=$qID value='$answer2'  >" .$q['answer2'];
			echo"<input type = 'radio' name=$qID value='$answer3'  >" .$q['answer3'];
			echo"<input type = 'radio' name=$qID value='$answer4'  >". $q['answer4']."<br>";
			
	
			//echo "<input type = 'checkbox' name =$i value = $qID /> ".$q['question_body']."<br/>\n";
			//$i++;
		}
		
		echo"<input type = 'hidden' name='compID' value=$compID >";
		echo"<input type = 'hidden' name='UID' value=$uID >";
	echo"<input type = 'submit'  vlaue='submit'/> </form>";
	?>
</html>