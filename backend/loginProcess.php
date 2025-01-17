<?php

session_start();

require "model/connection.php";

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email)) {
        echo "Please Enter Email";
    } else if (empty($password)) {
        echo "Please Enter Password";
    } else {
        $userResultSet = Database::search("SELECT * FROM `users` WHERE `email` = '" . $email . "'");

        if ($userResultSet->num_rows === 1) {
            $user = $userResultSet->fetch_assoc();
            if ($user["password"] && password_verify($password, $user["password"])) {
                $_SESSION["user"] = $user;
                if ($user["user_type"] === "ADMIN") {
                    echo "ADMIN";
                } else if ($user["user_type"] === "PARTNER") {
                    echo "PARTNER";
                } else {
                    echo "Invalid User";
                }
            } else {
                echo "Invalid Password";
            }
        } else {
            echo "Invalid Username";
        }
    }
} else {
    echo "Invalid Request";
}
