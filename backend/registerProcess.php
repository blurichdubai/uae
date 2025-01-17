<?php

require "model/connection.php";

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
            Database::iud("INSERT INTO `users`(`name`, `email`, `password`, `user_type`) VALUES('" . $name . "', '" . $email . "', " . $hashedPassword . "', 'PARTNER')");
            echo "Success";
        } else {
            echo "Username already exist";
        }
    }
} else {
    echo "Invalid Request";
}
