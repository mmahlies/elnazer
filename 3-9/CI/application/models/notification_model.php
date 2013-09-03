<?php

class Notification_model extends CI_Model{

	function Add_notification($from,$to,$type,$req_id)
	{	$this->load->helper('date');
		/*$format = 'DATE_RFC822';
		$now=now();
		$date=standard_date($format, $now); */
		///? problem (date in db is 0000.00.0)
		$date=date("F j, Y, g:i a");
		$data = array(
		'addedBy_ID' => $from ,
		'to_ID' => $to,
		'action_type' => $type ,
		'read'=>0 ,
		'read_date'=>$date,
		'req_id'=>$req_id
       );

		$this->db->insert('notifications', $data); 

	}
	function Remove_notifications($userId)
	{
		$before_date=//now date - 3 months
		$this->db->where('to_ID',$userId);
		//check this?
		$this->db->where('read_date <',$before_date);
		$this->db->delete('notifications'); 

	}
	function Make_read($notification_ID)
	{
		$this->db->where('notification_ID',$notification_ID);
		$data=array('read'=>1);
		$this->db->update('notifications', $data); 

	}
	function Get_read_date($notificaion_ID)
	{
		$this->db->where('notificaion_ID',$notificaion_ID);
		$this->db->select('read_date');
		$date = $this->db->get('notifications');
		return $date;
	}
	function Check_read($notificaion_ID)
	{
		$this->db->where('notificaion_ID',$notificaion_ID);
		$this->db->select('read');
		$read = $this->db->get('notifications');
		if ($read==1)
		{return true;}
		elseif($read==0)
		{return false;}
	}
	function Get_user_notifications($to_ID)
	{
		$this->db->where('to_ID',$to_ID);
		$user_notifications = $this->db->get('notifications');
		return $user_notifications;
	}




}









?>