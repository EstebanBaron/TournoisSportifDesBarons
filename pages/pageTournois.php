<?php
session_start();

//recup du num tournois
$numTournois = NULL;
if (isset($_POST['numtournois'])) {
    $numTournois = $_POST['numtournois'];
    $_SESSION['numtournois'] = $numTournois;
}
else if (isset($_SESSION['numtournois'])) {
    $numTournois = $_SESSION['numtournois'];
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
    else {
      echo "Erreur, la requête a échouée!<br>";
    }
  } catch (PDOException $e) {
      print "Erreur ! : " . $e->getMessage() . "<br>";
  }

  return $listeEquipes;
}

//on recupere le tour actuel, la liste des equipes du tour et on met à jour le classement du tournois
if (!isset($_SESSION["TourActuel" . $numTournois])) { //premiere fois qu'on arrive sur la page
  $_SESSION["TourActuel" . $numTournois] = 1;
}
else if (isset($_POST['listeEquipes'], $_POST['classementTour']) && $_SESSION['listeEquipes' . $numTournois] != $_POST['listeEquipes']) { //si on arrive de la page match tour et qu'un tour est terminé
  $_SESSION["TourActuel" . $numTournois] = $_SESSION["TourActuel" . $numTournois] + 1;
  $_SESSION['classementTournois' . $numTournois] = $_POST["classementTour"] . "," . $_SESSION['classementTournois' . $numTournois];
  $_SESSION['listeEquipes' . $numTournois] = $_POST['listeEquipes'];
}
//aucun tour n'a encore été commencé
if (!isset($_SESSION['listeEquipes' . $numTournois], $_SESSION['classementTournois' . $numTournois])) {
  $_SESSION['listeEquipes' . $numTournois] = getListeEquipe($numTournois);
  $_SESSION['classementTournois' . $numTournois] = "";
}


function getNbEquipe($listeEquipes) {
  $nbEquipe = 0;
  
  $tabEquipe = explode(',', $listeEquipes);
  $index = 0;
  while ($index < count($tabEquipe)) {
    $nbEquipe++;
    $index++;
  }

  return $nbEquipe;
}

//nb Equipes
$nbEquipe = getNbEquipe($_SESSION['listeEquipes' . $numTournois]);

//Mise par default de la formule
if (isset($_POST['choix'])) { 
  $_SESSION["formule" . $numTournois] = $_POST['choix'];
}
else { //mise par defaut
  if ($nbEquipe > 0) {
    if ($nbEquipe % 2 == 0) { //CAS PAIR
      $_SESSION["formule" . $numTournois] = ($nbEquipe/2) ."x2";
    }
    else{   //CAS IMPAIR
      if (floor($nbEquipe/2 - 1) != 0)
        $_SESSION["formule" . $numTournois] = floor($nbEquipe/2 - 1) ."x2+1x3";
      else  //cas où il y a 3 équipes
        $_SESSION["formule" . $numTournois] = "1x3";
    } 
  }
}

function ajouteClassementTournois($classement, $numTournois) {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $classementVide = true;
    foreach ($dbh->query('SELECT * FROM tournois') as $row) {
      if ($row['numtournois'] == $numTournois) {
        if ($row['classement'] !== NULL) {
          $classementVide = false;
        }
      }
    }
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
  if ($classementVide) {
    try{
      $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
      $sql = 'UPDATE tournois SET classement = :classement WHERE numtournois = :numTournois';
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':classement', $classement);
      $stmt->bindValue(':numTournois', $numTournois);
              
      if(strlen($classement) <= 495) { //nb max de caractère possible pour un classement
        if (!$stmt->execute([$classement, $numTournois])) {
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
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page Tournois</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
  </head>
  <body>
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
          echo "Erreur, les données de la base n'ont pas pu être récupérées !"; 
      }
    } catch (PDOException $e)
    {
        print "Erreur ! : " . $e->getMessage() . "<br>";
    }
  ?>
  <h1>Tournois : <?php echo '"' . $nomTournois . '"';  ?> </h1>

  <?php
    echo "tour : " . $_SESSION["TourActuel" . $numTournois] . "<br>";

    $numtour = 1;
    //boucle qui affiche tous les tours d'un tournois avec leurs états
    //getNbTotalTour
    while($numtour <= $_SESSION["TourActuel" . $numTournois])
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
      else if($numtour == $_SESSION["TourActuel" . $numTournois] && $nbEquipe !== 1)
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
      else {
        ?>
        <h3>Tournois terminé</h3>
        <?php
      }
      $numtour++;
      ?>
      </div>
      <?php
    }
    //ex : $_SESSION['classementTournois'] = "eq3,eq4,eq1,eq2.."
    //bouton fin du tournois, on y aura acces quand le dernier strlen($_POST['listeEquipes']) = 1
    if (isset($_POST['listeEquipes'], $_POST['classementTour']) && $nbEquipe === 1) {
      $tabClassement = explode(',', $_SESSION['classementTournois' . $numTournois]);
      if ($tabClassement[0] != $_SESSION['listeEquipes' . $numTournois]) {
        $_SESSION['classementTournois' . $numTournois] = $_SESSION["listeEquipes" . $numTournois] . "," . $_SESSION['classementTournois' . $numTournois];  
        $_SESSION['classementTournois' . $numTournois] = substr($_SESSION['classementTournois' . $numTournois], 0, strlen($_SESSION['classementTournois' . $numTournois])-1);     
      }
      echo '<p>Classement : ' . $_SESSION['classementTournois' . $numTournois] . '</p>';
      //remplir la bdd et echo le formulaire si tout c'est bien passé
      ajouteClassementTournois($_SESSION['classementTournois' . $numTournois], $numTournois); 
      echo '<form method="post" action="pageEvenement.php">';
      echo '<input type="submit" value="Fin du tournois" name="finTournois">';
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