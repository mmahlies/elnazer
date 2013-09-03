<?php

class Competition extends CI_Model{

        function Compete()
        {
		parent::__construct();
	}


	function hasEnoughQuestion($uID){
		$q = $this->db->query("select question_id from user_questions where u_id = $uID");
		return $q->num_rows();
	}
	
	function haveCompetition($firstUser, $secondUser){
		$q = $this->db->query("select comp_id, status from comp_req where (sender=$firstUser and reciever = $secondUser and statu !=3) or (sender=$secondUser and reciever = $firstUser and statu !=3)");
		return $q->num_rows();
	}
	
	function getQuestionsCount($uID){
		$i = 0 ;
		$questions = array();
		$this->db->select('question_id')->from('user_questions')->where('u_id',$uID);
		$q = $this->db->get();
		foreach($q->result() as $row)
		{
			foreach($row as $item)
			{
				$questions[] = mysql_fetch_assoc(mysql_query("select * from question where question_id = $item"));
				//$this->db->select()->from('question')->where('question_id',$item)->limit($num , $start);
				//$this->db->query("select * from question where question_id = $item");
				//$questions[] = $this->db->get();
			}
		}
		return count($questions);
	}
	function getQuestions($uID, $num = 20, $start = 0)
	{ 
		$i = 0 ;
		$questions = array();
		$this->db->select('question_id')->from('user_questions')->where('u_id',$uID)->limit($num,$start);
		$q = $this->db->get();
		foreach($q->result() as $row)
		{
			foreach($row as $item)
			{
				$questions[] = mysql_fetch_assoc(mysql_query("select * from question where question_id = $item"));
				//$this->db->select()->from('question')->where('question_id',$item)->limit($num , $start);
				//$this->db->query("select * from question where question_id = $item");
				//$questions[] = $this->db->get();
			}
		}
		return $questions;
	}
	
	function getQuestionsForScienceHouse($uID)
	{
		$questions = array();
		$q = mysql_query("select * from question where status=1");
		while($row = mysql_fetch_assoc($q))
		{
			$questions[] = $row['question_id'];
		}
	
		$userQuestions = array();
		$q = mysql_query("select * from user_questions where u_id = $uID");
		while($row = mysql_fetch_assoc($q))
		{
			$userQuestions[] = $row['question_id'];
		}	
		
		return array_diff($questions, $userQuestions);
	}
	
	function getQuestion($qID)
	{
		$q = mysql_query("select * from question where question_id = $qID");
		if (mysql_num_rows($q) == 0) return 0;
		return mysql_fetch_array($q);
	}
	
	function recieved($uID)
	{
		$requests = array();
		$result = mysql_query("select * from comp_req where (reciever = $uID and sender != $uID and status = 1 and statu != 3 )") ;
		
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

	function sent($uID)
	{
		$requests = array();
		$result = mysql_query("select * from comp_req where (sender = $uID and reciever != $uID and (status = 2 and statu !=3 ) or (status = 4 and statu != 3))") ;
		
		if(mysql_num_rows($result) == 0) $requests = 0;
		else
		{
			while($row=mysql_fetch_assoc($result))
			{
				$comp_id = $row['comp_id'];
				$reciever = $row['reciever'];
				$reciever_name = $this->userData($reciever);
				$reciever_name=$reciever_name['name'];
				$requests [] = array('compID'=>$comp_id, 'reciever'=>$reciever_name);
			}
		}
		return  $requests ;
	}
	
		
	function rejected($uID)
	{
		$requests = array();
		$result = mysql_query("select * from comp_req where (sender = $uID and status = 0)") ;
		
		if(mysql_num_rows($result) == 0) $requests = 0;
		else
		{
			while($row=mysql_fetch_assoc($result))
			{
				$comp_id = $row['comp_id'];
				$reciever = $row['reciever'];
				$reciever_name = $this->userData($reciever);
				$reciever_name=$reciever_name['name'];
				$requests [] = array('compID'=>$comp_id, 'reciever'=>$reciever_name);
			}
		}
		return  $requests ;
	}	
	function acceptedNotAns($uID)
	{
		$requests = array();
		$result = mysql_query("select * from comp_req where (reciever = $uID and sender != $uID and status = 4 and statu != 3)") ;
		
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
	
	
	function remove($compID)
	{
		$this->db->query("delete from comp_req where comp_id = $compID");
	}
	
	
	function userData($uID)
	{
		return mysql_fetch_assoc(mysql_query("select * from user where u_id=$uID"));
	}
	
	function reject($compID)
	{
		$this->db->query("update comp_req set status = 0 where comp_id = $compID");
		$this->db->query("update comp_req set statu = 3 where comp_id = $compID");
		
	}
	
	function accept($compID)
	{
		$this->db->query("update comp_req set status = 2 where comp_id = $compID");
	}
	
	function acceptNOTAns($compID)
	{
		$this->db->query("update comp_req set status = 4 where comp_id = $compID");
	}
	function addCompetitionRequest($sender, $reciever)
	{
		$this->db->query("insert into comp_req (sender, reciever, status) values ($sender, $reciever, 1)");
	}
	
	function getCompetitionID($sender, $reciever)
	{
		$row = mysql_fetch_assoc(mysql_query("select comp_id from comp_req where sender = $sender and reciever = $reciever and statu = 0 " ));
		return $row['comp_id'];
	}
	
	//add question to competition
	function addQuestions($compID, $questions, $questionSender)
	{
		foreach($questions as $q)
		{
			$this->db->query("insert into comp_q values($compID, $q, $questionSender)");
		}
	}
	
	function getSenderQuestion($compID, $uID)
	{   
		$q = mysql_fetch_assoc(mysql_query("select * from comp_q where comp_id = $compID and q_sender != $uID"));
		$qID = $q['question_id'];
		$question = mysql_fetch_assoc(mysql_query("select * from question where question_id = $qID"));
		//$this->db->query("delete from comp_q where comp_id = $compID and question_id = $qID");
		return $question;
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
	
	function senderOrReciever($compID, $uID)
	{
		$result = mysql_fetch_assoc(mysql_query("select * from comp_req  where comp_id = $compID"));
		if ($result['sender'] == $uID) $type = 'sender';
		elseif($result['reciever'] == $uID) $type = 'reciever';
		return $type;
	}
	
	function compData($compID)
	{
	$query = $this->db->query("select * from comp_req where comp_id = $compID");
	return $query->result_array();
	}
	function store($compID, $type, $score)
	{
		if($type == 'reciever')
		{
			$this->db->query("update comp_req set reciever_score = $score where comp_id = $compID");
			//$this->db->query("update comp_req set status = 2 where comp_id = $compID");			
		}
		elseif($type == 'sender')
		{	
			$this->db->query("update comp_req set sender_score = $score where comp_id = $compID");			
		}	
	}
	
	function setWinner($compID, $uID)
	{
		$this->db->query("update comp_req set winner = $uID where comp_id = $compID");
		$this->db->query("update account set knowledge = knowledge+100, satisfication=satisfication+100 where u_id = $uID");
		$this->db->query("update comp_req set statu = 3 where comp_id = $compID");
		
		//set loser
		
		$r = mysql_fetch_assoc(mysql_query("select * from comp_req where comp_id = $compID"));
		if($r['sender'] != $uID) $loser = $r['sender'] ;
		elseif($r['reciever'] != $uID) $loser = $r['reciever'] ;
		$this->db->query("update account set knowledge = knowledge-100, satisfication=satisfication-100 where u_id=$loser" );				
			
	}
	
	function seen($compID)
	{
	$this->db->query("update comp_req set seen = 1 where comp_id = $compID");
	}
	function noWinner($compID)
	{
	$this->db->query("update comp_req set statu = 3 where comp_id = $compID");
	}
	function getCompData($compID)
	{
		return mysql_fetch_assoc(mysql_query("select * from comp_req where comp_id = $compID"));
	}
	
	function storeScore($compID, $score, $uID)
	{
		$result = mysql_fetch_assoc(mysql_query("select * from comp_req where comp_id = $compID"));
		if ($result['sender'] == $uID) $type = 'sender';
		elseif($result['reciever'] == $uID) $type = 'reciever';
		$this->db->query("update comp_req set ".$type."_score = $score, status = 'round' where comp_id = $compID");
		$peers = mysql_fetch_assoc(mysql_query("select * from comp_req where comp_id = $compID"));
		$sender = $peers['sender'];
		$reciever = $peers['reciever'];
//select after update
		$result = mysql_fetch_assoc(mysql_query("select * from comp_req where comp_id = $compID"));
		
		$self = false;
		if($result['sender_score'] != null && $result['reciever_score'] != null)
		{
			if($result['sender_score']>$result['reciever_score'])  
			{
				$this->competition->updateAccount($sender);
				$winner = $sender;
				if($type == 'sender') $self = true ;
			} 
			elseif($result['sender_score']>$result['reciever_score'])  
			{
				$this->updateAccount($reciever);
				$winner = $sender;
				if($type == 'reciever') $self = true;
			}
		$this->db->query("delete from comp_req where comp_id = $compID");
		return $self;
		}
		
		else return 'still';			
	}
	
	function updateAccount($uID)
	{
		$this->db->query("update account set knowledge = knowledge+10, balance = balance+10 where u_id = $uID");
	}	
	
	function editStuff($compID, $uID)
	{
		$this->db->query("update account set knowledge = knowledge+10, balance = balance+10 where u_id = $uID");
	}
	
	function addQuestionToUser($uID, $qID) 
	{
		$this->db->query("insert into user_questions(u_id ,question_id) values($uID, $qID)");
	}
	
	function delete()
	{
		$this->db->query("delete from comp_req");
		$this->db->query("delete from comp_q");
	}

	//codedd by Gehad saad 24/8/2013
	function setSel($questions, $uID)
	{
		foreach ($questions as $q)
		{
			$this->db->query("update `user_questions` set `sel` = `sel` + 1 where `u_id` = $uID and `question_id` = $q ");
		}
	
	}
	
	function setSucFail($uID, $qID, $flag)
	{
		if ($flag = 1)
		{
			$this->db->query("update `user_questions` set `failed` = `failed` + 1 where `u_id` = $uID  and `question_id` = $qID ");
		}
		elseif($flag = 0)
		{
			$this->db->query("update `user_questions` set `successed` = `successed` + 1 where `u_id` = $uID and `question_id` = $qID ");
		
		}
	}
	
	function getQuestionSta($uID)
	{
	$query = $this->db->query("select question_id,sel,successed,failed from user_questions where u_id = $uID ");
	return $query->result_array();
	}
}

?>