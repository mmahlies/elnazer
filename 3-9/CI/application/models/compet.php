<?php 

   class compet extends CI_Model{
   
          function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    

      function index(){
                      }

	public function checkRequest($_session_uid,$to)
	{
       /* $query1=$this->db->query("SELECT * FROM request_competition WHERE reciever_id = "."'".($_session_uid)."'"."AND sender_id = "."'"($uname)."'");*/
//$query1=$this->db->query("SELECT * FROM request_competition WHERE reciever_id like "."'".$_session_uid."'"." AND sender_id = "."'"$uid."'");
	//return $query->result();
		$this->db->where('reciever_id',$to);
		$this->db->where('sender_id',$_session_uid);
		$this->db->select('status');
		$status=$this->db->get('request_competition');
		return $status->result();
	}	
     public function addRequest($uname)
        {//if (isset($uname))
		
         $query1=$this->db->query("SELECT * FROM user WHERE u_name like "."'".($uname)."'");
         return $query1->result();
        
		
		}
		

      public function add($_session_uid,$to)
        { 
         $data=array(
                      'reciever_id'=>$to,
                      'sender_id'=>$_session_uid
                     );        
        $this->db->insert('request_competition',$data);
        $comp_id=mysql_insert_id();
        return $comp_id;
        //return $query2->result(); that ensure that the insert is already added 
        }                    

//this accepting req has a com_id value but we need another fn to get the not values and comp_id if the accpt req appeared in feeds
      public function acceptingRequest($comp_id,$flag)
       {
        //SELECT * FROM user WHERE u_name like 

        if ($flag==1)
             { 
			 $data=array(
			        'status'=>$flag
					     );
			 
				$this->db->where('req_id', $comp_id);
				$this->db->update('request_competition', $data); 
                 echo "VALUES (1)";
             } 
          
        else if ($flag==0)
             {
			 $data=array(
			        'status'=>$flag
					     );
			 
				$this->db->where('req_id', $comp_id);
				$this->db->update('request_competition', $data); 
               echo "VALUES (0)";
             }


       else 
             { echo "error::undefined flag value";}


        }

                                       }




?>
