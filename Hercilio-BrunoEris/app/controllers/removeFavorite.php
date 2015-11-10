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
            return true;
        }
        else{
            echo '
            <div class="alert alert-info alert-modal" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Empresa não está na sua lista de favoritos.
            </div>';
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

function removeFavorite($favorite){
    global $conn;
    if ($stmt = $conn->prepare("DELETE FROM `favorites` WHERE `favo_id`=?")) {
        $stmt->bind_param("i", $favorite);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows != 1){
            echo '
            <div class="alert alert-warning alert-modal" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Falha ao tentar remover empresa dos favoritos.</div>';
            return false;
        }
        else{
            echo '
            <div class="alert alert-success alert-modal" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Empresa removida com sucesso.
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
if($check === true){
    removeFavorite($_GET['favorite']);
}
 ?>
