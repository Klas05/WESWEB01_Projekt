
<?php

include_once("modules/navbar.php");

require_once "functions/functions.php";


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
