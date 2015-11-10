<?php
include_once("DBConnect.php");
if(isset($_SESSION['id'])){
    header('location: main.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['useremail'])){
        $person = new User("", $_POST['useremail'], "", $_POST['password'], "", "");
        $result = $person->loginUser($person->_email, $person->_password);
        if($result == true){
        	$_SESSION['id'] = $person->_id;
        	$_SESSION['name'] = $person->_name;
        	$_SESSION['email'] = $person->_email;
        	$_SESSION['telephone'] = $person->_telephone;
        	$_SESSION['photo'] = (!isset($person->_photo)) ? 'avatar_default.png' : $person->_photo;
        	$_SESSION['logged_user'] = true;
            $_SESSION['LAST_ACTIVITY'] = time();
            header('location: main.php');
        }
        else{
            $_GET['status'] = "77726f6e6720757365726e616d65206f722070617373776f7264";
        }
    }
    if(isset($_POST['compemail'])){
        $company = new Company("", "", $_POST['compemail'], "", $_POST['password'], "", "");
        $result = $company->loginCompany($company->_email, $company->_password);
        if($result == 1){
        	$_SESSION['id'] = $company->_id;
        	$_SESSION['name'] = $company->_name;
        	$_SESSION['location'] = $company->_location;
        	$_SESSION['email'] = $company->_email;
        	$_SESSION['telephone'] = $company->_telephone;
        	$_SESSION['cnpj'] = $company->_cnpj;
        	$_SESSION['address'] = $company->_address;
        	$_SESSION['photo'] = $company->_logo;
        	$_SESSION['phrase'] = $company->_phrase;
        	$_SESSION['logged_company'] = true;
            $_SESSION['LAST_ACTIVITY'] = time();
            header('location: main.php');
        }
        else{
            $_GET['status'] = "77726f6e6720757365726e616d65206f722070617373776f7264";
        }
    }
}
?>
