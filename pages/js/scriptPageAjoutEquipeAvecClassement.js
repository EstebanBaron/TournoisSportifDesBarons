function afficheClassement(classement) {
    //clear la div
    document.getElementById("divClassement").innerHTML = "";
    //puis on la rempli de nouveau avec le classement du tournois selectionné
    let tabClassement = classement.split(',');
    let ligneAppend = '<div>';
    ligneAppend += '<p>Sélectionnez l\'équipe à partir de laquelle vous voulez la fin du classement (elle y compris) :</p>';

    let index = 0;
    while (index < tabClassement.length) {
        ligneAppend += '<button type="button" onclick="classementAPartirDe(\'' + tabClassement[index] + '\', \'' + classement + '\');">' +  tabClassement[index] + '</button>';
        index ++;
    }
    ligneAppend += '</div><br><br>';

    $("#divClassement").append(ligneAppend);
}

//renvoi le classement a partir de l'equipe qui a été selectionnée 
//(ex : classement = {eq2, eq3, eq1, eq4}, on clique sur eq3 alors ca renvoi => {eq3, eq1, eq4} 
function classementAPartirDe(equipe, classement) {
    //clear la div
    document.getElementById("divEquipesSelectionnees").innerHTML = "";


    let tabClassement = classement.split(',');
    while (tabClassement[0] != equipe) { //enleve toutes les equipes devant l'équipe séléctionné
        tabClassement.splice(0, 1);
    }

    let ligneAppend = '<h4>Equipes selectionnées : </h4>';
    let index = 0;
    let equipes = "";
    while (index < tabClassement.length) {
        equipes += tabClassement[index] + ", ";
        index++;
    }
    equipes = equipes.substring(0, equipes.length - 2); //enlever ', ' de la fin

    let boutonEnvoiDonneesBase = '<br><button type="button" onclick="envoiDesDonnees();">valider les équipes sélectionnées</button>';

    $("#divEquipesSelectionnees").append(ligneAppend);
    $("#divEquipesSelectionnees").append(equipes);
    $("#divEquipesSelectionnees").append(boutonEnvoiDonneesBase);

    //clear le form
    document.getElementById("ajoutEquipes").innerHTML = "";
    //ajout des données dans le form
    let donnees = '<input type="hidden" name="equipesSelectionnees" value="' + equipes + '">';
    $("#ajoutEquipes").append(donnees);
}

//une fois le bouton mis dans le formulaire, les équipes vont être envoyées dans la base
function envoiDesDonnees() {
    let boutonRetourPageConfigTournois = '<input id="boutonEnvoi" type="submit" name="boutonEnvoi" value="envoyer les données dans la base">';
    $("#ajoutEquipes").append(boutonRetourPageConfigTournois);
}