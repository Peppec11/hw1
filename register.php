<?php
require_once 'auth.php';

if (checkAuth()) {
    header("Location: home.php");
    exit;
}



if (!empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["username"]) && !empty($_POST["data"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confPassword"])) {
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    
    if (!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
        $error[] = "Username non valido";
    } else {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
        $query = "SELECT username FROM users WHERE username = '$username'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            $error[] = "Username già utilizzato";
        }
    }
    //CONTROLLO MAGGIORE ETA
    $dataDiNascita = $_POST['data'];

    $nascita = strtotime($dataDiNascita);
    $corrente = time();

    $differenza = date('Y', $corrente) - date('Y', $nascita);

    $giornoCorrente = date('d', $corrente);
    $meseCorrente = date('m', $corrente);
    $annoCorrente = date('Y', $corrente);

    $giornoDiNascita = date('d', $nascita);
    $meseDiNascita = date('m', $nascita);
    $annoDiNascita = date('Y', $nascita);

    if (($differenza < 18) ||($differenza==18 && $meseDiNascita>$meseCorrente)||($differenza==18 && $meseDiNascita==$meseCorrente&& $giornoDiNascita>$giornoCorrente)) {
       
    $error[] = "Devi essere maggiorenne per poter accedere";
    }
    //CONTROLLO PASSWORD

    if (strlen($_POST['password']) < 8) {
        $error[] = "Password poco sicura";
    }

    if (strcmp($_POST['password'], $_POST['confPassword']) != 0) {
        $error[] = "Le password non cincidono";
    }



    //CONTROLLO EMAIL
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $error[] = "Email non valida";
    } else { //CONTROLLA SE L'EMAIL GIA IN USO
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
        $res = mysqli_query($conn, "SELECT email FROM users WHERE email= '$email'");
        if (mysqli_num_rows($res) > 0) {
            $error[] = 'email gia in uso';
        }
        print_r($_POST['name']);
    }

    if (count($error) == 0) { 
        if ($_FILES['avatar']['size'] != 0) {
            $file = $_FILES['avatar'];
            $type = exif_imagetype($file['tmp_name']);
            $allowedExt = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif');
            if (isset($allowedExt[$type])) {
                if ($file['error'] === 0) {
                    if ($file['size'] < 7000000) {
                        $fileNameNew = uniqid('', true).".".$allowedExt[$type];
                        $avatarImg = 'img/'.$fileNameNew;
                        move_uploaded_file($file['tmp_name'], $avatarImg);
                    } else {
                        $error[] = "L'immagine non deve avere dimensioni maggiori di 7MB";
                    }
                } else {
                    $error[] = "Errore nel carimento del file";
                }
            } else {
                $error[] = "I formati consentiti sono .png, .jpeg, .jpg e .gif";
            }
        }else{
            echo "Non hai caricato nessuna immagine";
        }
    }


    // REGISTRAZIONE NEL DATABASE
    if (count($error) == 0) {

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $data = mysqli_real_escape_string($conn, $_POST['data']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);



        $query = "INSERT INTO users(username,password,email,name,surname,data,avatar) VALUES('$username','$password','$email','$name','$surname','$data','$avatarImg')";
        if (mysqli_query($conn, $query)) {
            $_SESSION["_agora_username"] = $_POST['username'];
            $_SESSION['agora_user_id'] = mysqli_insert_id($conn);
            mysqli_close($conn);
            header("Location: home.php");
            exit;
        } else {
            $error[] = "Errore di connessione al Database";
        }
    }
    mysqli_close($conn);
} else if (isset($_POST["username"])) {
    $error = array("Riempi tutti i campi");
}



?>

<html>

<head>
    <link rel="stylesheet" href="register.css">
    <script src="register.js" defer></script>
    <link rel="shortcut icon" href="img/icona.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <header>

    </header>

    <div class="contenitore">
        <form name='signup' method='post' enctype="multipart/form-data" autocomplete="off">
            <h1>SING UP</h1>
            <div class="name box">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" <?php if (isset($_POST["name"])) {
                                                                echo "value=" . $_POST["name"];
                                                            } ?>>

                <div class="hidden mex">

                    <img src="img/canc.png" class="errorImg">
                    <p class="errorMsg">Nome non valido</p>

                </div>
            </div>

            <div class="surname box">
                <label for="surname">Cognome</label>
                <input type="text" name="surname" id="surname" <?php if (isset($_POST["surname"])) {
                                                                    echo "value=" . $_POST["surname"];
                                                                } ?>>

                <div class="hidden mex">

                    <img src="img/canc.png" class="errorImg">
                    <p class="errorMsg">Cognome non valido</p>

                </div>
            </div>
            <div class="username box">
                <label for="email">Username</label>
                <input type="text" name="username" id="username" <?php if (isset($_POST["username"])) {
                                                                        echo "value=" . $_POST["username"];
                                                                    } ?>>

                <div class="hidden mex">

                    <img src="img/canc.png" class="errorImg">
                    <p class="errorMsg">Email non valida</p>

                </div>

            </div>

            <div class="email box">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" <?php if (isset($_POST["email"])) {
                                                                echo "value=" . $_POST["email"];
                                                            } ?>>

                <div class="hidden mex">

                    <img src="img/canc.png" class="errorImg">
                    <p class="errorMsg">Email non valida</p>

                </div>
            </div>

            <div class="data box">
                <label for="data">Data di nascita</label>
                <input type="date" name="data" id="data" <?php if (isset($_POST["data"])) {
                                                                echo "value=" . $_POST["data"];
                                                            } ?>>

                <div class="hidden mex">

                    <img src="img/canc.png" class="errorImg">
                    <p class="errorMsg">Devi essere maggiorenne per registrarti</p>

                </div>
            </div>

            <div class="password box">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" <?php if (isset($_POST["password"])) {
                                                                            echo "value=" . $_POST["password"];
                                                                        } ?>>

                <div class="hidden mex">

                    <img src="img/canc.png" class="errorImg">
                    <p class="errorMsg">Password non valida</p>

                </div>
            </div>

            <div class="confPass box">
                <label for="confPassword">Conferma la password</label>
                <input type="password" name="confPassword" id="confPass" <?php if (isset($_POST["confPassword"])) {
                                                                                echo "value=" . $_POST["confPassword"];
                                                                            } ?>>

                <div class="hidden mex">

                    <img src="img/canc.png" class="errorImg">
                    <p class="errorMsg">Password non corrispondente</p>

                </div>

            </div>

            <div class="fileupload box">
                    <label for='avatar'>Scegli un'immagine profilo</label>
                        <input type='file' name='avatar' accept='.jpg, .jpeg, image/gif, image/png' id="upload_original">
                       </div>



            <?php if (isset($error)) {
                foreach ($error as $err) {
                    echo "<div class='errore mex'><img src='img/canc.png'/><span>" . $err . "</span></div>";
                }
            } ?>
            <div class="submit">
                <input type="submit" id="submit">
            </div>

        </form>
    </div>
    </div>

    <footer>


    </footer>
</body>

</html>