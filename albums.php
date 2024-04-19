<?php include("modules/navbar.php"); ?>



<div class="albums_container">
  <div class="dropdown_wrapper">
    <form id="dropdown_form" action="/albums.php">
      <select name="artists" id="dropdown">
        <?php
        $sql = "SELECT * FROM artist_names";

        $names = getData($sql);

        // print_r($names);

        foreach ($names as $name) {
          echo "<option value=" . $name["name"] . ">" . $name["name"] . "</option>";
        }
        ?>
      </select>
    </form>
  </div>
  <div class="form_wrapper">

  </div>
  <div class="table_wrapper"></div>
</div>

<script>
  document.getElementById("dropdown").addEventListener("change", function() {
    document.getElementById("dropdown_form").submit();
  });
</script>

<?php include("modules/footer.php"); ?>