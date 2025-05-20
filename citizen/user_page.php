<?php
$conn = new mysqli("localhost", "root", "", "wmsp");

$result = $conn->query("SELECT * FROM recycling_info WHERE target_audience IN ('Citizens', 'All') ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Recycling Info for Citizens</title>
  <style>
    body {
      font-family: "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
      background-color: #eef2f5;
      color: #333;
      margin: 0;
      padding: 40px 20px;
    }

    .info-container {
      max-width: 900px;
      margin: auto;
    }

    .info-title {
      text-align: center;
      font-size: 30px;
      font-weight: bold;
      color: #1c4966;
      margin-bottom: 40px;
    }

    .info-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 25px 30px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
      margin-bottom: 25px;
      transition: all 0.3s ease;
    }

    .info-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .info-card h4 {
      margin: 0 0 10px;
      color: #2a7ae2;
    }

    .info-card p {
      line-height: 1.7;
      font-size: 16px;
    }
  </style>
</head>
<body>

  <div class="info-container">
    <div class="info-title">📢 Recycling Information for Citizens</div>

    <?php
    while ($row = $result->fetch_assoc()) {
      echo "<div class='info-card'>";
      echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
      echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
      echo "</div>";
    }

    $conn->close();
    ?>
  </div>

</body>
</html>
