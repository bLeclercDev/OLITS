 <?php

function ConnexionBdd2(){
    $user='TARAPRINT';
    $pass='0000';
    $addr='pgsql:host=192.168.10.27';
    $port=5432;
    $dbname='TARAPRINTBDD';
    $pdo = new PDO($addr.';port='.$port.';dbname='.$dbname, $user, $pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $pdo;
}

function Requete2($conn, $req) {
        return $conn->query($req)->fetch();
  }



?>