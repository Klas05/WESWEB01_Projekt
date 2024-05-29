<?php

/**
 * Denna fils översiktliga uppgift är att hämta alla album som existerar i databasen och visar upp de för klienten. Filen erbjuder även att lägga till, redigera och ta bort album från databasen.
 */
include_once("modules/navbar.php");
/**
 * Vid rad tillägg i databasen så skickas användaren till denna sida med en POST förfrågan.
 * Vid detta fall så saniteras indatan och raden läggs till i databasen med hjälp av addRow funktionen.
 */
if ($_POST) {
  $safePost = sanitize($_POST);
  if ($safePost["artist"] !== "default") {
    addRow($safePost);
  }
}
?>
<div class="albums_container">
  <form id="dropdown_form" action="">
    <select name="artists" id="dropdown">
      <?php
      $sql = "SELECT * FROM artist_names";
      $artists = getData($sql);
      ?>
      <option value="default">Välj artist</option>
      <?php
      foreach ($artists as $artist) {
        echo "<option value=" . $artist["id"] . ">" . $artist["name"] . "</option>";
      }
      ?>
    </select>
  </form>
  <div class="form_wrapper">
    <form action="" method="post">
      <fieldset>
        <legend>Lägg till en ny skiva:</legend>
        <label for="album">Namn:</label>
        <input type="text" name="album" id="album" required>
        <label for="rating">Betyg:</label>
        <input type="number" name="rating" id="rating" max="10" min="1" step="0.1" value="5" required>
        <label for="release">Utgivningsdatum:</label>
        <input type="date" name="release" id="release" value="<?php echo date("Y-m-d"); ?>" required>
        <label for="newDropdown">Artist:</label>
        <select name="artist" id="newDropdown" required>
          <option value="default">Välj artist</option>
          <?php
          foreach ($artists as $artist) {
            echo "<option value=" . $artist["id"] . ">" . $artist["name"] . "</option>";
          }
          ?>
        </select>
        <button type="submit" name="add" value="albums">Lägg till</button>
      </fieldset>
    </form>
  </div>
  <div class="table_wrapper">
    <table>
      <tr>
        <th>Album</th>
        <th>Artist</th>
        <th>Betyg</th>
        <th>Utgivnings datum</th>
        <th>Modifiera/radera skiva</th>
      </tr>
      <?php
      /**
       * Hämtar alla album och visar upp de samt alternativen att redigera och modifiera albumet i databasen.
       */
      $sql = "SELECT * FROM albums_display ORDER BY artist_id, release_date;";
      $albums = getData($sql);

      if ($_GET) {
        $safeGet = sanitize($_GET);
        $sql = "SELECT * FROM albums_display WHERE artist_id = :artist_id ORDER BY artist_id, release_date;";
        $albums = getData($sql, ["artist_id" => $safeGet["artists"]]);
      }

      foreach ($albums as $album) {
        echo "<tr>";
        foreach ($album as $key => $val) {
          if ($key !== "id") {
            echo "<td>" . $val . "</td>";
            continue;
          }
          echo "<td class='buttons'>";
          echo "<a href='change.php?action=modify&item=albums&id=" . $val . "'>Modifiera</a>";
          echo "<a href='change.php?action=delete&item=albums&id=" . $val . "'>Ta bort</a>";
          echo "</td>";
          break;
        }
        echo "</tr>";
      }


      ?>
    </table>
  </div>
</div>

<script>
  /**
   * Laddar om sidan vid förändring i dropdown elementet som väljer artist och sorterar därefter albumen efter artisten som är vald.
   */
  document.getElementById("dropdown").addEventListener("change", function() {
    document.getElementById("dropdown_form").submit();
  });
</script>
<?php include_once("modules/footer.php"); ?>