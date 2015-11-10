<?php
include_once("DBConnect.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['amount'] < 1){
        $erro = "Não é possível cadastrar produto sem quantidade em estoque.";
    }elseif($_POST['price'] < 0.1){
        $erro = "Não é possível cadastrar produto com preço inferior a R$ 0,10.";
    }elseif($_POST['price'] > 1000){
        $erro = "Não é possível cadastrar produto com preço superior a R$ 1000,00.";
    }elseif(!is_numeric($_POST['price'])){
        $erro = "Preço inválido.";
    }elseif(($_POST['expiration'] < 1) || !is_numeric($_POST['expiration'])){
        $erro = "Dias de validade inválidos.";
    }elseif(strlen($_POST['description']) < 3){
        $erro = "Descrição precisa ter pelo menos três caracteres.";
    }
    if(isset($erro)){
        echo '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            '.$erro.'
        </div>';
        exit;
    }
    else{
        editProduct($_POST['prod_id'], $_POST['description'], $_POST['production'], $_POST['expiration'], $_POST['price'], $_POST['amount']);
    }
}

function editProduct($prod_id, $description, $production, $expiration, $price, $amount){
    global $conn;
    if ($stmt = $conn->prepare("UPDATE products SET prod_description=?, prod_production=?, prod_expiration=?, prod_price=?, prod_amount=? WHERE prod_id=?")) {
        $stmt->bind_param("ssssii", $description, $production, $expiration, $price, $amount, $prod_id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        if($stmt->affected_rows != 1){
            echo '
            <div id="atualizarFoto" class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Produto não alterado.
            </div>';
        }
        else{
            echo '
            <div id="atualizarFoto" class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Produto atualizado com sucesso!
            </div>';
        }
    }
    else{
        echo "Falha na conexão: ".$conn->error;
    }
}
?>
