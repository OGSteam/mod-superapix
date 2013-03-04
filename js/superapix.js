


function get_CST_crossdomain(CST) {
   
	$.ajax({
		type: "GET",
		url: "index.php?action=superapix&sub_action=cross&url=" + CST + "" ,
		dataType: "xml",
        async : false,
        success: function(xml) {
       save_crossdomain(xml) ;
  	}
	});
}

function save_crossdomain(xml)
{
     conteneur = xml;
     //console.log(xml);
  
}




function ajax_query(my_action,my_sub_action , my_type , my_timestamp , my_value)
{
    var nouvel_valeur = new Object;    
    var my_nummer = 0
    for(var valeur in my_value)
    {
    // console.log(valeur + ' : ' + my_value[valeur] + '  ');
     nouvel_valeur[my_nummer] = my_value[valeur];
     my_nummer = my_nummer + 1 ;
     if(my_nummer > nb_send_max)
     { 
        task = task +1 ;
        sub_ajax_query(my_action,my_sub_action , my_type , my_timestamp , nouvel_valeur) // on inject
        nouvel_valeur =  new Object;// on vide l object
        my_nummer = 0 ; // remise a 0     
     }
   }
   
   
   
    task = task +1 ;
    // si je met en place un systeme de limitation par envoi
    sub_ajax_query(my_action,my_sub_action , my_type , my_timestamp , nouvel_valeur)
      
}


function sub_ajax_query(my_action,my_sub_action , my_type , my_timestamp , my_value)
{
    
  
   jQuery.ajax({
    
    type: 'post', // Le type de ma requete
    url: 'index.php', // L'url vers laquelle la requete sera envoyee
    async: false, 
    data: {
            'action': my_action, // Les donnees que l'on souhaite envoyer au serveur au format JSON
            'sub_action' : my_sub_action,
            'type' : my_type,
            'timestamp' : my_timestamp , 
            'value' : my_value  
    
            }, 
  success: function(data, textStatus, jqXHR) 
          {
       // alert(data);
       console.log(data);
       task = task - 1 ; // ( on decremente si jamais il y a tache en attente si pas le cas 0 - 1 = inf a 1 )
       if ( task < 1 ){ next_step(step); }
       

            
          },
  error: function(jqXHR, textStatus, errorThrown) {
            alert("echec lamentable");
            }
}); 
    
    
    
    
    



}
function next_step(nb)
{
    nb = nb + 1 ;
    if ( nb == 27 ) { window.location = "index.php?action=superapix"  ; }
    else
    {
        window.location = "index.php?action=superapix&step=" + nb ;
    }
     
}



