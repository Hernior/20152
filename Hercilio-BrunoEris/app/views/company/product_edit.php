<?php
include_once("../../controllers/DBConnect.php");
include_once("../../controllers/session_company.php");

function getProduct($companyId, $productId){
    global $conn;
    if ($stmt = $conn->prepare("SELECT prod_id, prod_description, prod_production, prod_expiration, prod_price, prod_amount FROM products WHERE Companies_comp_id=? AND prod_id=?")) {
        $stmt->bind_param("ii", $companyId, $productId);
        $stmt->execute();
        $stmt->bind_result($id, $description, $production, $expiration, $price, $amount);
        while ($stmt->fetch()) {
            $date = new DateTime($production);
            $date->add(new DateInterval('P'.$expiration.'D'));
            $product['id'] = $id;
            $product['description'] = $description;
            $product['production'] = $production;
            $product['expiration'] = $expiration;
            $product['price'] = $price;
            $product['amount'] = $amount;
            return $product;
            // echo "<tr>\n<td>$description</td>\n<td>".date("d/m/Y",strtotime($production))."</td>\n<td>".$date->format('d/m/Y')."</td>\n<td>R$ $price</td>\n<td>$amount</td>\n<td><a class=\"link_ajax\" href=\"edit?id=$id\">Editar</a></td>\n</tr>";
        }
        $stmt->close();
        $conn->close();
    }
    else{
        echo "Falha na conexão: ".$conn->error;
    }
}
$product = getProduct($_SESSION['id'],$_GET['id']);
?>
<div class="col-md-4 col-md-offset-4">
    <a class="btn btn-primary link_ajax" href="products.php">Voltar</a>
    <h1>Editar produto</h1>
    <form id="formAjax" action="../../controllers/editProduct.php" method="post">
        <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>">
        <div class="form-group" id="">
            <label for="InputDesc">Descrição do Produto</label>
            <input type="text" class="form-control" id="InputDesc" maxlength="255" name="description" value="<?php echo $product['description']; ?>">
        </div>
        <div class="form-group" id="">
            <label for="InputDP">Data de fabricação</label>
            <input type="date" class="form-control" id="InputDP" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>" name="production" value="<?php echo $product['production']; ?>">
        </div>
        <div class="form-group" id="">
            <label for="InputDE">Validade (dias)</label>
            <input type="number" min="1" class="form-control" id="InputDE" name="expiration" value="<?php echo $product['expiration']; ?>">
        </div>
        <div class="form-group" id="">
            <label for="InputPrice">Preço (R$ xx,xx)</label>
            <input type="number" step="0.01" min="0.1" max="1000" class="form-control" id="InputPrice" name="price" value="<?php echo $product['price']; ?>">
        </div>
        <div class="form-group" id="">
            <label for="InputAmount">Estoque</label>
            <input type="number" min="1" class="form-control" id="InputAmount" name="amount" value="<?php echo $product['amount']; ?>">
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Salvar alterações">
    </form>
</div>
<script src="../../assets/js/jquery.form.min.js"></script>
<script src="../../assets/js/form.js"></script>
