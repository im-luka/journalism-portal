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

                <h1 id="glavni_naslov"><img src="Slike/naslov.JPG"></h1><hr>
            </header>

            <?php
                $id = $_GET['id'];

                $query = "SELECT * FROM vijesti WHERE id=?;";
                $statement = mysqli_stmt_init($database);
                if(mysqli_stmt_prepare($statement, $query)) {
                    mysqli_stmt_bind_param($statement, 'i', $id);
                    mysqli_stmt_execute($statement);

                    $rezultat = mysqli_stmt_get_result($statement);
                    $redak = mysqli_fetch_assoc($rezultat);

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
                            <p><span id=\"prvo_slovo\"><b>" . $redak['sadrzaj'][0] . "</b></span>" . substr($redak['sadrzaj'], 1) . "</p>
                        </section>
                    ";
                }
                else {
                    echo "<p>Greška prilikom pristupa članku.</p>";
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