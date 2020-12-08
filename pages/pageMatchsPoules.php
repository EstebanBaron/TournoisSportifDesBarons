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
  $arraypoule = array();
  for($i=0; $i<count($oui); $i++)
  {
    $non = explode('-',$oui[$i]);
    array_push($arraypoule,$non);
  }
  return $arraypoule;
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
      return composeMatchs($poule);
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
    <input type="hidden" name="score" value="0-0">  <!-- ex : score = "4-6" -->
    <input type="hidden" name="equipes" value="LesBambous-LesFleurs">

    <input type="submit" name="match" value="LesBambous-LesFleurs">
  </form>
  <?php
    $arrayPoules = toArray("eq1-eq2-eq3,eq4-eq5-eq6-eq7,eq8-eq9-eq10");
    //$arrayPoules = toArray($poules);
    $arrayMatchs = creeMatchsArray($arrayPoules);
    for($numPoule=0; $numPoule<count($arrayMatchs); $numPoule++)
    {
      echo "<h3>Poule n°".($numPoule+1)." :</h3>";
      for($matchs=0; $matchs<count($arrayMatchs[$numPoule]); $matchs++)
      {
        echo '<form method ="post" action="pageMatch.php">';
        echo '<input type="hidden" name="numtournois" value='.$numTournois.'>';
        echo '<input type="hidden" name="score" value=' . $score .'>';//score = "4-6"
        echo '<input type="hidden" name="equipes" value=' . $arrayMatchs[$numPoule][$matchs] . '>';
        echo '<input type="submit" name="match" value=' .  $arrayMatchs[$numPoule][$matchs] .'>';
        echo '</form>';
      }
    }
    //RAjouter modifier $_SESSION['classement'] et verif que tout les matchs sont fini?>
    <form method ="post" action="pageTournois.php">
    <input type="hidden" name="numtournois" value=<?php echo $numTournois; ?>>
    <input type="hidden" name="numtour" value=<?php echo $numTour ?>>
    <input type="hidden" name="listeEquipes" value=<?php echo $_POST['listeEquipes']; ?>>
    <input type="submit" name="ValiderTour" value="Valider Tour">
    </form>
  </body>
</html>