<?php

$conn = mysqli_connect("localhost","root","","image");

if (isset($_POST['submit'])) {
    // Collect form data
    $name = $_POST['name'];
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;

    // Allowed MIME types for image validation
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];

    $fileMimeType = mime_content_type($tempname);

    if (preg_match('/[%\x00]/', $filename)) 
    {
        echo "File name contains null byte.";
        exit();
    }


    // Validate the file MIME type
    if (in_array($fileMimeType, $allowedMimeTypes)) {
        // SQL query to insert the name and file name into the database
        $sql = "INSERT INTO image (name, filename) VALUES ('$name', '$filename')";

        // Execute the SQL query
        if (mysqli_query($conn, $sql)) {
            // Move the uploaded file to the specified folder
            if (move_uploaded_file($tempname, $folder)) {
                echo "Image uploaded and record inserted successfully.";
            } else {
                echo "Failed to upload the image.";
            }
        } else {
            echo "Failed to insert record into the database.";
        }
    } else {
        echo "Invalid file type. Only JPEG, PNG, WebP, and JPG are allowed.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image insert</title>
</head>
<style>
    tr{
        border:2px solid black;
    }
    td{
        border:2px solid black;
    }
    table{
        border:2px solid black;
    }
</style>
<body>
    <div class="contain">
        <center>
            <form action="" method="POST" enctype="multipart/form-data">
          Name:  <input type="text" name="name" id="">
          <br><br>
            <input type="file" name="uploadfile" id="">
            <br>
            <br>
            <input type="submit" value="submit" name="submit">
            </form>
        </center>
    </div>
    <br><br><br>
</body>
</html>

