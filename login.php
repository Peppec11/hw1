<?php
 include 'auth.php';
 if (checkAuth()) {
     header('Location: home.php');
     exit;
 }

 if(!empty($_POST["username"]) && !empty($_POST["password"])){
    $conn=mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig["password"],$dbconfig["name"]) or die(mysqli_error($conn));

$username = mysqli_real_escape_string($conn, $_POST['username']);

    $query="SELECT * FROM users WHERE username= '".$username."'";

    $res=mysqli_query($conn,$query) or die(mysqli_error($conn));

    if(mysqli_num_rows($res)>0){
        $entry=mysqli_fetch_assoc($res);

        if(password_verify($_POST['password'],$entry['password'])){
            $_SESSION["_agora_username"] = $entry['email'];
            $_SESSION["_agora_user_id"] = $entry['id'];
            header("Location: home.php");
            mysqli_free_result($res);
            mysqli_close($conn);
            exit;
        }
    }
    $error="USERNAME O PASSWORD ERRATI";
 }

 else if(isset($_POST["username"])||isset($_POST['password'])){
    $error="inserisci username e password ";

 }

?>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="register.css">
<link rel="shortcut icon" href="img/icona.png" type="image/x-icon">
<Title>Accedi-FILMFILX</Title>
</head>

<body>
    <div class="contenitore">
        <form name='signup' method='post' enctype="multipart/form-data" autocomplete="off">
            <h1>LOGIN</h1>

            <div class="username box">
                <label for="email">Username</label>
                <input type="text" name="username" id="username" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>


            </div>

            <div class="password box">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>


            </div>

            


            <div class="submit">
                <input type="submit" id="submit">
            </div>

            <?php   if (isset($error)) {
                    echo "<p class='error'>$error</p>";
                }
                
            ?> 

            <div class="mex">
                <p>Non sei ancora registrato?</p><a href="register.php"> CLICCA QUI</a>
            </div>

        </form>
    </div>
</body>

</html>