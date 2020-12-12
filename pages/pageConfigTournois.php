<?php
session_start();

//recup du num tournois
$numTournois = NULL;
if (isset($_POST['numtournois'])) {
    $numTournois = $_POST['numtournois'];
    $_SESSION['numtournois'] = $numTournois;
}
else if (isset($_SESSION['numtournois'])){
  $numTournois = $_SESSION['numtournois'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page tournois</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
    <link rel="stylesheet" href="css/styleConfigTournois.css" />
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
    <!-- <a href="pageEvenement.php" style="text-decoration: none;">retour</a> -->
    <div class="barreTitre">
      <a class="retour"></a>

      <div class="divTitre">
        <a class="titre">La Baronnerie</a>
      </div>

      <div class="divDeco">
        <a class="boutonDeconnection"></a>
      </div>
    </div>
    <div id="tout">
      <?php 
      if($numTournois !== NULL)
      {
        try{
          $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
          $tournois = $dbh->query('SELECT * FROM tournois');
          $nomTournois = NULL; // la table de tournois selectionné
          if($tournois)
          {
              foreach($tournois as $row)
              {
                  if($row['numtournois'] == $numTournois)
                  {
                      $nomTournois = $row['nom'];
                  }
              }
          }
          else 
          {
              echo "Erreur, les données de la base n'ont pas pu être récupérées !<br>"; 
          }
        } catch (PDOException $e)
        {
            print "Erreur ! : " . $e->getMessage() . "<br>";
        }
      ?>
      <div id="divNomTournois">
        <p id="tournois">Tournois : <?php echo '<p id="nomTournois">' . $nomTournois . '</p>';  ?> </p>
      </div>
      <?php
        $nbEquipe = 0;
        echo '<form id="ajoutEq" method="post" action="pageAjoutEquipe.php">';
        echo '<input type="hidden" name="numtournois" value="' . htmlspecialchars($numTournois) . '" >';
        echo '<input class="button" type="submit" name="ajoutEquipe" value="Ajouter des équipes">';
        echo '</form>';

        echo '<form id="ajoutEqAvecClassement" method="post" action="pageAjoutEquipeAvecClassement.php">';
        echo '<input type="hidden" name="numtournois" value="' . htmlspecialchars($numTournois) . '" >';
        echo '<input class="button" type="submit" name="ajoutEquipeAvecClassement" value="Ajouter des équipes avec le classement d\'un autre tournois">';
        echo '</form>';
        try{
          $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
          $tournois = $dbh->query('SELECT t.numtournois, count(*) AS nbequipe FROM tournois t, equipe e WHERE e.numtournois = t.numtournois GROUP BY t.numtournois');
            
          if($tournois)
          {
            foreach($tournois as $row)
            {
              if($row['numtournois'] == $numTournois)
              {
                if($row['nbequipe'] >= 2) 
                {
                  $nbEquipe = $row['nbequipe'];
                  echo '<button id="buttonCloturer" type="button" onclick="clotureEquipe()">cloturer l\'ajout des équipes</button>';
                }
                else
                {
                  echo 'Pas assez d\'équipe pour cloturer l\'ajout (il en faut au minimum 2).<br>';
                }
              }
            }
          }
          else 
          {
            echo "Erreur, les données de la base n'ont pas pu être récupérées !<br>"; 
          }
        } catch (PDOException $e)
        {
            print "Erreur ! : " . $e->getMessage() . "<br>";
        }
      }
      else
      {
          echo 'Erreur pas de Tournois trouvé<br>';
      }

      ?>

      <!-- Commencer le tournois -->
      <form id="Formtournois" method="post" action="pageTournois.php">
        <input type="hidden" name="numtournois" value = <?php echo htmlspecialchars($numTournois)?>>
      </form>

    </div>
    <script src="js/JsPageConfigTournois.js"></script>
  </body>
</html>