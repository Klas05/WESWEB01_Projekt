<?php

include("modules/navbar.php");

require_once "functions/functions.php";

$sql = "SELECT * FROM albums ORDER BY import_date LIMIT 1";

$res = getData($sql);

?>

<div class="wrapper">
  <img src="<?php echo $res[0]["img"]; ?>" alt="">

</div>

<?php

include("modules/footer.php");

?>