<!DOCTYPE HTML>
  <html>
 <!--
 I worked with this function without my boss knowing about it, even though I was told that further development had stopped, He was not so happy when he found out. 
 But when I explained to him how easy the documentation work would be and how easy it would be for everyone else, he understood it very well and said good job. 
 And my boss have learned that sometimes you need to develop a little bit more even the development has stopped. 

 Boss comment: ohh yehh i have learnd. i also learn to listen better to the suggestions. is it easy, no but i am learning.
 
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
  <head>
    <link href="/Tools/CSS/ny-bruker.css" type="text/css" rel="stylesheet"/>
  </head>
  <body>
    <div id="top-nav">
      <?php include '/var/www/html/Tools/PHP/PHP-uni/nav-bar-uni.php'; ?>
    <div id="wrapper">
        <div id="send_data">
          <form method="post" action="/Tools/PHP/PHP-uni/Legge-til-ny.php">
          <textarea name="newUsr" placeholder="Skriv inn Brukernavn"></textarea>
            <br>
          <textarea name="newUsrPasswd" placeholder="Skriv inn Passord"></textarea>
            <br>
          <textarea name="newDataBase" placeholder="Skriv inn Database"></textarea>
            <br>
          <textarea name="serialNumber" placeholder="Skriv inn Serienummer"></textarea>
            <br>
          <input type="submit" name="newQuery" value="Opprett Ny Database">
        </form>
      </div>
      
    </body>
  </html>
