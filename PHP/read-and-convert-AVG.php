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
//How to avoid CORS:
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: x-requested-with, x-requested-by');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/json; charset=UTF-8');
    die();
}
header('Access-Control-Allow-Origin: *');
$ret = [
    'result' => 'OK',
];
header("Content-Type: application/json; charset=UTF-8");

$obj = json_decode($_GET["x"], false);
$servername = "localhost";
$user = "User";
$password = "Passwd";
$database = "MyDB";
$conn = new mysqli($servername, $user, $password, $database);
$stmt2 = $conn->prepare("SELECT AVG(Temperatur), AVG(Fuktighet) FROM `MyTable`");
$stmt2->bind_param("s", $obj->limit);
$stmt2->execute();
$result = $stmt2->get_result();
$dataGjennomsnitt = $result->fetch_all(MYSQLI_ASSOC);
$tags = array_map(function($dataGjennomsnitt) {
  return array(
    'Temperatur' => $dataGjennomsnitt['AVG(Temperatur)'],
    'Fuktighet' => $dataGjennomsnitt['AVG(Fuktighet)']
  );
}, $tags);
echo json_encode($dataGjennomsnitt);
?>
