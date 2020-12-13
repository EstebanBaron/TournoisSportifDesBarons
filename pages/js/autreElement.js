//variables à incrémenter pour les names des input ajouté dynamiquement
var numTournois = 0;
var numTerrain = 0;

//ajout d'un tournois
$("#boutonTournois").click(function autreTournois() {
    if (numTournois < 9) {
        numTournois++;
        let html = "";
        html += '<div id="divNumTournois' + numTournois + '">';
        html += '<label for="nomTournois' + numTournois + '"> Nom du tournois* :</label> ';
        html += '<input type="text" name="nomTournois' + numTournois + '" maxlength="40" required>&nbsp;&nbsp;';

        html += '<label for="typeTournois' + numTournois + '"> Type du tournois* :</label> ';
        html += '<select name="typeTournois' + numTournois + '">';
        html += '<option value="1vs1">1vs1</option>';
        html += '<option value="2vs2">2vs2</option>';
        html += '<option value="3vs3">3vs3</option>';
        html += '<option value="5vs5">5vs5</option>';
        html += '<option value="6vs6">6vs6</option>';
        html += '<option value="7vs7">7vs7</option>';
        html += '<option value="11vs11">11vs11</option>';
        html += '<option value="15vs15">15vs15</option>';
        html += '</select>';
        html += '</br>';
        html += '</div>';

        $("#tournois").append(html);
    }
    else {
        alert("Le nombre maximum de tournois a été atteint!");
    }
});

//ajout d'un terrain
$("#boutonTerrain").click(function autreTerrain() {
    if (numTerrain < 5) {
        numTerrain++;
        let html = "";
        html += '<div id="divNumTerrain' + numTerrain + '">';
        html += '<select name="sport' + numTerrain + '">';
        html += '<option value="Football">Football</option>';
        html += '<option value="Basketball">Basketball</option>';
        html += '<option value="Tennis">Tennis</option>';
        html += '<option value="Rugby">Rugby</option>';
        html += '<option value="Petanque">Pétanque</option>';
        html += '<option value="Volley">Volley</option>';
        html += '</select> ';
        html += '<input type="number" name="nbTerrain' + numTerrain + '" min="1" max="100" value="1">';
        html += '<br>';
        html += '</div>';

        $("#terrain").append(html);
    }
    else {
        alert("Le nombre maximum de tournois a été atteint!");
    }
});

//suppression d'un tournois
$("#boutonSupprimerTournois").click(function supprimerTournois() {
    if (numTournois > 0) {
        let idDivNumTournois = "#divNumTournois" + numTournois;
        $(idDivNumTournois).remove(); 
        numTournois--;
    }
    else {
        console.log("Aucun élément à supprimer.");
    }
});

//suppression d'un terrain
$("#boutonSupprimerTerrain").click(function supprimerTerrain() {
    if (numTerrain > 0) { 
        let idDivNumTerrain = "#divNumTerrain" + numTerrain;
        $(idDivNumTerrain).remove(); 
        numTerrain--;
    }
    else {
        console.log("Aucun élément à supprimer.");
    }
});


//variable à incrémenter pour les name lors de l'ajout d'une equipe
var numEquipe = 1;

//ajout equipe en fonction du nombre de joueur (typeJeu choisi)
function ajoutEquipe(nbJoueur) {
    if (numEquipe < 16) {
        numEquipe++;
        let html = "";
        html += '<div id="equipe' + numEquipe + '">';
        html += '<h2>Equipe ' + numEquipe + '</h2>';
        html += '<label for="nomEquipe' + numEquipe + '"> Nom d\'équipe* (espace non accepté) :</label> ';
        html += '<input type="text" name="nomEquipe' + numEquipe + '" maxlength="30" required onblur="this.value=removeSpaces(this.value);"><br>';
        html += '<label for="clubEquipe' + numEquipe + '">Club :</label> ';
        html += '<input type="text" name="clubEquipe' + numEquipe + '" maxlength="30"><br>';
        html += '<h3>Joueurs</h3>';
        html += '<ul>';
        let index = 0;
        while (index < nbJoueur) {
            html += '<li>joueur ' + (index+1) + '<br>';
            html += '<label for="nomJoueur' + (index+1) + 'Equipe' + numEquipe + '"> Nom* :</label> ';
            html += '<input type="text" name="nomJoueur' + (index+1) + 'Equipe' + numEquipe + '" maxlength="20" required><br>';
            html += '<label for="prenomJoueur' + (index+1) + 'Equipe' + numEquipe + '"> Prenom* :</label> ';
            html += '<input type="text" name="prenomJoueur' + (index+1) + 'Equipe' + numEquipe + '" maxlength="20" required><br>';
            html += '<label for="niveauJoueur' + (index+1) + 'Equipe' + numEquipe + '"> Niveau* :</label> ';
            html += '<select name="niveauJoueur' + (index+1) + 'Equipe' + numEquipe + '">';
            html += '<option value="1">Loisir</option>';
            html += '<option value="2">Départemental</option>';
            html += '<option value="3">Régional</option>';
            html += '<option value="4">N3</option>';
            html += '<option value="5">N2</option>';
            html += '<option value="6">Elite</option>';
            html += '<option value="7">Pro</option>';
            html += '</select></li>';
            index++;
        }
        html += '</ul>';
        html += '</div>';

        $("#equipes").append(html);
    }
    else {
        alert("Le nombre maximum d'équipe a été atteint!");
    }
}

//supprimer une equipe
$("#boutonSupprimerEquipe").click(function supprimerEquipe() {
    if (numEquipe > 1) { 
        let idDivNumEquipe = "#equipe" + numEquipe;
        $(idDivNumEquipe).remove(); 
        numEquipe--;
    }
    else {
        console.log("Aucun élément à supprimer.");
    }
});

function removeSpaces(string) {
    return string.split(' ').join('');
}

