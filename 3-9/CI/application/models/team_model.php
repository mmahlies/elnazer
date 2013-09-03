<?php

class Team_model extends CI_Model
{

	function getSchoolStudents($school)
	{
		$query = mysql_query("select * from user where school = $school and u_type = 'student'");
		$row = array();
		$students = array();
		while($row = mysql_fetch_assoc($query))
		{
			$students[] = $row;
		}
		
		return $students;
	}
	
	function form1($team1, $teacher)
	{
		$teamSize = count($team1);
		$team1 = implode(',', $team1);
		$this->db->query("insert into team_comp(teacher, team_size, team1, status) values ($teacher, $teamSize, '$team1', 'pending')");
		
		$comp = mysql_fetch_assoc(mysql_query("select * from team_comp where comp_id = LAST_INSERT_ID()"));
		return $comp['comp_id'];		
	}
	
	function form2($compID, $team2)
	{
		$team2 = implode(',', $team2);
		$this->db->query("update team_comp set team2 = '$team2' where comp_id = $compID");
	}
	
	function getSchoolStudents2($school, $compID)
	{
		$comp = mysql_fetch_assoc(mysql_query("select * from team_comp where comp_id = $compID"));
		$team1 = $comp['team1'];
		$team1 = explode(',', $team1);
		
		$query = mysql_query("select * from user where school = $school");
		$row = array();
		while($row = mysql_fetch_assoc($query))
		{
			if(in_array($row['u_id'], $team1)) continue;
			$students[] = $row;
		}
	
		return $students;
		
	}
	
	function comp($compID)
	{
		return mysql_fetch_assoc(mysql_query("select * from team_comp where comp_id = $compID"));
	}
	
	function removeComp($compID)
	{
		$this->db->query("delete from team_comp where comp_id = $compID");
	}
	
	function getTeamQuestions($team) 
	{
		$qIDs = array();
		foreach($team as $student)
		{
			$query = mysql_query("select * from user_questions where u_id = $student");
			if(mysql_num_rows($query) == 0) continue;
			while($row = mysql_fetch_assoc($query))
			{
				$qIDs[] = $row['question_id'];
			} 
		}	
		$qIDs = array_unique($qIDs);

		$questions = array();
		foreach($qIDs as $id)
		{
			$questions[] = mysql_fetch_assoc(mysql_query("select * from question where question_id = $id"));
		}
		
		return $questions;
	}
	
	function addQuestions($compID, $team, $teamQuestions)
	{
		$comp = $this->db->query("select * from team_comp where comp_id = $compID");
		if($comp->num_rows() == 0) die("competition not found");
		
		$questions = implode(',', $teamQuestions);
		$teamQ = "team".$team."_questions";
		$this->db->query("update team_comp set $teamQ = '$questions' where comp_id = $compID ");
	}
	
	function setRunning($compID)
	{
		$this->db->query("update team_comp set status = 'running' where comp_id = $compID ");
	}
	
	function updateTeam($compID, $teams)
	{
		$team1 = $teams[1];
		$team2 = $teams[2];
		$this->db->query("update team_comp set team1 = $team1, team2 = $team2 where comp_id = $compID");
	}
	
	function getQuestion($qID)
	{
		return $q = mysql_fetch_assoc(mysql_query("select * from question where question_id = $qID"));
	}

}

?>
