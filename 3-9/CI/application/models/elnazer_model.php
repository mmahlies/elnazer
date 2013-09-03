<?php

class Elnazer_model extends CI_Model 
{
	function _required($required,$data)
	{
		foreach($required as $field)
		if(!isset($data[$field])) {return false;}
		else
		{return true;}

	}
	
	//new
	function addUser($uname, $name, $password, $mail, $gender, $type, $school)
	{
		$this->db->query("insert into user (u_name, name, password, mail, gender, u_type, school) values ('$uname', '$name', '$password', '$mail', '$gender', '$type', '$school')");
		$this->addAccount($mail);
	}
	
	function addAccount($mail)
	{
		$r = mysql_fetch_assoc(mysql_query("select * from user where mail = '$mail'"));
		$id = $r['u_id'];
		$this->db->query("insert into account(u_id, balance) values($id, 1500)");
		$this->db->query("insert into building(u_id) values($id)");		
	}

	function GetUsers($options=array())
	{
		if(isset($options['u_id']))
			$this->db->where('u_id',$options['u_id']);
		if(isset($options['mail']))
			$this->db->where('mail',$options['mail']);
		if(isset($options['password']))
			$this->db->where('password',$options['password']);	
		$query=$this->db->get('user');
		if(isset($options['u_id'])||isset($options['mail']))
			return $query->row(0);
		return $query->result();

	}
	function is_email_in_DB($userEmail)
	{
		$query=$this->db->where('mail',$userEmail)->get('user');
		if($query->num_rows()>0)
			{
			return true;
			}
		else
		{
			$this->form_validation->set_message('check_db_email','This email is not in our records');
			return false ;
		}


	}
	
	function reset_password($userEmail)
	{
		$config = Array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'xxx',
		'smtp_pass' => 'xxx',
		'mailtype'  => 'html', 
		'charset'   => 'iso-8859-1');
		$this->load->library('email',$config);

		$temp_password='';
		$length=8;
		$i=0;
		$characters='0123456789abcdefghijklmnopqrstuvwxyz';
		for($i=0;$i<$length;$i++)
		{
			$maxlength=strlen($characters);
			if ($length > $maxlength) 
			{
				$length = $maxlength;
			}
			$char = substr($characters, mt_rand(0, $maxlength-1), 1);
			if (!strstr($temp_password, $char)) 
			{ 
			// no, so it's OK to add it onto the end of whatever we've already got...
			$temp_password .= $char;
			}
		}
		$query=$this->db->where('mail',$userEmail)->get('user');
		foreach($query->result() as $row)
		{
		$userName=$row->u_name;
		$userId=$row->u_id ;
		}
		$data=array('temp_password'=>$temp_password );
		$this->db->where('mail', $userEmail);
		$this->db->last_query();
		$this->db->update('user',$data);
		$this->email->from('wathba@info.com', 'wathbaTeam');
		$this->email->to($userEmail);
		$this->email->subject('lost password');
		$this->email->message("                         
		
		confirmation code =$temp_password ");
		$this->email->send();
		echo $this->email->print_debugger();

    }
	
	function get_user_info_temp_password($temp_password)
	{
	 $query=$this->db->where('temp_password',$temp_password)->get('user');
	 if ($query->num_rows()>0)
     {
		foreach ($query->result() as $row)
		{
		$userId=$row->u_id ;
		$userName=$row->u_name ; 
		}
	 }

	 else
	 {
		$userId=false;
		$userName=false;

	 }
	return array($userId,$userName); 
	}

	function change_password()
	{
	$userId=$this->input->post('userId');
	$data=array(
	'password'=>md5($this->input->post('userPassword')),'temp_password'=>'');
	$this->db->where('u_id', $userId);
	$this->db->update('user',$data);
	}

	
	function Login($options=array())
	{ 
		if(!$this->_required(array('mail','password'),$options)) return false;
		$user=$this->GetUsers(array('mail'=>$options['mail'],'password'=>md5($options['password'])));
		if(!$user) return false;
		return true ;
	}
	
	function getFriends($uID)
	{
	$query1 = $this->db->query("select friendId from friends where userId = $uID ");
	$query2 = $this->db->query("select userId from friends where friendId = $uID ");
	
	foreach($query1->result() as $row)
	{
	$friends[] = $row->friendId;
	}
	
	foreach($query2->result() as $r)
	{
	$friends[] = $r->userId;
	}
	
	return $friends;
	}
	
	function getCompIdReciever($uID, $u_id)
	{
	$query = $this->db->query("select comp_id, sender, reciever, winner from comp_req where sender = $u_id and reciever = $uID or ( reciever = $u_id and sender = $uID) ");
	return $query->result_array();
	}
	
	function getKnowledge($uID)
	{
	$query = $this->db->query("select knowledge, satisfication from account where u_id = $uID");
	return $query->result_array();
	}
	
	function getpendingQuestions()
	{
		$q = mysql_query("select * from question where status = 0");
		$questions = array();
		while($row = mysql_fetch_assoc($q))
		{
			$questions[] = $row ;
		}
		return $questions; 		
	}
	
	function rejectQuestion($qID)
	{
		$this->db->query("delete from question where question_id = $qID");
	}

	function acceptQuestion($qID)
	{
		$this->db->query("update question set status = 1 where question_id = $qID");
	}
	
	function getkids($uid)
	{
	$this->db->select('u_id')->from('kids')->where('father',$uid);
	//$this->db->select()->from('user')->where('kid',$u_id);
	$query = $this->db->get();
	
//$query =$this->db->query("select kid from kids where father = $uid");
	return $query->result();
	
	}
	
	
	function getUserData($ids)
	{
	$query = $this->db->query("select u_id ,u_name ,name ,profile_pic from user where u_id in ($ids)");
	return $query->result_array();
	}
	
	function getAccountData($ids)
	{
	$query= $this->db->query("select * from account where u_id in ($ids)");
	return $query->result_array();
	
	}
	
	
function addMessage($from,$to,$message)
{
$inserting = $this->db->query("INSERT INTO `1431106_elnazer`.`messages` (`from_mes`, `to_mes`, `message`) VALUES ( '$from', '$to', '$message')");
return $inserting;
}	

function viewMessage($uID)
{
$query = $this->db->query("SELECT `message_id`, `from_mes`, `to_mes`, `message` FROM `messages` WHERE `to_mes` = $uID");
return $query->result_array();

}

function messageSender($uID)
{

$query = $this->db->query("select from_mes from messages where to_mes = '$uID' ");
return $query->result_array();

}

/*function senderData($ids)
{
$query=$this->db->query("select u_name from user where u_id in ($ids)");
return $query->result_array();
}*/

function senderName($id)
{
$query=$this->db->query("select u_name from user where u_id = $id");
return $query->result();
}

function viewMessages($uID, $id)
{
$query = $this->db->query("select message from messages where from_mes = $id and  to_mes = $uID");
return $query->result_array();

}
}

?>
