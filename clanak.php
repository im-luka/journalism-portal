<!DOCTYPE html>

<?php
    session_start();
?>

<html>

    <head>
        <title>Frankfurter Allgemeine | Članak</title>
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
                                echo "<script>location.href = \"clanak.php\";</script>";
                            }
                        }
                    ?>
                </div>

                <div class="login">
                    <a href="prijava.php">Prijava</a>
                    <span> / </span>
                    <a href="registracija.php">Registracija</a>
                </div><br><br>

                <h1 id="glavni_naslov">Frankfurter Allgemeine</h1><hr>
            </header>

            <?php
                $id = $_GET['id'];

                $query = "SELECT * FROM vijesti WHERE id=$id;";
                $rezultat = mysqli_query($database, $query);
                $redak = mysqli_fetch_array($rezultat);

                echo "
                    <section class=\"clanak_naslov\">
                        <h3>" . $redak['podnaslov'] . "</h3>
                        <h1>" . $redak['naslov'] . "</h1>
                        <p class=\"preporuka\">Aktualizirano: " . $redak['datum'] . "</p>
                    </section>
                ";

                echo "
                    <section class=\"clanak_slika\">
                        <img src=\"upload_slike/" . $redak['slika'] . "\">
                    </section>
                ";

                echo "
                    <section class=\"clanak_opis\">
                        <h2>" . $redak['kratki_sadrzaj'] . "</h2>
                        <p>" . $redak['sadrzaj'] . "</p>
                    </section>
                ";
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