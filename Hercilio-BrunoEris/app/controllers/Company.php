<?php
class Company extends Manipulator{
    public $_id;
    public $_name;
    public $_location;
    public $_email;
    public $_telephone;
    public $_password;
    public $_cnpj;
    public $_address;
    public $_logo;
    public $_phrase;

    public function __construct($name, $location, $email, $telephone, $password, $cnpj, $address){
        $this->_name = $name;
        $this->_location = $location;
        $this->_email = $email;
        $this->_telephone = $telephone;
        $this->_password = $password;
        $this->_cnpj = $cnpj;
        $this->_address = $address;
    }

    public function registerCompany($name, $location, $email, $telephone, $password, $cnpj, $address){
        global $conn;
        if ($stmt = $conn->prepare("INSERT INTO companies (comp_name, comp_location, comp_email, comp_telephone, comp_password, comp_cnpj, comp_address) VALUES (?, ?, ?, ?, ?, ?, ?)")){
            $hashPassword = crypt($password, '$2a$08$GDSWHBpaonamao7psi2015$'); //results 60-digit hash.
            $stmt->bind_param("sssssss", ucfirst($name), $location, $email, $telephone, $hashPassword, $cnpj, $address);
    		$stmt->execute();
            if($stmt->affected_rows != 1){
                if($stmt->sqlstate == 23000){$errorSTMT = "Violação de integridade identificada";}
                if(strpos($stmt->error, "comp_email")){$errorSTMT .= " (e-mail)";}
                if(strpos($stmt->error, "comp_cnpj")){$errorSTMT .= " (CNPJ)";}
                if($stmt->errno == 1062){$errorSTMT .= "<br>Talvez sua empresa já tenha cadastro.";}
                echo '
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    '.$errorSTMT.' <abbr title="'.$stmt->error.'">Detahes</abbr>
                </div>';
                exit;
            }
            else{
                return true;
            }
        }
        else{
            echo "Falha na conexão: ".$conn->error;
        }
	}

    public function loginCompany($email, $password){
        global $conn;
        if ($stmt = $conn->prepare("SELECT comp_id, comp_name, comp_location, comp_email, comp_telephone, comp_cnpj, comp_logo, comp_phrase FROM companies WHERE comp_email=? AND comp_password=?")) {
            $hash = crypt($password, '$2a$08$GDSWHBpaonamao7psi2015$');
            $stmt->bind_param("ss", $email, $hash);
            $stmt->execute();
            $stmt->bind_result($id, $name, $location, $email, $telephone, $cnpj, $logo, $phrase);
            $stmt->store_result();
            $stmt->fetch();
            $result = $stmt->num_rows;
            $stmt->close();
            $conn->close();

            if($result == 1){
                $this->_id = $id;
                $this->_name = $name;
                $this->_location = $location;
                $this->_telephone = $telephone;
                $this->_cnpj = $cnpj;
                $this->_logo = $logo;
                $this->_phrase = $phrase;
                return 1;
            }
            else{
                $_GET['status'] = "77726f6e6720757365726e616d65206f722070617373776f7264";
                return 0;
            }
        }
        else{
            echo "Falha na conexão: ".$conn->error;
        }
	}

    public function uploadFile($image, $maxfilesize){
        $phpFileUploadErrors = array(
            0 => 'Upload de arquivo efetuado com sucesso.',
            1 => 'Arquivo excede a diretiva upload_max_filesize em php.ini.',
            2 => 'Arquivo excede a diretiva MAX_FILE_SIZE especificada no formulário HTML ('.$maxfilesize.' bytes).',
            3 => 'Upload foi executado apenas parcialmente.',
            4 => 'Nenhum arquivo foi submetido.',
            6 => 'Pasta temporária não encontrada.',
            7 => 'Falha ao gravar arquivo.',
            8 => 'Uma extensão PHP parou o upload do arquivo.',
        );
        $phpFileUploadResult = $phpFileUploadErrors[$image["error"]];

        if(isset($image['name']) && $image["error"] == 0){
            $tempFile = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            $extension = strtolower(strrchr($name, '.')); // Catch file extension

            // Check if file is an image
            if(strstr('.jpg;.jpeg;.gif;.png', $extension)){
                $outputFilename = md5($this->_cnpj).$extension; // Set filename as an MD5 crypt of company's CNPJ
                $target = '../assets/img/company/'; // Define target to move the uploaded image
                if (!is_dir($target)) {
                    mkdir($target, 0777, true);
                }
                chmod($target, 0777);
                $target = $target.$outputFilename; // Define target to move the uploaded image

                // Moving the file
                if(@move_uploaded_file($tempFile, $target)){
                    list($width, $height) = getimagesize($target);
                    // horizontal rectangle
                    if ($width > $height) {
                        $square = $height;              // $square: square side length
                        $offsetX = ($width - $height) / 2;  // x offset based on the rectangle
                        $offsetY = 0;              // y offset based on the rectangle
                    }
                    // vertical rectangle
                    elseif ($height > $width) {
                        $square = $width;
                        $offsetX = 0;
                        $offsetY = ($height - $width) / 2;
                    }
                    // it's already a square
                    else {
                        $square = $width;
                        $offsetX = $offsetY = 0;
                    }
                    list($width, $height) = getimagesize($target);

                    $tempTarget = imagecreatetruecolor($square,$square);
                    if(@imagecreatefromjpeg($target)){
                        $tempImage = imagecreatefromjpeg($target);
                        header("Content-Type: image/jpg");
                    }elseif(@imagecreatefrompng($target)){
                        $tempImage = imagecreatefrompng($target);
                        header("Content-Type: image/png");
                    }elseif(@imagecreatefromgif($target)){
                        $tempImage = imagecreatefromgif($target);
                        header("Content-Type: image/gif");
                    }else{
                        echo "Falha na conversão da imagem!";
                    }
                    imagecopyresampled($tempTarget, $tempImage, 0, 0, 0, 0, $square, $square, $width, $height);
                    imagejpeg($tempTarget, $target, 100);

                    global $conn;
                    $stmt = $conn->prepare("UPDATE companies SET comp_logo = ? WHERE comp_cnpj = ?");
                    $stmt->bind_param("ss", $outputFilename, $this->_cnpj);
            		$stmt->execute();
                    $conn->close();
                    if($stmt->affected_rows != 1){
                        global $errorSTMT;
                        $errorSTMT = $stmt->error;
                        return $_GET['status'] = "73746d74";
                    }
                    else{
                        echo '
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Cadastro de <b>'.$this->_name.'</b> efetuado com sucesso!
                        </div>';
                    }
                }
                else{
                    echo "Erro ao tentar salvar a imagem.";
                }
            }
            else
                echo "Você pode enviar apenas arquivos *.jpg;*.jpeg;*.gif;*.png<br>";
        }
        else{
            echo "Resultado do Upload: ".$phpFileUploadResult;
            exit;
        }
    }

    public function updateCompany($id, $name, $telephone, $phrase){
        if(!is_numeric($telephone)){
            echo "<div class=\"alert alert-warning\">Telefone deve ter apenas dígitos numéricos.</div>";
        }elseif(strlen($telephone) < 10 || strlen($telephone) > 11){
            echo "<div class=\"alert alert-warning\">Telefone deve ter entre 10 e 11 dígitos (com DDD).</div>";
        }else{
            global $conn;
            if ($stmt = $conn->prepare("UPDATE companies SET comp_name=?, comp_telephone=?, comp_phrase=? WHERE comp_id=?")) {
                $stmt->bind_param("sssi", $name, $telephone, $phrase, $id);
                $stmt->execute();
                $result = $stmt->affected_rows;
                echo ($result == 1) ? "<div class=\"alert alert-success alert-dismissible\" role=\"alert\"><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button> Dados atualizados com sucesso!</div>" : "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button> Você não alterou nenhum dado.</div>";
                $_SESSION['name'] = $this->_name;
                $_SESSION['phrase'] = $this->_phrase;
                $_SESSION['telephone'] = $this->_telephone;
            }
            else{
                echo "Falha na conexão: ".$conn->error;
            }
        }
	}

}
?>
