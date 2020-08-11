<!DOCTYPE HTML>
<html>

<!--

I worked with this function without my boss knowing about it, even though I was told that further development had stopped, He was not so happy when he found out. 
But when I explained to him how easy the documentation work would be and how easy it would be for everyone else, he understood it very well and said good job.
And my boss have learned that sometimes you need to develop a little bit more even the development has stoppe

Boss comment: ohh yehh i have learnd.

-->
  <head>
    <link href="/Tools/CSS/LeggeTilNyBruker.css" type="text/css" rel="stylesheet"/>
  </head>
  <body>
    <div id="top-nav">
      <?php include '/var/www/html/Tools/PHP/PHP-uni/nav-bar-uni.php'; ?>
    </div>
    <div id="responseText">
    <?php
    $errorImg = '"/Tools/media/error.svg"';
    $idError = '"error"';
    $successImg = '"/Tools/media/success.svg"';
    $idSuccess = '"success"';
    $host = "localhost";
    $adminUsr = "admin";
    $adminPasswd = "LeMaTempSens";
    if (isset($_POST["newQuery"])) {
      $newUsr = $_POST["newUsr"];
      $newUsrPasswd = $_POST["newUsrPasswd"];
      $newDataBase = $_POST["newDataBase"];
      $serialNumber = $_POST["serialNumber"];
      $infoTable = "`LMTS-Brukere`";
      $infoDB = "Brukere";
      $conn = new mysqli($host, $adminUsr, $adminPasswd);
      if ($conn->connect_error) {
        echo "<p>Feilet å logge inn i DB. </p>";
      }
      else {
        //Lage en ny Database
        $sqlDB = "CREATE DATABASE " . $newDataBase;
        if ($conn->query($sqlDB) === TRUE) {
          echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Å lage DB funket. </p>";
        }
        else {
          echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Feilet på å lage ny database. </p>";
        }
        //Lage en ny tabell inne i den nye databasen
        $sqlTable = "CREATE TABLE `" . $newDataBase ."`." . $newDataBase . " ( `ID` BIGINT NOT NULL AUTO_INCREMENT , `Temperatur` FLOAT NULL DEFAULT NULL , `Fuktighet` FLOAT NULL DEFAULT NULL , `Tid` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `TidUnix` INT NULL DEFAULT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB";
        if ($conn->query($sqlTable) === TRUE) {
          echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Å lage tabell funket </p>";
        }
        else {
          echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Feilet på å lage ny tabell. </p>";
        }
        //Lage ny bruker og passord
        $sqlUsr = "CREATE USER '" . $newUsr . "'@'localhost' IDENTIFIED BY '" . $newUsrPasswd . "'";
        if ($conn->query($sqlUsr) === TRUE) {
          echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Å lage ny bruker funket. </p>";
        }
        else {
          echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Feilet på å lage ny bruker. </p>";
        }
        //Gi rettigheter for den nye brukeren.
        $sqlPrivliges = "GRANT USAGE ON *.* TO '" . $newUsr . "'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
        if ($conn->query($sqlPrivliges) === TRUE) {
          echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Å gi rettigheter til " . $newUsr . " funket </p>";
        }
        else {
          echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Feilet på å gi rettigheter til " . $newUsr . ". </p>";
        }
        //Gi rettigheter for den nye brukeren på den nye databasen.
        $sqlPrivligesDB = "GRANT ALL PRIVILEGES ON `" . $newDataBase . "`.* TO '" . $newUsr ."'@'localhost'";
        if ($conn->query($sqlPrivligesDB) === TRUE) {
          echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Å gi rettigheter på " . $newDataBase ." til " . $newUsr . " funket. </p>";
        }
        else {
          echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Feilet å gi rettigheter til " . $newUsr . " på " . $newDataBase . ". </p>";
        }
        //Lukke koblingen mellom PHP scriptet og databasen.
        $conn->close();
      }

      //Legge inn i "LMTS-Brukere" under databasen "Brukere".
      $conn1 = new mysqli($host, $adminUsr, $adminPasswd, $infoDB);
      if ($conn1->connect_error) {
        echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Feilet å logge inn i `Brukere`</p>";
      }
      else {
        $sql = "INSERT INTO " . $infoTable . "
         (`Brukernavn`, `Passord`, `Host`, `Tabell`, `Enhet`)
        VALUES ('$newUsr', '$newUsrPasswd', '$host', '$newDataBase', '$serialNumber')";

        if ($conn1->query($sql) === TRUE) {
          echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Fikk lagt " . $newUsr . " inn i Brukere. </p>";
        }
        else {
          echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Error: " . $sql . "<br>" . $conn1->error . "</p>";
        }
        $conn1->close();
      }

      //Lage graf filene som er nødvendig.

      mkdir('/var/www/html/Tools/PHP/php-graf-' . $serialNumber, 0777, true);

      copy('/var/www/html/Tools/Maler/read-and-convert-24hr-Mal.php', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-24hr-Mal.php');
      copy('/var/www/html/Tools/Maler/read-and-convert-totalt-Mal.php', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-totalt-Mal.php');
      copy('/var/www/html/Tools/Maler/read-and-convert-CSV-Mal.php', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-CSV-Mal.php');
      copy('/var/www/html/Tools/Maler/read-and-convert-AVG-Mal.php', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-AVG-Mal.php');
      copy('/var/www/html/Tools/Maler/Graf-Mal.php', '/var/www/html/Linker/Grafer/Graf-Mal.php');

      $writingGraf = fopen('/var/www/html/Linker/Grafer/Graf-Mal.tmp', 'w');
      $readingGraf = fopen('/var/www/html/Linker/Grafer/Graf-Mal.php', 'r');
      $writing24hr = fopen('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-24hr-Mal.tmp', 'w');
      $reading24hr = fopen('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-24hr-Mal.php', 'r');
      $writingTotalt = fopen('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-totalt-Mal.tmp', 'w');
      $readingTotalt = fopen('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-totalt-Mal.php', 'r');
      $writingCSV = fopen('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-CSV-Mal.tmp', 'w');
      $readingCSV = fopen('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-CSV-Mal.php', 'r');
      $writingAVG = fopen('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-AVG-Mal.tmp', 'w');
      $readingAVG = fopen('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-AVG-Mal.php', 'r');
      $replaced = false;

      //////////////////// .htaccess ////////////////////

      //copy('var/www/html/Tools/Maler/.htaccess', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/.htaccess');

      //////////////////// 24hr ////////////////////

      while (!feof($reading24hr)) {
        $line = fgets($reading24hr);
        if (stristr($line,'changeMe')) {
          $line ='
          $user = "' . $newUsr . '";
          $password = "' . $newUsrPasswd . '";
          $database = "' . $newDataBase . '";
          $conn = new mysqli($servername, $user, $password, $database);
          $stmt = $conn->prepare("SELECT ID, Temperatur, Fuktighet, TidUNIX FROM `' . $newDataBase . '` ORDER BY ID DESC LIMIT 24");';
          $replaced = true;
          //echo "Klarte 24hr. </br>";
        }
        fputs($writing24hr, $line);
      }
      fclose($reading24hr); fclose($writing24hr);
      if ($replaced)
      {
        rename('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-24hr-Mal.tmp', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-24hr.php');
        echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Fikk laget, plassert og byttet navn på 'read-and-convert-24hr.php'. </p>";
        unlink('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-24hr-Mal.php');
      } else {
        unlink('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-24hr.tmp');
        echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Klarte ikke å lage, plassere eller byttet navn på 'read-and-convert-24hr.php'. </p>";
      }

      //////////////////// Totalt ////////////////////

      while (!feof($readingTotalt)) {
        $line = fgets($readingTotalt);
        if (stristr($line,'changeMe')) {
          $line = '
          $user = "' . $newUsr . '";
          $password = "' . $newUsrPasswd . '";
          $database = "' . $newDataBase . '";
          $conn = new mysqli($servername, $user, $password, $database);
          $stmt = $conn->prepare("SELECT ID, Temperatur, Fuktighet, TidUNIX FROM `' . $newDataBase . '` ORDER BY ID DESC");';
          $replaced = true;
          //echo "Klarte Totalt. </br>";
        }
        fputs($writingTotalt, $line);
      }
      fclose($readingTotalt); fclose($writingTotalt);
      if ($replaced)
      {
        rename('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-totalt-Mal.tmp', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-totalt.php');
        echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Fikk laget, plassert og byttet navn på 'read-and-convert-totalt.php'. </p>";
        unlink('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-totalt-Mal.php');
      } else {
        unlink('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-totalt.tmp');
        echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Klarte ikke å lage, plassere eller bytte navn på 'read-and-convert-totalt.php'.</p>";
      }

      //////////////////// CSV ////////////////////

      while (!feof($readingCSV)) {
        $line = fgets($readingCSV);
        if (stristr($line,'changeMe')) {
          $line = '
          $user = "' . $newUsr . '";
          $password = "' . $newUsrPasswd . '";
          $database = "' . $newDataBase . '";
          $conn = new mysqli($servername, $user, $password, $database);
          $stmt = $conn->prepare("SELECT ID, Temperatur, Fuktighet, TidUNIX FROM `' . $newDataBase . '` ORDER BY ID DESC LIMIT 24");';
          $replaced = true;
          //echo "Klarte CSV. </br>";
        }
        fputs($writingCSV, $line);
      }
      fclose($readingCSV); fclose($writingCSV);
      if ($replaced)
      {
        rename('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-CSV-Mal.tmp', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-CSV.php');
        echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Fikk laget, plassert og byttet navn på 'read-and-convert-CSV.php'. </p>";
        unlink('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-CSV-Mal.php');
      } else {
        unlink('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-CSV.tmp');
        echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Klarte ikke å lage, plassere eller bytte navn på 'read-and-convert-CSV.php'. </p>";
      }

      //////////////////// AVG ////////////////////

      while (!feof($readingAVG)) {
        $line = fgets($readingAVG);
        if (stristr($line,'changeMe')) {
          $line ='
          $user = "' . $newUsr . '";
          $password = "' . $newUsrPasswd . '";
          $database = "' . $newDataBase . '";
          $conn = new mysqli($servername, $user, $password, $database);
          $stmt = $conn->prepare("SELECT AVG(Temperatur), AVG(Fuktighet) FROM `' . $newDataBase . '`");';
          $replaced = true;
          //echo "Klarte AVG. </br>";
        }
        fputs($writingAVG, $line);
      }
      fclose($readingAVG); fclose($writingAVG);
      if ($replaced)
      {
        rename('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-AVG-Mal.tmp', '/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-AVG.php');
        echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Fikk laget, plassert og byttet navn på 'read-and-convert-AVG.php'. </p>";
        unlink('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-AVG-Mal.php');
      } else {
        unlink('/var/www/html/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-AVG.tmp');
        echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Klarte ikke å lage, plassere eller byttet navn på 'read-and-convert-AVG.php'. </p>";
      }

      //////////////////// Graf ////////////////////

      $linkHelp = 'http://';
      $writingGraf = fopen('/var/www/html/Linker/Grafer/Graf-Mal.tmp', 'w');
      $readingGraf = fopen('/var/www/html/Linker/Grafer/Graf-Mal.php', 'r');
      $replaced = false;
      while (!feof($readingGraf)) {
        $line = fgets($readingGraf);
        if (stristr($line,'changeMeLink24hr')) {
          $line = '              $.getJSON("' . $linkHelp . '10.12.3.26/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-24hr.php", parseData24hr);
          function parseData24hr(result) {
            for (var i = 0; i < result.length; i++) {
              dataTemp24timer.push({
                x: result[i].TidUNIX*1000,
                y: result[i].Temperatur
              });
              dataFukt24timer.push({
                x: result[i].TidUNIX*1000,
                y: result[i].Fuktighet
              });
            }
            chart24timer.render();
          }
          $.getJSON("' . $linkHelp . '10.12.3.26/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-totalt.php", parseDataTotalt);';
          $replaced = true;
          //echo "Klarte Graf del: 1. </br>";
        }
        $click = "'click'";
        $myButton = "'myButton'";
        fputs($writingGraf, $line);
        $line = fgets($readingGraf);
        if (stristr($line,'changeMeLinkCSV')) {
          $line = '              const jsonUrl = "' . $linkHelp . '10.12.3.26/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-CSV.php";
          const res = await fetch(jsonUrl);
          const json = await res.json();
          const data = json.map(row => ({
            ID: row.ID,
            Temperatur: row.Temperatur + "*C",
            Fuktighet: row.Fuktighet + "%",
            Tid: row.Tid,
          }));
          const csvData = objectToCsv(data);
          download(csvData);
        };
        (function() {
          const button = document.getElementById('. $myButton . ');
          button.addEventListener(' . $click . ', getReport);
        })();
      </script>
      </div>
      <div id="gjennomsnitt">
      <table id="tableID">
      <tr id="AVGtittel">
        <th>Gjennomsnitt Totalt</th>
      </tr>
      <tr id="AVGtemp">
        <th> Temperatur: </th>
        <th id="tempAVG"></th>
      </tr>
      <tr id="AVGfukt">
        <th>Fuktighet: </th>
        <th id="fuktAVG"></th>
      </tr>
      <script type="text/javascript">
        var tempAVG = [];
        var fuktAVG = [];
        $.getJSON("' . $linkHelp . '10.12.3.26/Tools/PHP/php-graf-' . $serialNumber . '/read-and-convert-AVG.php", parseDataAVG);';
          $replaced = true;
          //echo "Klarte Graf del: 2. </br>";
        }
        fputs($writingGraf, $line);
      }
      fclose($readingGraf);
      fclose($writingGraf);
      if ($replaced) {
        rename('/var/www/html/Linker/Grafer/Graf-Mal.tmp', '/var/www/html/Linker/Grafer/Graf-' . $serialNumber . '.php');
        echo "<p><img id =" . $idSuccess . " src=" . $successImg . "/>Fikk laget, plassert og byttet navn på 'Graf-" . $serialNumber . ".php'. </p>";
        unlink('/var/www/html/Linker/Grafer/Graf-Mal.php');
      }
      else {
        unlink('/var/www/html/Linker/Grafer/Graf-Mal.tmp');
        unlink('/var/www/html/Linker/Grafer/Graf-Mal.php');
        echo "<p><img id =" . $idError . " src=" . $errorImg . "/>Klarte ikke å lage, plassere eller byttet navn på 'Graf-" . $serialNumber . ".php'. </p>";
      }
    }
    ?>
    </div>
  </body>
</html>
