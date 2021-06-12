<!DOCTYPE html>

<?php
    session_start();
?>

<html>

    <head>
        <title>Frankfurter Allgemeine | Početna</title>
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
                                echo "<script>location.href = \"index.php\";</script>";
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

                #SECTION POLITIKA
                $query_pomoc_politika = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Politika';";
                $rezultat_pomoc_politika = mysqli_query($database, $query_pomoc_politika);
                $do_politika = mysqli_num_rows($rezultat_pomoc_politika);
                $od_politika = $do_politika - 3;

                $query_politika = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Politika' LIMIT $od_politika, $do_politika;";
                $rezultat_politika = mysqli_query($database, $query_politika);
                $brojac_politika = 0;

                while($redak = mysqli_fetch_array($rezultat_politika)) {
                    if($brojac_politika == 0) {
                        echo "
                            <section class=\"vijesti\">
                            <aside class=\"kateg\">
                                <hr>
                                <p>" . $redak['kategorija'] . "</p>
                            </aside>
                        ";
                    }

                    echo "
                        <article class=\"prvi\">
                            <img class=\"slika\" src=\"" . "upload_slike/" . $redak['slika'] . "\">
                            <h3 class=\"podnaslov_clanka\">" . $redak['podnaslov'] . "</h3>
                            <h2 class=\"naslov_clanka\"><a href=\"clanak.php?id=" . $redak['id'] . "\">" . $redak['naslov'] . "</a></h2>
                            <p class=\"opis\">" . $redak['kratki_sadrzaj'] . "</p>
                            <p class=\"preporuka\">" . $redak['datum'] . ": ☆ 5</p>
                        </article>
                    ";

                    
                    if($brojac_politika == 2) {
                        echo "
                            </section>
                        ";
                    }
                    $brojac_politika += 1;
                }

                #SECTION SPORT
                $query_pomoc_sport = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Sport';";
                $rezultat_pomoc_sport = mysqli_query($database, $query_pomoc_sport);
                $do_sport = mysqli_num_rows($rezultat_pomoc_sport);
                $od_sport = $do_sport - 3;

                $query_sport = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Sport' LIMIT $od_sport, $do_sport;";
                $rezultat_sport = mysqli_query($database, $query_sport);
                $brojac_sport = 0;

                while($redak = mysqli_fetch_array($rezultat_sport)) {
                    if($brojac_sport == 0) {
                        echo "
                            <section class=\"vijesti\">
                            <aside class=\"kateg\">
                                <hr>
                                <p>" . $redak['kategorija'] . "</p>
                            </aside>
                        ";
                    }

                    echo "
                        <article class=\"prvi\">
                            <img class=\"slika\" src=\"" . "upload_slike/" . $redak['slika'] . "\">
                            <h3 class=\"podnaslov_clanka\">" . $redak['podnaslov'] . "</h3>
                            <h2 class=\"naslov_clanka\"><a href=\"clanak.php?id=" . $redak['id'] . "\">" . $redak['naslov'] . "</a></h2>
                            <p class=\"opis\">" . $redak['kratki_sadrzaj'] . "</p>
                            <p class=\"preporuka\">" . $redak['datum'] . ": ☆ 5</p>
                        </article>
                    ";

                    
                    if($brojac_sport == 2) {
                        echo "
                            </section>
                        ";
                    }
                    $brojac_sport += 1;
                }

                #SECTION FILM I GLAZBA
                $query_pomoc_fig = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Film i Glazba';";
                $rezultat_pomoc_fig = mysqli_query($database, $query_pomoc_fig);
                $do_fig = mysqli_num_rows($rezultat_pomoc_fig);
                $od_fig = $do_fig - 3;

                $query_fig = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='Film i Glazba' LIMIT $od_fig, $do_fig;";
                $rezultat_fig = mysqli_query($database, $query_fig);
                $brojac_fig = 0;

                while($redak = mysqli_fetch_array($rezultat_fig)) {
                    if($brojac_fig == 0) {
                        echo "
                            <section class=\"vijesti\">
                            <aside class=\"kateg\">
                                <hr>
                                <p>" . $redak['kategorija'] . "</p>
                            </aside>
                        ";
                    }

                    echo "
                        <article class=\"prvi\">
                            <img class=\"slika\" src=\"" . "upload_slike/" . $redak['slika'] . "\">
                            <h3 class=\"podnaslov_clanka\">" . $redak['podnaslov'] . "</h3>
                            <h2 class=\"naslov_clanka\"><a href=\"clanak.php?id=" . $redak['id'] . "\">" . $redak['naslov'] . "</a></h2>
                            <p class=\"opis\">" . $redak['kratki_sadrzaj'] . "</p>
                            <p class=\"preporuka\">" . $redak['datum'] . ": ☆ 5</p>
                        </article>
                    ";

                    
                    if($brojac_fig == 2) {
                        echo "
                            </section>
                        ";
                    }
                    $brojac_fig += 1;
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