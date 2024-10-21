<?php
session_start();

function chooseWordToGuess($wordsArray) {
    $rdmIndexPos = rand(0, count($wordsArray) - 1);
    return str_split($wordsArray[$rdmIndexPos]);
}

function gameEnd() {
  unset($_SESSION['chosenWord']);
  unset($_SESSION['unknownLetters']);
  unset($_SESSION['tries']);
  echo '<br/><button onclick="window.location.href=\'' . $_SERVER['SCRIPT_NAME'] . '\'">New Game</button>';
  exit();
}

function showAllTriedLetters($letterArray) {
  for($i = 0; $i < count($letterArray); $i++) {
    echo $letterArray[$i] . " ";
  }
}

function checkIfAlreadyTried($letterArray, $letter) {
  $counter = 0;
  for ($i = 0; $i < count($letterArray); $i++) {
      if (strtoupper($letterArray[$i]) == strtoupper($letter)) {
          $counter++;
      }
  }
  return $counter;
}

$csvFile = 'words.txt';

if (($handle = fopen($csvFile, 'r')) !== false) {
  $wordsToPlay = [];
  while (($data = fgetcsv($handle)) !== false) {
      $wordsToPlay[] = $data[0];
  }
  fclose($handle);
} else {
  die('Error reading CSV file');
}

// 1. öffnet das CSV file in 'r' read only -> $handle variable
// if(!== false )prüft ob erfolgreich
// while (!== false) prüft ob noch Reihen im CSV file vorhanden sind
// fclose($handle) beendet file handle vom CSV file
// else { die('Error reading CSV file'); -> Wenn beim Öffnen der CSV-Datei ein Problem aufgetreten ist, wird das Skript mit einer Fehlermeldung beendet, die darauf hinweist, dass beim Lesen der CSV-Datei ein Fehler aufgetreten ist.


if (!isset($_SESSION['chosenWord'])) {
    $_SESSION['chosenWord'] = chooseWordToGuess($wordsToPlay);
    $_SESSION['unknownLetters'] = array_fill(0, count($_SESSION['chosenWord']), "__");
    $_SESSION['tries'] = 0;
    $_SESSION['triedLetters'] = [];
}

if (isset($_POST["startGame"])) {
    $_SESSION['chosenWord'] = chooseWordToGuess($wordsToPlay);
    $_SESSION['unknownLetters'] = array_fill(0, count($_SESSION['chosenWord']), "__");
    $_SESSION['tries'] = 0;
    $_SESSION['triedLetters'] = [];
}

// $guessedLetter = isset($_POST["letter"]);
// array_push($_SESSION['triedLetters'], strtoupper($guessedLetter));
//added a boolean to array -> output was 1,1,1, -> fixed it with chatgpt
$guessedLetter = isset($_POST["letter"]) ? $_POST["letter"] : '';
array_push($_SESSION['triedLetters'], strtoupper($guessedLetter));



if ($guessedLetter) {
    $letterFound = false;

    for ($i = 0; $i < count($_SESSION['chosenWord']); $i++) {
        if (strtoupper($_POST["letter"]) == strtoupper($_SESSION['chosenWord'][$i])) {
            $_SESSION['unknownLetters'][$i] = $_SESSION['chosenWord'][$i];
            $letterFound = true;
            echo "Letter was correct! ";
        }
    }

    if (!$letterFound && $_SESSION['tries'] < 7) {
        $_SESSION['tries']++;
        echo "Letter was incorrect! " . 7-$_SESSION['tries'] . " tries left";
    }  
    elseif ($_SESSION['tries'] < 7 && checkIfAlreadyTried($_SESSION['triedLetters'], strtoupper($guessedLetter)) > 2) {
      $_SESSION['tries']++;
        echo "Letter was already tried! " . 7-$_SESSION['tries'] . " tries left";
    }
    elseif ($_SESSION['tries'] >= 7) {
      echo "You lost!";
      gameEnd();
    }

    $checkIfWon = 0;

    for ($i = 0; $i < count($_SESSION['unknownLetters']); $i++) {
      if($_SESSION['unknownLetters'][$i] != "__") {
        $checkIfWon++;
      }
    }
    if($checkIfWon == count($_SESSION['unknownLetters'])) {
      echo "You won!";
      gameEnd();
    }
}

require_once("main.php");
?>
