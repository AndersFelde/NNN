<html>
<body>
<script>
function addRow(rowA){
    var table = document.getElementById("table");
    var tr = document.createElement("tr");
    var td1 = document.createElement("td");
    var td2 = document.createElement("td");
    var td3 = document.createElement("td");
    var navn = document.createElement("input");
    var dager = document.createElement("input");
    var button = document.createElement("button");

    tr.setAttribute("id", rowA);

    navn.name = "navn" + (rowA);
    navn.setAttribute("required", "true");

    dager.name = "dager" + (rowA+1);
    dager.type = "number";
    dager.setAttribute("required", "true");
    dager.setAttribute("min", "1");
    dager.setAttribute("max", "30");


    button.setAttribute("onClick", "javascript: delRow(" + rowA + ")");
    button.innerHTML = "slett rad";

    td1.appendChild(navn);
    td2.appendChild(dager);
    td3.appendChild(button);

    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    table.appendChild(tr);

    var index = rowA+2;

    document.getElementById("addRow").setAttribute("onClick", "javascript: addRow(" + index + ")");
    document.getElementById("endre").setAttribute("value", index)
};

function delRow(rowD){
    console.log("mama");
    var element = document.getElementById(rowD);
    element.parentNode.removeChild(element);
};

</script>

<?php 
session_start();

if(isset($_POST["Edit_all"])){
    if(isset($_SESSION["signed_in"])){
        $_SESSION["login"] = "true";
        header("Location: edit.php");
    } else {
        include("form.php");
    }
    
} elseif(isset($_POST["login"]) || isset($_SESSION["login"])) {

    function printEdit($signed_in){
        $file = "list.txt";
        $arr_list = explode("-",file_get_contents($file));
        $count = count($arr_list) - 1;
        echo "<form action='#' method='post'>";
        if($signed_in){
            echo "<br>Fortsatt være logget inn?<input type='checkbox' name='continue_sign_in' checked><br>";
        }
        echo "<button id='endre' name='endring' value='$count' type='submit'>Lagre</button>";
        echo "<table class='yayeet'>";
        echo "<thead>
                <tr><th>Navn</th><th>Har holdt seg fra:</th></tr>
              </thead>";
        echo "<tbody id='table'>";
        for ($i=0; $i < ($count); $i++) {
        
            echo "<tr id='$i'> <td><input name='navn$i' value='$arr_list[$i]'></td>";
            $i++;
            echo "<td><input type='number' min='1' max='30' value='$arr_list[$i]' name='dager$i'></td>";
            echo "<td><button type='button' onclick='delRow(" . ($i - 1) . ")'>Slett rad</button></td></tr>";
            
        }
        echo "</tbody>";
        echo "</table>";
        echo "</form>";
        echo "<button id='addRow' onclick='addRow($count)'>Legg til rad</button>";
    };

    if(isset($_POST["login"])){
        if($_POST["pas"] == "JoeMama"){
            if(isset($_POST["stay_signed"])){
                $_SESSION["signed_in"] = "true";
                printEdit(true);
            } else {
                printEdit(false);
            }

            
        } else {
            echo "Feil passord";
            include("form.php");
        }
    } elseif(isset($_SESSION["signed_in"])){
        printEdit(true);
    }
    unset($_POST["login"]);
    unset($_SESSION["login"]);

}elseif(isset($_POST["endring"])){
    var_dump($_POST);
    $file_content = "";
    for ($i=0; $i < $_POST["endring"]; $i++) {
        if(empty($_POST["navn$i"]) || empty($_POST["dager" . ($i + 1)])){
            $i++;
        } else {
            $file_content = $file_content . $_POST["navn$i"] . "-";
            $i++;
            $file_content = $file_content . $_POST["dager" . $i] . "-";

            if(file_put_contents("list.txt", $file_content)){
            }
        }
        
    }
    if(isset($_SESSION["signed_in"])){
        if(!isset($_POST["continue_sign_in"])){
            unset($_SESSION["signed_in"]);
        }

    }
    echo "du skal ikke være her<br>";
    header('Location: index.php');
    echo "<a href='index.php'>index</a>";
} else {
    header("Location: index.php");
}

?>
</body>
</html>