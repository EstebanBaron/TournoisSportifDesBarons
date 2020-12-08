<?php
session_start();

$numTournois = NULL;
$numTour = NULL;
$poules = NULL;
if (isset($_POST['numtournois'], $_POST['numtour'], $_POST['poules'])) {
    $numTournois = $_POST['numtournois'];
    $numTour = $_POST['numtour'];
    $poules = $_POST['poules'];
    $_SESSION['numtournois'] = $numTournois;
    $_SESSION['numtour'] = $numTour;
}
else if (isset($_SESSION['numtournois'], $_SESSION['numtour'])) {
    $numTournois = $_SESSION['numtournois'];
    $numTour = $_SESSION['numtour'];
}


function toArray($poule)
{
  $oui = explode(',',$poule);
  for($i=0; $i<count($oui); $i++)
  {

  }

}

function composeMatchs($poule)
{
  $matchs = array();
  for($i=0; $i<count($poule); $i++)
  {
    for($j=($i+1); $j<count($poule); $j++)
    {
      array_push($matchs, $poule[$i]."-".$poule[$j]);
    }
  }
  return array_unique($matchs);
}


function creeMatchsArray($poule)
{
  $matchsArray = array();
  for($i=0; $i<count($poule); $i++)
  {
    if(gettype($poule[$i]) == "array")
    {
      array_push($matchsArray,creeMatchsArray($poule[$i]));
    }
    else
    {
      array_push($matchsArray,composeMatchs($poule));
    }
  }
  return $matchsArray;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Page Poules</title>
  </head>
  <body>
  <h1>Les Matchs du Tour <?php echo '"' . $numtour . '"';  ?> </h1>

  <form method ="post" action="pageMatch.php">
    <!-- <input type="hidden" name="numtournois" value=<?php //echo $numTournois; ?>>
    <input type="hidden" name="score" value=<?php //echo $score ?>>  ex : score = "4-6"
    <input type="hidden" name="equipes" value=<?php //echo $equipes; ?>> -->

    <!-- tests -->
    <input type="hidden" name="numtournois" value=<?php echo $numTournois; ?>>
    <input type="hidden" name="score" value=<?php echo "0-0"; ?>>  <!-- ex : score = "4-6" -->
    <input type="hidden" name="equipes" value=<?php echo "LesBambous-LesFleurs"; ?>>

    <input type="submit" name="match" value=<?php //echo $equipe; ?>>
  </form>
  <?php

    $arrayPoules = toArray($poules);



    //RAjouter modifier $_SESSION['classement'] et verif que tout les matchs sont fini?>
    <form method ="post" action="pageTournois.php">
    <input type="hidden" name="numtournois" value=<?php echo $numTournois; ?>>
    <input type="hidden" name="numtour" value=<?php echo $numTour ?>>
    <input type="hidden" name="listeEquipes" value=<?php echo $_POST['listeEquipes']; ?>>
    <input type="submit" name="ValiderTour" value="Valider Tour">
    </form>
  </body>
</html>