<?php
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$role = $_GET['role'] ?? '';
$table = $role === 'citizen' ? 'users' : ($role === 'collector' ? 'wastecollector' : '');

if (!$table) {
    die("Invalid role provided.");
}

$result = $conn->query("SELECT * FROM $table");

echo "<h2>Remove " . ucfirst($role) . "</h2>";
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Action</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['email']}</td>
        <td>
            <form method='POST' action='delete_user.php' onsubmit='return confirm(\"Are you sure?\")'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <input type='hidden' name='role' value='$role'>
                <button type='submit'>Remove</button>
            </form>
        </td>
    </tr>";
}

echo "</table>";
$conn->close();
?>
