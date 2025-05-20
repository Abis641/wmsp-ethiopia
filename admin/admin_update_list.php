<?php
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$role = $_GET['role'] ?? '';
$table = '';
if ($role === 'citizen') {
    $table = 'users';
} elseif ($role === 'collector') {
    $table = 'wastecollector';
} else {
    die("Invalid role specified.");
}

// Fetch all users from the selected table
$result = $conn->query("SELECT * FROM $table");

echo "<h2>Update " . ucfirst($role) . "</h2>";
echo "<table border='1' cellpadding='8'>";
echo "<tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Address</th>
        <th>Password</th>";

if ($role === 'citizen') {
    echo "<th>Phone</th>";
}

echo "<th>Action</th></tr>";

// Each row is a form so you can submit updates individually
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <form method='POST' action='admin_process.php'>
            <td>" . $row['id'] . "<input type='hidden' name='id' value='" . $row['id'] . "'></td>
            <td><input type='text' name='first_name' value='" . htmlspecialchars($row['first_name'] ?? $row['firstname']) . "' ></td>
            <td><input type='text' name='last_name' value='" . htmlspecialchars($row['last_name'] ?? $row['lastname']) . "' ></td>
            <td><input type='text' name='username' value='" . htmlspecialchars($row['username']) . "' ></td>
            <td><input type='email' name='email' value='" . htmlspecialchars($row['email']) . "' ></td>
            <td><input type='text' name='address' value='" . htmlspecialchars($row['address']) . "' ></td>
            <td><input type='password' name='password' placeholder='New password' ></td>";

    if ($role === 'citizen') {
        echo "<td><input type='text' name='phone' value='" . htmlspecialchars($row['phone']) . "' ></td>";
    }

    echo "<td>
            <input type='hidden' name='action' value='update'>
            <input type='hidden' name='role' value='$role'>
            <button type='submit'>Update</button>
          </td>
        </form>
    </tr>";
}

echo "</table>";
echo "<br><a href='admin.php'>Back to Admin Page</a>";

$conn->close();
?>
