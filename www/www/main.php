<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" name="form">
    <!-- Kopf-Teil bleibt unverändert -->
    <div style="margin: 2%;">
        <div>
            <h1>Ferrari trying to win a GP</h1>
            Letter:
            <input type="text" name="letter" style="margin-bottom: 15px">
            <br>
            <input type="submit" value="Guess" name="guess" style="margin-bottom: 15px">
            <input
                type="submit"
                value="New Game"
                name="startGame"
                style="margin-bottom: 15px"></div>
                <div id="myWord">
                  <?php
                  for ($i = 0; $i < count($_SESSION['chosenWord']); $i++) {
                    echo $_SESSION['unknownLetters'][$i] . " ";
                  }
                  ?>
                </div>
                <div id="lettersYouTried">
                  <?php
                  echo "<br> Letters you have already tried: ";
                  showAllTriedLetters($_SESSION['triedLetters'])
                  ?>
                </div>
        <div id="carReachesTrophy">
            <?php
            if ($_SESSION['tries'] >= 1 && $_SESSION['tries'] <= 8) {
                $imageNumber = str_pad($_SESSION['tries'], 2, '0', STR_PAD_LEFT);
                echo '<img src="img/' . $imageNumber . '.png" style="width: 500px;">';
            }
            ?>
        </div>
    </div>
</form>
