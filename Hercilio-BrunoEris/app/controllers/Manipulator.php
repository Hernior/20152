<?php
Class Manipulator{
    public function checkPass($password, $confirmation){
        if($password != $confirmation){
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Confirmação de senha não confere com a senha digitada.
            </div>';
            exit;
        }elseif(strlen($password) > 45 || strlen($password) < 6){
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                A senha deve ter entre 6 e 45 caracteres.
            </div>';
            exit;
        }else{
            return true;
        }
	}

    public function checkPhone($telephone){
        if(!is_numeric($telephone)){
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Telefone deve conter apenas números.
            </div>';
            exit;
        }
        elseif(strlen($telephone) < 10 || strlen($telephone) > 11){
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Telefone deve ter entre 10 e 11 dígitos (com DDD).
            </div>';
            exit;
        }else{
            return true;
        }
	}

    public function checkEmail($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                O e-mail digitado ('.$email.') foi considerado inválido.
            </div>';
            exit;
        }else{
            return true;
        }
	}

    public function checkName($name){
        if (!preg_match("/^[0-9a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇºª ]+$/",$name)) {
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                O nome deve conter apenas letras, números e espaços.
            </div>';
            exit;
        }else{
            return true;
        }
	}

    public function checkCNPJ($cnpj){
        if (strlen($cnpj) != 14) {
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                O CNPJ deve conter 14 caracteres.
            </div>';
            exit;
        }elseif (!is_numeric($cnpj)) {
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                O CNPJ deve conter apenas números, sem caracteres especiais.
            </div>';
            exit;
        }else{
            return true;
        }
	}

    public function checkAddress($address){
        if (strlen($address) < 5) {
            echo '
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                O endereço deve ter pelo menos 5 caracteres.
            </div>';
            exit;
        }else{
            return true;
        }
	}
}
