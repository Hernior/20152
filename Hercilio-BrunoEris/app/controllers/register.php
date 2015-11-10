<?php
include_once("DBConnect.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['username'])){
        $person = new User($_POST['username'], $_POST['email'], $_POST['telephone'], $_POST['password']);
        $validation[] = $person->checkPass($person->_password, $_POST['password_confirm']);
        $validation[] = $person->checkPhone($person->_telephone);
        $validation[] = $person->checkEmail($person->_email);
        $validation[] = $person->checkName($person->_name);
        if (!in_array(0, $validation)) { //Check if some function returned 0
            $registerResult = $person->registerUser($person->_name, $person->_email, $person->_telephone, $person->_password);
            if($registerResult == true){
                if(!isset($_FILES['image'])){
                    echo '
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Cadastro de <b>'.$person->_name.'</b> efetuado. (sem imagem)
                    </div>';
                }
                else{
                    $person->uploadFile($_FILES['image'], $_POST['MAX_FILE_SIZE']);
                }
                echo '<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Redirecionando...</div>';
                echo "<meta http-equiv=\"refresh\" content=\"3;url=login.php\">";
            }
        }
    }
    if(isset($_POST['compname'])){
        if($_POST['lat'] != "" && $_POST['lng'] != "" && $_POST['address'] != ""){
            $location = "".$_POST['lat']." ".$_POST['lng']."";
            $company = new Company($_POST['compname'], $location, $_POST['email'], $_POST['telephone'], $_POST['password'], $_POST['cnpj'], $_POST['address']);
            $validation[] = $company->checkPass($company->_password, $_POST['password_confirm']);
            $validation[] = $company->checkPhone($company->_telephone);
            $validation[] = $company->checkEmail($company->_email);
            $validation[] = $company->checkCNPJ($company->_cnpj);
            $validation[] = $company->checkName($company->_name);
            $validation[] = $company->checkAddress($company->_address);
            if (!in_array(0, $validation)) { //Check if some function returned 0
                $registerResult = $company->registerCompany($company->_name, $company->_location, $company->_email, $company->_telephone, $company->_password, $company->_cnpj, $company->_address);
                if($registerResult == true && $_FILES['image']['error'] != 4){
                    $company->uploadFile($_FILES['image'], $_POST['MAX_FILE_SIZE']);
                }
                else{
                    echo '
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <br>Nenhuma imagem enviada.
                    </div>';
                }
                echo '<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Redirecionando...</div>';
                echo "<meta http-equiv=\"refresh\" content=\"3;url=login.php\">";
            }
        }
        else{
            echo "Escolha o local de sua empresa no mapa.";
        }
    }
}
?>
