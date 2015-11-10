<?php
if(isset($_GET["status"])){
    switch (@$_GET["status"]){
        case '7369676e75702073756363657373': //Signup Success
            $statusClass = "success";
            $statusTxt = "Cadastro efetuado com sucesso.";
            break;
        case '6c6f676f7574': //logout
            $statusClass = "success";
            $statusTxt = "Sessão encerrada com sucesso.";
            break;
        case '6e6f7420666f756e64': //not found (recover)
            $statusClass = "warning";
            $statusTxt = "Nenhum cadastro encontrado.";
            break;
        case '77726f6e6720757365726e616d65206f722070617373776f7264': //Signup Success
            $statusClass = "warning";
            $statusTxt = "Dados de acesso incorretos.";
            break;
        case '657870697265642073657373696f6e': //expired session
            $statusClass = "warning";
            $statusTxt = "Sua sessão expirou.<br>Efetue um novo login.";
            break;
        case '6163636573732064616e696564': //access danied
            $statusClass = "danger";
            $statusTxt = "Acesso negado!";
            break;
        default:
            break;
    }
    echo '
    <div class="alert alert-'.$statusClass.' alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        '.$statusTxt.'
    </div>';
}
 ?>
