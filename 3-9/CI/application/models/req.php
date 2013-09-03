<?php

class Req extends CI_Model{

        function __construct()
        {
		parent::__construct();
	}


	function hasEnoughQuestion($uID){
		$q = $this->db->query("select question_id from user_questions where u_id = $uID");
		return $q->num_rows();
	}
	
	function haveCompetition($firstUser, $secondUser){
		$q = $this->db->query("select comp_id, status from elnazer.comp_req where (sender=$firstUser and reciever = $secondUser) or 
		(sender=$secondUser and reciever = $firstUser)");
		return $q->num_rows();
	}
	
	function getQuestions($uID)
	{
		$questions = array();
		$q = $this->db->query("select question_id from user_questions where u_id = $uID ");
		foreach($q->result() as $row)
		{
			foreach($row as $item)
			{
				$questions[] = mysql_fetch_assoc(mysql_query("select * from question where question_id = $item"));
			}
		}
		return $questions ;
	}
	
	function getCompetitionRequests($uID)
	{
		$requests = array();
		$result = mysql_query("select * from comp_req where reciever = $uID") ;
		
		if(mysql_num_rows($result) == 0) $requests = 0;
		else
		{
			while($row=mysql_fetch_assoc($result))
			{
				$comp_id = $row['comp_id'];
				$sender = $row['sender'];
				$sender_name = $this->userData($sender);
				$sender_name=$sender_name['name'];
				$requests [] = array('compID'=>$comp_id, 'sender'=>$sender_name);
			}
		}
		return  $requests ;
	}
	
	function userData($uID){
		return mysql_fetch_assoc(mysql_query("select * from user where u_id=$uID"));
	}
	
	function reject($compID)
	{
		$this->db->query("update comp_req set status = 'rejected' where comp_id = $compID");
		$this->db->query("delete from comp_q where comp_id = $compID");
	}
	
	function accept($compID)
	{
		$this->db->query("update comp_req set status = 'accept' where comp_id = $compID");
	}
	
	function addCompetitionRequest($sender, $reciever)
	{
		$this->db->query("insert into comp_req (sender, reciever, status) values ($sender, $reciever, 'pending')");
	}
	
	function getCompetitionID($sender, $reciever)
	{
		$row = mysql_fetch_assoc(mysql_query("select comp_id from comp_req where sender = $sender and reciever = $reciever"));
		return $row['comp_id'];
	}
	
	function addQuestions($competitionID, $questions, $questionSender)
	{
		$this->db->query("insert into comp_q values ($competitionID, ".$questions[0].", '$questionSender'),
		($competitionID, ".$questions[1].", '$questionSender'), ($competitionID, ".$questions[2].", '$questionSender'),
		($competitionID, ".$questions[3].", '$questionSender')");
	}
	
	function getSenderQuestion($compID)
	{
		$q = mysql_fetch_assoc(mysql_query("select * from comp_q where comp_id = $compID and q_sender = 'sender'"));
		$qID = $q['question_id'];
		return mysql_fetch_assoc(mysql_query("select * from question where question_id = $qID"));
	}
	
	function getQuestionToAnswer($compID, $uID)
	{
		$q = mysql_query("select * from comp_q where comp_id = $compID and q_sender != $uID");
		$questions = array();
		while($row = mysql_fetch_assoc($q))
		{
			$id = $row['question_id'];
			$questions[] = mysql_fetch_assoc(mysql_query("select * from question where question_id = $id"));  
		}
		
		return $questions;
	}
	
	editStuff($compID, $uID)
	{
		$this->db->query("delete from comp_req where com_id = $compID");
		$this->db->query("update account set knowledge = knowledge+10, balance = balance+10");
	}

}

?>
