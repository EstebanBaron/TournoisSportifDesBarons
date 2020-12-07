<?php
session_start();

// fonction renvoyant selon un nombre d'équipe le nombre de poules au tour prochain
function nbEquipeSuivant($nb)
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
      return nbEquipeSuivant(floor($nb/2)) + nbEquipeSuivant(ceil($nb/2));
    }
  }
}

function getNbEquipe($numTournois) {
  $nbEquipe = -1;
  try{
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $tournois = $dbh->query('SELECT t.numtournois, count(*) AS nbequipe FROM tournois t, equipe e WHERE e.numtournois = t.numtournois GROUP BY t.numtournois');
        
    if ($tournois) {
        foreach ($tournois as $row) {
            if ($row['numtournois'] == $numTournois) {
                $nbEquipe = $row['nbequipe'];
            }
        }
    }
  } catch (PDOException $e) {
      print "Erreur ! : " . $e->getMessage() . "<br>";
  }

  return $nbEquipe;
}

function getListeEquipe($numTournois) {
  $listeEquipes = "";
  try{
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $equipes = $dbh->query('SELECT nom, numtournois FROM equipe');
        
    if ($equipes) {
        foreach ($equipes as $row) {
            if ($row['numtournois'] == $numTournois) {
              $listeEquipes .= $row['nom'] . ",";
            }
        }
        $listeEquipes = substr($listeEquipes, 0, -1);   //enlève la dernière virgule
    }
  } catch (PDOException $e) {
      print "Erreur ! : " . $e->getMessage() . "<br>";
  }

  return $listeEquipes;
}

function ajouteClassementTournois($classement, $numTournois) {
  try{
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $sql = 'UPDATE tournois SET classement = :classement WHERE numtournois = :numTournois';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':classement', $classement);
    $stmt->bindValue(':numTournois', $numTournois);
            
    if(strlen($classement) <= 495) { //nb max de caractère possible pour un classement
      if ($stmt->execute([$classement, $numTournois])) {
        echo '<form method="post" action="pageEvenement.php">';
        echo '<input type="submit" value="Fin du tournois" name="finTournois">';
        echo '</form>';
      }
      else {
        echo "Erreur d'envoie des données dans la base !<br>";
      }
    }
    else {
      echo "Erreur, le nombre de caractère dépasse la limite max (495 caractères) !<br>";
    }
  } catch (PDOException $e) {
      print "Erreur ! : " . $e->getMessage() . "<br>";
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
      $_SESSION['numtournois'] = $numTournois;
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
              if($row['numtournois'] == $numTournois)
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
    //nb Equipes
    $nbEquipe = getNbEquipe($numTournois);

    //Mise par default de la formule
    if (isset($_POST['choix'])) { 
      $_SESSION["formule" . $numTournois] = $_POST['choix'];
    }
    else if (!isset($_SESSION["formule" . $numTournois])) { //mise par defaut
      if ($nbEquipe > 0) {
        if ($nbEquipe % 2 == 0) { //CAS PAIR
          $_SESSION["formule" . $numTournois] = ($nbEquipe/2) ."x2";
        }
        else{   //CAS IMPAIR
          $_SESSION["formule" . $numTournois] = ($nbEquipe/2 - 1) ."x2+1x3";
        }  
      }
    }

    if (!isset($_SESSION["TourActuel" . $numTournois])) { //premiere fois qu'on arrive sur la page
      $_SESSION["TourActuel" . $numTournois] = 1;
    }
    else if (isset($_POST['classementTour'])) { //si on arrive de la page match tour et qu'un tour est terminé
      $_SESSION["TourActuel" . $numTournois] = $_SESSION["TourActuel" . $numTournois] + 1;
      $_SESSION['classementTour'] = $_POST["classementTour"];
    }
    //aucun tour n'a encore été commencé
    if (!isset($_SESSION['classementTour'])) {
      $_SESSION['classementTour'] = getListeEquipe($numTournois);
    }

    $numtour = 1;
    //boucle qui affiche tous les tours d'un tournois avec leurs états
    while($nbEquipe != 1)
    {
      //affiche les tours terminés d'abord tel que : Tour 1 : Terminé (remplacé terminé par le résultat du tour)
      ?>
      <div id="tour<?php echo $numtour;?>">
      <h3>Tour <?php echo $numtour; ?> : </h3>
      <!-- choisir la formule -->
      <?php
      if($numtour < $_SESSION["TourActuel" . $numTournois])
      {
        echo ' Terminé';//changer pour afficher Résultat du tour
      }
      //affiche le tour en cours tel que : Tour 2 : Poules (Poules étant le bouton permettant d'aller a la page pageTour correspondant)
      else if($numtour == $_SESSION["TourActuel" . $numTournois])
      { 
        ?>
        <p>Formule actuelle : <?php echo $_SESSION["formule" . $numTournois]; ?></p>
        <form id="choixFormule" method="post" action="pageChoixFormule.php">
          <input type="hidden" name="numtournois" value =<?php echo $numTournois;?>>
          <input type="submit" value = "changer la formule">
        </form>

        <form method="post" action="pageTour.php" >
        <input type="hidden" name="numtournois" value=<?php echo $numTournois; ?>>
        <input type="hidden" name="numtour" value=<?php echo $numtour; ?>>
        <input type="submit" name="boutonpoule" value="accès aux poules">
        </form>
        <?php
      }
      //affiche les tours à venir tel que : Tour 3 : à venir ...
      else
      {
        echo ' à venir ...';
      }
      $nbEquipe = nbEquipeSuivant($nbEquipe);
      $numtour++;
      ?>
      </div>
      <?php
    }
    $nombreTourTotal = $numtour;
    //ex : $_POST['classementTour'] = "eq3,eq4,eq1,eq2.."
    if (isset($_POST['classementTour']) && $_SESSION['TourActuel' . $numTournois] == $nombreTourTotal) {
      //remplir la bdd et echo le formulaire si tout c'est bien passé
      ajouteClassementTournois($_POST['classementTour'], $numTournois);
    }
  }
  else
  {
      echo 'Erreur pas de Tournois trouvé';
  }
  ?>  
  </body>
</html>