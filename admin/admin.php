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

            <!-- Oversee Requests -->
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                       
                    </div>
                    <div class="detail-box">
                        <h5><b>Oversee Requests</b></h5>
                        <form action="view_requests.php" method="GET">
    <button type="submit"  class="btn btn-sm" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);">Manage all Requests</button>
</form>




                    </div>
                </div>
            </div>
  <br><br> <br>
 <!-- Oversee Report -->
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                       
                    </div>
                    <div class="detail-box">
                        <h5><b>Oversee Reports</b></h5>
                        <form action="view_reports.php" method="GET">
                            <button type="submit" class="btn btn-sm" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);"> See Reports</button>
                        </form>




                    </div>
                </div>
            </div>
  <br><br> <br>
<!-- Oversee confirmation requset -->

    <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                       
                    </div>
                    <div class="detail-box">
                        <h5><b>payment confirmation requset</b></h5>
                        <form action="payment_confirmation_requests.php" method="GET">
                            <button type="submit"  class="btn btn-sm" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);"> See Requset</button>
                        </form>




                    </div>
                </div>
            </div>
  <br><br> <br><br><br>
  <!-- Oversee colloctor report -->

    <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="img-box">
                       
                    </div>
                    <div class="detail-box">
                        <h5><b>Bin Reports</b></h5>
                        <form action="admin_view_reports.php" method="GET">
                            <button type="submit"  class="btn btn-sm" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);"> 
                                See Reports</button>
                        </form>




                    </div>
                </div>
            </div>
  <br><br> <br><br><br>
<form id="setupScheduleForm" action="save_schedule.php" method="POST">
    <h5><b>Set up Schedules</b></h5>
    <label for="schedule">Schedule Name:</label><br>
    <input type="text" id="schedule" name="schedule" required><br>

       

    <label for="collectionDay">update Day:</label><br>
    <input type="date" id="collectionDay" name="collectionDay" required><br><br>

       <label for="day_label"> CollectionDays:</label><br>
       <input type="text" id="day_label" name="day_label" required placeholder="Monday"><br><br>

    <label for="collectionTimeStart">Collection Time starts:</label><br>
    <input  type="time" id="collectionTimeStart" name="collectionTimeStart" required><br><br>

    <label for="collectionTimeEnd">Collection Time ends:</label><br>
    <input type="time" id="collectionTimeEnd" name="collectionTimeEnd" required><br><br>

    <div class="btn_box">
        <button type="submit" class="btn btn-sm" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);">Save Schedule</button>
    </div>
</form>
<br><br>



    <!-- Notify Users -->
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="box">
                    <div class="detail-box">
                        <h5><b>Notify Users</b></h5>
                        <form action="send_admin_notification.php" method="POST" id="notifyUsersForm">
                           
                            
                          
                            <textarea id="notificationMessage" name="notificationMessage" rows="4" required></textarea><br> <br> 
  
                            <div class="btn_box">
                                <button type="submit"  class="btn btn-sm" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);">
                                    Send Notification
                                </button>
                            </div> <br>
                        </form>
                    </div>
                </div>
            </div>
  <br><br><br>
            
<!-- Manage User Accounts -->
<div class="col-md-6 col-lg-4 mx-auto">
  <div class="box">
    <div class="detail-box">
      <h5><b>Manage  Accounts</b></h5>
     <form id="manageUserForm" method="POST" action="manage_user.php">
  
  <label for="role">Select User Role:</label><br>
  <select id="role" name="role" required>
      <option value="">-- Select Role --</option>
    <option value="citizen">Citizen</option>
    <option value="collector">Waste Collector</option>
  </select><br><br>


  <label for="action">Select Action:</label><br>
  <select id="action" name="action" required>
    <option value="">-- Select Action --</option>
    <option value="add">Add</option>
    <option value="remove">Remove</option>
    <option value="update">Update</option>
  </select><br><br>


  <!-- Dynamic Fields Here -->
  <div id="dynamicFields"></div>
  
  <div id="removeList"></div>
</form>

    </div>
  </div>
</div>
<br><br><br><div>


<script>
document.addEventListener("DOMContentLoaded", function () {
  const actionSelect = document.getElementById("action");
  const roleSelect = document.getElementById("role");
  const dynamicForm = document.getElementById("dynamicFields");

  function buildForm(selectedAction, selectedRole) {
    dynamicForm.innerHTML = ""; // Clear previous content
if (selectedAction === "add") {
  const selectedRole = roleSelect.value;
  let showPhone = selectedRole === "citizen";

  dynamicForm.innerHTML = `
    <label for="first_name">First Name:</label><br>
    <input type="text" name="first_name" required><br>

    <label for="last_name">Last Name:</label><br>
    <input type="text" name="last_name" required><br>

    <label for="username">Username:</label><br>
    <input type="text" name="username" required><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" required><br>

    <label for="password">Password:</label><br>
    <input type="password" name="password" required><br>

    <label for="address">Address:</label><br>
    <input type="text" name="address" required><br>

    ${showPhone ? `
      <label for="phone">Phone:</label><br>
      <input type="text" name="phone" required><br>
    ` : ""}

    <br>
    <div class="btn_box">
      <button type="submit" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);">
        DONE
      </button>
    </div>
  `;
}
else if (selectedAction === "remove") {
      dynamicForm.innerHTML = `
        <p>To remove users or collector , please click the button below to view the list and delete them from there.</p>
        <a href="admin_remove_list.php?role=${selectedRole}">
          <button type="button" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);" >
          See the list to remove</button>
        </a>
      `;
    }
    else if (selectedAction === "update") {
  dynamicForm.innerHTML = `
    <p>To update users or collectors, please click the button below to view the list and edit them from there.</p>
    <a href="admin_update_list.php?role=${selectedRole}">
      <button type="button" style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);">
      See the list to update</button>
    </a>
  `;
}


  }

  // Trigger form build on both action and role change
  actionSelect.addEventListener("change", () => {
    buildForm(actionSelect.value, roleSelect.value);
  });

  roleSelect.addEventListener("change", () => {
    buildForm(actionSelect.value, roleSelect.value);
  });
});
</script>

  
<br><br><br>

            <!-- admin_recycling_post.html --><div class="form-container">
    <form action="post_recycling_info.php" method="POST">
      <h3>Post Recycling Information</h3>

      <label for="campaignTitle">Information Title:</label><br>
      <input type="text" id="campaignTitle" name="campaignTitle" required><br><br>

      <label for="campaignContent">Information Content:</label><br>
      <textarea id="campaignContent" name="campaignContent" rows="4" required></textarea><br><br>

      <label for="targetAudience">Target Audience:</label><br>
      <select id="targetAudience" name="targetAudience" required>
        <option value="">-- Select Audience --</option>
        <option value="Citizens">Citizens</option>
        <option value="Collectors">Collectors</option>
        <option value="All">All</option>
      </select><br><br>

      <button type="submit"  style="background: linear-gradient(to right, #cceeff, #e6f7ff); color: #004466; border: 1px solid #b3e0ff; border-radius: 8px; padding: 6px 14px; font-weight: bold; box-shadow: 0 2px 5px rgba(0, 102, 153, 0.15);">
        Post Information</button>
    </form>
  </div>

  <br><br>


</body>
<script>
  window.onpageshow = function(event) {
    if (event.persisted) {
      window.location.reload();
    }
  };
</script>
</html>