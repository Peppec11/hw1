<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
$userid = mysqli_real_escape_string($conn, $userid);
$query = "SELECT * FROM users WHERE id = $userid";
$res_1 = mysqli_query($conn, $query);
$userinfo = mysqli_fetch_assoc($res_1);





?>

<html>


<head>
    <title> <?php echo $userinfo['name'] . " " . $userinfo['surname'] ?>-FILMFLIX</title>
    <link rel="stylesheet" href="user.css">
    <link rel="shortcut icon" href="img/icona.png" type="image/x-icon">
    <script src="user.js" defer></script>
   
</head>

<body>
    <header>
        <div class="titolo">

            <h1><?php echo $userinfo['name'] ?> </h1>
            <h1 class="rosso"><?php echo $userinfo['surname'] ?></h1>

        </div>
        <div class="overlay">
    </header>
    <menu>
        <a href="home.php">home</a>
        <a href="film.php">Cerca un film</a>
        <a href="user.php"><?php echo $userinfo['name'] . " " . $userinfo['surname'] ?></a>
        <a href=logout.php>logout</a>

    </menu>

    <div class="separatore">

    </div>
    <div class="contenitore">
        <div class="userBox">
            <img src="<?php echo $userinfo['avatar'] ?>">
            <p class="username"><?php echo $userinfo['username'] ?> </p>


            <p class="email"><?php echo $userinfo['email'] ?> </p>
            <p class="data"><?php echo $userinfo['data'] ?> </p>
        </div>
        <div class="separatore">

        </div>
        <div class="favourite">
            <div id="film">

            </div>
        </div>

    </div>


    <div class="svg">
        <img src="img/svg (2).png" alt="" srcset="">

    </div>

    <footer>
        <div class="footerCol">
            <h3>Giuseppe Ciavola<br>
                Corso A-L<br>
                1000016097</h3>

        </div>

        <div class="footerCol">
            <a href="home.php">home</a>

            <a href="film.php">Cerca un film</a>

            <a href=logout.php>logout</a>

            <a href="user.php"><?php echo $userinfo['name'] . " " . $userinfo['surname'] ?></a>




        </div>

        <div class="footerCol">
            <div class="azienda">
                <h2> Film </h2>
                <h2 class="rosso">flix</h2>
            </div>

            <p>Chi Siamo? <br>
                Lavora con noi </p>
        </div>

    </footer>
</body>


</html>