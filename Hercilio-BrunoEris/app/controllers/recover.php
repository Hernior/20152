<?php
include_once("DBConnect.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['useremail'])){
        $person = new User(NULL, $_POST['useremail'], NULL, NULL, NULL, NULL);
        $result = $person->recoverUser($person->_email);
        if($result == true){
            echo "Encontrado: ".$person->_email;
            $message = "Foi solicitada a recuperação de sua conta no Pão na Mão.<br>";
            $message .= "Para recuperar a sua senha, acesse o link: ___";
            mail("$person->_email", "Recuperação de Senha", $message);
        }
        else{
            $_GET['status'] = "6e6f7420666f756e64";
        }
    }
    if(isset($_POST['compemail'])){
        $company = new Company(NULL, NULL, $_POST['compemail'], NULL, NULL, NULL, NULL);
        $result = $person->recoverCompany($company->_email);
        if($result == true){
            echo "Encontrado: ".$person->_email;
            $message = "Foi solicitada a recuperação de sua conta no Pão na Mão.<br>";
            $message .= "Para recuperar a sua senha, acesse o link: ___";
            mail("$person->_email", "Recuperação de Senha", $message);
        }
        else{
            $_GET['status'] = "6e6f7420666f756e64";
        }
    }
}
?>
