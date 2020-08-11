<!--
 _______                                      ______ _                                  _       __       _ _             _                                              
|__   __|                                    |  ____(_)                                | |     / _|     | | |           | |                                             
   | |_ __ ___  _ __ ___  ___    ___   __ _  | |__   _ _ __  _ __  _ __ ___   __ _ _ __| | __ | |_ _   _| | | _____  ___| | _____  _ __ ___  _ __ ___  _   _ _ __   ___ 
   | | '__/ _ \| '_ ` _ \/ __|  / _ \ / _` | |  __| | | '_ \| '_ \| '_ ` _ \ / _` | '__| |/ / |  _| | | | | |/ / _ \/ __| |/ / _ \| '_ ` _ \| '_ ` _ \| | | | '_ \ / _ \
   | | | | (_) | | | | | \__ \ | (_) | (_| | | |    | | | | | | | | | | | | | (_| | |  |   <  | | | |_| | |   <  __/\__ \   < (_) | | | | | | | | | | | |_| | | | |  __/
   |_|_|  \___/|_| |_| |_|___/  \___/ \__, | |_|    |_|_| |_|_| |_|_| |_| |_|\__,_|_|  |_|\_\ |_|  \__, |_|_|\_\___||___/_|\_\___/|_| |_| |_|_| |_| |_|\__,_|_| |_|\___|
                                       __/ |                                                        __/ |                                                               
                                      |___/                                                        |___/                                                                
 _          __  __    _______                   _____                
| |        |  \/  |  |__   __|                 / ____|               
| |     ___| \  / | __ _| | ___ _ __ ___  _ __| (___   ___ _ __  ___ 
| |    / _ \ |\/| |/ _` | |/ _ \ '_ ` _ \| '_ \\___ \ / _ \ '_ \/ __|
| |___|  __/ |  | | (_| | |  __/ | | | | | |_) |___) |  __/ | | \__ \
|______\___|_|  |_|\__,_|_|\___|_| |_| |_| .__/_____/ \___|_| |_|___/
                                         | |                         
                                         |_| 

Made by Lexus Marcel Andersen.
Contact: Lexus.marcel@gmail.com

Administrated by Tom Kristiansen.
Contact: Tom.kristiansen@TFFK.no
-->  
<?php
$servername = $_POST["server"];
$username = $_POST["usr"];
$password = $_POST["passwd"];
$dbname = $_POST["db"];
$table = $_POST["table"];
$temperatur = $_POST["temp"];
$fuktighet = $_POST["fukt"];
$tid = $_POST["tid"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO " . $table . " (Temperatur, Fuktighet, TidUNIX) VALUES ($temperatur, $fuktighet, $tid)";
if ($conn->query($sql) === TRUE) {
  echo "Data ble lagt inn riktig inn i " . $table . ". Data-arket er nå oppdatert.";
}
else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
