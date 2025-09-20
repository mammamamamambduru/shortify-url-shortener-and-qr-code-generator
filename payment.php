<?php
include "connection/connection.php";
if (!isset($_SESSION['id'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Stop script execution
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    payments - Link Shortener
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="css/assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
<!-- CSS Files -->

    <script src="https://www.paypal.com/sdk/js?client-id=AT48Y7gzxWgou98Al1qTklbvNyQ0T8WZcda-90m0H2KJftpTNeE37UEWCFOs8wsEMxprtl7o8y0qcoqf&currency=USD"></script>

    
</head>

<body class="g-sidenav-show   bg-gray-100">
<?php include "inc/menu.php" ?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Payment</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Payment</h6>
        </nav>
   
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-xl-6">
      <div class="row">
        <!-- Medium Plan -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                <i class="fas fa-rocket opacity-10"></i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0">Medium Plan</h6>
              <span class="text-xs">Get 500 link shorteners</span>
              <ul class="list-unstyled text-xs mt-2">
                <li>Standard support</li>
                <li>Reports</li>
                <li>QR code generator included</li>
              </ul>
              <hr class="horizontal dark my-3">
              <h5 class="mb-0">$4.99</h5>
              <div id="paypal-button-container-medium"></div>
            </div>
          </div>
        </div>

        <!-- Premium Plan -->
        <div class="col-md-6 mt-md-0 mt-4">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                <i class="fas fa-diamond opacity-10"></i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0">Premium Plan</h6>
              <span class="text-xs">Get 1500 link shorteners</span>
              <ul class="list-unstyled text-xs mt-2">
                <li>Standard support</li>
                <li>Reports</li>
                <li>QR code generator included</li>
              </ul>
              <hr class="horizontal dark my-3">
              <h5 class="mb-0">$9.99</h5>
              <div id="paypal-button-container-premium"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Golden Plan -->
    <div class="col-md-6 mt-md-0 mt-4">
      <div class="card">
        <div class="card-header mx-4 p-3 text-center">
          <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg">
            <i class="fas fa-crown opacity-10"></i>
          </div>
        </div>
        <div class="card-body pt-0 p-3 text-center">
          <h6 class="text-center mb-0">Golden Plan</h6>
          <span class="text-xs">Get 10000 link shorteners</span>
          <ul class="list-unstyled text-xs mt-2">
            <li>Premium 24/7 support</li>
            <li>Reports</li>
            <li>QR code generator included</li>
          </ul>
          <hr class="horizontal dark my-3">
          <h5 class="mb-0">$19.99</h5>
          <div id="paypal-button-container-golden"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=AT48Y7gzxWgou98Al1qTklbvNyQ0T8WZcda-90m0H2KJftpTNeE37UEWCFOs8wsEMxprtl7o8y0qcoqf&currency=USD"></script>

<script>
  // Medium Plan
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '4.99'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        // Redirect to a PHP script to update the database
        window.location.href = "paypal/update_medium_plan.php?orderID=" + data.orderID;
      });
    },
    onCancel: function(data) {
      // Redirect to a PHP script to handle cancellations
      window.location.href = "paypal/cancel_purchase.php";
    }
  }).render('#paypal-button-container-medium');

  // Premium Plan
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '9.99'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        // Redirect to a PHP script to update the database
        window.location.href = "paypal/update_premium_plan.php?orderID=" + data.orderID;
      });
    },
    onCancel: function(data) {
      // Redirect to a PHP script to handle cancellations
      window.location.href = "paypal/cancel_purchase.php";
    }
  }).render('#paypal-button-container-premium');

  // Golden Plan
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '19.99'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        // Redirect to a PHP script to update the database
        window.location.href = "paypal/update_golden_plan.php?orderID=" + data.orderID;
      });
    },
    onCancel: function(data) {
      // Redirect to a PHP script to handle cancellations
      window.location.href = "paypal/cancel_purchase.php";
    }
  }).render('#paypal-button-container-golden');
</script>


            
     
    </div>
  </main>
 
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>

</html>