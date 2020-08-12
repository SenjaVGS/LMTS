# Quick Info

This README file has two langues, the first part is written in norwegian.
The second part is written in english, I will go over what systems you will require
and there is a "README.md" file in each folder with instructions on what you will
have to do to adopt this system for yourself and your'e needs.

# Norsk Bokmål
# LeMaTempSens Prosjekt






# English
# LeMaTempSens Project 

This project was made because we had a need for measuring temperatures and humidity on different locations, but there was one challange. 
We had to do it so it would cost us the least amount of money over time, we had to not rely on any third-party service too.
So! here you have all that you need to set up a cheap measuring system for either your'e home or your'e buisness.

# Our setup

Our systems is set up to so we have a Web-Server installed as a LAMP(Linux, Apache2, MySQL/MariaDB and PHP) Stack,
we then have multiple RPI's(Raspberry Pi 3B+) install with NOOBS. They are running a Python3 script that reads from 
a DHT11/DHT22 sensor, it also makes a UNIX timestamp. We use CRON to run the script once an hour, when the script 
gets the readings from the sensor it sends over the temperature, humidity, UNIX timestamp and info about the database 
by using POST. Server side there is a universal PHP script that takes the data and the info about the database, 
then it logs into the database with the info it recived and runs a query to log the sensor reading and UNIX time 
at the time of when the script was ran.

//Paragraf 2 om graf oppsette//

//Paragraf 3 om "legge-til-ny.php"//

# Hardware and software required
