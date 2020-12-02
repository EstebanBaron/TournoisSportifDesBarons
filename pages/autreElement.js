var numTournois = 0;
var numTerrain = 0;

$("#boutonTournois").click(function autreTournois() {
    if (numTournois < 9) {
        numTournois++;
        let html = "";
        html += '<div id="divNumTournois' + numTournois + '">';
        html += '<label for="nomTournois' + numTournois + '"> Nom du tournois* :</label> ';
        html += '<input type="text" name="nomTournois' + numTournois + '" maxlength="40" required>&nbsp;&nbsp';

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
})

$("#boutonSupprimerTournois").click(function supprimerTournois() {
    if (numTournois > 0) {
        let idDivNumTournois = "#divNumTournois" + numTournois;
        $(idDivNumTournois).remove(); 
        numTournois--;
    }
    else {
        console.log("Aucun élément à supprimer.");
    }
})

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
        html += '<input type="number" name="nbTerrain' + numTerrain + '" min="1" max="100" value="1"><br>';
        html += '</div>';

        $("#terrain").append(html);
    }
    else {
        alert("Le nombre maximum de tournois a été atteint!");
    }
})

$("#boutonSupprimerTerrain").click(function supprimerTerrain() {
    if (numTerrain > 0) { 
        let idDivNumTerrain = "#divNumTerrain" + numTerrain;
        $(idDivNumTerrain).remove(); 
        numTerrain--;
    }
    else {
        console.log("Aucun élément à supprimer.");
    }
})