<?php
include_once("DBConnect.php");
include_once("session_user.php");
function alreadyFavorite($user, $company){
    global $conn;
    if ($stmt = $conn->prepare("SELECT favo_id, Users_user_id, favo_companyid FROM favorites WHERE Users_user_id=? AND favo_companyid=?")) {
        $stmt->bind_param("ii", $user, $company);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows != 0){
            echo '
            <div class="alert alert-info alert-modal" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Empresa já está na sua lista de favoritos.
            </div>';
            return true;
        }
        else{
            return false;
        }
    }
    else{
        echo '
        <div class="alert alert-danger alert-modal" role="alert">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
            Falha na conexão: '.$conn->error.'
        </div>';
        exit;
    }
}

function addFavorite($user, $company){
    global $conn;
    if ($stmt = $conn->prepare("INSERT INTO `favorites`(`Users_user_id`, `favo_companyid`) VALUES (?,?)")) {
        $stmt->bind_param("ii", $user, $company);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows != 1){
            echo '
            <div class="alert alert-warning alert-modal" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Falha ao tentar adicionar empresa aos favoritos.</div>';
            return false;
        }
        else{
            echo '
            <div class="alert alert-success alert-modal" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Empresa adicionada aos favoritos.
            </div>';
            return true;
        }
    }
    else{
        echo '
        <div class="alert alert-danger alert-modal" role="alert">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
            Falha na conexão: '.$conn->error.'
        </div>';
    }
}

$check = alreadyFavorite($_GET['user'], $_GET['company']);
if($check === false){
    addFavorite($_GET['user'], $_GET['company']);
}
 ?>
