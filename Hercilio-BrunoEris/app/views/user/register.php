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
                <h1 class="text-center">Registre-se</h1><br>
                <form id="formAjax" method="post" enctype="multipart/form-data" action="../../controllers/register.php">
                    <div class="form-group">
                        <label for="InputName">Nome Completo</label>
                        <input type="text" id="InputName" class="form-control" maxlength="255" name="username" placeholder="Nome" value="<?php echo @$person->_name ?>" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Endereço de Email</label>
                        <input type="email" id="InputEmail" class="form-control" maxlength="255" name="email" placeholder="E-mail" value="<?php echo @$person->_email ?>" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="InputTelephone">Telefone</label>
                        <input type="text" id="InputTelephone" class="form-control" maxlength="11" name="telephone" placeholder="Telefone" value="<?php echo @$person->_telephone ?>" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="InputPassword1">Senha</label>
                        <input type="password" id="InputPassword1" class="form-control" name="password" placeholder="Senha" required>
                    </div>
                    <div class="form-group">
                        <label for="InputPassword2">Insira novamente sua senha</label>
                        <input type="password" id="InputPassword2" class="form-control" name="password_confirm" placeholder="Confirme a Senha" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="MAX_FILE_SIZE" value="500000">
                        <label for="userFile">Escolha sua foto de perfil</label>
                        <input class="btn btn-primary btn-file" id="userFile" type="file" accept="image/*" name="image">
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
    <script src="../../assets/js/alert.js"></script>
</body>
</html>
