<?php 
if (!defined('IN_SPYOGAME')) die("Hacking attempt");


function insert_config($name,$value){
     global $db;
     
      	$query = "REPLACE INTO ".TABLE_CFG." (config_name, config_value) VALUES ('".$name."','".$value."')";
		$db->sql_query($query);
    
}


function find_config($name){
     global $db;
     
      	$query = "SELECT config_value FROM ".TABLE_CFG." WHERE config_name = '".$name."' ";
	    $result = $db->sql_query($query);
        $row = $db->sql_fetch_assoc($result);
          if($row) {return  $row['config_value'] ;}
      
}