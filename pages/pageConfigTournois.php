<?php
session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page tournois</title>
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
  <?php 
  if(isset($_POST["numtournois"]))
  {
    $_SESSION[htmlspecialchars($_POST["numtournois"])]="6x4"; // déclaration de la variable tournois qui nous donne la formule choisi (par default 6 poule de 4 equipe)
    try{
      $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
      $tournois = $dbh->query('SELECT * FROM tournois');
      $nomTournois = NULL; // la table de tournois selectionné
      if($tournois)
      {
          foreach($tournois as $row)
          {
              if($row['numtournois'] == $_POST['numtournois'])
              {
                  $nomTournois = $row['nom'];
              }
          }
      }
      else 
      {
          echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
      }
    } catch (PDOException $e)
    {
        print "Erreur ! : " . $e->getMessage() . "<br>";
    }
  ?>
  <h1>Tournois : <?php echo '"' . $nomTournois . '"';  ?> </h1>
  <?php

    echo '<form id="ajoutEq" method="post" action="pageAjoutEquipe.php"><br>';
    echo '<input type="hidden" name="numtournois" value="' . htmlspecialchars($_POST["numtournois"]) . '" >';
    echo '<input type="submit" value="Ajouter des équipes">';
    echo '</form>';
    try{
      $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
      $tournois = $dbh->query('SELECT t.numtournois, count(*) AS nbequipe FROM tournois t, equipe e WHERE e.numtournois = t.numtournois GROUP BY t.numtournois');
        
      if($tournois)
      {
        foreach($tournois as $row)
        {
          if($row['numtournois'] == $_POST['numtournois'])
          {
            if($row['nbequipe'] > 2) 
            {
              echo '<button id="bouton" type="button" onclick="clotureBouton()">cloturer l\'ajout des équipes</button>'; //A TERMINER
            }
            else
            {
              echo 'pas assez d\'équipe (minimum : 2)';
            }
          }
        }
      }
      else 
      {
        echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
      }
    } catch (PDOException $e)
    {
        print "Erreur ! : " . $e->getMessage() . "<br>";
    }
  }
  else
  {
      echo 'Erreur pas de Tournois trouvé';
  }
  ?>
  <form id="tournois" method="post" action="pageTournois.php">
  <input type="hidden" name="numtournois" value = <?php echo htmlspecialchars($_POST["numtournois"])?>>
  </form>
  <script src="JsPageConfigTournois.js"></script>
  </body>
</html>