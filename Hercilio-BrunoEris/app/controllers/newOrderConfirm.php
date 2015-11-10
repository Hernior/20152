<?php
include_once("DBConnect.php");
include_once("session_user.php");
$user = $_POST['user_id'];
$company = $_POST['comp_id'];
$product = $_POST['prod_id'];
$new_amount = ($_POST['current_amount']-$_POST['amount']);
// echo "Atual: ".$_POST['current_amount']." | Comprado: ".$_POST['amount']." | Nova quantidade: $new_amount";
// exit;
$total = ($_POST['price']*$_POST['amount']);
$address = $_POST['address'];
if(!is_numeric($total) || $total <= 0){
    echo "Quantidade incorreta!";
    exit;
}
elseif (strlen($address) < 5) {
    echo "Endereço deve ter no mínimo 5 caracteres";
    exit;
}

if(registerOrder($user, $company, $total, $address) && registerOrderHasProducts($company, $user, $orderID, $product)){
    if ($stmtProduct = $conn->prepare("UPDATE products SET prod_amount=? WHERE prod_id=?")) {
        $stmtProduct->bind_param("ii", $new_amount, $product);
        $stmtProduct->execute();
        $result = $stmtProduct->affected_rows;
        echo ($result == 1) ? '
        <div id="orderSuccess" class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Pedido efetuado com sucesso!
        </div>' : '
        <div class=\"alert alert-warning alert-dismissible\" role=\"alert\">
            <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
            Você não alterou nenhum dado.</div>';
    }
    else{
        echo "Falha ao baixar estoque: ".$conn->error;
    }
}
else{
    echo '
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Erro fatal.
    </div>';
}


//Functions
function registerOrder($userID, $companyID, $price, $address){
    global $conn;
    $stmtOrder = $conn->prepare("INSERT INTO orders (Users_user_id, Companies_comp_id, orde_price, orde_address) VALUES (?, ?, ?, ?)");
    $stmtOrder->bind_param("iiss", $userID, $companyID, $price, $address);
    $stmtOrder->execute();
    if($stmtOrder->affected_rows != 1){
        echo '
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            '.$stmtOrder->error.'
        </div>';
        exit;
    }
    else{
        global $orderID;
        $orderID = $conn->insert_id;
        return true;
    }
}
function registerOrderHasProducts($companyID, $userID, $orderID, $productID){
    global $conn;
    $stmtOHP = $conn->prepare("INSERT INTO orders_has_products (Orders_Companies_comp_id, Orders_Users_user_id, Orders_orde_id, Products_prod_id) VALUES (?, ?, ?, ?)");
    $stmtOHP->bind_param("iiii", $companyID, $userID, $orderID, $productID);
    $stmtOHP->execute();
    if($stmtOHP->affected_rows != 1){
        echo '
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            '.$stmtOHP->error.'
        </div>';
        exit;
    }
    else{
        return true;
    }
}
