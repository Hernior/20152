<?php
include_once("../../controllers/DBConnect.php");
include_once("../../controllers/session_company.php");

function getProducts($companyId){
    global $conn;
    if ($stmt = $conn->prepare("SELECT prod_id, prod_description, prod_production, prod_expiration, prod_price, prod_amount FROM products WHERE Companies_comp_id=?")) {
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $stmt->bind_result($id, $description, $production, $expiration, $price, $amount);
        while ($stmt->fetch()) {
            $date = new DateTime($production);
            $date->add(new DateInterval('P'.$expiration.'D'));
            echo "<tr>\n<td>$description</td>\n<td>".date("d/m/Y",strtotime($production))."</td>\n<td>".$date->format('d/m/Y')."</td>\n<td>R$ $price</td>\n<td>$amount</td>\n<td><a class=\"link_ajax\" href=\"product_edit.php?id=$id\">Editar</a></td>\n</tr>";
        }
        $stmt->close();
        $conn->close();
    }
    else{
        echo "Falha na conexão: ".$conn->error;
    }
}
?>
<div class="col-md-8 col-md-offset-2">
    <a class="btn btn-primary" role="button" data-toggle="modal" data-target="#newProduct">Novo Produto</a>
    <h1>Seus produtos</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Data de Produção</th>
                <th>Data de Vencimento</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php getProducts($_SESSION['id']); ?>
        </tbody>
    </table>
</div>
<div id="newProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalUpdate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="modalUpdate">Cadastrar Produto</h4>
            </div>
            <form id="formAjax" action="../../controllers/newProduct.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="comp_id" value="<?php echo $_SESSION['id'] ?>">
                    <div class="form-group" id="">
                        <label for="InputDesc">Descrição do Produto</label>
                        <input type="text" class="form-control" id="InputDesc" maxlength="255" name="description">
                    </div>
                    <div class="form-group" id="">
                        <label for="InputDP">Data de fabricação</label>
                        <input type="date" class="form-control" id="InputDP" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>" name="production">
                    </div>
                    <div class="form-group" id="">
                        <label for="InputDE">Validade (dias)</label>
                        <input type="number" min="1" class="form-control" id="InputDE" name="expiration">
                    </div>
                    <div class="form-group" id="">
                        <label for="InputPrice">Preço (R$ xx,xx)</label>
                        <input type="number" step="0.01" min="0.1" max="1000" class="form-control" id="InputPrice" name="price">
                    </div>
                    <div class="form-group" id="">
                        <label for="InputAmount">Estoque</label>
                        <input type="number" min="1" class="form-control" id="InputAmount" name="amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="submitNewProduct" class="btn btn-primary" name="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../../assets/js/jquery.form.min.js"></script>
<script src="../../assets/js/form.js"></script>
<script src="../../assets/js/form_modal.js"></script>
