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

// Lookup collector’s address
$collectorUsername = $_SESSION['user'];
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$stmt = $conn->prepare("SELECT address FROM wastecollector WHERE username = ?");
$stmt->bind_param("s", $collectorUsername);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 1) {
    $collectorAddress = $res->fetch_assoc()['address'];
} else {
    $collectorAddress = ''; // fallback
}
$stmt->close();
$conn->close();
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
  <link rel="icon" href="images/logo2.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>WasteCollector</title>


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

</head>
<body>
  <header class="header_section long_section px-0">
    <nav class="navbar navbar-expand-lg custom_nav-container ">
      <a class="navbar-brand" href="index.html">
        <img src="images/logo.png" alt="" width="100px">
        <span>
          KOSHE
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""> </span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
          
        </div>
        <a href="signout.php">
          Sign Out
        </a>
      </div>
    </nav>
  </header>
  <section class="blog_section layout_padding" id="WasteCollector">
    <div class="container">
      <div class="heading_container">
        <h2>
          Waste Collector Tasks
        </h2>
      </div>
      <div class="row">
        
       <!-- Receive and View Collection Requests -->
<!-- Receive and View Collection Requests -->
<div class="col-md-6 col-lg-4 mx-auto">
      <div class="box">
          <div class="img-box">
              <img src="images/receive-requests.png" alt="">
          </div>
          <div class="detail-box">
              <h5>Receive and View Collection Requests</h5>
              <div class="btn_box">
                  <!-- Pass the collector’s address in the URL -->
                  <a 
                    href="view_requests.php?address=<?= urlencode($collectorAddress) ?>" 
                    class="btn btn-primary"
                  >
                      View Requests
                  </a>
              </div><br>
          </div>
      </div>
  </div>


  
      
  
        <!-- Report Bin Issues -->
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/report-bin-issues.png" alt="">
            </div>
            <div class="detail-box">
              <h5>
                Report Bin Issues
              </h5>
              <form id="reportBinIssuesForm">
                <label for="collectorID">Collector ID:</label> <br>
                <input type="text" id="collectorID" name="collectorID" required> <br>
                
                <label for="binLocation">Bin Location:</label> <br>
                <textarea id="binLocation" name="binLocation" rows="4" required></textarea><br>
  
                <label for="issueDescription">Description of the Issue:</label> <br>
                <textarea id="issueDescription" name="issueDescription" rows="4" required></textarea><br>
  
                <div class="btn_box">
                  <button type="submit">
                    Report Issue
                  </button>
                </div> <br>
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-4 mx-auto">
        <div class="box">
          
          <div class="detail-box">
            <h5>
              Access Information
            </h5>
            <p>
              Empower yourself with knowledge about recycling and waste segregation.<br><br>

              Comprehensive Search: Look up recyclable materials and find specific drop-off locations near you.<br><br>

              Educational Content: Access valuable information and guides on proper waste segregation and recycling practices.<br><br>

              Request Recyclable Collection: Initiate separate collection requests for your recyclables to ensure they are properly handled.
            </p>
          </div>
        </div>
      </div>
  </section>
  


  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By KOSHE    
      </p>
    </div>
  </footer>
  <!-- footer section -->
</body>
<script>
  window.onpageshow = function(event) {
    if (event.persisted) {
      window.location.reload();
    }
  };
</script>
</html>  