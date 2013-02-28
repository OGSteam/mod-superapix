///fonction representant un objet rank ( une ligne de classement alliance )
function alliance_rank(position,id,score) {
    this.position = position;
    this.id = id;
    this.score = score;
   
    
  }   
     // recherche du timestamp
function find_rank_alliance_timestamp()
{
   	var headline = 	$(conteneur).find('highscore');
    var value = headline.attr('timestamp');

 
    return value;

  }
  

function sending_conteneur_CST_ALLIANCES_RANK_TECHNOLOGY(CST)
{
    sending_conteneur_rank_generique(CST) ; 
}
function sending_conteneur_CST_ALLIANCES_RANK_TECHNOLOGY(CST)
{
    sending_conteneur_rank_generique(CST) ; 
}

function sending_conteneur_CST_ALLIANCES_RANK_ECO(CST)
{
    sending_conteneur_rank_generique(CST) ; 
}

function sending_conteneur_CST_ALLIANCES_RANK_POINTS(CST)
{
    sending_conteneur_rank_generique(CST) ;
}
function sending_conteneur_CST_ALLIANCES_RANK_MILITARY(CST)
{
    sending_conteneur_rank_generique(CST) ;
}

function sending_conteneur_CST_ALLIANCES_RANK_MILITARY_BUILT(CST)
{
    sending_conteneur_rank_generique(CST) ;
}
function sending_conteneur_CST_ALLIANCES_RANK_MILITARY_DESTROYED(CST)
{
    sending_conteneur_rank_generique(CST) ;
}
function sending_conteneur_CST_ALLIANCES_RANK_MILITARY_LOST(CST)
{
    sending_conteneur_rank_generique(CST) ;
}
function sending_conteneur_CST_ALLIANCES_RANK_MILITARY_HONNOR(CST)
{
    sending_conteneur_rank_generique(CST) ;
}


   
   

 // CST necessaire uniquement pour fonctions génériques (classement par ex)
function sending_conteneur_rank_generique(CST)    
{
 // timestamp   
 timestamp =  find_rank_alliance_timestamp();
 value = new Object;    

              
 // nb_player
 var count = 0;
 

 // on boucle sur le nb de joueur
 $(conteneur).find("alliance").each(function() {
 //          console.log($(this));
    var position = $(this).attr('position');
    var id = $(this).attr('id')
    var score = $(this).attr('score')
  
    
    // protection undefined ( on place ici pour pas reiterer la recherche d attr
   
      
    value[count] = new alliance_rank(position,id,score);       
     //console.log(new player(name,id,status,alliance));          
    count= count+1;           
        });
  
  
 
    // hop on envoit le tout ...
     ajax_query('superapix' ,'send' , CST , timestamp , value) ; 
    
    
}

