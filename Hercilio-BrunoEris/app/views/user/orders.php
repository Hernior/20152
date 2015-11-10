<?php
include_once("../../controllers/DBConnect.php");
include_once("../../controllers/session_user.php");
?>
<div class="col-md-10 col-md-offset-1">
    <h1>Pedidos de <?php echo $_SESSION['name']; ?></h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Empresa</th>
                <th class="text-center">Pedido</th>
                <th class="text-center">Descrição</th>
                <th class="text-center">Qtd.</th>
                <th class="text-center">Preço</th>
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
function getOrders($userID){
    global $conn;
    if ($stmtOrders = $conn->prepare("SELECT o.`orde_id`, o.`Companies_comp_id`, o.`orde_price`, o.`orde_status`, o.`orde_stars`, o.`orde_address`, ohp.`Products_prod_id`, p.`prod_description`, p.`prod_price`, c.`comp_name` FROM orders o, orders_has_products ohp, products p, companies c WHERE o.`Users_user_id`=? AND ohp.`Orders_orde_id`=o.`orde_id` AND p.`prod_id`=ohp.`Products_prod_id` AND c.`comp_id`=o.`Companies_comp_id` ORDER BY o.`orde_id` DESC")) {
        $stmtOrders->bind_param("i", $userID);
        $stmtOrders->execute();
        $stmtOrders->bind_result($orderID, $orderCompanyID, $orderPrice, $orderStatus, $orderStars, $orderAddress, $productID, $productDescription, $productPrice, $compName);
        $stmtOrders->store_result();
        while ($stmtOrders->fetch()){
            $showReceiveOption = $orderStatus;
            $statusClass = getStatusClass($orderStatus);
            $orderStatus = getStatus($orderStatus);
            $orderStars = getStars($orderStars);
            echo "<tr class=\"$statusClass\">\n
            <td>$compName</td>\n
            <td class=\"text-center\">$orderID</td>\n
            <td>$productDescription</td>\n
            <td class=\"text-center\">".($orderPrice/$productPrice)."</td>\n
            <td class=\"text-right\">R$ ".number_format($orderPrice, 2, ',', ' ')."</td>\n
            <td class=\"text-center\">$orderStatus</td>\n
            <td class=\"text-center\">$orderStars</td>\n
            <td>$orderAddress</td>\n";
            echo getOption($showReceiveOption, $orderID);
            echo "</tr>";
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
            return "Avaliado";
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
        case 3:
            return "";
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
function getOption($status, $order){
    switch ($status) {
        case 0:
            return "<td class=\"text-center\"><a class=\"btn btn-danger btn-xs\" href=\"../../controllers/cancelOrder.php?order=$order\" role=\"button\" data-toggle=\"modal\" data-target=\"#order\">Cancelar</a></td>\n";
            break;
        case 1:
            return "<td class=\"text-center\"><a class=\"btn btn-success btn-xs\" href=\"../../controllers/receiveOrder.php?order=$order\" role=\"button\" data-toggle=\"modal\" data-target=\"#order\">Recebi</a></td>\n";
            break;
        case 2:
            return "<td class=\"text-center\"><a class=\"btn btn-info btn-xs link_ajax\" href=\"../../controllers/rateOrder.php?order=$order\" role=\"button\">Avaliar</a></td>\n";
            break;
        default:
            return "<td></td>";
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
