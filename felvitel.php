<?php 

$mysqli = new mysqli('localhost', 'root', '');
$mysqli->query('SET NAMES UTF8');
$mysqli->select_db('tankonyvek_doga');
if ($_POST['szerzo'] != '' && $_POST['evfolyam'] != '') {
    $q='INSERT INTO konyvek (tantargyid, evfolyam, szerzo, ar)
    VALUES (?, ?, ?, ?)';
    $result = $mysqli->prepare($q);
    $result->bind_param
        ('iisd', $_POST['tantargyak'], $_POST['evfolyam'], $_POST['szerzo'], $_POST['ar']);
    $success=$result->execute();

}
header('Location:index.php');
?>
