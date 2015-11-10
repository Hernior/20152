<?php
include_once("DBConnect.php");
include_once("session_user.php");
function getProduct($productId){
    global $conn;
    if ($stmt = $conn->prepare("SELECT prod_id, prod_description, prod_production, prod_expiration, prod_price, prod_amount FROM products WHERE prod_id=?")) {
        $stmt->bind_param("i", $productId);
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
$product = getProduct($_GET['product']);
echo '<div class="col-md-6 col-md-offset-3">';
echo '<a class="btn btn-default link_ajax" href="newOrder.php?company='.$_GET['company'].'">Cancelar</a>';
echo '<form id="formOrder" action="../../controllers/newOrderConfirm.php" method="post">
        <input type="hidden" name="user_id" value="'.$_SESSION['id'].'">
        <input type="hidden" name="comp_id" value="'.$_GET['company'].'">
        <input type="hidden" name="prod_id" value="'.$product['id'].'">
        <input type="hidden" name="current_amount" value="'.$product['amount'].'">
        <div class="form-group">
            <label for="InputDesc">Descrição do Produto</label>
            <input type="text" class="form-control" id="InputDesc" maxlength="255" name="description" value="'.$product['description'].'" readonly>
        </div>
      <div class="row">
        <div class="form-group col-md-6">
            <label for="InputPrice">Preço</label>
            <input type="number" step="0.01" min="0.1" max="1000" class="form-control" id="InputPrice" name="price" value="'.$product['price'].'" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="InputAmount">Quantidade desejada</label>
            <input type="number" min="1" max="'.$product['amount'].'" class="form-control" id="InputAmount" name="amount">
        </div>
      </div>
      <div class="form-group">
          <label for="InputAddress">Endereço de entrega</label>
          <input type="text" class="form-control" id="InputAddress" name="address">
      </div>
      <input type="submit" id="confirmOrder" class="btn btn-primary" name="submit" value="Pedir">
</form>';
echo '</div>';
 ?>
 <script src="../../assets/js/jquery.form.min.js"></script>
 <script src="../../assets/js/form.js"></script>
