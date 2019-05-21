<?php 

$mysqli = new mysqli('localhost', 'root', '');
$mysqli->query('SET NAMES UTF8');
$mysqli->select_db('tankonyvek_doga');
if ($_POST['szerzo'] != '' && $_POST['evfolyam'] != '') {
    $q='UPDATE konyvek
            SET tantargyid = ?,
                evfolyam = ?,
                szerzo = ?,
                ar = ?
            WHERE id = ?';
    $result = $mysqli->prepare($q);
    $result->bind_param
        ('iisdi', $_POST['tantargyak'], $_POST['evfolyam'], $_POST['szerzo'], $_POST['ar'], $_POST["id"]);
    $success=$result->execute();

}
header('Location:index.php');
?>