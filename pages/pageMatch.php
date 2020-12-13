<?php
session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page de match</title>
    <link rel="stylesheet" href="css/barreTitre.css" />
    <link rel="stylesheet" href="css/styleMatch.css" />
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
  <div class="barreTitre">
      <div class="divTitre">
        <a class="titre">La Baronnerie</a>
      </div>
    </div>
    <?php
    if (isset($_POST['numtournois'], $_POST['score'], $_POST['equipes'])) {
        $numTournois = $_POST['numtournois'];
        $score = $_POST['score'];
        $equipes = $_POST['equipes'];

        $equipes = explode('-', $equipes);
        $score = explode('-', $score);
        ?>
        <div id="divMatchOppose">
            <p class="matchOppose">Match qui oppose <?php echo '<p class="nomEquipe">' . $equipes[0] . '</p> <p class="matchOppose">et</p> <p class="nomEquipe">' . $equipes[1] . '</p>' ?></h1>
        </div>
        <div id="divTable">
            <table>
                <tr id="nomEquipes">
                    <th id="equipe1"><?php echo $equipes[0]; ?></th>
                    <th id="equipe2"><?php echo $equipes[1]; ?></th>
                </tr>
                <tr id="score">
                    <td id="scoreJ1"><?php echo $score[0]; ?></td>
                    <td id="scoreJ2"><?php echo $score[1]; ?></td>
                </tr>
                <tr id="boutons">  
                    <td id="boutonJ1">
                        <button class="button" type="button" name="plusUnJ1" onclick="plusUnJ1();">+1</button>
                        <button class="button" type="button" name="moinsUnJ1" onclick="moinsUnJ1();">-1</button>
                    </td>
                    <td id="boutonJ2">
                        <button class="button" type="button" name="plusUnJ2" onclick="plusUnJ2();">+1</button>
                        <button class="button" type="button" name="moinsUnJ2" onclick="moinsUnJ2();">-1</button>               
                    </td>
                </tr>
            </table>

            <form id="formulaire" method="post" action="pageMatchsPoules.php">
                <input type="hidden" name="numtournois" value=<?php echo $numTournois;?>>
            </form>
            <button class="boutonEnregistrerScore" type="button" name="boutonAjoutScore" onclick="ajoutScore();">enregistrer score</button>
        </div>
        <?php
    }
    else {
        echo "Erreur lors du chargement des données de la page ! <br>";
    } 
    ?>
    <script src="js/feuilleMatch.js"></script>
  </body>
</html>