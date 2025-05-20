<?php
// For citizen users
$conn = new mysqli("localhost", "root", "", "wmsp");

$result = $conn->query("SELECT * FROM recycling_info WHERE target_audience IN ('Citizens', 'All') ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
  echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
  echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
  echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
  echo "<small>Audience: " . $row['target_audience'] . "</small>";
  echo "</div>";
}

$conn->close();
?>
