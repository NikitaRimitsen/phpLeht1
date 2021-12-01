
<?php
//require('conf.php');
/*session_start();
if (!isset($_SESSION['tuvastamine'])){//!-не / ne
    header('Location: loginAB.php');
    exit();

}
function clearVarsExcept($url, $varname){
    return strtok(basename($_SERVER['REQUEST_URI']), "?")."?$varname=".$_REQUEST[$varname];
}

global $yhendus;
//lisamine INSERT INTO
if(!empty($_REQUEST['koomentaartabel'])){
    $kask=$yhendus->prepare('INSERT INTO kommentaar(Kommentaar, Hinne, Nimi, Perenimi)
VALUES (?, ?, ?, ?)');
//"s" - string
// $_REQUEST['loomanimi'] - запрос в текстовый ящик input name="loomanimi"
    $kask->bind_param("ssss", $_REQUEST['koomentaartabel'], $_REQUEST['hinne'], $_REQUEST['nimed'], $_REQUEST['perenimed']);
    $kask->execute();
// изменяет адресную строку
    //$_SERVER[PHP_SELF] - до имени файла
    header("Location:" .basename($_SERVER['REQUEST_URI']));

}



// puu kustutamine - uus
if (isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask->bind_param("i",$_REQUEST['kustuta'] );
    $kask->execute();
}




?>
<!DOCTYPE html>
<html lang="et">
<head>
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <meta charset="UTF-8">
    <title>Kommentaar</title>
</head>
<body>
<div>
    <p><?$_SESSION["kasutaja"]?> on sisse logitud</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout2">
    </form>
</div>
<div class ="leftcolumn">
    <h2>Kommentaar</h2>

    <a href="https://rimitsen20.thkit.ee/phpLeht/index.php?">Tagasi</a>
    <br>
    <?php
global $yhendus;
//tabeli sisu näitamine
$kask=$yhendus->prepare("SELECT KommentaarID, Kommentaar, Hinne, Nimi, Perenimi FROM kommentaar");
$kask->bind_result($id, $komment, $hinne, $nimi, $perenimi);
$kask->execute();
echo "<table>";
echo "<tr>
<th>ID</th>
<th>Kommentaar</th>
<th>Hinne</th>
<th>Nimi</th>
<th>Perenimi</th>
</tr>";
//fetch() - извлечение данных из набора данных
    while($kask->fetch()){
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$komment</td>";
        echo "<td>$hinne</td>";
        echo "<td>$nimi</td>";
        echo "<td>$perenimi</td>";
        echo "<td><a href='".clearVarsExcept(basename($_SERVER['REQUEST_URI']), "leht")."&kustuta=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    echo "</table>";

    ?>
</div>
<br><br>
<div>
    <form action="<?=clearVarsExcept(basename($_SERVER['REQUEST_URI']), "leht")?>" method="post">
        <label for="koomentaartabel">Loomanimi</label>
        <br>
        <input type="text" name="koomentaartabel" id="koomentaartabel">
        <br>
        <label for="hinne">Kirjeldus</label>
        <br>
        <label for="nimed">Kirjeldus</label>
        <br>
        <label for="perenimed">Kirjeldus</label>
        <br>
        <input type="text" name="hinne" id="hinne">
        <br><br>
        <input type="submit" value="Lisa">
    </form>


</body>
</html>
*/


require ('conf.php'); //require - запрашиваем
// функция, которая удаляет из адресной строки переменные
function clearVarsExcept($url, $varname){
    return strtok(basename($_SERVER['REQUEST_URI']), "?")."?$varname=".$_REQUEST[$varname];
}

global $yhendus;
//lisamine INSERT INTO
if(!empty($_REQUEST['kommentaarnimi'])){
    $kask=$yhendus->prepare('INSERT INTO kommentaar(nimi, kirjeldus)
VALUES (?, ?)');
//"s" - string
// $_REQUEST['kommentaarnimi'] - запрос в текстовый ящик input name="kommentaarnimi"
    $kask->bind_param("ss", $_REQUEST['kommentaarnimi'], $_REQUEST['kirj']);
    $kask->execute();
// изменяет адресную строку
    //$_SERVER[PHP_SELF] - до имени файла
    header("Location:" .basename($_SERVER['REQUEST_URI']));

}

//lisamine kirjeldus INSERT INTO


//tabelist kustutamine
if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare('DELETE FROM loomad WHERE id=?');
    $kask->bind_param("i",$_REQUEST['kustuta']);
    $kask->execute();
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Kommentaar</title>
</head>
<body>
<h1>
    Andmetabeli "Kommentaar" sisu näitamine
</h1>
<div ">
<?php
global $yhendus;
//tabeli sisu näitamine
$kask=$yhendus->prepare("SELECT KommentaarID, Kommentaar, Hinne, Nimi, Perenimi FROM kommentaar");
$kask->bind_result($id, $komment, $hinne, $nimi, $perenimi);
$kask->execute();
echo "<table>";
echo "<tr>
<th>ID</th>
<th>Kommentaar</th>
<th>Hinne</th>
<th>Nimi</th>
<th>Perenimi</th>
</tr>";


//fetch() - извлечение данных из набора данных
while($kask->fetch()){
    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td>$komment</td>";
    echo "<td>$hinne</td>";
    echo "<td>$nimi</td>";
    echo "<td>$perenimi</td>";
    echo "<td><a href='".clearVarsExcept(basename($_SERVER['REQUEST_URI']), "leht")."&kustuta=$id'>Kustuta</a></td>";
    echo "</tr>";
}
echo "</table>";

?>
</div>
<!--new code-->
<br><br>
<div>
    <form action="<?=clearVarsExcept(basename($_SERVER['REQUEST_URI']), "leht")?>" method="post">
        <label for="kommentaarnimi">Loomanimi</label>
        <br>
        <input type="text" name="kommentaarnimi" id="kommentaarnimi">
        <br>
        <label for="kirj">Kirjeldus</label>
        <br>
        <input type="text" name="kirj" id="kirj">
        <br><br>
        <input type="submit" value="Lisa">
    </form>
</div>

<?php
$yhendus->close();
?>
</body>
</html>