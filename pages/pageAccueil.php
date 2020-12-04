<?php
session_start();

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
  </head>
  <body>
    <h1>Accueil</h1>
    <h2>Mes événement en cours :</h2>
    <?php 
      try {
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        $evenement = $dbh->query('SELECT identifiant, numevenement, E.nom, lieu, dateevenement from organisateur O, evenement E where idorga = identifiant');
        if ($evenement) {
          foreach ($evenement as $row) {
            if ($row['identifiant'] === $_SESSION['identifiant']) {
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
              if (!$tousLesTournoisSontFinis) {
                echo '<form method="post" action="pageEvenement.php">';
                echo '<input type="hidden" name="numevenement" value="' . $row["numevenement"] . '" />';
                echo '<input type="submit" value="' . $row["nom"] . ' - ' . $row["lieu"] . ' - ' . $row["dateevenement"] . '" /><br>';
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
    <h2>Mes événement terminés :</h2>
    <?php 
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
              if ($tousLesTournoisSontFinis) {
                echo '<form method="post" action="pageEvenement.php">';
                echo '<input type="hidden" name="numevenement" value="' . $row["numevenement"] . '" />';
                echo '<input type="submit" value="' . $row["nom"] . ' - ' . $row["lieu"] . ' - ' . $row["dateevenement"] . '" /><br>';
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
    <br>
    <form action="pageCreationEvenement.php">
        <input type="submit" value="créer un événement">
    </form>
  </body>
</html>