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

                var ime = document.getElementById("ime");
                var ime_tekst = ime.value;
                if(ime_tekst === "" || ime_tekst.length === 0) {
                    ispravnaForma = false;
                    ime.style.border = "2px solid red";
                    document.getElementById("ime_error").innerHTML = "Unesite ime!<br>";
                }
                else {
                    ime.style.border = "2px solid black";
                    document.getElementById("ime_error").innerHTML = "";
                }

                var prezime = document.getElementById("prezime");
                var prezime_tekst = prezime.value;
                if(prezime_tekst === "" || prezime_tekst.length === 0) {
                    ispravnaForma = false;
                    prezime.style.border = "2px solid red";
                    document.getElementById("prezime_error").innerHTML = "Unesite prezime!<br>";
                }
                else {
                    prezime.style.border = "2px solid black";
                    document.getElementById("prezime_error").innerHTML = "";
                }

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

                var ponovljena_lozinka = document.getElementById("ponovljena_lozinka");
                var ponovljena_lozinka_tekst = ponovljena_lozinka.value;
                if(ponovljena_lozinka_tekst === "" || ponovljena_lozinka_tekst.length === 0) {
                    ispravnaForma = false;
                    ponovljena_lozinka.style.border = "2px solid red";
                    document.getElementById("ponovljena_lozinka_error").innerHTML = "Ponovno unesite lozinku!<br>";
                }
                else if(ponovljena_lozinka_tekst != lozinka_tekst) {
                    ispravnaForma = false;
                    ponovljena_lozinka.style.border = "2px solid red";
                    document.getElementById("ponovljena_lozinka_error").innerHTML = "Ponovljena lozinka ne odgovara unesenoj lozinki!<br>";
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
                                echo "<script>location.href = \"registracija.php\";</script>";
                            }
                        }
                    ?>
                </div>

                <div class="login">
                    <a href="prijava.php">Prijava</a>
                    <span> / </span>
                    <a href="registracija.php">Registracija</a>
                </div><br><br>

                <h1 id="glavni_naslov"><img src="Slike/naslov.JPG"></h1>
            </header>

            <?php

                if(isset($_SESSION['username'])) {
                    echo "
                        <section class=\"unos2\">
                            <h2>Već ste ulogirani!</h2>
                            <p>Da biste registrirali novi račun, molimo da se odjavite sa postojećeg.</p>
                        </section>
                    ";
                }
                else {
                    echo "
                        <section class=\"unos2\">
                            <form action=\"\" method=\"POST\" name=\"forma\" onsubmit=\"return validacija()\">
                                <label for=\"ime\">Ime:</label><br>
                                <input type=\"text\" name=\"ime\" id=\"ime\"><br>
                                <span id=\"ime_error\" class=\"error\"></span><br>
            
                                <label for=\"prezime\">Prezime:</label><br>
                                <input type=\"text\" name=\"prezime\" id=\"prezime\"><br>
                                <span id=\"prezime_error\" class=\"error\"></span><br>
            
                                <label for=\"korisnicko_ime\">Korisničko ime:</label><br>
                                <input type=\"text\" name=\"korisnicko_ime\" id=\"korisnicko_ime\"><br>
                                <span id=\"korisnicko_ime_error\" class=\"error\"></span><br>
            
                                <label for=\"lozinka\">Lozinka:</label><br>
                                <input type=\"password\" name=\"lozinka\" id=\"lozinka\"><br>
                                <span id=\"lozinka_error\" class=\"error\"></span><br>
            
                                <label for=\"ponovljena_lozinka\">Ponovite lozinku:</label><br>
                                <input type=\"password\" name=\"ponovljena_lozinka\" id=\"ponovljena_lozinka\"><br>
                                <span id=\"ponovljena_lozinka_error\" class=\"error\"></span><br>
            
                                <input type=\"submit\" name=\"gumb\" id=\"gumb\" value=\"Registriraj me\">
                            </form>
                        </section>
                    ";
                }

            ?>


            <?php

                if(isset($_POST['gumb'])) {
                    $ime = $_POST['ime'];
                    $prezime = $_POST['prezime'];
                    $korisnicko_ime = $_POST['korisnicko_ime'];
                    $lozinka = $_POST['lozinka'];
                    $lozinka_hash = password_hash($lozinka, CRYPT_BLOWFISH);

                    $query_korIme = "SELECT * FROM korisnik WHERE korisnicko_ime=?;";
                    $statement_korIme = mysqli_stmt_init($database);
                    if(mysqli_stmt_prepare($statement_korIme, $query_korIme)) {
                        mysqli_stmt_bind_param($statement_korIme, 's', $korisnicko_ime);
                        mysqli_stmt_execute($statement_korIme);
                        mysqli_stmt_store_result($statement_korIme);
                    }

                    if(mysqli_stmt_num_rows($statement_korIme) > 0) {
                        echo "
                            <script>
                                alert('Već postoji račun s ovim korisničkim imenom! Molimo ponovite registraciju.');
                            </script>
                        ";
                        echo "<script>location.href = \"registracija.php\";</script>";
                    }
                    else {
                        $dozvola = 0;
                        $rezultat = false;

                        $query = "INSERT INTO korisnik(ime, prezime, korisnicko_ime, lozinka, dozvola)
                                        VALUES(?, ?, ?, ?, ?);";
                        $statement = mysqli_stmt_init($database);
                        if(mysqli_stmt_prepare($statement, $query)) {
                            mysqli_stmt_bind_param($statement, 'ssssi', $ime, $prezime, $korisnicko_ime, $lozinka_hash, $dozvola);
                            mysqli_stmt_execute($statement);
                            $rezultat = true;
                        }

                        if($rezultat) {
                            echo "
                                <script>
                                    alert('Uspješna registracija! Molimo prijavite se za nastavak.');
                                </script>
                            ";
                            echo "<script>location.href = \"prijava.php\";</script>";
                        }
                        else {
                            echo "
                                <script>
                                    alert('Greška prilikom registracije!');
                                </script>
                            ";
                            echo "<script>location.href = \"index.php\";</script>";
                        } 
                    }
                }

            ?>

        </div>

        <?php 
            mysqli_close($database);
        ?>

        <footer>
            <h1 id="glavni_naslov"><img src="Slike/footer.JPG"></h1>
            <p>Luka Dušak | ldusak@tvz.hr | 2021.</p>
            <p>© Copyright. All right reserved.</p>
        </footer>
    </body>
</html>