<?php include("modules/navbar.php"); ?>
<div class="albums_container">
  <div class="dropdown_wrapper">
    <form id="dropdown_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
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
  </div>
  <div class="form_wrapper">
    <form action="<?php echo "functions/addAlbum.php" ?>" method="post">
      <fieldset>
        <legend>Lägg till en ny skiva:</legend>
        <input type="text" name="album" required>
        <input type="number" name="rating" max="10" min="1" step="0.1" value="5" required>
        <input type="date" name="release" value="<?php echo date("Y-m-d"); ?>" required>
        <select name="artist" id="newDropdown" required>
          <option value="default">Välj artist</option>
          <?php
          foreach ($artists as $artist) {
            echo "<option value=" . $artist["id"] . ">" . $artist["name"] . "</option>";
          }
          ?>
        </select>
        <input type="submit" value="Lägg till">
      </fieldset>
    </form>
  </div>
  <div class="table_wrapper">
    <table class="albums">
      <tr class="albums">
        <th class="albums">Album</th>
        <th class="albums">Artist</th>
        <th class="albums">Betyg</th>
        <th class="albums">Utgivnings datum</th>
        <th class="albums">Modifiera/radera skiva</th>
      </tr>
      <?php
      if ($_GET) {
        $sql = "SELECT * FROM albums_display WHERE artist_id = " . $_GET["artists"];

        $res = getData($sql);

        foreach ($res as $album) {
          echo "<tr class='albums'>";
          foreach ($album as $key => $val) {
            if ($key !== "id") {
              echo "<td class='albums'>" . $val . "</td>";
              continue;
            }
            echo "<td class='buttons albums'>";
            echo "<a href='mod.php?item=album&id=" . $val . "'>Modifiera</a>";
            echo "<a href='rem.php?item=album&id=" . $val . "'>Ta bort</a>";
            echo "</td>";
            break;
          }
          echo "</tr>";
        }
      } else {
        $sql = "SELECT * FROM albums_display;";

        $res = getData($sql);

        foreach ($res as $album) {
          echo "<tr class='albums'>";
          foreach ($album as $key => $val) {
            if ($key !== "id") {
              echo "<td class='albums'>" . $val . "</td>";
              continue;
            }
            echo "<td class='buttons albums'>";
            echo "<a href='mod.php?item=album&id=" . $val . "'>Modifiera</a>";
            echo "<a href='rem.php?item=album&id=" . $val . "'>Ta bort</a>";
            echo "</td>";
            break;
          }
          echo "</tr>";
        }
      }

      ?>
    </table>
  </div>
</div>

<script>
  document.getElementById("dropdown").addEventListener("change", function() {
    document.getElementById("dropdown_form").submit();
  });
</script>
<?php include("modules/footer.php"); ?>