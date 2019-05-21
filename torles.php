<?php 

$mysqli = new mysqli('localhost', 'root', '');
$mysqli->query('SET NAMES UTF8');
$mysqli->select_db('tankonyvek_doga');
if (isset ($_GET['i'] )) {
    $q='DELETE
            FROM konyvek
        WHERE id = ?';
    $result = $mysqli->prepare($q);
    $result->bind_param
        ('i', $_GET["i"]);
    $success=$result->execute();

}
header('Location:index.php');
?>