<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

?>

<html>
<?php
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
$userid = mysqli_real_escape_string($conn, $userid);
$query = "SELECT * FROM users WHERE id = $userid";
$res_1 = mysqli_query($conn, $query);
$userinfo = mysqli_fetch_assoc($res_1);
?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cerca film- FILMFLIX</title>
    <link rel="stylesheet" href="film.css">
    <script src="film.js" defer></script>
    <link rel="shortcut icon" href="img/icona.png" type="image/x-icon">
</head>

<body>
    <header>
        <div class="titolo">
            <h1>FILM </h1><h1 class="rosso">FLIX</h1>
            
        </div>
        <div class="overlay">
    </header>
    <menu>
        <a href="home.php">home</a>
        <a href="film.php">Cerca un film</a>
        <a href="user.php"><?php echo $userinfo['username'] ?></a>
        <a href=logout.php>logout</a>

    </menu>
    <div class="container">
        <div class="contenitore">
            <div class="search">
                <input type="text" name="cerca" id="cerca">
                <input type="submit" name="submit" id="button"></input>
            </div>
            <div class="results">

            </div>
        </div>

    </div>


    <div class="svg">
        <img src="img/svg (2).png" alt="" srcset="">

    </div>
</body>


<footer>
    <div class="footerCol">
        <h3>Giuseppe Ciavola<br>
            Corso A-L<br>
            1000016097</h3>

    </div>

    <div class="footerCol">
        <a href="film.php">Cerca un film</a>

        <a href=logout.php>logout</a>

        <a href="user.php"><?php echo $userinfo['name'] . " " . $userinfo['surname'] ?></a>
    </div>

    <div class="footerCol">
        <h2> Filmflix</h2>
        <p>Chi Siamo? <br>
            Lavora con noi </p>
    </div>

</footer>

</html>