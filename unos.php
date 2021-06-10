<!DOCTYPE html>

<?php
    session_start();
?>

<html>

    <head>
        <title>Frankfurter Allgemeine | Forma</title>
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

                var naslov = document.getElementById("naslov");
                var naslov_tekst = naslov.value;
                if(naslov_tekst.length < 10 || naslov_tekst.length > 70) {
                    ispravnaForma = false;
                    naslov.style.border = "2px dashed red";
                    document.getElementById("naslov_error").innerHTML = "Naslov vijesti mora imati između 10 i 70 znakova!<br>";
                }
                else {
                    naslov.style.border = "2px dashed black";
                    document.getElementById("naslov_error").innerHTML = "";
                }

                var podnaslov = document.getElementById("podnaslov");
                var podnaslov_tekst = podnaslov.value;
                if(podnaslov_tekst.length < 10 || podnaslov_tekst.length > 35) {
                    ispravnaForma = false;
                    podnaslov.style.border = "2px dashed red";
                    document.getElementById("podnaslov_error").innerHTML = "Podnaslov vijesti mora imati između 10 i 35 znakova!<br>";
                }
                else {
                    podnaslov.style.border = "2px dashed black";
                    document.getElementById("podnaslov_error").innerHTML = "";
                }

                var kratki_sadrzaj = document.getElementById("kratki_sadrzaj");
                var kratki_sadrzaj_tekst = kratki_sadrzaj.value;
                if(kratki_sadrzaj_tekst.length < 20 || kratki_sadrzaj_tekst.length > 275) {
                    ispravnaForma = false;
                    kratki_sadrzaj.style.border = "2px dashed red";
                    document.getElementById("kratki_sadrzaj_error").innerHTML = "Kratki sadržaj mora imati između 20 i 275 znakova!<br>";
                }
                else {
                    kratki_sadrzaj.style.border = "2px dashed black";
                    document.getElementById("kratki_sadrzaj_error").innerHTML = "";
                }

                var sadrzaj = document.getElementById("sadrzaj");
                var sadrzaj_tekst = sadrzaj.value;
                if(sadrzaj_tekst === "" || sadrzaj_tekst.length === 0) {
                    ispravnaForma = false;
                    sadrzaj.style.border = "2px dashed red";
                    document.getElementById("sadrzaj_error").innerHTML = "Sadržaj članka je obavezan!<br>";
                } 
                else {
                    sadrzaj.style.border = "2px dashed black";
                    document.getElementById("sadrzaj_error").innerHTML = "";
                }

                var kategorija = document.getElementById("kategorija");
                if(kategorija.selectedIndex == 0) {
                    ispravnaForma = false;
                    kategorija.style.border = "2px dashed red";
                    document.getElementById("kategorija_error").innerHTML = "Kategorija je obavezna!<br>";
                }
                else {
                    kategorija.style.removeProperty("border");
                    document.getElementById("kategorija_error").innerHTML = "";
                }

                var slika = document.getElementById("slika");
                var slika_vrijednost = slika.value;
                if(slika_vrijednost === "" || slika_vrijednost.length === 0) {
                    ispravnaForma = false;
                    slika.style.border = "2px dashed red";
                    document.getElementById("slika_error").innerHTML = "Slika je obavezna!<br>";
                }
                else {
                    slika.style.removeProperty("border");
                    document.getElementById("slika_error").innerHTML = "";
                }
                
                return ispravnaForma;
            }
        </script>

    </head>

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
                                echo "<script>location.href = \"unos.php\";</script>";
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
                <hr>
            </header>

            <section class="unos">
                <form method="POST" action="skripta.php" name="forma" enctype="multipart/form-data" onsubmit="return validacija()">
                    <label for="naslov">Naslov vijesti:</label><br>
                    <input type="text" name="naslov" id="naslov" placeholder="Unesite naslov..."><br>
                    <span id="naslov_error" class="error"></span><br>

                    <label for="podnaslov">Podnaslov vijesti:</label><br>
                    <input type="text" name="podnaslov" id="podnaslov" placeholder="Unesite podnaslov..."><br>
                    <span id="podnaslov_error" class="error"></span><br>

                    <label for="kratki_sadrzaj">Kratki sadržaj vijesti:</label><br>
                    <textarea name="kratki_sadrzaj" id="kratki_sadrzaj" placeholder="Unesite kratki sadržaj..."></textarea><br>
                    <span id="kratki_sadrzaj_error" class="error"></span><br>

                    <label for="sadrzaj">Sadržaj vijesti:</label><br>
                    <textarea name="sadrzaj" id="sadrzaj" placeholder="Unesite sadržaj vijesti..."></textarea><br>
                    <span id="sadrzaj_error" class="error"></span><br>

                    <label for="kategorija">Kategorija vijesti:</label><br>
                    <select name="kategorija" id="kategorija">
                        <option value="" disabled selected>---Odaberite kategoriju---</option>
                        <option value="Politika">Politika</option>
                        <option value="Sport">Sport</option>
                        <option value="Film i Glazba">Film i Glazba</option>
                    </select><br>
                    <span id="kategorija_error" class="error"></span><br>

                    <label for="slika">Slika: </label>
                    <input type="file" name="slika" id="slika"><br>
                    <span id="slika_error" class="error"></span><br>

                    <span>Arhivirati:</span>
                    <input type="checkbox" name="arhiva" id="arhiva" value="potvrdi">
                    <label for="arhiva">Da, želim arhivirati.</label><br>

                    <input type="submit" value="Unesi" id="gumb" name="gumb">
                </form>
            </section>

        </div>

        <footer>
            <h1 id="glavni_naslov">Frankfurter Allgemeine</h1>
            <p>Luka Dušak | ldusak@tvz.hr | 2021.</p>
            <p>© Copyright. All right reserved.</p>
        </footer>
    </body>

</html>