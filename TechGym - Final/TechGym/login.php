<?php
require 'database.php';
session_start();

//$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pass = $_POST["password"];

    if (!empty($email) && !empty($pass)) {
        $mysqli = require __DIR__ . "/database.php";

        $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($email));

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();

        if ($user) {
            $hashedPassword = $user["password_hash"];
            
            echo "Inputted Password: " . $pass . "<br>";
            echo "Hashed Password from Database: " . $hashedPassword . "<br>";
            
            if (password_verify($pass, $hashedPassword)) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $user["id"];
                header("Location: index.php");
                exit;
            } else {
                //$is_invalid = true;
                echo ("Wrong password");
            }
        } else {
            //$is_invalid = true;
            echo ("User not found");
        }
    } else {
        //$is_invalid = true;
        echo ("Empty");
    }
}
?>
