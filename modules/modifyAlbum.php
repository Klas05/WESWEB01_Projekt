<div class="edit_album_content">
  <div class="form_wrapper">
    <form action="" method="post">
      <fieldset class="editing">
        <legend>
          Redigera albumet <?php echo $result["name"]; ?>
        </legend>
        <div class="values">
          <label for="name">Namn:</label>
          <input type="text" name="name" id="name" value="<?php echo $result["name"]; ?>" required>
          <label for="rating">Betyg:</label>
          <input type="number" name="rating" id="rating" max="10" min="1" step="0.1" value="<?php echo $result["rating"]; ?>" required>
          <label for="release_date">Utgivningsdatum:</label>
          <input type="date" name="release_date" id="release_date" value="<?php echo $result["release_date"]; ?>" required>
          <label for="img">Bildlänk:</label>
          <input type="url" name="img" id="img" value="<?php echo $result["img"]; ?>">
          <label for="artist_id">Artist:</label>
          <select name="artist_id" id="artist_id" required>
            <?php
            foreach ($artists as $artist) {
              if ($artist["id"] == $result["artist_id"]) {
                echo "<option selected value=" . $artist["id"] . ">" . $artist["name"] . "</option>";
              } else {
                echo "<option value=" . $artist["id"] . ">" . $artist["name"] . "</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="answers">
          <input type="submit" name="answer" value="Spara">
          <input type="submit" name="answer" value="Avbryt">
        </div>
      </fieldset>
    </form>
  </div>

  <div class="songs_wrapper info">
    <form action="" method="post">
      <fieldset class="editing">
        <legend>Lägg till låt</legend>
        <div class="values">
          <label for="name">Låtnamn:</label>
          <input type="text" name="name" id="name" required>
          <label for="duration">Längd (mm:ss):</label>
          <input type="time" name="duration" id="duration" min="00:01" required>
          <label for="release_year">Utgivningsår:</label>
          <input type="number" min="1901" max="<?php echo date("Y"); ?>" step="1" value="<?php echo date("Y"); ?>" maxlength="4" name="release_year" required>
        </div>
        <div class="answers">
          <input type="submit" name="answer" value="Lägg till">
        </div>
      </fieldset>
    </form>
    <h1>Låtar</h1>
    <table>
      <tr>
        <th>Låtnamn</th>
        <th>Längd</th>
        <th>Utgivningsår</th>
        <th>Ta bort</th>
      </tr>
      <?php
      $songs = getSongs($result["id"]);

      if (count($songs) > 0) {
        foreach ($songs as $song) {
          echo "<tr>";
          echo "<td>" . $song["name"] . "</td>";
          echo "<td>" . $song["duration"] . "</td>";
          echo "<td>" . $song["release_year"] . "</td>";
          echo "<td><a href='change.php?action=delete&item=songs&id=" . $song["id"] . "&album=" . $result["id"] . "'>Ta bort</a></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr>";
        for ($i = 0; $i < 4; $i++) {
          echo "<td>Albumet är tomt!!</td>";
        }
        echo "</tr>";
      }

      ?>
    </table>
  </div>
</div>