<?php

/**
 * Denna filens översiktliga uppgift är att visa upp alla artister som finns med i databasen och erbjuder alternativen att lägga till, modifiera och radera artister från databasen.
 */
include_once("modules/navbar.php");
/**
 * Vid rad tillägg i databasen så skickas användaren till denna sida med en POST förfrågan.
 * Vid detta fall så saniteras indatan och raden läggs till i databasen.
 */
if ($_POST) {
  $safePost = sanitize($_POST);
  addRow($safePost);
}
?>


<div class="artists_container">
  <form action="" id="dropdown_form">
    <select name="genre" id="dropdown">
      <option value="default">Välj genre</option>
      <?php
      $sql = "SELECT DISTINCT genre FROM artists";
      $genres = getData($sql);

      foreach ($genres as $id => $genre) {
        echo "<option value='" . $genre["genre"] . "'>" . $genre["genre"] . "</option>";
      }
      ?>
    </select>
  </form>
  <div class="form_wrapper">
    <form action="" method="post">
      <fieldset>
        <legend>Lägg till ny artist:</legend>
        <label for="name">Namn:</label>
        <input type="text" name="name" id="name">
        <label for="genre">Genre</label>
        <input type="text" name="genre" id="genre">
        <button type="submit" name="add" value="artists">Lägg till</button>
      </fieldset>
    </form>
  </div>
  <div class="table_wrapper">
    <table class="artists">
      <tr>
        <th>Artistnamn</th>
        <th>Genre</th>
        <th>Se album</th>
        <th>Modifiera/Ta bort artist</th>
      </tr>
      <?php
      /**
       * Radar upp alla artister som finns i databasen samt alternativen att radera eller modifiera artisten men också att visa upp alla album som artisten har i databasen.
       */
      $sql = "SELECT * FROM artists ORDER BY name;";
      if ($_GET) {
        $sql = "SELECT * FROM artists WHERE genre = '" . $_GET["genre"] . "' ORDER BY name;";
      }

      $artists = getData($sql);

      foreach ($artists as $artist) {
        echo "<tr>";
        $id = $artist["id"];
        unset($artist["id"]);
        foreach ($artist as $val) {
          echo "<td>" . $val . "</td>";
        }
        echo "<td><a href='albums.php?artists=" . $id . "'>Se album</a></td>";
        echo "<td class='buttons'>";
        echo "<a href='change.php?action=modify&item=artists&id=" . $id . "'>Modifiera</a>";
        echo "<a href='change.php?action=delete&item=artists&id=" . $id . "'>Ta bort</a>";
        echo "</td>";
      }
      ?>
    </table>
  </div>
</div>

<script>
  /**
   * Laddar om sidan vid val av genre för sortering.
   */
  document.getElementById("dropdown").addEventListener("change", function() {
    document.getElementById("dropdown_form").submit();
  });
</script>

<?php include_once("modules/footer.php"); ?>