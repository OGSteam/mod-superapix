
function universe(g,s,r,id_player,name_planete , name_moon) {
    this.g = g;
    this.s = s;
    this.r = r;
    this.id_player = id_player; // => on pourra recuperer nom / status / id ally et donc ally
    this.name_planete = name_planete;
    //si nom de lune alors : lune
    if(typeof(name_moon)=='undefined'){this.name_moon =  "0";} else {this.name_moon = name_moon;} ;
    if(typeof(name_moon)=='undefined'){this.moon =  "0";} else {this.moon = "1";} ;
    
  }   
     // recherche du timestamp
function find_universe_timestamp()
{
   	var headline = 	$(conteneur).find('universe');
    var value = headline.attr('timestamp');
 
    return value;

 }
 


 


 function sending_conteneur_CST_UNIVERSE(CST)
 {
   var tab = CST.split("_");
   var nb = parseInt(tab.length);
   
   var i = tab[nb-1];
  // alert(i);   
   var timestamp = find_universe_timestamp()
      
    
  
      sending_conteneur_CST_UNIVERSE_bis(CST, i , timestamp );
       // on prépare autant de tache que de galaxie a remplir
       
 
  
 }
 
 
 function sending_conteneur_CST_UNIVERSE_bis(CST, galaxie , timestamp )
 {
   // on prépare une galaxie vide
   value = new Object;     
  // var ss = 0 ;
  // var rr = 0;
  // for (ss =1; ss< (nb_sys + 1); ss++) 
  // {
    //    for (rr =1; rr< (nb_row + 1); rr++) 
    //   {    
    //    var temp = (ss * nb_row ) + rr ;
    //        value[temp] = new universe(galaxie,ss,rr,0,"",undefined);
    //  }
  // }
   
   // maintenant, il faut parcourir le fichier, en modifiant value via l index
   
  // console.log(task);
  // console.log(value);
    var i = 0 ;
     // on boucle 
   $(conteneur).find('planet[coords^=' + galaxie + ']').each(function() {
    var temp = $(this).attr('coords');
    tab_coords = temp.split(":");
    
     var my_g = parseInt(tab_coords[0]);
     var my_s = parseInt(tab_coords[1]);
     var my_r = parseInt(tab_coords[2]);
     var my_id_player = $(this).attr('player');
     var my_planet_name = $(this).attr('name');
     var my_moon_name = $(this).find('moon').attr('name');
   
    // on change ce qui va bien
    var temps =   (my_s * nb_row ) + my_r ;
   
    value[temps] = new universe(my_g,my_s,my_r,my_id_player,my_planet_name,my_moon_name);
       
 // console.log( value[index]);
    });
    
   // il ne reste plus qu'a envoyer'.
 

    // au cas ou il en reste :p
    ajax_query('superapix' ,'send' , CST , timestamp , value) ; 
     
 
 }