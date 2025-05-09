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

 

</head>

<body>
  <header class="header_section long_section px-0">
    <nav class="navbar navbar-expand-lg custom_nav-container ">
      <a class="navbar-brand" href="index.html">
        <img src="images/logo.png" alt="" width="50px">
        <span>
          KOSHE
        </span>
      </a>
      <br><br><br><br>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""> </span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
        
        <ul class="navbar-nav  ">
            
            
            <li class="nav-item">
              <a class="nav-link" href="#Request Waste Collection">Request</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#View Requests">Request Status</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#Report">Report</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#Make a Payment">Payment</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#View Payment">Payment history</a>
            </li>
           
          </ul>
        </div>
       
        <a href="signout.php" >
         Sign Out
       </a>

      </div>
    </nav>
  </header>

  <section class="blog_section layout_padding" id="Information">
     <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/acc.png" alt="" id="serv" >
            </div>
            <div class="detail-box">
              <h5>
                Information
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
        </div>
        </div>
        </div>
 </section>

    <section class="blog_section layout_padding" id="Report">
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/x6.png" alt="" id="serv">
            </div>
            <div class="detail-box">
              <h5>
              Report Waste Issues
              </h5>
              <form id="wasteForm">
                <label for="name">Full Name:</label> <br>
                <input type="text" id="name" name="name" required>
                <br>
    
              
    
                <label for="phone">Phone Number:</label> <br>
                <input type="tel" id="phone" name="phone" required> <br>
    
                <label for="address">Report Address:</label> <br>
                <textarea id="address" name="address" required></textarea><br>
                <p>use this google map as a refer for your Address name </p>
                <iframe width="200" height="100" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q=Addis%20Ababa,%20piassa%20Addis%20ababa+(Koshe)&amp;t=&amp;z=19&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a href='https://dissertationschreibenlassen.com/dissertation-medizin/'>med. Dissertation</a>  <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=4e17309ba93e65a02504dcaeb9a7e13860151520'></script> <br> <br><br>
    
                
    
                <label for="ReportDate">Preferred Report Date:</label> <br> 
                <input type="date" id="ReportDate" name="ReportDate" required> <br> <br>

                <label for="address">What is your Report?</label> <br>
                <textarea id="Report" name="Report" required></textarea><br>
    
                <div class="btn_box">
                  <button>
                    SUBMIT
                  </button>
                </div> <br>
            </form>
            </div>
          </div>
        </div>

     </section>
  

  <section class="blog_section layout_padding" id="Request Waste Collection">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/collecting.png" alt="" >
            </div>
            <div class="detail-box">
              <h5>
                Request Waste Collection
              </h5>
             
              <form action="submit_waste_request.php" method="post">
                <div class="container">
                  
                  <form id="wasteForm">
                      <label for="name">Full Name:</label> <br>
                      <input type="text" id="name" name="name" required>
                      <br>
          
                      <label for="email">Email:</label> <br>
                      <input type="email" id="email" name="email" required> <br>
          
                      <label for="phone">Phone Number:</label> <br>
                      <input type="tel" id="phone" name="phone" required> <br>
          
                      <label for="address">Pickup Address:</label> <br>
                      <textarea id="address" name="address" required></textarea><br>
                      <p>use this google map as a refer for your Address name </p>
                      <iframe width="200" height="100" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q=Addis%20Ababa,%20piassa%20Addis%20ababa+(Koshe)&amp;t=&amp;z=19&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a href='https://dissertationschreibenlassen.com/dissertation-medizin/'>med. Dissertation</a>  <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=4e17309ba93e65a02504dcaeb9a7e13860151520'></script> <br> <br><br>
          
                      <label for="wasteType">Type of Waste:</label> <br>
                      <select id="wasteType" name="wasteType" required>
                          <option value="">Select Waste Type</option>
                          <option value="organic">Organic</option>
                          <option value="plastic">Plastic</option>
                          <option value="electronic">Electronic</option>
                          <option value="medical">Medical</option>
                      </select> <br> <br> <br>
          
                      <label for="pickupDate">Preferred Pickup Date:</label> <br> 
                      <input type="date" id="pickupDate" name="pickupDate" required> <br> <br>
          
                      <div class="btn_box">
                        <button>
                          SUBMIT
                        </button>
                      </div> <br>

                      
                  </form>
                  
                  <p id="confirmationMessage" style="display: none;">Your request has been submitted successfully!</p>
                </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>
  </section>

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
                        <h5>
                            Make a Payment
                        </h5>
                        <form id="paymentForm">
                            <div class="container">
                                <label for="name">Full Name:</label> <br>
                                <input type="text" id="name" name="name" required> <br>

                                <label for="email">Email:</label> <br>
                                <input type="email" id="email" name="email" required> <br>

                                <label for="phone">Phone Number:</label> <br>
                                <input type="tel" id="phone" name="phone" required> <br><br>

                                <label for="phone"> choose Payment Methods</label> <br>

                                <select id="payment" name="payment methods" required>
                                  <option value="">Select payment method</option>
                                  <option value="organic">Telebirr</option>
                                  <option value="plastic">CBE mobile banking</option>
                                  <option value="electronic">CBEbirr</option>
                              </select> <br> <br> <br>
                              <label for="name">Money Amount</label> <br>
                              <input type="text"  placeholder="100 birr" id="money" name="money" required> <br><br><br>
                                <div class="btn_box">
                                    <button type="submit">
                                        PAY
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
              <img src="images/pay.png" alt="" >
            </div>
            <div class="detail-box">
              <h5>
                View Billing and Payment History
              </h5>
              <form id="billingForm">
                <label for="userID">User ID:</label> <br>
                <input type="text" id="userID" name="userID" required> <br>
  
                <label for="billingDateRange">Billing Date Range:</label> <br>
                <input type="date" id="startDate" name="startDate" required> to 
                <input type="date" id="endDate" name="endDate" required> <br> <br>
  
                <label for="accountType">Account Type:</label> <br>
                <select id="accountType" name="accountType" required>
                  <option value="">Select Account Type</option>
                  <option value="residential">Residential</option>
                  <option value="commercial">Commercial</option>
                
                </select> <br> <br>
  
                <div class="btn_box">
                  <button type="submit">
                    View History
                  </button>
                </div> <br>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
 
</body>
<script>
  window.onpageshow = function(event) {
    if (event.persisted) {
      window.location.reload();
    }
  };
</script>
</html>