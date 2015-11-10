<?php
include_once("../../controllers/DBConnect.php");
include_once("../../controllers/session_user.php");
function getFavorites($userID){
    global $conn;
    if ($stmtOrders = $conn->prepare("SELECT F.`favo_id`, F.`Users_user_id`, F.`favo_companyid`, C.`comp_name` FROM `favorites` F, `companies` C WHERE F.`Users_user_id`=? AND C.`comp_id` = F.`favo_companyid`")) {
        $stmtOrders->bind_param("i", $userID);
        $stmtOrders->execute();
        $stmtOrders->bind_result($FavID, $UserID, $CompID, $CompName);
        $stmtOrders->store_result();
        while ($stmtOrders->fetch()){
            echo "<tr>\n
            <td>".$CompName."</td>\n
            <td><a class=\"btn btn-success link_ajax\" href=\"newOrder.php?company=$CompID\">Pedir</a>\n
            <a class=\"btn btn-danger\" href=\"../../controllers/removeFavorite.php?company=$CompID&user=$UserID&favorite=$FavID\" data-toggle=\"modal\" data-target=\"#favorite\">Remover</a></td>\n
            </tr>";
        }
    }
    else{
        echo "Falha na conexão: ".$conn->error;
    }
}
?>
<div class="col-md-8 col-md-offset-2">
    <h1>Empresas Favoritas</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php getFavorites($_SESSION['id']); ?>
        </tbody>
    </table>
</div>
<div id="favorite" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Favorito" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
<script src="../../assets/js/alert_modal.js"></script>
