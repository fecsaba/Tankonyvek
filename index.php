<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tankönyvek</title>
</head>
<body>
    <h1>Tankönyv nyilvántartás</h1>
    <form action="index.php" method="get">
        <label for="keres">Keres: </label>
        <input type="text" name="keres" id="">
        <button type="submit">Keresés</button>
    </form>
    <div style="height:200px; overflow-y: scroll;">
    <table border="1">
        <tr>
            <th>Szerző</th>
            <th>Évfolyam</th>
            <th>Tantárgy neve</th>
        </tr>
        <?php
        $mysqli = new mysqli('localhost', 'root', '');
        $mysqli->query('SET NAMES UTF8');
        $mysqli->select_db('tankonyvek_doga');
        if (isset($_GET['keres'])) {
            $s = $_GET['keres'];
        } else $s= null;
        $q = 'SELECT
                    konyvek.id,
                    konyvek.szerzo,
                    konyvek.evfolyam,
                    tantargyak.megnevezes,
                    konyvek.tantargyid
                FROM konyvek
                    INNER JOIN tantargyak
                    ON konyvek.tantargyid = tantargyak.id
                WHERE (szerzo LIKE "%'.$s.'%" OR szerzo IS null) OR
                      (megnevezes LIKE "%'.$s.'%" OR megnevezes IS null);';
                    
        $result = $mysqli->query($q);
       
            while ($row = $result->fetch_object()) {
                echo '<tr>';
                echo '<td>'.$row->szerzo.'</td>';
                echo '<td>'.$row->evfolyam.'</td>';
                echo '<td>'.$row->megnevezes.'</td>';
                echo '<td><a href="index.php?i='.$row->id.'&t='.$row->tantargyid.'">Módosítás</a></td>';
                echo '<td><a href="torles.php?i='.$row->id.'">Törlés</a></td>';
                echo '</tr>';
            }
        
        $mysqli->close();
        ?>
    </table>
    </div>
    <div>
        <h2>Új felvitel</h2>
        <form action="felvitel.php" method="post">
            <select name="tantargyak" id="">
                <?php 
                $mysqli = new mysqli('localhost', 'root', '');
                $mysqli->query('SET NAMES UTF8');
                $mysqli->select_db('tankonyvek_doga');
                $q='SELECT
                            tantargyak.id,
                            tantargyak.megnevezes
                        FROM tantargyak;'; 
                $result=$mysqli->query($q);
                while ($row = $result->fetch_object()) {
                    echo '<option value="'.$row->id.'">'.$row->megnevezes.'</option>';
                }
                echo '</select>';
                echo '<label for="szerzo">Szerző:</label>';
                echo '<input type="text" name="szerzo" id="">';
                echo '<label for="evfolyam">Évfolyam:</label>';
                echo '<input type="number" name="evfolyam" id="">';
                echo '<label for="ar">Ár:</label>';
                echo '<input type="number" name="ar" id="">';

                echo '<button type="submit" >Ment</button>';

                $mysqli->close();
                ?>
            
        </form>

    </div>
    <div>   
        <h2>Módosítás</h2>
        <?php 
        if (isset($_GET['i'])) {
            echo '<form action="modosit.php" method="post">';
            echo '<select name="tantargyak" id="">';
            $mysqli = new mysqli('localhost', 'root', '');
            $mysqli->query('SET NAMES UTF8');
            $mysqli->select_db('tankonyvek_doga');
            $q='SELECT
                        tantargyak.id,
                        tantargyak.megnevezes
                    FROM tantargyak;'; 
            $result=$mysqli->query($q);
            while ($row = $result->fetch_object()) {
                echo '<option value="'.$row->id.'" '.($row->id == $_GET['t']? "selected" : "").
                    '>'.$row->megnevezes.'</option>';
            }
            

            
            echo '</select>';
            $mysqli->close();

            $mysqli = new mysqli('localhost', 'root', '');
            $mysqli->query('SET NAMES UTF8');
            $mysqli->select_db('tankonyvek_doga');
            $q='SELECT
                        konyvek.id,
                        konyvek.tantargyid,
                        konyvek.evfolyam,
                        konyvek.szerzo,
                        konyvek.ar,
                        tantargyak.megnevezes
                    FROM konyvek
                        INNER JOIN tantargyak
                        ON konyvek.tantargyid = tantargyak.id
                    WHERE konyvek.id = '.$_GET["i"].';'; 
            $result=$mysqli->query($q);
            $row = $result->fetch_object();
            echo '<label for="szerzo">Szerző:</label>';
            echo '<input type="text" name="szerzo" value="'.$row->szerzo.'">';
            echo '<label for="evfolyam">Évfolyam:</label>';
            echo '<input type="number" name="evfolyam" value="'.$row->evfolyam.'">';
            echo '<label for="ar">Ár:</label>';
            echo '<input type="number" name="ar" value="'.$row->ar.'">';
            echo '<input type="hidden" name="id" value="'.$row->id.'">';
            echo '<button type="submit" >Ment</button>';
            $mysqli->close();

            echo '</form>';
        }
        ?>
    </div>
</body>
</html>