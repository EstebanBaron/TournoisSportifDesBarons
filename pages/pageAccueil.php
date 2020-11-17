<?php
session_start();
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
        $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
        $evenement = $dbh->query('SELECT identifiant, E.nom, lieu, dateevenement, classement from organisateur O, evenement E, tournois T where idorga = identifiant AND T.numEvenement = E.numEvenement');
        if ($evenement) {
          foreach($evenement as $row) {
            if($row['identifiant'] === $_SESSION['identifiant'] && $row['classement'] === NULL) {
              echo $row['nom'] . ' - ' . $row['lieu'] . ' - ' . $row['dateevenement'] . "<br>";
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
        $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
        $evenement = $dbh->query('SELECT identifiant, E.nom, lieu, dateevenement, classement from organisateur O, evenement E, tournois T where idorga = identifiant AND T.numEvenement = E.numEvenement');
        if ($evenement) {
          foreach($evenement as $row) {
            if(!is_int($cle) && $row['identifiant'] === $_SESSION['identifiant'] && $row['classement'] !== NULL) {
              $boutonClassement = '<a href="pageClassement.php"><input type="submit" value="classement"></a>';
              echo $row['nom'] . ' - ' . $row['lieu'] . ' - ' . $row['dateevenement'] . ' ' . $boutonClassement . "<br>";
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