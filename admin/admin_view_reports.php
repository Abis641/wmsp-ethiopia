<?php
$conn = new mysqli("localhost", "root", "", "wmsp"); 
$result = $conn->query("SELECT * FROM collector_reports WHERE status = 'pending'");

while ($row = $result->fetch_assoc()) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
    echo "<strong>Collector Username:</strong> " . htmlspecialchars($row['username']) . "<br>";
    echo "<strong>Bin Location:</strong> " . htmlspecialchars($row['bin_location']) . "<br>";
    echo "<strong>Issue Description:</strong> " . htmlspecialchars($row['issue_description']) . "<br><br>";

    echo '<form method="POST" action="admin_process_report.php">';
    echo '<input type="hidden" name="username" value="' . $row['username'] . '">';
    echo '<input type="hidden" name="status" value="approved">';
    echo '<button type="submit">Approve</button>';
    echo '</form>';

    echo '<form method="POST" action="admin_process_report.php">';
    echo '<input type="hidden" name="username" value="' . $row['username'] . '">';
    echo '<input type="hidden" name="status" value="rejected">';
    echo '<button type="submit">Reject</button>';
    echo '</form>';

    echo "</div>";
}
?>
