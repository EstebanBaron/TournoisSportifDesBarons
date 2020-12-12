<?php
session_start();

//récupère le numero de tournois et on le sauvegarde dans une variable de session lorsque l'on vient de la page config tournois
//le sauvegarder nous permet de rester sur la page quand il y a un probleme lors de l'ajout des equipes
$numTournois = NULL;
if (isset($_POST['numtournois'])) {
  $numTournois = $_POST['numtournois'];
  $_SESSION['numtournois'] = $_POST['numtournois'];
}
else if (isset($_SESSION['numtournois'])) {
  $numTournois = $_SESSION['numtournois'];
}

//récupère le nombre de joueur par équipe (typeJeu du tournois)
function nbJoueurParEquipe($numTournois) {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $tournois = $dbh->query('SELECT numtournois, typejeu FROM tournois');
    if ($tournois) {
      $nbJoueurEquipe = 0;
      foreach ($tournois as $row) {
        if ($row['numtournois'] == $numTournois) {
          $nbJoueurEquipe = $row['typejeu'];
        }
      }
      return $nbJoueurEquipe;
    }
    else {
      echo "Erreur lors de la recuperation du type de jeu!";
      return -1;
    }
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}
$nbJoueurParEquipe = nbJoueurParEquipe($numTournois);

//vérifie si le nom d'équipe choisi est unique (clé primaire dans la bdd)
function nomEquipeLibre($nomEquipe) {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $libre = true;
    foreach ($dbh->query('SELECT nom FROM equipe') as $row) {
      if ($nomEquipe == $row['nom']) {
        $libre = false;
      }
    }
    return $libre;
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}

//return le dernier NumJoueur pour l'ajout des joueurs dans la base
function getLastNumJoueur() {
  try {
    $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
    $num = 0;
    foreach ($dbh->query('SELECT numjoueur FROM joueur') as $row) {
      if ($row['numjoueur'] > $num)
        $num = $row['numjoueur'];
    }
    return $num;
  } catch (PDOException $e) {
    print "Erreur ! : " . $e->getMessage() . "<br>";
    die();
  }
}

//vérifie si tous les champs sur la page sont remplis
function tousLesChampsSontRemplis() {
  $tousLesChampsSontRemplis = true;
  $index = 1;
  //on verifie que tous les champs sur la page sont bien rempli
  while (isset($_POST['nomEquipe' . $index])) {
    if (empty($_POST['nomEquipe' . $index])) {
      $tousLesChampsSontRemplis = false;
      "Erreur ! Le nom d'équipe n'a pas été rempli";
    }
    else {
      $indexNbJoueur = 1;
      while ($indexNbJoueur <= $nbJoueurParEquipe) {
        $nomJoueur = 'nomJoueur' . $indexNbJoueur . 'Equipe' . $index;
        $prenomJoueur = 'prenomJoueur' . $indexNbJoueur . 'Equipe' . $index;
        $niveauJoueur = 'niveauJoueur' . $indexNbJoueur . 'Equipe' . $index;
        if (!isset($_POST[$nomJoueur], $_POST[$prenomJoueur], $_POST[$niveauJoueur]) || empty($_POST[$nomJoueur]) || empty($_POST[$prenomJoueur])) {
          echo "Erreur ! Tous les champs ne sont pas remplis";
          $tousLesChampsSontRemplis = false;
        } 
      $indexNbJoueur++;
      }
    }
    $index++;
  }

  return $tousLesChampsSontRemplis;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page ajout des équipes</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
    <link rel="stylesheet" href="css/styleAjoutEquipe.css" />
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
    <div class="barreTitre">
      <a class="retour" href="pageConfigTournois.php" style="text-decoration: none;">retour</a>

      <div class="divTitre">
        <a class="titre">La Baronnerie</a>
      </div>

      <div class="divDeco">
        <a class="boutonDeconnection" href="pageAuthentification.php">Déconnection</a>
      </div>
    </div>
  <div id="tout">
  <?php
    if ($numTournois !== NULL) {
      ?>
        <h1>Création des équipes</h1>
        <p id="champsObligatoires">(Les champs prefixés par des * sont obligatoires)</p>

        <form method="post"> <!-- action="pageConfigTournois.php"> -->
        <div id="equipes">
          <div class="equipe">
          <h2>Equipe 1</h2>
          <!-- nom -->
          <label for="nomEquipe1"> Nom d'équipe* (espace non accepté) :</label>
          <input type="text" name="nomEquipe1" maxlength="30" required onblur="this.value=removeSpaces(this.value);"><br>
          <!-- club -->
          <label for="clubEquipe1"> Club :</label>
          <input type="text" name="clubEquipe1" maxlength="30"><br>
          <h3>Joueurs</h3>
          <ul>
          <?php
            //ajout dynamique des joueurs en fonction du nombre de joueur par équipe (typejeu du tournois)
            $index = 0;
            while ($index < $nbJoueurParEquipe) {
              echo '<li>joueur'. ($index+1) . ' <br>';
              echo '<label for="nomJoueur' . ($index+1) . 'Equipe1"> Nom* :</label> ';
              echo '<input type="text" name="nomJoueur' . ($index+1) . 'Equipe1" maxlength="20" required><br>';
              echo '<label for="prenomJoueur' . ($index+1) . 'Equipe1"> Prenom* :</label> ';
              echo '<input type="text" name="prenomJoueur' . ($index+1) . 'Equipe1" maxlength="20" required><br>';
              echo '<label for="niveauJoueur' . ($index+1) . 'Equipe1"> Niveau* :</label> ';
              echo '<select name="niveauJoueur' . ($index+1) . 'Equipe1">';
              echo '<option value="1">Loisir</option>';
              echo '<option value="2">Départemental</option>';
              echo '<option value="3">Régional</option>';
              echo '<option value="4">N3</option>';
              echo '<option value="5">N2</option>';
              echo '<option value="6">Elite</option>';
              echo '<option value="7">Pro</option>';
              echo '</select></li>';
              $index++;
            }
          ?>
          </ul>
          </div>
        </div>
        <!-- boutons pour ajouter ou supprimer des équipes au code html -->
        <button class="button" type="button" id="boutonAjoutEquipe" onclick="ajoutEquipe(<?php echo $nbJoueurParEquipe;?>)">autre équipe</button> <button class="button" type="button" id="boutonSupprimerEquipe">supprimer</button><br>
        
        <input class="buttonValider" type="submit" value="Valider" name="valider">
        </form>
      <?php

      $tousLesChampsSontRemplis = false;
      if (isset($_POST['valider'])) {
        $tousLesChampsSontRemplis = tousLesChampsSontRemplis();
      }
      //si tous les champs sont remplis on envoi dans la base les équipes et les joueurs
      if ($tousLesChampsSontRemplis) {
        $bienPasse = true;
        try {
          $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
          //envoi des données
          $index = 1;
          while (isset($_POST['nomEquipe' . $index])) {    //tant qu'on a une equipe
            //AJOUT DES EQUIPES
            $nomEquipe = htmlspecialchars($_POST['nomEquipe' . $index]);
            if (nomEquipeLibre($nomEquipe)) {
              $club = NULL;
              if (isset($_POST['clubEquipe' . $index])) {
                $club = htmlspecialchars($_POST['clubEquipe' . $index]);
              }
              //preparation de la requete evenement
              $sql = "INSERT INTO equipe (nom, club, numtournois) VALUES (?, ?, ?)";
              $stmt = $dbh->prepare($sql);
              //verification des contraintes
              if(strlen($nomEquipe) <= 30 && strlen($club) <= 30) {
                if ($stmt->execute([$nomEquipe, $club, $numTournois])) {
                  $indexNbJoueur = 1;
                  while ($indexNbJoueur <= $nbJoueurParEquipe) {
                    //AJOUT DES JOUEURS
                    //variables
                    $numJoueur = getLastNumJoueur() + 1;
                    $nomJoueur = htmlspecialchars($_POST['nomJoueur' . $indexNbJoueur . 'Equipe' . $index]);
                    $prenomJoueur = htmlspecialchars($_POST['prenomJoueur' . $indexNbJoueur . 'Equipe' . $index]);
                    $niveauJoueur = htmlspecialchars($_POST['niveauJoueur' . $indexNbJoueur . 'Equipe' . $index]);
                    $sql = "INSERT INTO joueur (numjoueur, nom, prenom, niveau, nomequipe) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($sql);
                    //verification des contraintes
                    if(strlen($nomJoueur) <= 20 && strlen($prenomJoueur) <= 20 && $niveauJoueur >= 1 && $niveauJoueur <= 7) {
                      if (!$stmt->execute([$numJoueur, $nomJoueur, $prenomJoueur, $niveauJoueur, $nomEquipe])) {
                        echo "Erreur, le joueur n'a pas pu être ajouté dans la base de donnée!<br>";
                        $bienPasse = false;
                      }
                    }
                    else {
                      echo "Erreur, les contraintes pour la créaction du joueur pas respecté !<br>";
                      $bienPasse = false;
                    }
                    $indexNbJoueur++;
                  }
                }
                else {
                  echo "Erreur, l'équipe n'a pas pu être ajouté dans la base de donnée!<br>";
                  $bienPasse = false;
                }
              }
              else {
                echo "Erreur, la contrainte du nom d'équipe n'est pas respecté!<br>";
                $bienPasse = false;
              }
            }
            else {
              echo "Erreur, le nom d'équipe n'est pas disponible<br>";
              $bienPasse = false;
            }
            $index++;
          }
          //si toutes les requêtes se sont bien passées
          if ($bienPasse) {
            ?>
            <br>
            <h3>Ajout des équipes réussi !</h3>
            <h4>Redirection en cours...</h4>
            <script type="text/javascript">
                setTimeout(function() {window.location.href = "pageConfigTournois.php";}, 2500);
            </script>
            <?php
          }
        } catch (PDOException $e) {
          print "Erreur ! : " . $e->getMessage() . "<br>";
          die();
        }
      }
    }
    else {
      echo "Erreur, la page n'a pas pu être chargé !<br>";
    }
  ?>
  </div>
  <script src="js/autreElement.js"></script>
  </body>
</html>