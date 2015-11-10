<?php
include_once("../../controllers/DBConnect.php");
include_once("../../controllers/session_company.php");
?>
<div class="col-md-8 col-md-offset-2">
    <h1>Pedidos Recebidos</h1>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">Nº do Pedido</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Descrição</th>
                <th class="text-center">Qtd.</th>
                <th class="text-center">Preço Total</th>
                <th class="text-center">Status</th>
                <th class="text-center">Avaliação</th>
                <th class="text-center">Endereço de entrega</th>
                <th class="text-center">Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php getOrders($_SESSION['id']); ?>
        </tbody>
    </table>
</div>
<?php
function getOrders($companyID){
    global $conn;
    if ($stmtOrders = $conn->prepare("SELECT o.`orde_id`, o.`Users_user_id`, o.`orde_price`, o.`orde_status`, o.`orde_stars`, o.`orde_address`, ohp.`Products_prod_id`, p.`prod_description`, p.`prod_price`, u.`user_name` FROM orders o, orders_has_products ohp, products p, users u WHERE o.`Companies_comp_id`=? AND ohp.`Orders_orde_id`=o.`orde_id` AND p.`prod_id`=ohp.`Products_prod_id` AND u.`user_id`=o.`Users_user_id` ORDER BY o.`orde_id` DESC")) {
        $stmtOrders->bind_param("i", $companyID);
        $stmtOrders->execute();
        $stmtOrders->bind_result($orderID, $orderUserID, $orderPrice, $orderStatus, $orderStars, $orderAddress, $productID, $productDescription, $productPrice, $userName);
        $stmtOrders->store_result();
        while ($stmtOrders->fetch()){
            $statusClass = getStatusClass($orderStatus);
            $orderStatus = getStatus($orderStatus);
            $orderStars = getStars($orderStars);
            echo "<tr class=\"$statusClass\">\n
            <td>$orderID</td>\n
            <td class=\"text-center\">$userName</td>\n
            <td>$productDescription</td>\n
            <td class=\"text-center\">".($orderPrice/$productPrice)."</td>\n
            <td class=\"text-right\">R$ ".number_format($orderPrice, 2, ',', ' ')."</td>\n
            <td class=\"text-center\">$orderStatus</td>\n
            <td class=\"text-center\">$orderStars</td>\n
            <td>$orderAddress</td>\n
            <td class=\"text-center\"><a class=\"btn btn-primary btn-xs\" href=\"../../controllers/sendOrder.php?order=$orderID\" role=\"button\" data-toggle=\"modal\" data-target=\"#order\">Enviar</a></td>\n
            </tr>";
        }
    }
    else{
        echo "Falha na conexão: ".$conn->error;
    }
}
function getStatus($id){
    switch ($id) {
        case 0:
            return "Aberto";
            break;
        case 1:
            return "Enviado";
            break;
        case 2:
            return "Recebido";
            break;
        default:
            return "ERRO";
            break;
    }
}
function getStatusClass($id){
    switch ($id) {
        case 0:
            return "warning";
            break;
        case 1:
            return "info";
            break;
        case 2:
            return "success";
            break;
        default:
            return "ERRO";
            break;
    }
}
function getStars($id){
    switch ($id) {
        case 0:
            return "Pendente";
            break;
        case 1:
            return "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>";
            break;
        case 2:
            return "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>";
            break;
        case 3:
            return "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>";
            break;
        case 4:
            return "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star-empty\" aria-hidden=\"true\"></span>";
            break;
        case 5:
            return "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>
            <span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span>";
            break;
        default:
            return "ERRO!";
            break;
    }
}
?>
<div id="order" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Favorito" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
<script src="../../assets/js/alert_modal.js"></script>
