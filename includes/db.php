<?php ob_start (); ?>
<?php
    // // 1-2a. Easiest way to connect to the Database:
    // $connection = mysqli_connect("localhost", "root", "", "cms");


    // 1b. Connection way with defining Constants:
        // 1.1a. Localhost:
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "cms");

    //     // 1.2a. Online:
    // define("DB_HOST", "localhost");
    // define("DB_USER", "mrnobody");
    // define("DB_PASS", "db1Nobody0mr123");
    // define("DB_NAME", "mrnobody");

    // 1c. Connection way with conversion Variables to Constants:
        // 1.1c. Localhost:
    // $db['db_host'] = "localhost";
    // $db['db_user'] = "root";
    // $db['db_pass'] = "";
    // $db['db_name'] = "cms";

        // 1.2c. Online:
    // $db['db_host'] = "localhost";
    // $db['db_user'] = "mrnobody";
    // $db['db_pass'] = "db1Nobody0mr123";
    // $db['db_name'] = "mrnobody";
    // foreach($db as $key => $value) {
    //     // define($key, $value);               // Задали константи
    //     define(strtoupper("$key"), "$value");   // Задали константи і перейменували їх у верхній регістр
    // }

    
    // 2b/2c. Connection to DataBase itself:
    // $connection = mysqli_connect(db_host, db_user, db_pass, db_name);
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    //  // Setting Charset in DB via Query:
    // $query = "SET NAMES 'utf8'";
    // mysqli_query($connection, $query);

        // Setting Charset in DB via Function:
    mysqli_set_charset($connection, "utf8mb4");
    
    /*
    // Just simple verification:
    if ($connection) {
        echo "You're connected";
    } else {
        echo "NOT connected";
    }
    */
?>