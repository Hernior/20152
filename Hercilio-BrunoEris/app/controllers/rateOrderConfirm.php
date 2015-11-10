<?php
include_once("DBConnect.php");
include_once("session_user.php");
function alreadyRated($id){
    global $conn;
    if ($stmt = $conn->prepare("SELECT `orde_status` FROM `orders` WHERE `orde_id`=? AND `orde_stars` IS NOT NULL")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows != 0){
            echo '
            <div class="alert alert-info" id="orderSuccess" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Pedido avaliado anteriormente.
            </div>';
            return true;
        }
        else{
            return false;
        }
    }
    else{
        echo '
        <div class="alert alert-danger" id="orderSuccess" role="alert">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
            Falha na conexão: '.$conn->error.'
        </div>';
        exit;
    }
}

function rateOrder($order, $rate){
    global $conn;
    if ($stmt = $conn->prepare("UPDATE `orders` SET `orde_stars`=?, `orde_status`=3 WHERE `orde_id`=?")) {
        $stmt->bind_param("ii", $rate, $order);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows != 1){
            echo '
            <div class="alert alert-warning" id="orderSuccess" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Falha ao tentar avaliar pedido.</div>';
            return false;
        }
        else{
            echo '
            <div class="alert alert-success" id="orderSuccess" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                Pedido ('.$order.') avaliado com sucesso!
            </div>';
            return true;
        }
    }
    else{
        echo '
        <div class="alert alert-danger"  id="orderSuccess"role="alert">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
            Falha na conexão: '.$conn->error.'
        </div>';
    }
}
if(isset($_POST['order'])){
  $check = alreadyRated($_POST['order']);
}
else{
  echo "ERRO FATAL";
  exit;
}
if($check === false && isset($_POST['order']) && isset($_POST['rate'])){
    rateOrder($_POST['order'], $_POST['rate']);
}
 ?>
