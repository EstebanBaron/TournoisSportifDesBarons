<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page classement</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
  </head>
  <body>
    <div class="barreTitre">
      <a class="retour" href="pageEvenement.php" style="text-decoration: none;">retour</a>

      <div class="divTitre">
        <a class="titre">La Baronnerie</a>
      </div>

      <div class="divDeco">
        <a class="boutonDeconnection" href="pageAuthentification.php">Déconnection</a>
      </div>
    </div>
    <h1>Classements : </h1> 
    <?php
    if (isset($_POST['numtournois'])) {
      try {
        $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
        $tournois = $dbh->query('SELECT * from tournois');
        $classement = "";
        if ($tournois) {
          foreach ($tournois as $row) {
            if ($row['numtournois'] == $_POST['numtournois'] && $row['classement'] !== NULL) {
                $classement = $row['classement'];  //on récupère le classement du tournois dans la base
            }
          }
          if ($classement === "") {
            echo "Le classement n'est pas encore disponible, revenez quand le tournois sera terminé.";
          }
          else {
            //On affiche le classement
            $tabDeClassement = explode(',', $classement);
            $position = 1;
            $index = 0;
            while ($index < count($tabDeClassement)) {
              echo $position . " : " . $tabDeClassement[$index] . "<br>"; 
              $position++;
              $index++;
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