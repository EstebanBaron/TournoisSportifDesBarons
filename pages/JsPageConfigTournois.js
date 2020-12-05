function clotureEquipe()
{
    var r = confirm("ATTENTION! \n vous ne pourrez plus ajouter d'équipe");
    if(r)
    { 
        $("#ajoutEq").remove();
        $("#bouton").remove();

        let choixFormule = '<input type="submit" value = "choisir la formule">';
        $("#choixFormule").append(choixFormule);

        let commencerTournois = '<input type="submit" value = "commencer tournois" >';
        $("#tournois").append(commencerTournois);
    }  
}


// function cloturerChoixFormule() {
//     var reponseEstOK = confirm("ATTENTION! \n vous ne pourrez plus changer la formule");
//     if(reponseEstOK) { 
//         $("#choixFormule").remove();

//         let commencerTournois = '<input type="submit" value = "commencer tournois" >';
//         $("#tournois").append(commencerTournois);
//     }  
// }