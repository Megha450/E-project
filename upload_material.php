<?php
session_start();
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["study_file"])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $subject = $_POST['subject'];
    $uploaded_by = $_SESSION['user_id']; // Get user ID from session

    $target_dir = "uploads/study_materials/";
    $file_name = basename($_FILES["study_file"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ["pdf", "docx", "ppt", "pptx"];
    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES["study_file"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO study_materials (title, description, file_path, subject, uploaded_by)
                    VALUES ('$title', '$description', '$target_file', '$subject', '$uploaded_by')";
            if (mysqli_query($conn, $sql)) {
                echo "Study material uploaded successfully!";
            } else {
                echo "Database error!";
            }
        } else {
            echo "File upload failed!";
        }
    } else {
        echo "Invalid file format!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Material</title>
    <style>
         <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        @media (max-width: 480px) {
            .container {
                width: 100%;
                margin: 10px;
            }
        }
    </style>
    </style>
</head>
<body>
<form action="upload_material.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Enter Material Title" required><br>
        <textarea name="description" placeholder="Enter Description"></textarea><br>
        <select name="subject">
            <option value="Science">Science</option>
            <option value="Maths">Maths</option>
            <option value="Computer">Computer</option>
        </select><br>
        <input type="file" name="study_file" required><br>
        <button type="submit">Upload Material</button>
    </form>
</body>
</html>
