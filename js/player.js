///fonction representant un objet rank ( une ligne de classement alliance )
function player(name,id,status,alliance) {
    this.name = name;
    this.id = id;
    this.status = status;
    this.alliance = alliance;
    
  }   
     // recherche du timestamp
function find_players_timestamp()
{
   	var headline = 	$(conteneur).find('players');
    var value = headline.attr('timestamp');

 
    return value;

  }
  
  
function nb_players()
{
     var headline = 	$(conteneur).find('player');
     var nb = headline.length;
    
     return nb;
}  
    
  
  // CST necessaire uniquement pour fonctions génériques (classement par ex)
function sending_conteneur_CST_PLAYERS(CST)    
{
 // timestamp   
 timestamp =  find_players_timestamp();
 value = new Object;    

              
 // nb_player
 var nb = nb_players();
 var count = 0;
 

 // on boucle sur le nb de joueur
 $(conteneur).find("player").each(function() {
 //          console.log($(this));
    var name = $(this).attr('name');
    var id = $(this).attr('id')
    var status = $(this).attr('status')
    var alliance = $(this).attr('alliance')   
    
    // protection undefined ( on place ici pour pas reiterer la recherche d attr
    if(status == undefined) { status = "" ; }
    if(alliance == undefined) { alliance = "" ; }
      
    value[count] = new player(name,id,status,alliance);       
     //console.log(new player(name,id,status,alliance));          
    count= count+1;           
        });
  
  
 
    // hop on envoit le tout ...
     ajax_query('superapix' ,'send' , CST , timestamp , value) ; 
    
    
}

