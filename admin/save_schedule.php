<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "wmsp"; // Replace with your DB name

$conn = new mysqli($host, $user, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $schedule = $_POST['schedule'];
    $collectionDay = $_POST['collectionDay'];
     $day_label = $_POST['day_label'];
    $timeStart = $_POST['collectionTimeStart'];
    $timeEnd = $_POST['collectionTimeEnd'];

    $sql = "INSERT INTO schedules (schedule_name, day_label,collection_day, time_start, time_end)
            VALUES ('$schedule','$day_label', '$collectionDay', '$timeStart', '$timeEnd')";

    if ($conn->query($sql) === TRUE) {
        echo "Schedule saved successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>
