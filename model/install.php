<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");



function create_table_config()
{
    global $db;
    
    $sql = " CREATE TABLE If NOT EXISTS ".TABLE_CFG." ( ";
    $sql .= " config_name varchar(255) NOT NULL default '', ";
    $sql .= " config_value varchar(255) NOT NULL default '', ";
    $sql .= " PRIMARY KEY  (config_name) ) ;";
    
    $db->sql_query($sql);    
}


function delete_table_config()
{
    global $db;
    
    $sql = " DROP TABLE IF EXISTS ".TABLE_CFG." ;";
    
    $db->sql_query($sql);    
}


function create_table_players()
{
    global $db;
    
    $sql = " CREATE TABLE If NOT EXISTS ".TABLE_PLAYERS." ( ";
    $sql .= " id_player INT(6) NOT NULL , ";
    $sql .= " name_player varchar(65) NOT NULL , ";
    $sql .= " status varchar(6) NOT NULL default '', ";
    $sql .= " id_ally INT(6) NOT NULL ,  ";
    $sql .= " PRIMARY KEY  (id_player) ) ;";
    
    $db->sql_query($sql);    
}


function delete_table_players()
{
    global $db;
    
    $sql = " DROP TABLE IF EXISTS ".TABLE_PLAYERS." ;";
    
    $db->sql_query($sql);    
}

function create_table_alliances()
{
    global $db;
    
    $sql = " CREATE TABLE If NOT EXISTS ".TABLE_ALLIANCES." ( ";
    $sql .= " id_alliance INT(6) NOT NULL , ";
    $sql .= " tag varchar(65) NOT NULL , ";
    $sql .= " nb varchar(6) NOT NULL default '', ";
    $sql .= " PRIMARY KEY  (id_alliance) ) ;";
    
    $db->sql_query($sql);    
}

    
    
function delete_table_alliances()
{
    global $db;
    
    $sql = " DROP TABLE IF EXISTS ".TABLE_ALLIANCES." ;";
    
    $db->sql_query($sql);    
}


function create_table_rank_alliance()
{
     global $db;
    
    $sql = " CREATE TABLE If NOT EXISTS ".TABLE_RANK_ALLIANCES." ( ";
    $sql .= " datadate INT(11) NOT NULL , ";
    $sql .= " rank INT(11) NOT NULL , ";
    $sql .= " id_alliance INT(11) NOT NULL , ";
    $sql .= " points INT(11) NOT NULL, ";
   $sql .= " sender_id INT(11) NOT NULL, ";
    $sql .= " PRIMARY KEY (`rank`,`datadate`,`id_alliance`));";

    
    $db->sql_query($sql);    
    
     
}


function delete_table_rank_alliance()
{
    global $db;
    
    $sql = " DROP TABLE IF EXISTS ".TABLE_RANK_ALLIANCES." ;";
    
    $db->sql_query($sql);    
}
function create_table_rank_player()
{
     global $db;
    
    $sql = " CREATE TABLE If NOT EXISTS ".TABLE_RANK_PLAYERS." ( ";
    $sql .= " datadate INT(11) NOT NULL , ";
    $sql .= " rank INT(11) NOT NULL , ";
    $sql .= " id INT(11) NOT NULL , ";
    $sql .= " points INT(11) NOT NULL, ";
    $sql .= " ships INT(11) NOT NULL default '0' , ";
   $sql .= " sender_id INT(11) NOT NULL, ";
    $sql .= " PRIMARY KEY (`rank`,`datadate`,`id`));";

    
    $db->sql_query($sql);    
    
  
}


function delete_table_rank_player()
{
    global $db;
    
    $sql = " DROP TABLE IF EXISTS ".TABLE_RANK_PLAYERS." ;";
    
    $db->sql_query($sql);    
}

function create_table_univers()
{
     global $db;
    
    $sql = " CREATE TABLE If NOT EXISTS ".TABLE_UNIVERS." ( ";
    $sql .= " g INT(2) NOT NULL , ";
    $sql .= " s INT(3) NOT NULL , ";
    $sql .= " r INT(2) NOT NULL , ";
    $sql .= " id_player INT(11) NOT NULL, ";
   $sql .= " datadate INT(11) NOT NULL, ";
    $sql .= " name_planete VARCHAR(40) NOT NULL  , ";
    $sql .= " name_moon VARCHAR(40) NOT NULL  , ";
    $sql .= " moon VARCHAR(1) NOT NULL  , ";
       $sql .= " sender_id INT(11) NOT NULL, ";
    $sql .= " UNIQUE KEY univers (g,s,r) );";

    
    $db->sql_query($sql);    
    
  
}


function delete_table_univers()
{
    global $db;
    
    $sql = " DROP TABLE IF EXISTS ".TABLE_UNIVERS." ;";
    
    $db->sql_query($sql);    
}

