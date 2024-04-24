
<?php

include("modules/navbar.php");

require_once "functions/functions.php";


if ($_GET) {
  if ($_GET["action"] == "delete") {
    include("functions/delete.php");
  } else {
    include("functions/modify.php");
  }
}


include("modules/footer.php");
?>
