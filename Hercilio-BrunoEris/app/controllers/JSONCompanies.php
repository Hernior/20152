<?php
include_once("DBConnect.php");
function catchCompanies(){
    global $conn;
    if ($stmt = $conn->prepare("SELECT comp_id, comp_name, comp_location, comp_telephone, comp_logo, comp_phrase FROM companies")) {
    /* execute statement */
    $stmt->execute();
    /* bind result variables */
    $stmt->bind_result($id, $name, $latlng, $telephone, $logo, $phrase);
    /* fetch values */
    $i = 0;
    while ($stmt->fetch()) {
        $coord = explode(" ", $latlng);
        $lat = $coord[0];
        $lng = $coord[1];
        $result[$i]["id"] = $id;
        $result[$i]["nome"] = $name;
        $result[$i]["latitude"] = $lat;
        $result[$i]["longitude"] = $lng;
            $pattern_telephone = '/(\d{2})(\d{4,5})(\d{4})/';
            $telephone = preg_replace($pattern_telephone, '($1) $2.$3', $telephone);
        $result[$i]["telefone"] = $telephone;
        $result[$i]["logo"] = $logo;
        $result[$i]["frase"] = $phrase;
        $i++;
    }
    $json = json_encode($result);
    return $json;
    }
}
echo catchCompanies();
?>
