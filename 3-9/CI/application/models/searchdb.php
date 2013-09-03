<?php


class Searchdb extends CI_Model {
    var $query   = '';
    var $content = '';
    var $data2   = '';

    function __Constructor()
    {
        // Call the Model constructor
        parent::__Constructor();
    }
    
  public function index()
{

$this->load->database();


}

  public function search_user($data)
{

$this->load->database();
$this->db->like('u_name',$data);
$this->db->or_like('name',$data);
$this->db->select('u_id,u_name,name,u_type');
$query1=$this->db->get('user');

    return $query1->result();
}
/*
public function search_like($input){
	$this->load->database();
	$this->db->select('name')->from('user')->like('name',$input);
	$this->db->query("select * from question where question_id = $item");
	$questions = $this->db->get();
}
*/

}

?>
