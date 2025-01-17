<?php

require "model/connection.php";

if (isset($_POST["name"]) && isset($_POST["location"]) && isset($_POST["price-per-night"]) && isset($_POST["description"])) {

    $name = $_POST["name"];
    $location = $_POST["location"];
    $pricePerNight = $_POST["price-per-night"];
    $description = $_POST["description"];

    if (empty($name)) {
        echo "Please Enter Name";
    } else if (empty($location)) {
        echo "Please Enter Location";
    } else if (empty($pricePerNight)) {
        echo "Please Enter Price per Night";
    } else if (!is_numeric($pricePerNight) || $pricePerNight <= 0) {
        echo "Please Enter a Valid Price per Night (must be a positive number)";
    } else if (empty($description)) {
        echo "Please Enter Description";
    } else {
        if (isset($_FILES["image-url"])) {
            $imageUrl = $_FILES["image-url"];

            if ($imageUrl["error"] !== UPLOAD_ERR_OK) {
                echo "Error uploading the file. Please try again.";
                exit();
            }

            $maxFileSize = 2 * 1024 * 1024;
            if ($imageUrl["size"] > $maxFileSize) {
                echo "File size exceeds the maximum limit of 2 MB.";
                exit();
            }

            $allowed_image_extension = array("png", "jpg", "jpeg");
            $file_extension = pathinfo($imageUrl["name"], PATHINFO_EXTENSION);

            if (in_array($file_extension, $allowed_image_extension)) {
                $fileName = "resources/images/hotels/" . uniqid() . "." . $file_extension;
                move_uploaded_file($imageUrl["tmp_name"], $fileName);

                Database::iud("INSERT INTO `hotels`(`name`, `location`, `price_per_night`, `description`, `image_url`) 
                VALUES('" . $name . "', '" . $location . "', '" . $pricePerNight . "', '" . $description . "', '" . $fileName . "')");

                echo "Success";
            } else {
                echo "Please Select a Valid Image. You Can Select Only PNG, JPG, or JPEG Files";
            }
        } else {
            echo "Please Select Image";
        }
    }
} else {
    echo "Invalid Request. Missing Required Parameters.";
}
