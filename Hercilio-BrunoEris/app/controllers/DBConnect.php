<?php
define("host", "127.0.0.1");
define("user", "root");
define("senha", "");
define("banco", "paonamao");

// Create connection
$conn = new mysqli(host, user, senha, banco);

// Check connection
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    $conn->close(); //Close connection
}
if (!$conn->set_charset("utf8")) {
    printf("Erro ao configurar character set to utf8: %s\n", $conn->error);
    exit();
}

/* Requests classes on demand */
function autoload ($Class) {
    include(__DIR__ . "/" . $Class . ".php");
}
spl_autoload_register("autoload");
session_start();
