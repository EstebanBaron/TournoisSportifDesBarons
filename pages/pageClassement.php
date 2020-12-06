<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page classement</title>
  </head>
  <body>
  <h1>Classements : </h1>
  <?php
  if (isset($_POST['numtournois'])) {
    try {
      $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
      $tournois = $dbh->query('SELECT * from tournois');
      $classement = "";
      if ($tournois) {
        foreach ($tournois as $row) {
          if ($row['numtournois'] == $_POST['numtournois']) {
            if ($row['classement'] !== NULL) {
              $classement = $row['classement'];  //on récupère le classement du tournois dans la base
            }
          }
        }
        if ($classement === "") {
          echo "Le classement n'est pas encore disponible, revenez quand le tournois est terminé.";
        }
        else {
          //On affiche le classement
          $tabDeClassement = preg_split('/ - /', $classement);
          $position = 1;
          foreach ($tabDeClassement as $equipe) {
            echo $position . " : " . $equipe . "<br>"; 
            $position++;
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
  }
  else {
    echo 'Erreur pas de tournois trouvé !';
  }
  ?>
  </body>
</html>