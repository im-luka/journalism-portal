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

                <h1 id="glavni_naslov"><img src="Slike/naslov.JPG"></h1>
            </header>

            <?php
                $arhiva = 0;

                #SECTION POLITIKA
                $kategorijaP = 'Politika';
                $query_pomoc_politika = "SELECT * FROM vijesti WHERE arhiva=? AND kategorija=?;";
                $statement_pomoc_politika = mysqli_stmt_init($database);
                if(mysqli_stmt_prepare($statement_pomoc_politika, $query_pomoc_politika)) {
                    mysqli_stmt_bind_param($statement_pomoc_politika, 'is', $arhiva, $kategorijaP);
                    mysqli_stmt_execute($statement_pomoc_politika);
                    mysqli_stmt_store_result($statement_pomoc_politika);
                }
                $do_politika = mysqli_stmt_num_rows($statement_pomoc_politika);
                $od_politika = $do_politika - 3;

                $query_politika = "SELECT * FROM vijesti WHERE arhiva=? AND kategorija=? LIMIT ?, ?;";
                $statement_politika = mysqli_stmt_init($database);
                if(mysqli_stmt_prepare($statement_politika, $query_politika)) {
                    mysqli_stmt_bind_param($statement_politika, 'isii', $arhiva, $kategorijaP, $od_politika, $do_politika);
                    mysqli_stmt_execute($statement_politika);
                    $rezultat_politika = mysqli_stmt_get_result($statement_politika);
                    $brojac_politika = 0;

                    while($redak = mysqli_fetch_assoc($rezultat_politika)) {
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
                }


                #SECTION SPORT
                $kategorijaS = 'Sport';
                $query_pomoc_sport = "SELECT * FROM vijesti WHERE arhiva=? AND kategorija=?;";
                $statement_pomoc_sport = mysqli_stmt_init($database);
                if(mysqli_stmt_prepare($statement_pomoc_sport, $query_pomoc_sport)) {
                    mysqli_stmt_bind_param($statement_pomoc_sport, 'is', $arhiva, $kategorijaS);
                    mysqli_stmt_execute($statement_pomoc_sport);
                    mysqli_stmt_store_result($statement_pomoc_sport);
                }
                $do_sport = mysqli_stmt_num_rows($statement_pomoc_sport);
                $od_sport = $do_sport - 3;

                $query_sport = "SELECT * FROM vijesti WHERE arhiva=? AND kategorija=? LIMIT ?, ?;";
                $statement_sport = mysqli_stmt_init($database);
                if(mysqli_stmt_prepare($statement_sport, $query_sport)) {
                    mysqli_stmt_bind_param($statement_sport, 'isii', $arhiva, $kategorijaS, $od_sport, $do_sport);
                    mysqli_stmt_execute($statement_sport);
                    $rezultat_sport = mysqli_stmt_get_result($statement_sport);
                    $brojac_sport = 0;

                    while($redak = mysqli_fetch_assoc($rezultat_sport)) {
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
                }


                #SECTION FILM I GLAZBA
                $kategorijaFIG = 'Film i Glazba';
                $query_pomoc_FIG = "SELECT * FROM vijesti WHERE arhiva=? AND kategorija=?;";
                $statement_pomoc_FIG = mysqli_stmt_init($database);
                if(mysqli_stmt_prepare($statement_pomoc_FIG, $query_pomoc_FIG)) {
                    mysqli_stmt_bind_param($statement_pomoc_FIG, 'is', $arhiva, $kategorijaFIG);
                    mysqli_stmt_execute($statement_pomoc_FIG);
                    mysqli_stmt_store_result($statement_pomoc_FIG);
                }
                $do_FIG = mysqli_stmt_num_rows($statement_pomoc_FIG);
                $od_FIG = $do_FIG - 3;

                $query_FIG = "SELECT * FROM vijesti WHERE arhiva=? AND kategorija=? LIMIT ?, ?;";
                $statement_FIG = mysqli_stmt_init($database);
                if(mysqli_stmt_prepare($statement_FIG, $query_FIG)) {
                    mysqli_stmt_bind_param($statement_FIG, 'isii', $arhiva, $kategorijaFIG, $od_FIG, $do_FIG);
                    mysqli_stmt_execute($statement_FIG);
                    $rezultat_FIG = mysqli_stmt_get_result($statement_FIG);
                    $brojac_FIG = 0;

                    while($redak = mysqli_fetch_assoc($rezultat_FIG)) {
                        if($brojac_FIG == 0) {
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
    
                        
                        if($brojac_FIG == 2) {
                            echo "
                                </section>
                            ";
                        }
                        $brojac_FIG += 1;
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