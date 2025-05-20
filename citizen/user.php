<?php
session_start();

// Block access if user not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

// Prevent browser from caching this page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="../images/logo2.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Citizen</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />

  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

 <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    #map {
      height: 300px;
      width: 100%;
      margin-top: 10px;
      margin-bottom: 10px;
    }
    input, textarea, select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
    }
    .btn_box {
      text-align: center;
    }
  </style>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

</head>

<body>
 <header class="header_section long_section px-0" style="background: linear-gradient(135deg, #cce7ff, #f0f8ff); padding: 10px 0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"
">
  <nav class="navbar navbar-expand-lg custom_nav-container" style="width: 100%; padding: 0 20px;">
    <a class="navbar-brand" href="index.html" style="display: flex; align-items: center; color: #5e3d2b; font-weight: bold;">
      <img src="images/logo.png" alt="" width="50px" style="margin-right: 8px;">
      <span style="font-size: 22px;">KOSHE</span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class=""> </span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#Request Waste Collection" style="color: #5e3d2b;">Request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#View Requests" style="color: #5e3d2b;">Request Status</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#Report" style="color: #5e3d2b;">Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#Make a Payment" style="color: #5e3d2b;">Payment</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#View Payment" style="color: #5e3d2b;">Payment History</a>
          </li>
          <li class="nav-item">
  <a class="nav-link" href="notifications.php" id="notificationLink" 
     style="color: #3c2f2f; position: relative; padding: 10px 12px; font-weight: 600; text-decoration: none;">
    <i class="fa fa-bell" aria-hidden="true" 
       style="font-size: 18px; color: #bfa980; transition: transform 0.3s ease;"></i>
    <span id="notification-count" 
          style="
            background: linear-gradient(145deg, #6b4c3b, #9c8b75);
            color: #fff;
            border-radius: 50%;
            padding: 3px 7px;
            font-size: 10px;
            font-weight: 600;
            position: absolute;
            top: -4px;
            right: -4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
          ">0</span>
  </a>
</li>


        </ul>
      </div>
     <a href="signout.php" 
   style="
     background: linear-gradient(135deg, #c8ad7f, #a67c52); 
     color: #fff; 
     padding: 8px 16px; 
     border-radius: 30px; 
     text-decoration: none; 
     font-weight: bold; 
     font-size: 14px; 
     box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
     transition: all 0.3s ease;
     display: inline-block;
   "
   onmouseover="this.style.background='linear-gradient(135deg, #a67c52, #c8ad7f)'; this.style.transform='scale(1.05)'"
   onmouseout="this.style.background='linear-gradient(135deg, #c8ad7f, #a67c52)'; this.style.transform='scale(1)'"
>
  Sign Out
</a>

    </div>
  </nav>
</header>

<style>
  .info-card-section {
    padding: 10px 20px;
    background: linear-gradient(135deg, #2c3e50, #d4af37); /* dark blue to gold */
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .info-card {
    display: flex;
    flex-direction: row;
    max-width: 10000px;
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    background: linear-gradient(135deg, rgba(230, 216, 190, 0.9), rgba(183, 147, 95, 0.7));
    backdrop-filter: blur(10px);
  }

  .info-card img {
    width: 50%;
    object-fit: cover;
    height: auto;
    border-right: 2px solid #ddd;
  }

  .info-card-text {
    padding: 40px;
    width: 50%;
    background: transparent;
    display: flex;
    flex-direction: column;
    justify-content: center;
  color: #5e3d2b;
  }

  .info-card-text h2 {
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #6a1b9a;
  }

  .info-card-text p {
    font-size: 16px;
    line-height: 1.7;
  }

  @media (max-width: 768px) {
    .info-card {
      flex-direction: column;
    }

    .info-card img, .info-card-text {
      width: 100%;
    }

    .info-card img {
      border-right: none;
      border-bottom: 2px solid #ddd;
    }
  }
</style>
<section class="info-card-section" id="Information">
<!-- Schedule Viewing Section -->
<section class="blog_section layout_padding" id="ViewSchedule">
<div style="position: absolute; top: 110px; left: 10px; width: 700px; height: auto; font-family: 'Segoe UI', sans-serif;">

    <?php
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "wmsp");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the latest schedule
    $sql = "SELECT schedule_name, day_label, collection_day, time_start, time_end 
            FROM schedules 
            ORDER BY created_at DESC 
            LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo '
        <div style="
            background: linear-gradient(135deg, #fdf6e3, #e4d4c8); 
            padding: 14px 22px; 
            border-radius: 22px; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); 
            font-size: 14px; 
            color: #3e2e2e; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-left: 5px solid #bfa980;
            width: 1000px;
        ">
            <div><strong>📅 Schedule:</strong> ' . htmlspecialchars($row["schedule_name"]) . '</div>
            <div><strong>📆 Update Date:</strong> ' . htmlspecialchars($row["collection_day"]) . '</div>
            <div><strong>🗓️ Working Days:</strong> ' . htmlspecialchars($row["day_label"]) . '</div>
            <div><strong>⏰ Time:</strong> ' . htmlspecialchars($row["time_start"]) . ' - ' . htmlspecialchars($row["time_end"]) . '</div>
        </div>';
    } else {
        echo '<p style="font-family: Segoe UI; color: #7a6c5d;">No schedule available.</p>';
    }

    $conn->close();
    ?>

</div>



  <div class="info-card">
    <img src="images/xyz.png" alt="Recycling Info">
    <div class="info-card-text">
      <h2>Recycling & Waste Info</h2>
      <p>
        Empower yourself with knowledge about recycling and waste segregation.<br><br>
        <strong>Comprehensive Search:</strong> Find recyclable materials and nearby drop-off locations.<br><br>
        <strong>Educational Content:</strong> Discover how to properly separate waste into recyclables, compostables, and trash to reduce pollution and promote sustainability. Click 
  <a href="user_page.php" style="color:#8e24aa; font-weight:bold; text-decoration:underline;">here</a> to see content.<br><br>
        <strong>Recyclable Collection:</strong> Send requests to ensure items are properly handled.
      </p>
    </div>
  </div>
  </section>
</section>




 <section class="blog_section layout_padding" id="Report" >
  <div class="col-md-5 col-lg-4 mx-auto">
    <div class="box">
      <div class="img-box">
        <img src="images/x6.png" alt="" id="serv">
      </div>
      <div class="detail-box">
        <h5 class="text-center mb-3">Report Waste Issues</h5>
        <form id="wasteForm" action="submit_report.php" method="POST" enctype="multipart/form-data" >
          <label for="username">user name:</label>
          <input type="text" id="username" name="username" class="form-control mb-2" required>

          <label for="phone">Phone Number:</label>
          <input type="tel" id="phone" name="phone" class="form-control mb-2" required>

          <label for="issueType">Issue Type:</label>
          <select id="issueType" name="issueType" class="form-control mb-2" required>
            <option value="">--Select--</option>
            <option value="Overflowing Bin">Overflowing Bin</option>
            <option value="Illegal Dumping">Illegal Dumping</option>
            <option value="Uncollected Waste">Uncollected Waste</option>
            <option value="Other">Other</option>
          </select>

          <label for="address">Report Address:</label>
          <textarea id="address" name="address" class="form-control mb-2" rows="2" required></textarea>

          <small class="text-muted">Use the Google map below for reference:</small>
          <iframe width="200" height="100" frameborder="0" scrolling="no"
            src="https://maps.google.com/maps?q=Addis%20Ababa,%20piassa&z=19&output=embed" class="mb-2"></iframe>

          <label for="ReportDate">Preferred Report Date:</label>
          <input type="date" id="ReportDate" name="ReportDate" class="form-control mb-2" required>

          <label for="reportDetails">What is your Report?</label>
          <textarea id="reportDetails" name="reportDetails" class="form-control mb-2" rows="2" required></textarea>

          <label for="photo">Upload Photo (optional):</label>
          <input type="file" id="photo" name="photo" accept="image/*" class="form-control mb-3">

          <div class="btn_box text-center">
            <button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


  


<section class="blog_section layout_padding" id="Request Waste Collection">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="img-box" id="serv">
            <img src="images/collecting.png" alt="" style="width:100%;">
          </div>
          <div class="detail-box">
            <h2 class="text-center mb-3">Request Waste Collection</h2>

            <form action="submit_waste_request.php" method="post">

              <label for="name">Full Name:</label>
              <input type="text" id="name" name="name" required>

              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>

              <label for="phone">Phone Number:</label>
              <input type="tel" id="phone" name="phone" required>

              <label for="address">Pickup Address:</label>
                   <textarea id="address" name="address" rows="2" readonly></textarea>

              <label>Select Pickup Location (click on map):</label>
              <div id="map"></div>

              <!-- Hidden fields for coordinates -->
              <input type="hidden" id="latitude" name="latitude">
              <input type="hidden" id="longitude" name="longitude">

              <label for="wasteType">Type of Waste:</label>
              <select id="wasteType" name="wasteType" required>
                <option value="">Select Waste Type</option>
                <option value="organic">Organic</option>
                <option value="plastic">Plastic</option>
                <option value="electronic">Electronic</option>
                <option value="medical">Medical</option>
              </select>

              <label for="pickupDate">Preferred Pickup Date:</label>
              <input type="date" id="pickupDate" name="pickupDate" required>

              <div class="btn_box">
                <button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>
              </div>

              <p style="color: red; margin-top: 10px;">
                *Your collection request won't be accepted or handled if you haven't paid for the service.*
              </p>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  var map = L.map('map').setView([9.03, 38.74], 13); // Addis Ababa center

  // Add OpenStreetMap tiles
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
  }).addTo(map);

  var marker;

  // When user clicks on map
  map.on('click', function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;

    // Set lat/lng values
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    // Add or update marker
    if (marker) {
      marker.setLatLng(e.latlng);
    } else {
      marker = L.marker(e.latlng).addTo(map);
    }

    // Reverse geocoding with Nominatim
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
      .then(response => response.json())
      .then(data => {
        if (data.display_name) {
          document.getElementById('address').value = data.display_name;
        } else {
          document.getElementById('address').value = 'Address not found';
        }
      })
      .catch(error => {
        console.error('Error:', error);
        document.getElementById('address').value = 'Error getting address';
      });
  });
</script>


  <section class="blog_section layout_padding" id="View Requests">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">
        <div class="box">
            <div class="detail-box"> 
                 <h2>View Requests</h2>


             <a href="check_status.php">
                  <button type="button">Check My Request Status</button>
                       </a>
                      </div>
                      </div>
                      </div>
                      </div>
                      </div>
                      </section>

  <section class="blog_section layout_padding"id="Make a Payment">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                        <img src="images/pay.png" alt="Payment Image">
                    </div>
                    <div class="detail-box">
                      <p style="color: red;"><b>*Before you confirm a payment, please use <u>Telebirr</u> or <u>CBE birr</u> and Pay  <u>"100"</u> Birr. Make the payment by this number  <br>  "+251 922836223". </b></p>

                        <h5 class="text-center mb-3">
                            Confirm a Payment
                        </h5>
                        <form action="confirm_payment.php" method="post" id="paymentForm">
                            <div class="container">
                                <label for="name">Full Name:</label> <br>
                                <input type="text" id="name" name="name" required> <br>

                                <label for="email">Email:</label> <br>
                                <input type="email" id="email" name="email" required> <br>

                                <label for="phone">Phone Number:</label> <br>
                                <input type="tel" id="phone" name="phone" required> <br><br>

                                <label for="payment_method">Choose Payment Method you used</label> <br>

<select id="payment" name="payment_method" required>
  <option value="">Select payment method</option>
  <option value="Telebirr">Telebirr</option>
  <option value="CBE Birr">CBE Birr</option>
</select>

                                   <br> <br>  <br>
                              <label for="name">Paid Money Amount</label> <br>
                              <input type="text"  placeholder="birr" id="money" name="money" required> <br><br><br>

                              <label for="photo">Upload screen shot of your payment:</label>
                             <input type="file" id="photo" name="photo" accept="image/*" class="form-control mb-3" required>
                              <br><br><br>

                                 <div class="btn_box  text-center ">
                      <button type="submit" class="btn btn-primary btn-sm"> CONFIRM
                        </button>
                      </div> <br>
                            </div>
                        </form>
                        <p id="confirmationMessage" style="display: none;">Your payment has been processed successfully!</p>
                    </div>
                </div>
            </div>
                      </div>
        </div>
    </div>
 </section>

 <section class="blog_section layout_padding" id="View Payment">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-4 mx-auto">
        <div class="box">
          <div class="img-box">
            <img src="images/pay.png" alt="Payment History">
          </div>
          <div class="detail-box text-center">
            <h5>View Billing and Payment History</h5>
            <p>Click below to see your previous payments.</p>

            <div class="btn_box mt-3">
              <button onclick="openReceipt()" class="btn btn-primary" style="padding: 10px 20px; font-weight: bold; border-radius: 30px; background-color: #007bff; border: none;">
                View My Payment History
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function openReceipt() {
    const phone = prompt("Please enter your phone number to view your payment history:");
    if (phone) {
      // Pass phone as a GET parameter to a new receipt page
      window.open('view_payment_receipt.php?phone=' + encodeURIComponent(phone), '_blank');
    }
  }
</script>


                      </section>


  <!-- info section -->
  <section class="info_section long_section">

    <div class="container">
      <div class="contact_nav">
        <a href="">
          <i class="fa fa-phone" aria-hidden="true"></i>
          <span>
            Call : +251 922-83-62-23
          </span>
        </a>
        <a href="">
          <i class="fa fa-envelope" aria-hidden="true"></i>
          <span>
            Email : Koshe@gmail.com
          </span>
        </a>
      </div>

      <div class="info_top " >
        <div class="row ">
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="info_links">
              <h4>
                QUICK LINKS
              </h4>
              <div class="info_links_menu">
                <a class="" href="index.html">Home <span class="sr-only">(current)</span></a><br>
                
                <a class="" href="#Information"> Info</a>
                <a class="" href="#Request Waste Collection">Request</a>
                <a class="" href="#Report">Report</a>
                <a class="" href="#Make a Payment">Payment</a>
                <a class="" href="#View Payment">View history</a>
              </div>
            </div>
          </div>
          
              </form>
              
                
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end info_section -->


  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By KOSHE    
      </p>
    </div>
  </footer>
  <!-- footer section -->
 
  <script>
  function checkNotifications() {
    fetch('check_notification.php')
      .then(response => response.json())
      .then(data => {
        const count = data.unread_count;
        const countElement = document.getElementById('notification-count');

        if (count > 0) {
          countElement.textContent = count;
          countElement.style.display = 'inline-block';
        } else {
          countElement.style.display = 'none';
        }
      })
      .catch(error => {
        console.error('Error fetching notifications:', error);
      });
  }

  // Check notifications on page load and then every 30 seconds
  document.addEventListener('DOMContentLoaded', () => {
    checkNotifications();
    setInterval(checkNotifications, 30000);
  });
</script>


<script>
    function loadNotificationCount() {
        fetch('get_notifications.php')
            .then(res => res.text())
            .then(count => {
                const countElem = document.getElementById("notification-count");
                countElem.textContent = count > 0 ? ` (${count})` : "";
            });
    }

    loadNotificationCount();
    setInterval(loadNotificationCount, 10000); // refresh every 10 seconds
</script>
<script>
  function toggleNotifications() {
  const dropdown = document.getElementById('notification-dropdown');
  const isHidden = dropdown.style.display === 'none';

  dropdown.style.display = isHidden ? 'block' : 'none';

  if (isHidden) {
    // Mark admin notifications as read
    fetch('mark_admin_notifications_read.php')
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Optionally reload the notification list or update styles
          window.location.reload(); // or re-fetch just the updated notification section
        }
      });
  }
}

  </script>

  <script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentForm = document.getElementById('paymentForm');

    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(paymentForm);

        fetch('confirm_payment.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if (data.trim().includes("✅")) {
                alert("Sent successfully!");
                paymentForm.reset();
            } else {
                alert("Error: " + data);
            }
        })
        .catch(error => {
            alert("Network Error: " + error);
        });
    });
});
</script>



</body>
<script>
  window.onpageshow = function(event) {
    if (event.persisted) {
      window.location.reload();
    }
  };
</script>
</html>