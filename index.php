<HTML>
<body>
<h1> T h e  n o  n u t  n o v e m b e r - c h a l l e n g e  </h1>



<?php
session_start();

$json = file_get_contents("list.json");
$personer = json_decode($json);

echo "<table class='yayeet'>";
echo "<thead>
        <tr><th>Navn</th><th>Har holdt i:</th></tr>
      </thead>";
echo "<tbody>";

foreach ($personer as $person) {
  echo "<tr> <td>" . $person->navn . "</td>";
  $dager_siden = date("d") - $person->dato;
  if($dager_siden < 0){
    echo "<td>Om " . $dager_siden * (-1) . " dager</td> </tr>";
  } else {
    echo "<td>" . $dager_siden . " dager</td> </tr>";
  }
}

echo "</tbody>";
?>
</table>
<form action="edit.php" method="post">
<button name="Edit_all" type="submit">Edit</button>
</form>
</body>
</HTML>