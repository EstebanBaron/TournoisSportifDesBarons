<?php
session_start();

// Prototype de fonction
function nbEquipeTourSuivant($nb)
{
  if($nb == 2 || $nb == 3)
  {
    return 1;
  }
  else
  {
    if(fmod($nb, 2) == 0)
    {
      return $nb/2;
    }
    else
    {
      return nbEquipeTourN(floor($nb/2)) + nbEquipeTourN(ceil($nb/2));
    }
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page Tournois</title>
  </head>
  <body>
  <?php 
  //recup du num tournois
  $numTournois = NULL;
  if (isset($_POST['numtournois'])) {
      $numTournois = $_POST['numtournois'];
  }
  else if (isset($_SESSION['numtournois'])) {
      $numTournois = $_SESSION['numtournois'];
  }
  
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
  <!-- choisir la formule -->
  <form id="choixFormule" method="post" action="pageChoixFormule.php">
    <input type="hidden" name="numtournois" value = <?php echo $_POST["numtournois"];?>>
    <input type="submit" value = "choisir la formule">
  </form>

  <?php 
    //Mise par default de la formule
    if ($nbEquipe > 0) {
      if ($nbEquipe % 2 == 0) { //CAS PAIR
        $_SESSION["formule" . $numTournois] = ($nbEquipe/2) ."x2";
      }
      else{   //CAS IMPAIR
        $_SESSION["formule" . $numTournois] = ($nbEquipe/2 - 1) ."x2+1x3";
      }  
    }
    $formule = $_SESSION["formule" . $_POST["numtournois"]];
    $nbEquipe = $formule[0];
    $nbtour = 1;
    $_SESSION["TourActuel" . $_POST["numtournois"]]=2;
    while($nbEquipe != 1)
    {
      echo '<p>Tour ' . $nbtour . ' : </p>';
      if($nbtour < $_SESSION["TourActuel" . $_POST["numtournois"]] )
      {
        echo ' Terminé';
      }
      else if($nbtour == $_SESSION["TourActuel" . $_POST["numtournois"]] )
      { 
        echo '<form method="post" action="pageTour.php" >';
        echo '<input type="hidden" name="numt" value="' . $_POST["numtournois"] . '" >';
        echo '<input type="hidden" name="numtour" value="' . $nbtour . '" >';
        echo '<input type="submit" name="boutonpoule" value="Poules" >';
        echo '</form>';
      }
      else
      {
        echo ' à venir ...';
      }
      $nbEquipe = nbEquipeTourSuivant($nbEquipe);
      $nbtour++;
    }

  }
  else
  {
      echo 'Erreur pas de Tournois trouvé';
  }
  ?>
 
  </body>
</html>