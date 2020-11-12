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
    <?php 
      try {
        $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
        $evenement = $dbh->query('SELECT E.nom, lieu, dateevenement from evenement E, organisateur O where idorga = identifiant');
        if ($evenement) {
          echo "Tous les événements : <br>";
          foreach($evenement as $row) {
            foreach($row as $cle=>$value) {
              if(!is_int($cle))
                echo $cle . " : " . $value . " |";
            }
            echo "<br>";
          }
        }
        $dbh = null;
    } catch (PDOException $e) {
        print "Erreur ! : " . $e->getMessage() . "<br>";
        die();
    }
    ?>
    <h2>Evenement terminés :</h2>
    <h2>Evenement en cours :</h2>



    <form action="pageCreationEvenement.php">
        <input type="submit" value="créer un événement">
    </form>
  </body>
</html>