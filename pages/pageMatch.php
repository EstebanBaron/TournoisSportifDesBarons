<?php
session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Page de match</title>
    <link rel="stylesheet" href="css/styleFeuilleMatch.css" />
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
  </head>
  <body>
    <?php
    if (isset($_POST['numtournois'], $_POST['score'], $_POST['equipes'])) {
        $numTournois = $_POST['numtournois'];
        $score = $_POST['score'];
        $equipes = $_POST['equipes'];

        $equipes = explode('-', $equipes);
        $score = explode('-', $score);
        ?>
        <h1>Match qui oppose <?php echo '"' . $equipes[0] . '" et "' . $equipes[1] . '"' ?></h1>
        <table>
            <tr id="nomEquipes">
                <th id="equipe1"><?php echo $equipes[0]; ?></th>
                <th id="equipe2"><?php echo $equipes[1]; ?></th>
            </tr>
            <tr id="score">
                <th id="scoreJ1"><?php echo $score[0]; ?></th>
                <th id="scoreJ2"><?php echo $score[1]; ?></th>
            </tr>
            <tr id="boutons">  
                <th id="boutonJ1">
                    <button type="button" name="plusUnJ1" onclick="plusUnJ1();">+1</button>
                    <button type="button" name="moinsUnJ1" onclick="moinsUnJ1();">-1</button>
                </th>
                <th id="boutonJ2">
                    <button type="button" name="plusUnJ2" onclick="plusUnJ2();">+1</button>
                    <button type="button" name="moinsUnJ2" onclick="moinsUnJ2();">-1</button>               
                </th>
            </tr>
        </table>

        <form id="formulaire" method="post" action="pageMatchsPoules.php">
            <input type="hidden" name="numtournois" value=<?php echo $numTournois;?>>
        </form>
        <button type="button" name="boutonAjoutScore" onclick="ajoutScore();">fin du match</button>
        <?php
    }
    else {
        echo "Erreur lors du chargement des données de la page ! <br>";
    } 
    ?>
    <script src="js/feuilleMatch.js"></script>
  </body>
</html>