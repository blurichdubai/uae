<?php

require "model/connection.php";

if (isset($_POST["name"]) && isset($_POST["services"]) && isset($_POST["price"]) && isset($_POST["promo-offer"])) {

    $name = $_POST["name"];
    $services = $_POST["services"];
    $price = $_POST["price"];
    $promoOffer = $_POST["promo-offer"];

    if (empty($name)) {
        echo "Please Enter Name";
    } else if (empty($services)) {
        echo "Please Enter Services";
    } else if (empty($price)) {
        echo "Please Enter Price";
    } else if (!is_numeric($price) || $price <= 0) {
        echo "Please Enter a Valid Price (must be a positive number)";
    } else if (empty($promoOffer)) {
        echo "Please Enter Promo Offer";
    } else {
        Database::iud("INSERT INTO `combo_packages`(`name`, `services`, `price`, `promo_offer`) 
                VALUES('" . $name . "', '" . $services . "', '" . $price . "', '" . $promoOffer . "')");
        echo "Success";
    }
} else {
    echo "Invalid Request. Missing Required Parameters.";
}
