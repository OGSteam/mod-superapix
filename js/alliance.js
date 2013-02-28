///fonction representant un objet rank ( une ligne de classement alliance )
function alliance(id,tag,nb) {
    this.id = id;
    this.tag = tag;
    this.nb = nb;
   
    
  }   
     // recherche du timestamp
function find_alliances_timestamp()
{
   	var headline = 	$(conteneur).find('alliances');
    var value = headline.attr('timestamp');

 
    return value;

  }
  
  
function nb_alliances()
{
     var headline = 	$(conteneur).find('alliance');
     var nb = headline.length;
    
     return nb;
}  

function nb_player_of_alliances(ally)
{
     var headline = 	$(ally).find('player');
     var nb = headline.length;
    
     return nb;
}  





 // CST necessaire uniquement pour fonctions génériques (classement par ex)
function sending_conteneur_CST_ALLIANCES(CST)    
{
 // timestamp   
 timestamp =  find_alliances_timestamp();
 value = new Object;    
 

              
 // nb_player
 var nb = nb_alliances();
 var count = 0;
 

 // on boucle sur le nb de joueur
 $(conteneur).find("alliance").each(function() {
 //          console.log($(this));
    var id = $(this).attr('id')
    var tag = $(this).attr('tag')
    var nb = nb_player_of_alliances($(this));
    
  
         
    value[count] = new alliance(id,tag,nb);       
     //console.log(new player(name,id,status,alliance));          
    count= count+1;           
        });
  
  
 
    // hop on envoit le tout ...
   ajax_query('superapix' ,'send' , CST , timestamp , value) ; 
    
    
}

