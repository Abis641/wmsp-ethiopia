<?php
$conn = new mysqli("localhost", "root", "", "wmsp");

$result = $conn->query("SELECT * FROM recycling_info WHERE target_audience IN ('Collectors', 'All') ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Recycling Information for Collectors</title>
  <style>
    body {
      font-family: Georgia, "Times New Roman", Times, serif;
      background-color: #f9f9f9;
      color: #202124;
      padding: 40px;
    }

    .info-container {
      max-width: 800px;
      margin: auto;
    }

    .info-box {
      background-color: #fff;
      border: 1px solid #dcdcdc;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s ease;
    }

    .info-box:hover {
      transform: scale(1.01);
    }

    .info-box h4 {
      margin-top: 0;
      color: #1a73e8;
    }

    .info-box p {
      line-height: 1.6;
    }

    .page-title {
      text-align: center;
      margin-bottom: 40px;
      color: #2c3e50;
      font-size: 28px;
    }
  </style>
</head>
<body>

  <div class="info-container">
    <div class="page-title">♻️ Recycling Information for Collectors</div>

    <?php
    while ($row = $result->fetch_assoc()) {
      echo "<div class='info-box'>";
      echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
      echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
      echo "</div>";
    }

    $conn->close();
    ?>
  </div>

</body>
</html>
