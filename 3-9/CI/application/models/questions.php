<?php

class Questions extends CI_Model{

	function getStudentQuestions()
		{
			$q  = $this->db->query("select * from user_questions where u_id = 18");
			if($q->num_rows() < 4){
				return false;
			}
			
			$questions = array();
			
			foreach($q as $v)
			{
				foreach($v as $s)
				{
					print_r($s);
					echo "<br/>";
				}
				echo "<br/>";
			}
		}

}

?>
