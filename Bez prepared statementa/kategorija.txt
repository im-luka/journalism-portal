<!DOCTYPE html>

<?php
    session_start();
?>

<html>

    <?php
        include('connection.php');

        $id = $_GET['id'];
        $kategorija = 'kategorija';

        if($id == 'politika') {
            $kategorija = 'Politika';
        }
        elseif($id == 'sport') {
            $kategorija = 'Sport';
        }
        elseif($id == 'fig') {
            $kategorija = 'Film i Glazba';
        }
    ?>

    <head>
        <title>Frankfurter Allgemeine | <?php echo "$kategorija"; ?></title>
        <meta charset="UTF-8">
        <meta name="author" content="Luka Dušak">
        <meta name="description" content="Frankfurter Allgemeine - Web stranica">
        <meta name="keywords" content="Frankfurter Allgemeine, Frankfurter, Allgemeine, portal, mediji, novine, stranica">
        <link href="https://fonts.googleapis.com/css2?family=Germania+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Stint+Ultra+Condensed&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">
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
                                header("Refresh: 0");
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

                $query = "SELECT * FROM vijesti WHERE kategorija='$kategorija' AND arhiva=0;";
                $rezultat = mysqli_query($database, $query);
                $broj_zapisa = mysqli_num_rows($rezultat);
                $brojac = 1;

                while($redak = mysqli_fetch_array($rezultat)) {
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
                        <br><hr>
                    ";

                    if($brojac == $broj_zapisa) {
                        echo "
                            </section>
                        ";
                    }
                    $brojac += 1;
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