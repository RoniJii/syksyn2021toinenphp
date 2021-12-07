<?php
function openDb(): object {
 $ini = parse_ini_file("config.ini", true);

 $host = $ini['host'];
 $database = $ini['database'];
 $user = $ini['user'];
 $password = $ini['password'];
 $db = new PDO("mysql:host=$host;port=3306;dbname=$database;charset=utf8",$user, $password);
 $db ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 return $db;
}

 /* void ei oo vihreenä niin ku ohjeessa, joku pielessä..?  */
function selectAsJson(object $db,string $sql): void {
    $query = $db->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    header('HTTP/1.1 200 OK');
    echo json_encode($results);
}

function executeInsert(object $db,string $sql): int {
    $query = $db->query($sql);
    return $db->lastInsertId();
}

function returnError(PDOException $pdoex): void {
 header('HTTP/1.1 500 Internal Server Error');
 $error = array('error' => $pdoex -> getmessage());
 print json_encode($error);
 exit;
}
function checkUser(PDO $dbcon, $username, $passwd){

    //Sanitoidaan. Lisätty tuntien jälkeen
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $passwd = filter_var($passwd, FILTER_SANITIZE_STRING);

    try{
        $sql = "SELECT password FROM user WHERE username=?";  //komento, arvot parametreina
        $prepare = $dbcon->prepare($sql);   //valmistellaan
        $prepare->execute(array($username));  //kysely tietokantaan

        $rows = $prepare->fetchAll(); //haetaan tulokset (voitaisiin hakea myös eka rivi fetch ja tarkistus)

        //Käydään rivit läpi (max yksi rivi tässä tapauksessa) 
        foreach($rows as $row){
            $pw = $row["password"];  //password sarakkeen tieto (hash salasana tietokannassa)
            if( password_verify($passwd, $pw) ){  //tarkistetaan salasana tietokannan hashia vasten
                return true;
            }
        }

        //Jos ei löytynyt vastaavuutta tietokannasta, palautetaan false
        return false;

    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}


function createUser(PDO $dbcon, $fname, $lname, $username, $passwd){

    //Sanitoidaan. Lisätty tuntien jälkeen.
    $fname = filter_var($fname, FILTER_SANITIZE_STRING);
    $lname = filter_var($lname, FILTER_SANITIZE_STRING);
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $passwd = filter_var($passwd, FILTER_SANITIZE_STRING);

    try{
        $hash_pw = password_hash($passwd, PASSWORD_DEFAULT); 
        $sql = "INSERT IGNORE INTO user VALUES (?,?,?,?)"; 
        $prepare = $dbcon->prepare($sql); //valmistellaan
        $prepare->execute(array($fname, $lname, $username, $hash_pw));  
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}


function createDbConnection(){

    try{
        $dbcon = new PDO('mysql:host=localhost;dbname=webshop', 'root', '');
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }

    return $dbcon;
}

function createTable(PDO $con){
    $sql = "CREATE TABLE IF NOT EXISTS user(
        first_name varchar(50) NOT NULL,
        last_name varchar(50) NOT NULL,
        username varchar(50) NOT NULL,
        password varchar(150) NOT NULL,
        PRIMARY KEY (username)
        )";

    try{   
        $con->exec($sql);  
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }

    //Luodaan pari käyttäjää tietokantaan
    createUser($con,'Etunimi','Sukunimi', 'admin', 'admin');
    createUser($con,'Käyttäjä','Käyttäjä', 'user', 'user');
}

?>
