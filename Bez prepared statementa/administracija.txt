<!DOCTYPE html>

<?php
    session_start();
?>

<html>

    <head>
        <title>Frankfurter Allgemeine | Administracija</title>
        <meta charset="UTF-8">
        <meta name="author" content="Luka Dušak">
        <meta name="description" content="Frankfurter Allgemeine - Web stranica">
        <meta name="keywords" content="Frankfurter Allgemeine, Frankfurter, Allgemeine, portal, mediji, novine, stranica">
        <link href="https://fonts.googleapis.com/css2?family=Germania+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Stint+Ultra+Condensed&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">

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
                                echo "<script>location.href = \"administracija.php\";</script>";
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
                if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['level'])) {
                    if($_SESSION['level'] == 0) {
                        echo "
                            <section class=\"unos2\">
                                <h2>Bok " . $_SESSION['username'] . ", kaj ima?</h2>
                                <p>Uspješno si prijavljen, ali nemaš ovlasti administratora pa nažalost ne možeš pristupiti ovoj stranici...</p>
                            </section>
                        ";
                    }
                    else {
                        $query = "SELECT * FROM vijesti;";
                        $rezultat = mysqli_query($database, $query);
                        $broj_zapisa = mysqli_num_rows($rezultat);
                        $brojac = 1;

                        while($redak = mysqli_fetch_array($rezultat)) {
                            if($redak['arhiva'] == 0) {
                                if($brojac == 1) {
                                    echo "
                                        <section id=\"ka_section\">
                                    ";
                                }

                                echo "
                                    <article>
                                        <img src=\"upload_slike/" . $redak['slika'] . "\">
                                        <h3 class=\"podnaslov_clanka\">" . $redak['podnaslov'] . "</h3>
                                        <h2 class=\"naslov_clanka\"><a href=\"clanak.php?id=" . $redak['id'] . "\">" . $redak['naslov'] . "</a></h2>
                                        <p id=\"ka_p\">" . $redak['kratki_sadrzaj'] . "</p>
                                        <p class=\"preporuka\">" . $redak['datum'] . ": ☆ 5</p>
                                    </article>
                                ";

                                echo "
                                    <section class=\"unos\">
                                        <form method=\"POST\" action=\"\" name=\"forma\" enctype=\"multipart/form-data\">
                                            <label for=\"naslov\">Naslov vijesti:</label><br>
                                            <input type=\"text\" name=\"naslov\" id=\"naslov\" value=\"" . $redak['naslov'] . "\"><br>
                                            <span id=\"naslov_error\"></span>
                        
                                            <label for=\"podnaslov\">Podnaslov vijesti:</label><br>
                                            <input type=\"text\" name=\"podnaslov\" id=\"podnaslov\" value=\"" . $redak['podnaslov'] . "\"><br>
                                            <span id=\"podnaslov_error\"></span>
                        
                                            <label for=\"kratki_sadrzaj\">Kratki sadržaj vijesti:</label><br>
                                            <textarea name=\"kratki_sadrzaj\" id=\"kratki_sadrzaj\">" . $redak['kratki_sadrzaj'] . "</textarea><br>
                                            <span id=\"kratki_sadrzaj_error\"></span>
                        
                                            <label for=\"sadrzaj\">Sadržaj vijesti:</label><br>
                                            <textarea name=\"sadrzaj\" id=\"sadrzaj\">" . $redak['sadrzaj'] . "</textarea><br>
                                            <span id=\"sadrzaj_error\"></span>
                        
                                            <label for=\"kategorija\">Kategorija vijesti:</label><br>
                                            <select name=\"kategorija\" id=\"kategorija\">
                                                <option value=\"\" disabled selected>---Odaberite kategoriju---</option>
                                                <option value=\"Politika\">Politika</option>
                                                <option value=\"Sport\">Sport</option>
                                                <option value=\"Film i Glazba\">Film i Glazba</option>
                                            </select><br>
                                            <span id=\"kategorija_error\"></span>
                        
                                            <label for=\"slika\">Slika: </label>
                                            <input type=\"file\" name=\"slika\" id=\"slika\" value=\"" . $redak['slika'] . "\"><br>
                                            <span id=\"slika_error\"></span>
                        
                                            <span>Arhivirati:</span>
                                            <input type=\"checkbox\" name=\"arhiva\" id=\"arhiva\" value=\"potvrdi\">
                                            <label for=\"arhiva\">Da, želim arhivirati.</label><br>

                                            <input type=\"hidden\" name=\"id\" value=\"" . $redak['id'] . "\">
                        
                                            <input type=\"submit\" value=\"Izmijeni\" id=\"gumb\" name=\"izmijeni\">
                                            <input type=\"submit\" value=\"Obriši\" id=\"gumb\" name=\"obrisi\">
                                        </form>
                                    </section>
                                ";

                                echo "<hr>";
                                if($brojac == $broj_zapisa) {
                                    echo "
                                        </section>
                                    ";
                                }
                                $brojac += 1;
                            }
                        }

                        if(isset($_POST['izmijeni'])) {
                            $naslov = $_POST['naslov'];
                            $podnaslov = $_POST['podnaslov'];
                            $kratki_sadrzaj = $_POST['kratki_sadrzaj'];
                            $sadrzaj = $_POST['sadrzaj'];
                            $kategorija = $_POST['kategorija'];
                            $slika = $_FILES['slika']['name'];
                            $direktorij = 'upload_slike/' . $slika;
                            move_uploaded_file($_FILES['slika']['tmp_name'], $direktorij);
                            $datum = date("d.m.Y. H:i:s");
                            $arhiva = 0;
                            if(isset($_POST['arhiva'])) {
                                $arhiva = 1;
                            }

                            $zastavica = true;
                            if(strlen($slika) === 0 || strlen($naslov) === 0 || strlen($podnaslov) === 0 || strlen($kratki_sadrzaj) === 0 || strlen($kategorija) === 0 || strlen($sadrzaj) === 0) {
                                $zastavica = false;
                            }

                            $id = $_POST['id'];

                            $query = "UPDATE vijesti SET naslov='$naslov', podnaslov='$podnaslov', kratki_sadrzaj='$kratki_sadrzaj', sadrzaj='$sadrzaj', kategorija='$kategorija', slika='$slika', arhiva=$arhiva, datum='$datum' 
                                        WHERE id=$id;";
                            if($zastavica == true) {
                                $rezultat = mysqli_query($database, $query);
                            }
                            else {
                                $rezultat = false;
                            }

                            if($rezultat) {
                                echo "
                                    <script>
                                        alert('Podaci su uspješno promijenjeni!');
                                    </script>
                                ";
                            }
                            else {
                                echo "
                                    <script>
                                        alert('Greška prilikom izmjene podataka! Molimo unesite sve podatke.');
                                    </script>
                                ";
                            }
                            echo "<script>location.href = \"index.php\";</script>";
                        }

                        if(isset($_POST['obrisi'])) {
                            $id = $_POST['id'];

                            $query = "DELETE FROM vijesti WHERE id=$id;";
                            $rezultat = mysqli_query($database, $query);

                            if($rezultat) {
                                echo "
                                    <script>
                                        alert('Podaci su uspješno obrisani!');
                                    </script>
                                ";
                            }
                            else {
                                echo "
                                    <script>
                                        alert('Greška prilikom brisanja podataka!');
                                    </script>
                                ";
                            }
                            echo "<script>location.href = \"index.php\";</script>";
                        }
                    }
                }
                else {
                    echo "
                        <section class=\"unos2\">
                            <h2>Niste prijavljeni!</h2>
                            <p>Molimo da se prijavite ili registrirate kako biste mogli pristupiti stranici <em><strong>Administracija</strong></em>!</p>
                            <p><a href=\"prijava.php\">Prijavi se</a></p>
                            <p><a href=\"registracija.php\">Registriraj se</a></p>
                        </section>
                    ";
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