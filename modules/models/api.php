<?php
    $db_connection = require './resources/conn.php';

    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    date_default_timezone_set('Asia/Jakarta');

    if($db_connection){
        $headers = apache_request_headers();
        if(isset($headers['Authorization'])){
            if($headers['Authorization']=='Acc50!'){
                $json = file_get_contents('php://input');
                $dt = json_decode($json,true);

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $tag = $dt["tag"];
                    $data = $dt["data"];

                    if($tag=='posproject_cu'){
                        $sql = "INSERT INTO pp_login(uname,password,role,shift,nama,created_at,updated_at) values (?,?,?,?,?,?,?) ";
                        $prp = $db_connection->prepare($sql);
                        $prp->execute(array($data["u"],$data["p"],$data["r"],$data["s"],$data["n"],date("Y-m-d H:i:s"),date("Y-m-d H:i:s")));
                        $result = $prp->fetchAll();
                        if($result){
                            echo 'a';
                        }else{
                            echo 'b';
                        }
                    }else if($tag=='posproject_uu'){
                        $sql = "UPDATE pp_login SET nama=?,role=?,shift=?,password=?,updated_at=? where id=?";
                        $prp = $db_connection->prepare($sql);
                        $prp->execute(array($data["n"],$data["r"],$data["s"],$data["p"],date("Y-m-d H:i:s"),$data["i"]));
                        $result = $prp->fetchAll();
                        return $result;                        
                    }else if($tag=="posproject_du"){
                        $sql = "DELETE FROM pp_login where id=?";
                        $prp = $db_connection->prepare($sql);
                        $prp->execute(array($data["i"]));
                        $result = $prp->fetchAll();
                        return $result;
                    }else if($tag=="posproject_su"){
                        $sql = "SELECT * FROM pp_login where uname=? and password=?";
                        $prp = $db_connection->prepare($sql);
                        $prp->execute(array($data["u"],$data["p"]));
                        $result = $prp->fetchAll();
                        echo base64_encode(json_encode($result));
                    }
                }else{
                    echo '404, Request Prohibited';
                }    
            }else{
                echo('404, Error T-Auth False');
            }
        }else{
            echo('404, Error Token Missing');    
        }
    }else{
        echo '404, Connection Error';
    }
?>