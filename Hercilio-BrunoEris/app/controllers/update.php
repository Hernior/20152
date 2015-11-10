<?php
include_once("DBConnect.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['comp_id'])){
        $company = new Company($_POST['name'], NULL, NULL, $_POST['telephone'], NULL, NULL, NULL); //$name, $location, $email, $telephone, $password, $cnpj, $address
        $company->_id = $_POST['comp_id'];
        $company->_phrase = $_POST['phrase'];
        $company->updateCompany($company->_id, $company->_name, $company->_telephone, $company->_phrase);
    }
    elseif(isset($_POST['user_id'])){
        $person = new User($_POST['name'], $_SESSION['email'], $_POST['telephone'], NULL); //$name, $email, $telephone, $password
        $person->_id = $_POST['user_id'];
        $person->updatePerson($person->_id, $person->_name, $person->_telephone);
    }
}
?>
