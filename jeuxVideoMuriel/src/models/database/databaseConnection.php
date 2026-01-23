<?php
/**
 * connect to the database
 *
 * This function initializes a connection to a MySQL database 
 * using predefined parameters for 
 *    - the server, 
 *    - the username, 
 *    - the password, 
 *    - the database name. 
 * If the connection fails, an error is logged, and an exception is thrown.
 *  
 *  @return mysqli mysqli An instance of the MySQLi connection.
 * @throws Exception If an error occurs during the connection.
 */

 function bddConnect() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $base = "jeuxVideo";

    $connection = new mysqli($servername, $username, $password, $base);
    
    // Check connection
    if ($connection->connect_error) {
        error_log("Erreur de connexion à la base de données : " . $connection->connect_error);
        throw new Exception("Erreur de connexion à la base de données : ");
    }
    
    return $connection;
}


/*

                                base de données et connexion
jeuxvideo
    calendar        SELECT id, idUser, weekDays, startTime, endTime, Town, department, country FROM calendar 
    circle          SELECT id, idLeaderUser, name FROM circle
    department      SELECT idNumber, name FROM department 
    game            SELECT id, nameGame, platformGame, urlPictureGame FROM game 
    gamesuser       SELECT id, idUser, idGame, levelGame, favoriteGame FROM gamesuser
    location        SELECT id, town, department, country FROM location
    matchmaking     SELECT id, idUser, idCircle FROM matchmaking
    message         SELECT id, idCircle, text, dateTime FROM message
    platform        SELECT id, name FROM platform 
    stream          SELECT id, idGame, idUser, dateTime, duration, link FROM stream
    user            SELECT id, firstname, lastname, alias, passwordUser, email, ageRangeUser, token FROM user 


    ouvrir xampp et cliquer sur start à apache et mySQL
     taper sur le web https://localhost/phpmyadmin/  
*/
