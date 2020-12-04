<?php
session_start();

$numTournois = NULL;
if (isset($_POST['numtournois'])) {
  $numTournois = $_POST['numtournois'];
}

function nbJoueurParEquipe() {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $nbEquipe = 0;
    foreach ($dbh->query('SELECT typejeu FROM tournois') as $row) {
      if ($row['numtournois'] == $numTournois)
        $nbEquipe = $row['typejeu'];
    }
    return $nbEquipe;
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}
$nbJoueurParEquipe = nbJoueurParEquipe();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page ajout des équipes</title>
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
  <?php
    if ($numTournois !== NULL) {
      ?>
        <h1>Création des équipes :  </h1>
        <p>(Les champs prefixés par des * sont obligatoires)</p>

        <form method="post">
        <div id="equipes">
          <div id="equipe1">
          <h2>Equipe 1 :</h2>
          <!-- nom -->
          <label for="nomEquipe1"> Nom d'équipe* :</label>
          <input type="text" name="nomEquipe1" maxlength="30" required><br>
          <!-- club -->
          <label for="clubEquipe1"> Club :</label>
          <input type="text" name="clubEquipe1" maxlength="30"><br>
          <h3>Joueurs :</h3>
          <ul>
          <?php
            $index = 0;
            while ($index < $nbJoueurParEquipe) {
              echo '<li>joueur'. ($index+1) . ' <br>';
              echo '<label for="nomJoueur' . ($index+1) . 'Equipe1"> Nom* :</label> ';
              echo '<input type="text" name="nomJoueur' . ($index+1) . 'Equipe1" maxlength="20" required><br>';
              echo '<label for="prenomJoueur' . ($index+1) . 'Equipe1"> Prenom* :</label> ';
              echo '<input type="text" name="prenomJoueur' . ($index+1) . 'Equipe1" maxlength="20" required><br>';
              echo '<label for="niveauJoueur' . ($index+1) . 'Equipe1"> Niveau* :</label> ';
              echo '<input type="number" name="niveauJoueur' . ($index+1) . 'Equipe1" min="1" max="7" value="0"></li><br>';
              
              $index++;
            }
          ?>
          </ul>
          </div>
        </div>
        </form>
        <button id="boutonAjoutEquipe" onclick="ajoutEquipe(<?php echo $nbJoueurParEquipe;?>)">autre équipe</button> <button id="boutonSupprimerEquipe">supprimer</button><br>
        
        <form mothod="post">
        <input type="submit" value="Valider" name="ajoutequipe">
        </form>
      <?php
    }
    else {
      echo "Erreur lors de l'envoi du numero de tournois !";
    }
  ?>
  <script src="autreElement.js"></script>
  </body>
</html>