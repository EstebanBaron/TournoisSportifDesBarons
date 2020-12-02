<?php
session_start();

function tousLesChampsSontRemplis() {
  $i = 0;
  $tournoisCreer = true;
  $tousLesChampsSontRemplis = true;
  while ($i < 10 && $tournoisCreer) {
    $nomTournois = "nomTournois" . $i;
    //check cb de tournois veut l'organisateur
    if (!($_POST[$nomTournois])) {
      $tournoisCreer = false;
    }
    else {
      //si un champ n'est pas rempli
      if (empty($_POST[$nomTournois])) {
        $toutLesChampsSontRemplis = false;
        $tournoisCreer = false;
      }
    }
    $i++;
  }

  return $tousLesChampsSontRemplis;
}

function tousLesSportsSontDiff() {
  $tousLesSportsSontDiff = true;
  $sports = array();
  $j = 0;
  $sortie = false;
  while ($j < 6 && !$sortie) {
    $sport = "sport" . $j;
    if (isset($_POST[$sport])) {
      if (in_array($_POST[$sport], $sports)) {
        $tousLesSportsSontDiff = false;
        $sortie = true;
      }
      else {
        array_push($sports, $_POST[$sport]);
      }
      $j++;
    }
    else {
      $sortie = true;
    }
  }

  return $tousLesSportsSontDiff;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page de creation d'événement</title>
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
    <h1>Créer votre événement :</h1>
    <form method="post">
    <p>(Les champs prefixés par des * sont obligatoires)</p>
    <!-- nom -->
    <label for="nom"> Nom* :</label>
    <input type="text" name="nom" maxlength="40" required><br>

    <!-- lieu -->
    <label for="lieu"> Lieu* :</label>
    <input type="text" name="lieu" maxlength="20" required><br>

    <!-- date evenement -->
    <label for="dateevenement"> Date de l'événement* :</label>
    <input type="date" name="dateevenement" required><br>
    <!-- </form> -->

    <h3>Tournois : </h3>
    <form method="post">
    <div id="tournois">
      <div id="divNumTournois0">
      <label for="nomTournois0"> Nom du tournois* :</label>
      <input type="text" name="nomTournois0" maxlength="40" required>&nbsp;&nbsp; 
      <label for="typeTournois0"> Type du tournois* :</label>
      <select name="typeTournois0">
        <option value="1vs1">1vs1</option>
        <option value="2vs2">2vs2</option>
        <option value="3vs3">3vs3</option>
        <option value="5vs5">5vs5</option>
        <option value="6vs6">6vs6</option>
        <option value="7vs7">7vs7</option>
        <option value="11vs11">11vs11</option>
        <option value="15vs15">15vs15</option>
      </select>
      <br>
      </div>
    </div>
    <button id="boutonTournois">autre tournois</button> <button id="boutonSupprimerTournois">supprimer</button><br>
    <!-- </form> -->

    <h3>Terrains : </h3>
    <!-- <form method="post"> -->
    <div id="terrain">
      <div id="divNumTerrain0">
      <select name="sport0">
        <option value="Football">Football</option>
        <option value="Basketball">Basketball</option>
        <option value="Tennis">Tennis</option>
        <option value="Rugby">Rugby</option>
        <option value="Petanque">Pétanque</option>
        <option value="Volley">Volley</option>
      </select>
      <input type="number" name="nbTerrain0" min="1" max="100" value="1"><br>
      </div>
    </div>
    <button id="boutonTerrain">autre terrain</button> <button id="boutonSupprimerTerrain">supprimer</button><br>
    
    <br><br>
    <input type="submit" value="Creer l'événement" name="creationevenement">
    </form>
    
    <?php
    if (isset($_POST['nom'], $_POST['lieu'], $_POST['dateevenement'], $_POST['creationevenement'])) {
      //check de tous les tournois
      $tousLesChampsSontRemplis = tousLesChampsSontRemplis();
      //check que tous les sports soient différents
      $tousLesSportsSontDiff = tousLesSportsSontDiff();

      if ($tousLesChampsSontRemplis) {
        if (!$tousLesSportsSontDiff) {
          echo '<script type="text/javascript">';
          echo 'alert("Les sports doivent être tous différents !");';
          echo '</script>';
        }
        else {
          echo "C bon";
        }
      }
    }
    ?>
    <script src="autreElement.js"></script>
  </body>
</html>