<HTML>
<body>
<h1> The nonutnovember-challenge </h1>



<?php
session_start();

$file = "list.txt";
$arr_list = explode("-",file_get_contents($file));

echo "<table class='yayeet'>";
echo "<thead>
        <tr><th>Navn</th><th>Har holdt i:</th></tr>
      </thead>";
echo "<tbody>";
for ($i=0; $i < count($arr_list)-1; $i++) {

  echo "<tr> <td>" . $arr_list[$i] . "</td>";
  $i++;
  $dager_siden = date("d") - $arr_list[$i];
  if($dager_siden < 0){
    echo "joe mama";
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