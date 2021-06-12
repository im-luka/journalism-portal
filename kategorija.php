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

                <h1 id="glavni_naslov"><img src="Slike/naslov.JPG"></h1>
            </header>

            <?php 
                $arhiva = 0;

                $query = "SELECT * FROM vijesti WHERE kategorija=? AND arhiva=?;";
                $statement = mysqli_stmt_init($database);
                if(mysqli_stmt_prepare($statement, $query)) {
                    mysqli_stmt_bind_param($statement, 'si', $kategorija, $arhiva);
                    mysqli_stmt_execute($statement);
                    $rezultat = mysqli_stmt_get_result($statement);

                    echo "
                        <section id=\"ka_section\">
                    ";

                    while($redak = mysqli_fetch_assoc($rezultat)) {
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
                    }

                    echo "
                        </section>
                    ";
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