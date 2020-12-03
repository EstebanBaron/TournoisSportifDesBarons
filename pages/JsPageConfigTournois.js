

function clotureBouton()
{
    var r = confirm("ATTENTION! \n vous ne pourrez plus ajouter d'équipe");
    if(r)
    { 
    $("#ajoutEq").remove();
    $("#bouton").remove();
    
    var txt = '<input type="submit" value = "commencer tournois" >';
    $("#tournois").append(txt);
    }
    
}