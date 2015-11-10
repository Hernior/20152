<?php
@session_start();
if(session_status() != 2){
    echo "Erro ao iniciar sessão.";
    exit;
}
else{
    // Logout
    if(@$_GET['logout'] == true){
        session_destroy();
        header('location: ../views/company/login.php?status=6c6f676f7574');
    }

    // Checking session
    if((isset($_SESSION['logged_company'])) && ($_SESSION['logged_company'] == true)){
        checkSessionTimeout();
    }
    else{
        session_destroy();
        header('location: login.php?status=6163636573732064616e696564');
    }
}

/* Session Management */
function checkSessionTimeout(){
    $timelimit = 600; // seconds
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timelimit)) {
        session_unset();
        session_destroy();
        header('Location: login.php?status=657870697265642073657373696f6e');
    }
    else{
        $_SESSION['LAST_ACTIVITY'] = time();
    }
}
