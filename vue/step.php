<?php
if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");

include_once ("mod/superapix/common.php");


$step = (int)$pub_step;

$tab_stepper = constante_stepper();
$type = $tab_stepper[(int)$step];
$fields = array();


// on charge le xml
$value = f_chargement_fichier_xml(MOD_ROOT_XML . $type . ".xml");
//var_dump($value);

if ($type == "CST_PLAYERS")
{
    traitement_player($value);
   
}


if ($type == "CST_ALLIANCES")
{
    traitement_alliance($value);
  
}


if ($type == "CST_UNIVERSE")
{
    traitement_universe($value);
  
}



if ( strstr($type, "CST_ALLIANCES_RANK_"))
{
    traitement_alliance_rank($value, $type);

  
}



if ( strstr($type, "CST_PLAYERS_RANK_"))
{
    traitement_player_rank($value, $type);

  
}









function traitement_universe($value)
{

global $db , $user_data ,  $server_config , $pub_timestamp ; 
$table = TABLE_UNIVERS;
$sender_id = $user_data['user_id'] ;

$timestamp = find_timestamp($value);
 
 
$query = array();

$fields =  "g, s, r, id_player , datadate , name_planete ,name_moon , moon  , sender_id   " ;

foreach($value->planet as $ta_planete_en_cours) 
{
  $t_coordonnee = explode(':', $ta_planete_en_cours[0]['coords']); // récuperation coord en cours
  $g = $t_coordonnee[0];
  $s = $t_coordonnee[1];
  $r = $t_coordonnee[2];
  $id_player = (int)strval($ta_planete_en_cours[0]['player']);
  $datadate = $timestamp ; 
  $name_planete =  strval($ta_planete_en_cours[0]['name']);
  $name_moon = empty($s_nom_lune)?'': strval($ta_planete_en_cours[0]->moon['name']);
  $moon = empty($s_nom_lune)?'0':'1';
  //$sender_id = 
  




$query[] = "( ".$g.", ".$s." , ".$r."  , ".$id_player." , ".$datadate." , '".my_encodage($name_planete)."' , '".$name_moon."' , '".$moon."'  , ".$sender_id." ) ";
  


}

//$db->sql_query('REPLACE INTO '.$table.' ('.$fields.') VALUES '.implode(',', $query));
mass_replace_into($table,$fields,$query);


// on a plus qu a updater ...


$sql = "UPDATE ".TABLE_UNIVERSE." as U INNER JOIN ".TABLE_UNIVERS." as T ";
$sql .= " ON ";
$sql .= "( U.galaxy = T.g AND U.row = T.r  AND U.system = T.s )   ";
$sql .= "INNER JOIN ".TABLE_PLAYERS." as P ";
$sql .= " ON ";
$sql .= "( T.id_player = P.id_player  )   ";
$sql .= "INNER JOIN ".TABLE_ALLIANCES." as A ";
$sql .= " ON ";
$sql .= "( A.id_alliance = P.id_ally  )   ";
$sql .= " SET ";
$sql .= " U.moon = T.moon , U.name = T.name_planete  , U.ally = A.tag , U.player = P.name_player , U.status = P.status   , U.last_update = T.datadate   , U.last_update_user_id = T.sender_id  ";
$sql .= " WHERE  ";
$sql .= "  U.last_update < T.datadate ";


$db->sql_query($sql); 


prepare_table_universe($timestamp);


insert_config("last_CST_UNIVERSE",$timestamp );
}

function traitement_player($value)
{
    global $db,$type;
    $fields = "id_player, name_player, status, id_ally";
    $querys = array();
    $querys[] = "( 0, '' , '', 0 ) "; // player vide
     $timestamp = find_timestamp($value);


    foreach ($value->player as $ta_xml_player) {
        $querys[] = "( " . (int)$ta_xml_player[0]['id'] . ", '" . my_encodage(strval($ta_xml_player[0]['name'])) .
            "' , '" . strval($ta_xml_player[0]['status']) . "', " . (int)strval($ta_xml_player[0]['alliance']) .
            " ) ";
    }

    $db->sql_query('REPLACE INTO ' . TABLE_PLAYERS . ' (' . $fields . ') VALUES ' .
        implode(',', $querys));

insert_config("last_".$type,$timestamp );

}


function traitement_alliance($value)
{
    global $db , $type;
   $fields =  "id_alliance, tag, nb " ;
    $querys = array();
    $querys[] = "( 0 , '' , 0 ) ";// ally vide

   $timestamp = find_timestamp($value);
      
    foreach ($value->alliance as $ta_xml_alliance) {
        
  
    
     $temp_query = "( ".intval($ta_xml_alliance[0]['id']).", '".my_encodage(strval($ta_xml_alliance[0]['tag']))."' , '".$ta_xml_alliance->count()."' ) ";
     $querys[] = $temp_query;

    }

    $db->sql_query('REPLACE INTO ' . TABLE_ALLIANCES . ' (' . $fields . ') VALUES ' .
        implode(',', $querys));
        
         

insert_config("last_".$type,$timestamp );
}


function traitement_alliance_rank($value, $type)
{
    global $db , $type , $user_data;
  $fields =  "datadate, rank, id_alliance, points , sender_id " ;
    $querys = array();
    $attribut = array();
    
// on recupere les attribut :

      
        $timestamp = formatage_timestamp_for_rank(find_timestamp($value));
       
        

    foreach ($value->alliance as $ta_xml_rank) {
     
    $datadate = $timestamp ;
    $rank = (int)strval($ta_xml_rank[0]['position']) ;
    $id_alliance = (int)intval($ta_xml_rank[0]['id']);
    $points = (int)intval($ta_xml_rank[0]['score']); ;
       
     $temp_query = "( ".$timestamp.", ".$rank.", '".$id_alliance."' , '".$points."' , ".$user_data['user_id'] ." ) ";
     $querys[] = $temp_query;
     
    }

    $db->sql_query('REPLACE INTO ' . TABLE_RANK_ALLIANCES . ' (' . $fields . ') VALUES ' .
        implode(',', $querys));



    // on fait la jointure qui va bien pour injecter le bon classement

$sql = "REPLACE INTO ".find_table_rank_alliance($type)."  ";
$sql .= " ( `datadate`, `rank`, `ally`, `number_member`, `points` , `sender_id`) ";
$sql .= " SELECT sra.datadate, sra.rank, sa.tag, sa.nb , sra.points , sra.sender_id ";
$sql .= " FROM  ".TABLE_ALLIANCES." as sa ";
$sql .= "INNER JOIN ".TABLE_RANK_ALLIANCES." as sra "; 
$sql .= " on sa.id_alliance	= sra.id_alliance ; " ;

$db->sql_query($sql);


// on efface la table rank
$sql = "DELETE FROM ".TABLE_RANK_ALLIANCES." ;";
$db->sql_query($sql);

insert_config("last_".$type,$timestamp );

}


function find_table_rank_alliance($type)
{
    $tab = array();
    $tab = array(
    "CST_ALLIANCES_RANK_POINTS" => TABLE_RANK_ALLY_POINTS,
    "CST_ALLIANCES_RANK_ECO" => TABLE_RANK_ALLY_ECO,
   "CST_ALLIANCES_RANK_TECHNOLOGY" => TABLE_RANK_ALLY_TECHNOLOGY,
   "CST_ALLIANCES_RANK_MILITARY" => TABLE_RANK_ALLY_MILITARY,
   "CST_ALLIANCES_RANK_MILITARY_BUILT" => TABLE_RANK_ALLY_MILITARY_BUILT,
   "CST_ALLIANCES_RANK_MILITARY_DESTROYED" => TABLE_RANK_ALLY_MILITARY_DESTRUCT,
   "CST_ALLIANCES_RANK_MILITARY_LOST" => TABLE_RANK_ALLY_MILITARY_LOOSE,
   "CST_ALLIANCES_RANK_MILITARY_HONNOR" => TABLE_RANK_ALLY_HONOR,
    );
    $retour = $tab[$type];
    return $retour;
    
}

 
function traitement_player_rank($value, $type)
{
    global $db , $type , $user_data;
    $fields =  "datadate, rank, id, points , ships , sender_id " ;
    $querys = array();
    $attribut = array();
    
// on recupere les attribut :

      
    $timestamp = formatage_timestamp_for_rank(find_timestamp($value));
       
        

    foreach ($value->player as $ta_xml_rank)  {
     
    $datadate = $timestamp ;
    $rank = strval($ta_xml_rank[0]['position']);
    $id = intval($ta_xml_rank[0]['id']);
    $points = intval($ta_xml_rank[0]['score']);
    $ships = (int)($ta_xml_rank[0]['ships']) ; 
    $sender_id = (int)$user_data['user_id'] ;
    
    $temp_query =  $temp_query = "( ".$datadate.", ".$rank.", ".$id." , ".$points." , ".(int)$ships." , ".$user_data['user_id'] ." ) ";
    $querys[] = $temp_query;

    }

    $db->sql_query('REPLACE INTO ' . TABLE_RANK_PLAYERS . ' (' . $fields . ') VALUES ' .
        implode(',', $querys));


$table  = find_table_rank_player($type) ;
    // on fait la jointure qui va bien pour injecter le bon classement
$sql = "REPLACE INTO ".$table."  ";
$sql .= ($table != "CST_PLAYERS_RANK_MILITARY" ) ? " ( `datadate`, `rank`, `player`, `ally`, `points` , `sender_id`) " : " ( `datadate`, `rank`, `player`, `ally`, `points` , `ships` ,`sender_id`) " ;
$sql .= ($table != "CST_PLAYERS_RANK_MILITARY" ) ? " SELECT srp.datadate, srp.rank,sp.name_player  ,sa.tag,  srp.points , srp.sender_id " : " SELECT srp.datadate, srp.rank,sp.name_player  ,sa.tag, srp.points , srp.ships,srp.sender_id ";
$sql .= " FROM  ".TABLE_PLAYERS." as sp ";
$sql .= "INNER JOIN ".TABLE_RANK_PLAYERS." as srp "; 
$sql .= " on sp.id_player	= srp.id " ;
$sql .= "INNER JOIN ".TABLE_ALLIANCES." as sa "; 
$sql .= " on sa.id_alliance	= sp.id_ally ; " ;



$db->sql_query($sql);


// on efface la table rank
$sql = "DELETE FROM ".TABLE_RANK_PLAYERS." ;";
$db->sql_query($sql);

insert_config("last_".$type,$timestamp );

}

function find_table_rank_player($type)
{
    $tab = array();
    $tab = array(
    "CST_PLAYERS_RANK_POINTS" => TABLE_RANK_PLAYER_POINTS,
    "CST_PLAYERS_RANK_ECO" => TABLE_RANK_PLAYER_ECO,
   "CST_PLAYERS_RANK_TECHNOLOGY" => TABLE_RANK_PLAYER_TECHNOLOGY,
   "CST_PLAYERS_RANK_MILITARY" => TABLE_RANK_PLAYER_MILITARY,
   "CST_PLAYERS_RANK_MILITARY_BUILT" => TABLE_RANK_PLAYER_MILITARY_BUILT,
   "CST_PLAYERS_RANK_MILITARY_DESTROYED" => TABLE_RANK_PLAYER_MILITARY_DESTRUCT,
   "CST_PLAYERS_RANK_MILITARY_LOST" => TABLE_RANK_PLAYER_MILITARY_LOOSE,
   "CST_PLAYERS_RANK_MILITARY_HONNOR" => TABLE_RANK_PLAYER_HONOR,
    );
    $retour = $tab[$type];
    return $retour;
    
}

 
function find_timestamp($value)
{
       foreach($value->attributes() as $a => $b) 
		{
			$attribut[$a] = strval($b);
		}
        
        $timestamp = ((int)$attribut["timestamp"]);
        return $timestamp;
}


/// voir si utile
function prepare_table_universe( $datadate)
{
global $db , $user_data ,  $server_config;
$table = TABLE_UNIVERSE;

	

$sql = "";
$sql .= " UPDATE  ".$table."  ";
$sql .= " set ";
$sql .= " ally = '' , ";
$sql .= " player = '' , ";
$sql .= " status = '' , ";
$sql .= " gate = '0' , ";
$sql .= " phalanx = '0' , ";
$sql .= " last_update = '".$datadate."' ,";
$sql .= " name =  '', ";
$sql .= " moon = '0' ";


 $sql .= " where last_update < '".(int)$datadate."' ";  


 $db->sql_query($sql);
 
 
}