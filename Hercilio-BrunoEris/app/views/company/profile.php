<?php
include_once("../../controllers/DBConnect.php");
include_once("../../controllers/session_company.php");
$pattern_cnpj = '/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/';
$pattern_telephone = '/(\d{2})(\d{4,5})(\d{4})/';
$cnpj = preg_replace($pattern_cnpj, '$1.$2.$3/$4-$5', $_SESSION['cnpj']);
$telephone = preg_replace($pattern_telephone, '($1) $2.$3', $_SESSION['telephone']);
?>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div id="outputPhoto"></div>
        <div class="text-center">
            <img src="../../assets/img/company/<?php echo $_SESSION['photo'] ?>" class="profile-avatar img-circle img-thumbnail" alt="avatar">
            <form id="formPhoto" method="post" enctype="multipart/form-data" action="../../controllers/update_company_logo.php">
                <div class="form-group text-center">
                    <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                    <input class="btn btn-default" id="avatarInput" type="file" accept="image/*" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary">Salvar foto</button>
            </form>
        </div>
    </div>
    <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
        <h3>Informações Pessoais</h3>
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <div class="col-lg-8">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span></div>
                        <input class="form-control" value="<?php echo $_SESSION['name'];?>" type="text" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-8">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                        <input class="form-control" value="<?php echo $_SESSION['email'];?>" type="text" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-8">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
                        <input class="form-control" value="<?php echo $telephone;?>" type="text" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-8">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-info-sign"></span></div>
                        <input class="form-control" value="<?php echo $cnpj;?>" type="text" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group <?php if($_SESSION['phrase'] ==""){echo " has-warning";}?>">
                <div class="col-lg-8">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-comment"></span></div>
                        <input class="form-control" value="<?php echo ($_SESSION['phrase'] != "")?$_SESSION['phrase']:"Você ainda não definiu uma frase."; ?>" type="text" readonly>
                    </div>
                </div>
            </div>
        </form>
        <a class="btn btn-primary" role="button" data-toggle="modal" data-target="#atualizarDados">Editar</a>
    </div>
</div>
<div id="atualizarDados" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalUpdate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="modalUpdate">Dados cadastrais</h4>
            </div>
            <form id="formAjax" action="../../controllers/update.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="comp_id" value="<?php echo $_SESSION['id'] ?>">
                    <div class="form-group" id="">
                        <label for="InputName">Nome da Empresa</label>
                        <input type="text" class="form-control" id="InputName" maxlength="255" name="name" value="<?php echo $_SESSION['name'] ?>">
                    </div>
                    <div class="form-group" id="">
                        <label for="InputTelephone">Telefone</label>
                        <input type="text" class="form-control" id="InputTelephone" maxlength="11" name="telephone" value="<?php echo $_SESSION['telephone'] ?>">
                    </div>
                    <div class="form-group" id="">
                        <label for="InputPhrase">Frase</label>
                        <input type="text" class="form-control" id="InputPhrase" maxlength="45" name="phrase" value="<?php echo $_SESSION['phrase'] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="submitModal" class="btn btn-primary" name="submit" value="Salvar alterações">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../../assets/js/alert.js"></script>
<script src="../../assets/js/jquery.form.min.js"></script>
<script src="../../assets/js/form.js"></script>
<script src="../../assets/js/form_modal.js"></script>
