<?php
	require_once 'config.php';


function connect(string $host,string $port, string $dbname, string $user, string $password){
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $pdo;
    } catch (PDOException $e) { 
        die($e->getMessage());
    } finally {
        if ($pdo) {
            $pdo = null;
        }
    }
}

return connect($hst,$prt,$dname,$usr,$pswd);
?>