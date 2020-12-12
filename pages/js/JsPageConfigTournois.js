function clotureEquipe()
{
    var r = confirm("ATTENTION! \n vous ne pourrez plus ajouter d'équipe");
    if(r)
    { 
        $("#ajoutEq").remove();
        $("#ajoutEqAvecClassement").remove();
        $("#buttonCloturer").remove();

        let commencerTournois = '<input class="button" type="submit" name="boutonCloture" value="commencer le tournois" >';
        $("#Formtournois").append(commencerTournois);
    }  
}