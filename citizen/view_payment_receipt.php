<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wmsp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['phone'])) {
    $phone = $_GET['phone'];

    $sql = "SELECT * FROM payments WHERE phone = ? ORDER BY payment_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            background-attachment: fixed;
            background-size: cover;
            padding: 40px;
            margin: 0;
        }
        .receipt {
            background: #ffffff;
            padding: 30px;
            max-width: 600px;
            margin: 20px auto;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border-left: 10px solid #6a11cb;
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .receipt h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #6a11cb;
        }
        .receipt-item {
            border-bottom: 1px dashed #ccc;
            padding: 12px 0;
            color: #34495e;
        }
        .receipt-item:last-child {
            border-bottom: none;
        }
        .label { font-weight: bold; color: #2d3436; }
        .value { color: #0984e3; }
        .receipt p { font-size: 16px; line-height: 1.6; }
        .receipt-item p { margin: 5px 0; }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #636e72;
            font-style: italic;
        }
        .message {
            text-align: center;
            color: #fff;
            background-color: #d63031;
            padding: 15px;
            border-radius: 8px;
            margin: 20px auto;
            max-width: 600px;
            font-size: 18px;
        }
    </style>";

    if ($result->num_rows > 0) {
        $hasApproved = false;

        while ($row = $result->fetch_assoc()) {
            if (strtolower($row['status']) === 'approved') {
                $hasApproved = true;

                echo "<div class='receipt'>";
                echo "<h2>Payment Receipt</h2>";
                echo "<div class='receipt-item'>";
                echo "<p><span class='label'>Name:</span> <span class='value'>" . htmlspecialchars($row['full_name']) . "</span></p>";
                echo "<p><span class='label'>Phone:</span> <span class='value'>" . htmlspecialchars($row['phone']) . "</span></p>";
                echo "<p><span class='label'>Email:</span> <span class='value'>" . htmlspecialchars($row['email']) . "</span></p>";
                echo "<p><span class='label'>Paid Amount:</span> <span class='value'>" . htmlspecialchars($row['amount']) . " Birr</span></p>";
                echo "<p><span class='label'>Payment Method:</span> <span class='value'>" . htmlspecialchars($row['payment_method']) . "</span></p>";
                echo "<p><span class='label'>confirmation_request Date and time:</span> <span class='value'>" . htmlspecialchars($row['payment_date']) . "</span></p>";
                echo "</div>";
                echo "<div class='footer'>Thank you for using our service!</div>";
                echo "</div>";
            }
        }

        if (!$hasApproved) {
            echo "<div class='message'>No approved payment found for this phone number. Your payment may be pending or was rejected.</div>";
        }
    } else {
        echo "<div class='message'>No payments found for this phone number.</div>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<div class='message'>No phone number provided.</div>";
}
?>
