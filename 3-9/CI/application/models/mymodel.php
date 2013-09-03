<?php
class MyModel extends CI_Model
{

public function ViewProfile($id)
{
$query='select u_name,school,age,mail,city,profile_pic from user where u_id=?';
$data = $this->db->query($query,$id);
return $data->result();
}

public function getBuildingUpdate($id)
{
$query='select building_name, xLocation, yLocation, level, build_path, maintenance_time from building where u_id=?';
$data = $this->db->query($query,$id); 
return $data->result();
}

public function getAccountUpdate($id)
{
$query='select balance,knowledge,satisfication,level,health from account where u_id=?';
$data = $this->db->query($query,$id);
return $data->result();
}

function buildMaintenanceOut($uID, $Satisfication, $Knowledge){
	$this->db->query("UPDATE account SET  knowledge=knowledge+'$Knowledge', satisfication=satisfication+'$Satisfication' WHERE u_id=$uID");				
	} 
	
function maintenanceBuild($uID, $buildName, $timeNow, $xLocation, $yLocation, $Knowledge, $Satisfication){
	$this->db->query("UPDATE account SET  knowledge=knowledge+'$Knowledge', satisfication=satisfication+'$Satisfication' WHERE u_id=$uID ");
	$this->db->query("update building set maintenance_time='$timeNow'  where u_id='$uID' and building_name ='$buildName' and xLocation ='$xLocation' and yLocation='$yLocation'");

}	
	

function addBuilding($building, $uID, $Balance, $Satisfication, $Knowledge, $buildingTime){ 
	$name = $building->building_name;
	$picture = $building->build_path;
	$x = $building->xLocation;
	$y = $building->yLocation;
	$level=$building->level;
	$this->db->query("UPDATE account SET balance=balance+'$Balance' ,  knowledge=knowledge+'$Knowledge', satisfication=satisfication+'$Satisfication' WHERE u_id=$uID ");
	$this->db->query("insert into building(building_name, build_path, xLocation, yLocation,level,u_id, maintenance_time) 
	values('$name', '$picture', $x, $y, $level, $uID, $buildingTime)");	
	}
	

function deleteBuilding($building, $uID, $Balance, $Satisfication, $Knowledge){ 
	
	$name = $building->building_name;
	$x = $building->xLocation;
	$y = $building->yLocation;
	$this->db->query("UPDATE account SET balance=balance+'$Balance' , knowledge=knowledge+'$Knowledge', satisfication=satisfication+'$Satisfication' WHERE u_id=$uID");			
	$this->db->query("delete FROM building WHERE u_id = $uID AND  xLocation ='$x' AND yLocation = '$y'");
	
	}
	
	function mirror($uID, $xOld, $yOld ,$xNew ,$yNew ,$buildingName ,$buildingPath){
	$this->db->query("UPDATE building SET  xLocation ='$xNew' , yLocation = '$yNew' ,build_path='$buildingPath'  WHERE u_id=$uID and  xLocation ='$xOld' AND yLocation = '$yOld'");
	
	}
}
?>
