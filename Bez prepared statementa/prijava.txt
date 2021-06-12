<!DOCTYPE html>

<?php
    session_start();
?>

<html>

    <head>
        <title>Frankfurter Allgemeine | Registracija</title>
        <meta charset="UTF-8">
        <meta name="author" content="Luka Dušak">
        <meta name="description" content="Frankfurter Allgemeine - Web stranica">
        <meta name="keywords" content="Frankfurter Allgemeine, Frankfurter, Allgemeine, portal, mediji, novine, stranica">
        <link href="https://fonts.googleapis.com/css2?family=Germania+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Stint+Ultra+Condensed&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">

        <script type="text/javascript">
            function validacija() {
                var ispravnaForma = true;

                var korisnicko_ime = document.getElementById("korisnicko_ime");
                var korisnicko_ime_tekst = korisnicko_ime.value;
                if(korisnicko_ime_tekst === "" || korisnicko_ime_tekst.length === 0) {
                    ispravnaForma = false;
                    korisnicko_ime.style.border = "2px solid red";
                    document.getElementById("korisnicko_ime_error").innerHTML = "Unesite korisničko ime!<br>";
                }
                else {
                    korisnicko_ime.style.border = "2px solid black";
                    document.getElementById("korisnicko_ime_error").innerHTML = "";
                }
                
                var lozinka = document.getElementById("lozinka");
                var lozinka_tekst = lozinka.value;
                if(lozinka_tekst === "" || lozinka_tekst.length === 0) {
                    ispravnaForma = false;
                    lozinka.style.border = "2px solid red";
                    document.getElementById("lozinka_error").innerHTML = "Unesite lozinku!<br>";
                }
                else {
                    lozinka.style.border = "2px solid black";
                    document.getElementById("lozinka_error").innerHTML = "";
                }
                
                return ispravnaForma;
            }
        </script>
    </head>

    <?php
        include('connection.php');
    ?>

    <body>
        <div class="container">
            <header>
                <nav class="navigacija">
                    <ul>
                        <li><a href="index.php">Početna</a></li>
                        <li><a href="kategorija.php?id=politika">Politika</a></li>
                        <li><a href="kategorija.php?id=sport">Sport</a></li>
                        <li><a href="kategorija.php?id=fig">Film i Glazba</a></li>
                        <li><a href="unos.php">Novi članak</a></li>
                        <li><a href="administracija.php">Administracija</a></li>
                    </ul>
                    <hr>
                </nav>

                <div class="sesija">
                    <?php 
                        if(isset($_SESSION['username'])) {
                            echo "<span>Dobrodošao " . $_SESSION['username'] . "</span>!";
                            echo "
                                <form action=\"\" method=\"POST\" name=\"forma\">
                                    <input type=\"submit\" value=\"Odjavi me\" name=\"odjava\">
                                </form>
                            ";

                            if(isset($_POST['odjava'])) {
                                session_destroy();
                                echo "<script>location.href = \"prijava.php\";</script>";
                            }
                        }
                    ?>
                </div>

                <div class="login">
                    <a href="prijava.php">Prijava</a>
                    <span> / </span>
                    <a href="registracija.php">Registracija</a>
                </div><br><br>

                <h1 id="glavni_naslov">Frankfurter Allgemeine</h1>
            </header>

            <?php

                if(isset($_SESSION['username'])) {
                    echo "
                        <section class=\"unos2\">
                            <h2>Već ste ulogirani!</h2>
                            <p>Da biste se prijavili drugim računom, molimo da se odjavite sa postojećeg.</p>
                        </section>
                    ";
                }
                else {
                    echo "
                        <section class=\"unos2\">
                            <form action=\"\" method=\"POST\" name=\"forma\" onsubmit=\"return validacija()\">
                                <label for=\"korisnicko_ime\">Korisničko ime:</label><br>
                                <input type=\"text\" name=\"korisnicko_ime\" id=\"korisnicko_ime\"><br>
                                <span id=\"korisnicko_ime_error\" class=\"error\"></span><br>
            
                                <label for=\"lozinka\">Lozinka:</label><br>
                                <input type=\"password\" name=\"lozinka\" id=\"lozinka\"><br>
                                <span id=\"lozinka_error\" class=\"error\"></span><br>
            
                                <input type=\"submit\" value=\"Prijavi me\" name=\"gumb\" id=\"gumb\">
                            </form>
                        </section>
                    ";
                }

            ?>


            <?php

                if(isset($_POST['gumb'])) {
                    $korisnicko_ime = $_POST['korisnicko_ime'];
                    $lozinka = $_POST['lozinka'];

                    $query_korIme = "SELECT * FROM korisnik WHERE korisnicko_ime='$korisnicko_ime';";
                    $rezultat_korIme = mysqli_query($database, $query_korIme);
                    $redak = mysqli_fetch_array($rezultat_korIme);

                    if(mysqli_num_rows($rezultat_korIme) === 0) {
                        echo "
                            <script>
                                alert('Račun s unesenim korisničkim imenom ne postoji! Molimo prvo se registrirajte.');
                            </script>
                        ";
                        echo "<script>location.href = \"registracija.php\";</script>";
                    }
                    else {
                        if(password_verify($lozinka, $redak['lozinka'])) {
                            $_SESSION['username'] = $korisnicko_ime;
                            $_SESSION['password'] = $lozinka;
                            $_SESSION['level'] = $redak['dozvola'];

                            echo "
                                <script>
                                    alert('Uspješna prijava!');
                                </script>
                            ";
                            echo "<script>location.href = \"index.php\";</script>";
                        }
                        else {
                            echo "
                                <script>
                                    alert('Lozinka je neispravna! Molimo ponovite prijavu.');
                                </script>
                            ";
                        }
                    }
                }

            ?>

        </div>

        <?php
            mysqli_close($database);
        ?>

        <footer>
            <h1 id="glavni_naslov">Frankfurter Allgemeine</h1>
            <p>Luka Dušak | ldusak@tvz.hr | 2021.</p>
            <p>© Copyright. All right reserved.</p>
        </footer>
    </body>
</html>