<?php
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Safely fetch action and role from POST
$action = $_POST['action'] ?? '';
$role = $_POST['role'] ?? '';

if (empty($action) || empty($role)) {
    echo "<p style='color:red;'>Error: Action or role is missing.</p>";
    echo "<a href='admin.php'><button>Back to Admin Page</button></a>";
    exit;
}

$table = $role === 'citizen' ? 'users' : 'wastecollector';

// === ADD USER ===
if ($action === 'add') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $rawPassword = $_POST['password'] ?? '';
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    if (!$firstName || !$lastName || !$username || !$email || !$address || !$rawPassword || ($role === 'citizen' && empty($_POST['phone']))) {
        echo "<p style='color:red;'>Error: All fields are required.</p>";
        echo "<a href='admin.php'><button>Back to Admin Page</button></a>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>Error: Invalid email format.</p>";
        echo "<a href='admin.php'><button>Back to Admin Page</button></a>";
        exit;
    }

    if ($role === 'citizen') {
        $phone = trim($_POST['phone']);
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, address, password, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstName, $lastName, $username, $email, $address, $password, $phone);
    } else {
        $stmt = $conn->prepare("INSERT INTO wastecollector (firstname, lastname, username, email, address, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstName, $lastName, $username, $email, $address, $password);
    }

    if ($stmt->execute()) {
        header("Location: admin.php?message=add_success");
        exit;
    } else {
        error_log("Add Error: " . $stmt->error);
        echo "<p style='color:red;'>An error occurred while adding the user.</p>";
        echo "<a href='admin.php'><button>Back to Admin Page</button></a>";
    }
    $stmt->close();


// === REMOVE USER (Handled from a separate list view) ===
} elseif ($action === 'remove') {
    echo "<p style='color:orange;'>To remove users, please use the 'See the list to remove' feature.</p>";
    echo "<a href='admin.php'><button>Back to Admin Page</button></a>";
    exit;


// === UPDATE USER ===
} elseif ($action === 'update') {
    $id = $_POST['id'] ?? '';
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $rawPassword = $_POST['password'] ?? '';
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    if (empty($id) || !$firstName || !$lastName || !$username || !$email || !$address || !$rawPassword) {
        echo "<p style='color:red;'>Error: All fields and ID are required for update.</p>";
        echo "<a href='admin.php'><button>Back to Admin Page</button></a>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>Error: Invalid email format.</p>";
        echo "<a href='admin.php'><button>Back to Admin Page</button></a>";
        exit;
    }

    if ($role === 'citizen') {
        $phone = trim($_POST['phone'] ?? '');
        $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, username=?, email=?, address=?, password=?, phone=? WHERE id=?");
        $stmt->bind_param("sssssssi", $firstName, $lastName, $username, $email, $address, $password, $phone, $id);
    } else {
        $stmt = $conn->prepare("UPDATE wastecollector SET firstname=?, lastname=?, username=?, email=?, address=?, password=? WHERE id=?");
        $stmt->bind_param("ssssssi", $firstName, $lastName, $username, $email, $address, $password, $id);
    }

    if ($stmt->execute()) {
        header("Location: admin.php?message=update_success");
        exit;
    } else {
        error_log("Update Error: " . $stmt->error);
        echo "<p style='color:red;'>An error occurred while updating the user.</p>";
        echo "<a href='admin.php'><button>Back to Admin Page</button></a>";
    }
    $stmt->close();
}

$conn->close();
?>
