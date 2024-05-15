
<?php

include_once("modules/navbar.php");

require_once "functions/functions.php";

/**
 * När användaren vill redigera eller ta bort en rad i databasen skickas de till denna fil.
 * Vid val av borttagning inkluderas filen för att ta bort rader och vid val av redigering
 * inkluderas filen för modifikation på en rad.
 */
if ($_GET) {
  if ($_GET["action"] == "delete") {
    include_once("modules/delete.php");
  }
  if ($_GET["action"] == "modify") {
    include_once("modules/modify.php");
  }
}


include_once("modules/footer.php");
?>
