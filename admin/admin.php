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
  <link rel="icon" href="images/logo2.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Admin</title>


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
          <a href="signout.php" >
            Sign Out
          </a>
      </div>
    </nav>
  </header>
  <section class="admin_section layout_padding" id="AdminPage">
    <div class="container">
        <div class="heading_container">
            <h2>Admin </h2>
        </div> <br> <br> 
        <div class="row">
            
            <!-- Manage User Accounts -->
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                       
                    </div>
                    <div class="detail-box">
                        <h5><b>Manage User Accounts</b></h5>
                        <form id="manageUserForm">
                            <label for="userID">User ID:</label><br>
                            <input type="text" id="userID" name="userID" required><br>
                    
                            <label for="firstName">First Name:</label><br>
                            <input type="text" id="firstName" name="firstName" required><br>
                    
                            <label for="lastName">Last Name:</label><br>
                            <input type="text" id="lastName" name="lastName" required><br>
                    
                            <label for="email">Email:</label><br>
                            <input type="email" id="email" name="email" required><br>
                    
                            <label for="password">Password:</label><br>
                            <input type="password" id="password" name="password" required><br>
                    
                            <label for="userRole">User Role:</label><br>
                            <select id="userRole" name="userRole" required>
                                <option value="citizen">Citizen</option>
                                <option value="collector">Waste Collector</option>
                            </select><br><br>
                            <select id="requestAction" name="requestAction" required>
                                <option value="">-- Select Action --</option>
                                <option value="add">Add</option>
                                <option value="remove">Remove</option>
                                <option value="updated">Update</option>
                            </select><br><br>
                            <div class="btn_box">
                                <button type="submit">Submit</button>
                            </div><br>
                        </form>
                    </div>
                </div>
            </div>
  <br> <br> <br>
            <!-- Setup Schedules -->
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                       
                    </div>
                    <div class="detail-box">
                        <h5><b>Setup Schedules</b></h5>
                        <form id="setupScheduleForm">
                            <label for="scheduleID">Schedule ID:</label> <br>
                            <input type="text" id="scheduleID" name="scheduleID" required> <br>
                            
                            <label for="collectionDay">Collection Day:</label> <br>
                            <input type="date" id="collectionDay" name="collectionDay" required> <br>
  
                            <label for="collectionTime">Collection Time:</label> <br>
                            <input type="time" id="collectionTime" name="collectionTime" required> <br> <br> 
                            
                            <label for="requestAction">Action:</label><br>

                           <select id="requestAction" name="requestAction" required>
                              <option value="">-- Select Action --</option>
                              <option value="approved">Approve</option>
                              <option value="rejected">Reject</option>
                              <option value="updated">Update</option>
                          </select><br><br>
                            <div class="btn_box">
                                <button type="submit">
                                    Save Schedule
                                </button>
                            </div> <br>
                        </form>
                    </div>
                </div>
            </div>
  <br><br> <br>
            <!-- Oversee Requests -->
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                       
                    </div>
                    <div class="detail-box">
                        <h5><b>Oversee Requests</b></h5>
                        <form action="view_requests.php" method="GET">
    <button type="submit">Manage all Requests</button>
</form>




                    </div>
                </div>
            </div>
  <br><br> <br>
            <!-- Post Recycling Information -->
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                     
                    </div>
                    <div class="detail-box">
                        <h5><b>Post Recycling Information</b></h5>
                        <form id="postRecyclingForm">
                          
                          <!-- Step 2: Choose to create or manage -->
                          <label for="campaignMode">Select Action:</label><br>
                          <select id="campaignMode" name="campaignMode" required>
                            <option value="">-- Select Mode --</option>
                            <option value="create">Create New Campaign</option>
                            <option value="edit">Manage Existing Campaign</option>
                          </select><br><br>
                      
                          <!-- Step 3: Campaign Details -->
                          <label for="campaignTitle">Campaign Title:</label><br>
                          <input type="text" id="campaignTitle" name="campaignTitle" required><br>
                      
                          <label for="campaignContent">Campaign Content:</label><br>
                          <textarea id="campaignContent" name="campaignContent" rows="4" required></textarea><br>
                      
                          <label for="targetAudience">Target Audience:</label><br>
                          <input type="text" id="targetAudience" name="targetAudience" placeholder="e.g. Citizens, Collectors, All"><br>
                      
                          <label for="incentives">Incentives:</label><br>
                          <input type="text" id="incentives" name="incentives" placeholder="e.g. Badges, Discounts"><br><br>
                      
                          <!-- Step 4: Submit -->
                          <div class="btn_box">
                            <button type="submit">Post Campaign</button>
                          </div><br>
                        </form>
                      </div>
                      
                </div>
            </div>
  <br><br> <br>
           
            <!-- Notify Users -->
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                       
                    </div>
                    <div class="detail-box">
                        <h5><b>Notify Users</b></h5>
                        <form id="notifyUsersForm">
                            <label for="notificationTitle">Notification Title:</label> <br>
                            <input type="text" id="notificationTitle" name="notificationTitle" required> <br>
                            
                            <label for="notificationMessage">Message:</label> <br>
                            <textarea id="notificationMessage" name="notificationMessage" rows="4" required></textarea><br> <br> 
  
                            <div class="btn_box">
                                <button type="submit">
                                    Send Notification
                                </button>
                            </div> <br>
                        </form>
                    </div>
                </div>
            </div>
  
        </div>
    </div>
</section>
</body>
<script>
  window.onpageshow = function(event) {
    if (event.persisted) {
      window.location.reload();
    }
  };
</script>
</html>