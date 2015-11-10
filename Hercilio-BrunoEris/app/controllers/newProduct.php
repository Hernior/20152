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
        newProduct($_POST['comp_id'], $_POST['description'], $_POST['production'], $_POST['expiration'], $_POST['price'], $_POST['amount']);
    }
}

function newProduct($comp_id, $description, $production, $expiration, $price, $amount){
    global $conn;
    if ($stmt = $conn->prepare("INSERT INTO products (Companies_comp_id, prod_description, prod_production, prod_expiration, prod_price, prod_amount) VALUES (?, ?, ?, ?, ?, ?)")){
        $stmt->bind_param("issssi", $comp_id, $description, $production, $expiration, $price, $amount);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            if($stmt->sqlstate == 23000){$errorSTMT = "Violação de integridade identificada";}
            if($stmt->errno == 1062){$errorSTMT .= "<br>Talvez sua empresa já tenha cadastro.";}
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                '.$errorSTMT.' <abbr title="'.$stmt->error.'">Detahes</abbr>
            </div>';
            exit;
        }
        else{
            echo '
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Produto cadastrado com sucesso.
            </div>';
        }
    }
    else{
        echo "Falha na conexão: ".$conn->error;
    }
}
?>
