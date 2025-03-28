<?php
include 'config.php';

$sql = "SELECT * FROM study_materials ORDER BY uploaded_at DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<p>Subject: " . $row['subject'] . "</p>";
    echo "<a href='" . $row['file_path'] . "' target='_blank'>Download</a>";
    echo "</div><hr>";
}
?>
