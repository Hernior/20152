<?php
include_once("../../controllers/DBConnect.php");
include_once("../../controllers/session_user.php");
function getCompany($companyId){
    global $conn;
    if ($stmt = $conn->prepare("SELECT comp_id, comp_name, comp_location, comp_email, comp_telephone, comp_cnpj, comp_logo, comp_phrase FROM companies WHERE comp_id=?")) {
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $stmt->bind_result($id, $name, $location, $email, $telephone, $cnpj, $logo, $phrase);
        $stmt->store_result();
        $stmt->fetch();
        $result = $stmt->num_rows;

        if($result == 1){
            $company['id'] = $id;
            $company['name'] = $name;
            $company['location'] = $location;
            $company['telephone'] = $telephone;
            $company['cnpj'] = $cnpj;
            $company['logo'] = $logo;
            $company['phrase'] = $phrase;
            return $company;
        }
        else{
            echo "Falha ao obter dados da empresa.";
            return false;
        }
    }
    else{
        echo "Falha na conexão: ".$conn->error;
    }
}
function getProducts($companyId){
    global $conn;
    if ($stmt = $conn->prepare("SELECT prod_id, prod_description, prod_production, prod_expiration, prod_price, prod_amount FROM products WHERE Companies_comp_id=?")) {
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $stmt->bind_result($id, $description, $production, $expiration, $price, $amount);
        while ($stmt->fetch()) {
            if($amount>0){
                $today = new DateTime(date("Y-m-d"));
                $expir = new DateTime($production);
                $expir->add(new DateInterval('P'.$expiration.'D'));
                $interval = $today->diff($expir);
                // echo "<br><br><br>Hoje: ".$today->format('d/m/Y');
                // echo "<br>Venc: ".$expir->format('d/m/Y');
                $diff = $interval->format('%r%a');
                if($diff >= 0){
                    echo "<tr>\n
                    <td><a class=\"btn btn-primary btn-xs link_ajax\" href=\"../../controllers/newOrder.php?user=".$_SESSION['id']."&product=$id&company=".$_GET['company']."\" role=\"button\">Pedir</a></td>\n
                    <td>$description</td>\n
                    <td>".date("d/m/Y",strtotime($production))."</td>\n
                    <td>".$expir->format('d/m/Y')."</td>\n
                    <td>R$ $price</td>\n
                    <td>$amount</td>\n
                    </tr>";
                }
                else{
                    // echo "<br>Diferença negativa do produto $id.";
                    // echo "<br>".$diff;
                }
            }
        }
        $stmt->close();
        $conn->close();
    }
    else{
        echo "Falha na conexão: ".$conn->error;
    }
}
$company = getCompany($_GET['company']);
?>
<div class="col-md-8 col-md-offset-2">
    <div class="col-md-2">
        <div class="text-center">
            <img src="../../assets/img/company/<?php echo $company['logo']; ?>" class="img-circle img-thumbnail" alt="avatar">
        </div>
    </div>
    <div class="col-md-10">
        <a class="btn btn-default" href="../../controllers/newFavorite.php?company=<?php echo $_GET['company']?>&user=<?php echo $_SESSION['id']?>" data-toggle="modal" data-target="#favorite"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> Adicionar aos favoritos</a>
        <h1>Produtos de <?php echo $company['name']; ?></h1>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Opção</th>
                <th>Descrição</th>
                <th>Data de Produção</th>
                <th>Data de Vencimento</th>
                <th>Preço</th>
                <th>Estoque</th>
            </tr>
        </thead>
        <tbody>
            <?php getProducts($_GET['company']); ?>
        </tbody>
    </table>
</div>
<div id="favorite" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Favorito" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="Favorito">Favoritos</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<script src="../../assets/js/jquery.form.min.js"></script>
<script src="../../assets/js/form.js"></script>
