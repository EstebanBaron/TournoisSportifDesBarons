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
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
    <!-- <a href="pageEvenement.php" style="text-decoration: none;">retour</a> -->
    <div class="barreTitre">
      <a class="titre">La Baronnerie</a>
    </div>
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
    <h1>Tournois : <?php echo '"' . $nomTournois . '"';  ?> </h1>
    <?php
      $nbEquipe = 0;
      echo '<form id="ajoutEq" method="post" action="pageAjoutEquipe.php"><br>';
      echo '<input type="hidden" name="numtournois" value="' . htmlspecialchars($numTournois) . '" >';
      echo '<input type="submit" name="ajoutEquipe" value="Ajouter des équipes">';
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
                echo '<button id="bouton" type="button" onclick="clotureEquipe()">cloturer l\'ajout des équipes</button>';
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
    <form id="tournois" method="post" action="pageTournois.php">
      <input type="hidden" name="numtournois" value = <?php echo htmlspecialchars($numTournois)?>>
    </form>

    <script src="js/JsPageConfigTournois.js"></script>
  </body>
</html>