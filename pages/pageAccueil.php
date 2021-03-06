<?php
session_start();

//vérifie que tous les tournois sont fini et donc que l'événement est terminé ou en cours
function tousLesTournoisSontFinis($resultatRequete, $numEvenement) {
  $tousLesTournoisSontFinis = true;
  foreach ($resultatRequete as $ligne) {
    if ($ligne['numevenement'] === $numEvenement) {
      if ($ligne['classement'] === NULL) {
        $tousLesTournoisSontFinis = false;
      }
    }
  }

  return $tousLesTournoisSontFinis;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
    <link rel="stylesheet" href="css/styleAccueil.css" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body>
    <div class="barreTitre">
      <div class="divTitre">
        <a class="titre">La Baronnerie</a>
      </div>

      <div class="divDeco">
        <a class="boutonDeconnexion" href="pageAuthentification.php">Déconnexion</a>
      </div>
    </div>
    
    <h1>Accueil</h1>

    <div class="evenement">
    <h2>Mes événements en cours :</h2>
    <?php 
      //ici on va afficher les événements en cours de l'organisateur identifié 
      try {
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        $evenement = $dbh->query('SELECT identifiant, numevenement, E.nom, lieu, dateevenement from organisateur O, evenement E where idorga = identifiant');
        //on recupere les evenements par organisateur
        if ($evenement) {
          foreach ($evenement as $row) {
            if ($row['identifiant'] === $_SESSION['identifiant']) {
              //on recupere les classements de chaque tournois pour savoir si l'événement est terminé ou non
              $classements = $dbh->query('SELECT T.numevenement, classement from tournois T, evenement E where T.numevenement = E.numevenement');
              $numEvenement = $row['numevenement'];
              if ($classements) {
                $tousLesTournoisSontFinis = tousLesTournoisSontFinis($classements, $numEvenement);
              }
              else {
                echo "Erreur, les données de la base n'ont pas pu être récupérées ! <br>";
                echo "Aucune donnée n'est donc affichée.";
                $tousLesTournoisSontFinis = true;
              }
              if (!$tousLesTournoisSontFinis) { //cas où ils ne sont pas terminé 
                echo '<form method="post" action="pageEvenement.php">';
                echo '<input type="hidden" name="numevenement" value="' . $row["numevenement"] . '" />';
                echo '<input class="button" type="submit" value="' . $row["nom"] . ' - ' . $row["lieu"] . ' - ' . $row["dateevenement"] . '" /><br>';
                echo '</form>';
              }
            }
          }
        }
        else {
          echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
        }
        $dbh = null;
    } catch (PDOException $e) {
        print "Erreur ! : " . $e->getMessage() . "<br>";
        die();
    }
    ?>
    </div>
    <div class="evenement">
    <h2>Mes événements terminés :</h2>
    <?php 
      //idem qu'au dessus mais pour les événements terminé
      try {
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        $evenement = $dbh->query('SELECT identifiant, numevenement, E.nom, lieu, dateevenement from organisateur O, evenement E where idorga = identifiant');
        if ($evenement) {
          foreach ($evenement as $row) {
            if ($row['identifiant'] === $_SESSION['identifiant']) {
              $classements = $dbh->query('SELECT T.numevenement, classement from tournois T, evenement E where T.numevenement = E.numevenement');
              $numEvenement = $row['numevenement'];
              $tousLesTournoisSontFinis = false;
              if ($classements) {
                $tousLesTournoisSontFinis = tousLesTournoisSontFinis($classements, $numEvenement);
              }
              else {
                echo "Erreur, les données de la base n'ont pas pu être récupérées ! <br>";
                echo "Aucune donnée n'est donc affichée.";
                $tousLesTournoisSontFinis = false;
              }
              if ($tousLesTournoisSontFinis) { //cas où ils sont terminé 
                echo '<form method="post" action="pageEvenement.php">';
                echo '<input type="hidden" name="numevenement" value="' . $row["numevenement"] . '" />';
                echo '<input class="button" type="submit" value="' . $row["nom"] . ' - ' . $row["lieu"] . ' - ' . $row["dateevenement"] . '" /><br>';
                echo '</form>';
              }
            }
          }
        }
        else {
          echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
        }
        $dbh = null;
    } catch (PDOException $e) {
        print "Erreur ! : " . $e->getMessage() . "<br>";
        die();
    }
    ?>
    </div>

    <!-- bouton pour aller sur la page de création d'événement -->
    <div id="formulaire">
      <form action="pageCreationEvenement.php">
          <input class="button" type="submit" value="créer un événement">
      </form>
    </div>
  </body>
</html>