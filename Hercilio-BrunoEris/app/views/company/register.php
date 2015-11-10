<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pão na Mão</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="../../assets/css/signup.css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="../../assets/css/style.css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="../../assets/plugins/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 container-signup-user">
                <h2 class="text-center"><img class="media-bar" src="../../assets/img/bread-512.png" alt="" /></h2>
                <h1 class="text-center">Cadastro Empresa</h1><br>
                <form id="formAjax" method="post" enctype="multipart/form-data" action="../../controllers/register.php">
                    <div class="form-group">
                        <label for="compName">Nome da Empresa</label>
                        <input type="text" class="form-control" id="compName" maxlength="255" name="compname" placeholder="Nome da empresa" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="compCNPJ">CNPJ</label>
                        <input type="text" class="form-control" id="compCNPJ" maxlength="14" name="cnpj" placeholder="CNPJ" required>
                    </div>
                    <div class="form-group">
                        <input id="latInput" type="hidden" name="lat" value="">
                        <input id="lngInput" type="hidden" name="lng" value="">
                    </div>
                    <div class="form-group">
                        <label for="compEmail">Email</label>
                        <input type="email" class="form-control" id="compEmail" maxlength="255" name="email" placeholder="E-mail" required>
                    </div>
                    <div class="form-group">
                        <label for="compTelephone">Telefone</label>
                        <input type="text" class="form-control" id="compTelephone" maxlength="11" name="telephone" placeholder="Telefone" required>
                    </div>
                    <div class="form-group">
                        <label for="compPassword">Senha</label>
                        <input type="password" class="form-control" id="compPassword" maxlength="45" name="password" placeholder="Senha" required>
                    </div>
                    <div class="form-group">
                        <label for="compPasswordConfirmation">Insira novamente sua senha</label>
                        <input type="password" class="form-control" id="compPasswordConfirmation" maxlength="45" name="password_confirm" placeholder="Confirme a Senha" required>
                    </div>
                    <div class="form-group">
                        <label for="map">Localização</label>
                        <div id="map" style="max-width:500px;height:300px;margin:auto;"></div>
                    </div>
                    <div class="form-group">
                        <label for="endInput">Endereço</label>
                        <input id="endInput" type="text" class="form-control" maxlength="255" name="address" placeholder="Arraste o marcador no mapa" title="Arraste o marcador no mapa para o endereço da empresa" value="" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                        <label for="compFile">Escolha a logotipo da empresa</label>
                        <input class="btn btn-primary btn-file" id="compFile" type="file" accept="image/*" name="image" title="É obrigatório selecionar uma imagem." required>
                    </div><br>
                    <button type="submit" class="btn btn-default">Cadastrar</button>
                </form>
                <a type="submit" href="login.php" class="btn btn-link">Voltar</a>
                <br>
            </div>
        </div>
    </div>
    <div id="output"></div>

    <script src="../../assets/js/jquery-1.11.3.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script src="../../assets/js/jquery.form.min.js"></script>
    <script src="../../assets/js/form.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBPlkMMoM8tjnpx5CE_uq0LkWII8Poc0w&callback=initMap"async defer></script>
    <script src="../../assets/js/map_signup.js"></script>
    <script src="../../assets/js/alert.js"></script>
</body>
</html>
