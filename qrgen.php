<?php
include "connection/connection.php";
if (!isset($_SESSION['id'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Stop script execution
}

// Include the PHP QR Code library
include 'qr-code/qrlib.php';

// Check if the form was sent


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    qr gen- Link shortener
  </title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="css/assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">QR Code Generator</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">QR Code Generator</h6>
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
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>QR Code Generator</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <div class="container mt-5">
        <h2 class="text-center">QR Code Generator</h2>

        <!-- Formulario para ingresar el enlace -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="url" class="form-label">Enter URL</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="Enter your URL here" required>
            </div>
            <button type="submit" class="btn btn-primary">Generate QR Code</button>
        </form>
    </div>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form link
    $data = $_POST['url'];

    // Check that the link is not empty
    if (!empty($data)) {
        // Path where the QR image will be saved
        $file = 'qr-code-output.png';

        // Generate the QR code
        QRcode::png($data, $file);

        // Display the generated QR code
        echo '<h3 class="text-center">QR Code for: ' . htmlspecialchars($data) . '</h3>';
        echo '<img class="text-center"  src="' . $file . '" alt="QR Code" >';
    } else {
        echo '<div class="alert alert-danger">Please enter a valid URL.</div>';
    }
} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
     
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