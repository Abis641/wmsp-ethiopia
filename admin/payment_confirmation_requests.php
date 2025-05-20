<?php

session_start();
$conn = new mysqli("localhost", "root", "", "wmsp");
// Approve or Reject handler
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $action = $_POST['action']; // approve or reject

    // Fetch user_id to send notification
    $stmt = $conn->prepare("SELECT email FROM payments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    if ($action == 'approve') {
        $status = 'approved';
        $message = "Your payment has been approved and we sent the receipt.";
    } elseif ($action == 'reject') {
        $status = 'rejected';
        $message = "Your payment has been rejected.";
    }

    // Update status
    $update = $conn->prepare("UPDATE payments SET status = ? WHERE id = ?");
    $update->bind_param("si", $status, $id);
    $update->execute();
    $update->close();

    // Insert notification
    $notify = $conn->prepare("INSERT INTO notifications (email, message) VALUES (?, ?)");
    $notify->bind_param("ss", $email, $message);
    $notify->execute();
    $notify->close();

    header("Location: payment_confirmation_requests.php");
    exit();
}

// Get pending confirmations
$result = $conn->query("SELECT * FROM payments WHERE status = 'pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Confirmations</title>
    <style>
        body {
            font-family: Arial;
            background: #e0f7fa;
            padding: 20px;
        }
        h2 { color: #00796b; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }
        form { display: inline; }
        button {
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }
        .approve { background-color: #4CAF50; color: white; }
        .reject { background-color: #f44336; color: white; }
    </style>
</head>
<body>

<h2>Pending Payment Confirmations</h2>

<?php if ($result->num_rows > 0): ?>
<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Payment Method</th>
        <th>Amount</th>
        <th>Requested At</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['payment_method'] ?></td>
        <td><?= $row['amount'] ?></td>
        <td><?= $row['payment_date'] ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" name="action" value="approve" class="approve">Approve</button>
            </form>
            <form method="post">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" name="action" value="reject" class="reject">Reject</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p>No pending payment confirmations.</p>
<?php endif; ?>

</body>
</html>
