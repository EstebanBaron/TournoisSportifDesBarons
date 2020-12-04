<?php
session_start();

//renvoi le dernier num evenement
function getLastNumEvenement() {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $num = 0;
    foreach ($dbh->query('SELECT numevenement FROM evenement') as $row) {
      if ($row['numevenement'] > $num)
        $num = $row['numevenement'];
    }
    return $num;
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}

//renvoi le dernier num tournois
function getLastNumTournois() {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $num = 0;
    foreach ($dbh->query('SELECT numtournois FROM tournois') as $row) {
      if ($row['numtournois'] > $num)
        $num = $row['numtournois'];
    }
    return $num;
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}

//renvoi le dernier num terrain
function getLastNumTerrain() {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $num = 0;
    foreach ($dbh->query('SELECT numterrain FROM terrain') as $row) {
      if ($row['numterrain'] > $num)
        $num = $row['numterrain'];
    }
    return $num;
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}

function supprimerEvenement($numevenement) {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $sql = "DELETE FROM evenement WHERE numevenement = :num_evenement";
    $stmt = $dbh->prepare($sql); 
    $stmt->bindParam(':num_evenement', $numevenement);
    if($stmt->execute())
      echo "requête evenement supprimé. <br>";
    else 
      echo "suppression de la requete evenement échouée! <br>";
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}

function supprimerTournois($saveNumTournois, $numtournois) {  
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $sql = "DELETE FROM tournois WHERE numtournois = :num_tournois";
    $tousLesTournoisSontSupp = true;
    while ($saveNumTournois <= $numtournois) {
      $stmt = $dbh->prepare($sql); 
      $stmt->bindParam(':num_tournois', $saveNumTournois);
      if(!$stmt->execute())
        $tousLesTournoisSontSupp = false;
      $saveNumTournois++;
    }
    if ($tousLesTournoisSontSupp)
      echo "Tous les tournois ont bien été supprimé<br>";
    else
      echo "Erreur lors de la suppression des tournois<br>";
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}

function supprimerTerrain($saveNumTerrain, $numterrain) {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $sql = "DELETE FROM terrain WHERE numterrain = :num_terrain";
    $tousLesTerrainSontSupp = true;
    while ($saveNumTerrain <= $numterrain) {
      $stmt = $dbh->prepare($sql); 
      $stmt->bindParam(':num_terrain', $saveNumTerrain);
      if(!$stmt->execute())
        $tousLesTerrainSontSupp = false;
      $saveNumTerrain++;
    }
    if ($tousLesTerrainSontSupp)
      echo "Tous les terrains ont bien été supprimé. <br>";
    else
      echo "Erreur lors de la suppression des terrains. <br>";
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}

function tousLesChampsSontRemplis() {
  $i = 0;
  $tournoisCreer = true;
  $tousLesChampsSontRemplis = true;
  while ($i < 10 && $tournoisCreer) {
    $nomTournois = "nomTournois" . $i;
    //check cb de tournois veut l'organisateur
    if (!($_POST[$nomTournois])) {
      $tournoisCreer = false;
    }
    else {
      //si un champ n'est pas rempli
      if (empty($_POST[$nomTournois])) {
        $toutLesChampsSontRemplis = false;
        $tournoisCreer = false;
      }
    }
    $i++;
  }

  return $tousLesChampsSontRemplis;
}

function tousLesSportsSontDiff() {
  $tousLesSportsSontDiff = true;
  $sports = array();
  $j = 0;
  $sortie = false;
  while ($j < 6 && !$sortie) {
    $sport = "sport" . $j;
    if (isset($_POST[$sport])) {
      if (in_array($_POST[$sport], $sports)) {
        $tousLesSportsSontDiff = false;
        $sortie = true;
      }
      else {
        array_push($sports, $_POST[$sport]);
      }
      $j++;
    }
    else {
      $sortie = true;
    }
  }

  return $tousLesSportsSontDiff;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page de creation d'événement</title>
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
    <h1>Créer votre événement :</h1>
    <form method="post">
    <p>(Les champs prefixés par des * sont obligatoires)</p>
    <!-- nom -->
    <label for="nom"> Nom* :</label>
    <input type="text" name="nom" maxlength="40" required><br>

    <!-- lieu -->
    <label for="lieu"> Lieu* :</label>
    <input type="text" name="lieu" maxlength="50" required><br>

    <!-- date evenement -->
    <label for="dateevenement"> Date de l'événement* :</label>
    <input type="date" name="dateevenement" required><br>
    <!-- </form> -->

    <h3>Tournois : </h3>
    <!-- <form method="post"> -->
    <div id="tournois">
      <div id="divNumTournois0">
      <label for="nomTournois0"> Nom du tournois* :</label>
      <input type="text" name="nomTournois0" maxlength="40" required>&nbsp;&nbsp; 
      <label for="typeTournois0"> Type du tournois* :</label>
      <select name="typeTournois0">
        <option value="1vs1">1vs1</option>
        <option value="2vs2">2vs2</option>
        <option value="3vs3">3vs3</option>
        <option value="5vs5">5vs5</option>
        <option value="6vs6">6vs6</option>
        <option value="7vs7">7vs7</option>
        <option value="11vs11">11vs11</option>
        <option value="15vs15">15vs15</option>
      </select>
      <br>
      </div>
    </div>
    <button id="boutonTournois">autre tournois</button> <button id="boutonSupprimerTournois">supprimer</button><br>
    <!-- </form> -->

    <h3>Terrains : </h3>
    <!-- <form method="post" action="pageAccueil.php"> -->
    <div id="terrain">
      <div id="divNumTerrain0">
      <select name="sport0">
        <option value="Football">Football</option>
        <option value="Basketball">Basketball</option>
        <option value="Tennis">Tennis</option>
        <option value="Rugby">Rugby</option>
        <option value="Petanque">Pétanque</option>
        <option value="Volley">Volley</option>
      </select>
      <input type="number" name="nbTerrain0" min="1" max="100" value="1"><br>
      </div>
    </div>
    <button id="boutonTerrain">autre terrain</button> <button id="boutonSupprimerTerrain">supprimer</button><br>
    
    <br><br>
    <input type="submit" value="Creer l'événement" name="creationevenement">
    </form>

    
    <?php
    if (isset($_POST['nom'], $_POST['lieu'], $_POST['dateevenement'], $_POST['creationevenement']) && !empty($_POST['nom']) &&  !empty($_POST['lieu']) && !empty($_POST['dateevenement'])) {
      //check => tous les tournois demandés sont bien remplis
      $tousLesChampsSontRemplis = tousLesChampsSontRemplis();
      //check => tous les sports sont différents
      $tousLesSportsSontDiff = tousLesSportsSontDiff();

      if ($tousLesChampsSontRemplis) {      //ici peut-etre mettre les deux dans 1 if
        if (!$tousLesSportsSontDiff) {
          ?>
          <script type="text/javascript">
            alert("Les sports doivent être tous différents !");
          </script>
          <?php
        }
        else {
          try {
            $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
            //AJOUT EVENEMENT
            //variables pour la requetes
            $numevenement = getLastNumEvenement() + 1;
            $nom = htmlspecialchars($_POST['nom']);
            $lieu = htmlspecialchars($_POST['lieu']);
            $dateevenement = htmlspecialchars($_POST['dateevenement']);
            $idOrga = $_SESSION['identifiant'];
            //preparation de la requete evenement
            $sql = "INSERT INTO evenement (numevenement, nom, lieu, dateevenement, idorga) VALUES (?, ?, ?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            
            //variable pour verifier s'il y a une erreur
            $malPasse = false;
            //verification des contraintes
            if(strlen($nom) <= 40 && strlen($lieu) <= 50) {
                if ($stmt->execute([$numevenement, $nom, $lieu, $dateevenement, $idOrga])) {
                  //AJOUT DES TOURNOIS
                  //variable utile pour les requetes tournois
                  $numtournois = getLastNumTournois();
                  $saveNumTournois = $numtournois + 1;
                  $arrayTypeJeu = ['1vs1' => 1, '2vs2' => 2, '3vs3' => 3, '5vs5' => 5, '6vs6' => 6, '7vs7' => 7, '11vs11' => 11, '15vs15' => 15];
                  //preparation des requetes tournois
                  $sql = "INSERT INTO tournois (numtournois, nom, classement, typejeu, numevenement) VALUES (?, ?, ?, ?, ?)";
                  $stmt = $dbh->prepare($sql);     
                  $indexTournois = 0;
                  while (isset($_POST['nomTournois' . $indexTournois]) && !$malPasse) {
                    $numtournois++;
                    $nomTournois = $_POST['nomTournois' . $indexTournois];
                    $typeJeu = $arrayTypeJeu[$_POST['typeTournois' . $indexTournois]];
                    //verification des contraintes
                    if(strlen($nomTournois) <= 40 && $typeJeu >= 1 && $typeJeu <= 15) {
                      if (!$stmt->execute([$numtournois, $nomTournois, NULL, $typeJeu, $numevenement])) {
                        $malPasse = true;
                        echo "Erreur d'ajout d'un tournois dans la base!<br>";
                      }
                    }
                    else {
                      echo "Erreur de taille ou de type de jeu sur les champs renseignés!<br>";
                      $malPasse = true;
                    }
                    $indexTournois++;
                  }
                  if (!$malPasse) {
                    //AJOUT DES TERRAINS
                    //variable utile pour les requetes
                    $numterrain = getLastNumTerrain();
                    $saveNumTerrain = $numterrain + 1;
                    //preparation des requetes
                    $sql = "INSERT INTO terrain (numterrain, sport, numevenement) VALUES (?, ?, ?)";
                    $stmt = $dbh->prepare($sql); 
                    //varible pour la verification des contraintes 
                    $arraySportDispo = ['Football', 'Rugby', 'Basketball', 'Volley', 'Petanque', 'Tennis'];

                    $indexTerrain = 0;
                    while (isset($_POST['sport' . $indexTerrain]) && !$malPasse) {
                      $indexTerrainPourUnSport = $_POST['nbTerrain' . $indexTerrain];
                      while ($indexTerrainPourUnSport > 0){
                        $numterrain++;
                        $sport = $_POST['sport' . $indexTerrain];
                        //verification des contraintes
                        if(in_array($sport , $arraySportDispo)) {
                          if (!$stmt->execute([$numterrain, $sport, $numevenement])) {
                            $malPasse = true;
                            echo "Erreur de l'ajout d'un terrain dans la base ! <br>";
                          }
                        }
                        else {
                          echo "Erreur, le sport séléctionné n'est pas disponible! <br>";
                          $malPasse = true;
                        }
                        $indexTerrainPourUnSport--;
                      }
                      $indexTerrain++;
                    }
                    if ($malPasse) {
                      //supprime les tuples de evenement et tournois et affiche une erreur
                      supprimerEvenement($numevenement);
                      supprimerTournois($saveNumTournois, $numtournois);
                      supprimerTerrain($saveNumTerrain, $numterrain);
                      //evite de resupprimer
                      // $malPasse = false;
                    }
                    else {
                      //redirection sur la page Evenement en envoyant le numEvenement
                      $_SESSION['numevenement'] = $numevenement;
                      ?>
                      <br>
                      <h3>Creation de l'événement réussi !</h3>
                      <h4>Redirection en cours...</h4>
                      <script type="text/javascript">
                          setTimeout(function() {window.location.href = "pageEvenement.php";}, 2500);
                      </script>
                      <?php
                    }
                  }
                  else {
                    //erreur lors d'une requete des tournois => drop la requête de l'événement et les requetes tournois deja envoyés
                    //suppression de la requete evenement
                    supprimerEvenement($numevenement);
                    //suppression les requetes tournois qui ce sont executées jusqu'à celle qui a échouée
                    supprimerTournois($saveNumTournois, $numtournois);
                  }
                }
                else {
                    echo "Erreur d'execution de la requête préparé evenement!<br>";
                }
            }
            else {
                echo "Erreur, la taille des champs renseigné dépasse la limite autorisé !<br>";
            }
            $dbh = null;
          } catch (PDOException $e) {
              print "Erreur ! : " . $e->getMessage() . "<br>";
              die();
          }
        }
      }
    }
    ?>
    <script src="autreElement.js"></script>
  </body>
</html>