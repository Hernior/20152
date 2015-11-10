<?php
include_once("DBConnect.php");
include_once("session_user.php");
function alreadyReceived($id){
    global $conn;
    if ($stmt = $conn->prepare("SELECT `orde_status` FROM `orders` WHERE `orde_id`=? AND `orde_status` > 1")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows != 0){
            echo '
            <div class="alert alert-info alert-modal" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Pedido recebido anteriormente.
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

function receiveOrder($id){
    global $conn;
    if ($stmt = $conn->prepare("UPDATE `orders` SET `orde_status`=2 WHERE `orde_id`=?")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows != 1){
            echo '
            <div class="alert alert-warning alert-modal" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Falha ao tentar receber pedido.</div>';
            return false;
        }
        else{
            echo '
            <div class="alert alert-success alert-modal" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Pedido ('.$id.') recebido com sucesso!
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

$check = alreadyReceived($_GET['order']);
if($check === false){
    receiveOrder($_GET['order']);
}
 ?>
