function clotureEquipe()
{
    var r = confirm("ATTENTION! \n vous ne pourrez plus ajouter d'équipe");
    if(r)
    { 
        $("#ajoutEq").remove();
        $("#bouton").remove();

        let commencerTournois = '<input type="submit" name="boutonCloture" value="commencer tournois" >';
        $("#tournois").append(commencerTournois);
    }  
}