<?php
session_start();
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
    <input type="text" name="lieu" maxlength="20" required><br>

    <!-- date evenement -->
    <label for="dateevenement"> Date de l'événement* :</label>
    <input type="date" name="dateevenement" required><br>
    </form>

    <h3>Tournois : </h3>
    <!-- nom du Tournois -->
    <div id="tournois">
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
    <button id="boutonTournois">autre tournois</button> <button id="boutonSupprimerTournois">supprimer</button><br>

    <h3>Terrains : </h3>
    <div id="terrain">
    <select name="sport">
      <option value="Football">Football</option>
      <option value="Basketball">Basketball</option>
      <option value="Tennis">Tennis</option>
      <option value="Rugby">Rugby</option>
      <option value="Petanque">Pétanque</option>
      <option value="Volley">Volley</option>
    </select>
    <input type="number" name="nbTerrain0" min="1" max="100" value="1"><br>
    </div>
    <button id="boutonTerrain">autre terrain</button> <button id="boutonSupprimerTerrain">supprimer</button><br>

    <!--bouton-->
    <br><br>
    <input type="submit" value="Creer l'événement" name="creationevenement">
    <?php
    if (isset($_POST['nom']) && isset($_POST['lieu']) && isset($_POST['dateevenement']) && isset($_POST['creationevenement'])) {
        $identifiant = $_POST['identifiant'];
        $mdp = $_POST['motdepasse'];
        $confirmMDP = $_POST['confirmationMDP'];
        if ($mdp !== $confirmMDP) {
            echo "Erreur, les mots de passes sont incohérents !";
        }
        else {
            try {
                $dbh = new PDO("pgsql:dbname=postgres;host=localhost;user=postgres;password=carpate3433;options='--client_encoding=UTF8'");
                $organisateur = $dbh->query('SELECT * from organisateur');
                if ($organisateur) {
                    $dejaUtilise = false;
                    foreach($organisateur as $row) {
                        foreach($row as $cle=>$value) {
                            if($identifiant === $row['identifiant']) {
                                echo "Erreur, nom d'utilisateur déjà utilisé !";
                                $dejaUtilise = true;
                            }
                        }
                    }
                    if(!$dejaUtilise) {
                        $sql = "INSERT INTO organisateur (identifiant, motdepasse, nom, prenom) VALUES (?, ?)";
                        $stmt = $dbh->prepare($sql);
                        //ajout utilisateur
                        if(strlen($identifiant) <= 20 && strlen(md5($mdp)) <= 50) {
                            if ($stmt->execute([$identifiant, md5($mdp)])) {
                                $_SESSION['identifiant'] = $identifiant;
                                echo "Enregistrement réussi. Bienvenue " . htmlspecialchars($_SESSION['identifiant']) . " !";
                                ?>
                                <br>
                                <h4>Redirection en cours...</h4>
                                <script type="text/javascript">
                                    //permet d'attentre 3000ms (3s) avant d'aller sur pageAccueil.php
                                    setTimeout(function() {window.location.href = "pageAccueil.php";}, 3000);
                                </script>
                                <?php
                            }
                            else {
                                echo "Erreur d'execution de la requête préparé !";
                            }
                        }
                        else {
                            echo "Erreur, la taille des champs renseigné dépasse la limite autorisé !";
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
    }
    ?>
    <script src="autreElement.js"></script>
  </body>
</html>