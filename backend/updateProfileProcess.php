<?php

session_start();

require "model/connection.php";

if (isset($_SESSION["user"])) {
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])) {

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        if (empty($name)) {
            echo "Please Enter Name";
        } else if (empty($email)) {
            echo "Please Enter Email";
        } else if (empty($password)) {
            echo "Please Enter Password";
        } else {
            $userResultSet = Database::search("SELECT * FROM `users` WHERE `email` = '" . $email . "'");

            if ($userResultSet->num_rows === 0) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                Database::iud("UPDATE `users` SET `name` = '" . $name . "', `email` = '" . $email . "', `password` = " . $hashedPassword . "' WHERE `id` = '" . $_SESSION["user"]["id"] . "'");
                $_SESSION["user"]["name"] = $name;
                $_SESSION["user"]["email"] = $email;
                $_SESSION["user"]["password"] = $password;
                echo "Success";
            } else {
                if ($_SESSION["user"]["email"] === $email) {
                    Database::iud("UPDATE `users` SET `name` = '" . $name . "', `email` = '" . $email . "', `password` = " . $hashedPassword . "' WHERE `id` = '" . $_SESSION["user"]["id"] . "'");
                    $_SESSION["user"]["name"] = $name;
                    $_SESSION["user"]["email"] = $email;
                    $_SESSION["user"]["password"] = $password;
                    echo "Success";
                } else {
                    echo "Username already exist";
                }
            }
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo "Authentication Failed";
}
