<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page de creation compte</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
    <link rel="stylesheet" href="css/styleCreerCompte.css" />
  </head>
  <body>
  <div class="barreTitre">
    <a class="retour" href="pageAuthentification.php" style="text-decoration: none;">retour</a>
    <div class="divTitre">
        <a class="titre">La Baronnerie</a>
    </div>
  </div>
    <div id="tout">
        <form method="post">
            <!--identifiant-->
            <p>(Les champs prefixés par des * sont obligatoires)</p>
            <label for="identifiant"> Identifiant* :</label>
            <input type="text" name="identifiant" maxlength="20" required><br>

            <!--mot de passe-->
            <label for="motdepasse"> Mot de passe* :</label>
            <input type="password" name="motdepasse" maxlength="20" required><br>

            <!--confirmation mdp-->
            <label for="confirmationMDP"> Confirmer votre mot de passe* :</label>
            <input type="password" name="confirmationMDP" maxlength="20" required><br>

            <!--bouton-->
            <input class="button" type="submit" value="s'enregistrer" name="enregistrement">
        </form>
    <?php
    if (isset($_POST['identifiant']) && isset($_POST['motdepasse']) && isset($_POST['confirmationMDP']) && isset($_POST['enregistrement'])) {
        $identifiant = $_POST['identifiant'];
        $mdp = $_POST['motdepasse'];
        $confirmMDP = $_POST['confirmationMDP'];
        if ($mdp !== $confirmMDP) {
            echo "Erreur, les mots de passes sont incohérents !";
        }
        else {
            try {
                $dbh = new PDO("pgsql:dbname=bddestebanjulien;host=localhost;user=bddestebanjulien;password=lesbarons;options='--client_encoding=UTF8'");
                $organisateur = $dbh->query('SELECT * from organisateur');
                //on vérifie que le nom d'utilisateur n'est pas déjà utilisé (clé primaire)
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
                    if(!$dejaUtilise) { //on insert dans la base le nouveau organisateur
                        $sql = "INSERT INTO organisateur (identifiant, motdepasse) VALUES (?, ?)";
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
                                    //permet d'attentre 2500ms (2.5s) avant d'aller sur pageAccueil.php
                                    setTimeout(function() {window.location.href = "pageAccueil.php";}, 2500);
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
    </div>
  </body>
</html>