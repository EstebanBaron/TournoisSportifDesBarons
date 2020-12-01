<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page tournois</title>
  </head>
  <body>
  <?php 
  if(isset($_POST["numtournois"]))
  {
    try{
      $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
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
    $equipeOk = false;
    $cloture = false;
    if(!$equipeOk || !$cloture)
    {
      echo '<form method="post" action="pageEquipe.php"><br>';
      echo '<input type="hidden" value="' . htmlspecialchars($_POST["numtournois"]) . '" >';
      echo '<input type="submit" value="Ajouter des équipes">';
      echo '</form>';
      try{
        $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
        $tournois = $dbh->query('SELECT t.numtournois, count(*) AS nbequipe FROM tournois t, equipe e WHERE e.numtournois = t.numtournois GROUP BY t.numtournois');
          
        if($tournois)
        {
          foreach($tournois as $row)
          {
            if($row['numtournois'] == $_POST['numtournois'])
            {
              if($row['nbequipe'] > 2) 
              {
                $equipeOk = true;
                echo '<button>cloturer l\'ajout des équipes</button>'; //A TERMINER
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
      echo '<form method="post" action="pageTournois.php"><br>';
      echo '<input type="submit" value = "' . htmlspecialchars($_POST["numtournois"]) . '" >';
      echo '</form>';
    }
  }
  else
  {
      echo 'Erreur pas de Tournois trouvé';
  }
  ?>
  </body>
</html>