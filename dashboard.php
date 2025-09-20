<?php 
include "connection/connection.php";
if (!isset($_SESSION['id'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Stop script execution
}
$correo = $_SESSION['email'];




if (!empty($correo)) {
    // Query to count URLs in the 'urls' table
    $sqlUrls = "SELECT COUNT(*) AS total_urls FROM urls WHERE user_email = '$correo'";
    $resultUrls = $conn->query($sqlUrls);

    // Query to get the remaining links in the 'users' table
    $sqlEnlacesRestantes = "SELECT remaining_links, plan FROM users WHERE email = '$correo'";
    $resultEnlacesRestantes = $conn->query($sqlEnlacesRestantes);

    // Process results of both queries
    if ($resultUrls && $resultUrls->num_rows > 0) {
        $rowUrls = $resultUrls->fetch_assoc();
        $totalUrls = $rowUrls['total_urls'];
        
    } else {
        
    }

    if ($resultEnlacesRestantes && $resultEnlacesRestantes->num_rows > 0) {
        $rowEnlaces = $resultEnlacesRestantes->fetch_assoc();
        $enlacesRestantes = $rowEnlaces['remaining_links'];
        $plan = $rowEnlaces['plan'];
       
    } else {
       
    }
} else {
    echo "The email is not defined.";
}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Link Shortener</title>
    <!-- Enlace a Bootstrap CSS -->
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">List of URLs used</p>
                    <h5 class="font-weight-bolder">
                      <?php echo " $totalUrls"; ?> URLs
                    </h5> 
                    <p class="mb-0">
                  
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-world-2 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">User Name</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $_SESSION['username']; ?>
                    </h5>
                  
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-circle-08  text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Links for use</p>
                    <h5 class="font-weight-bolder">
                      <?php echo "$enlacesRestantes"; ?> URLs
                    </h5>
      
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-world-2 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Subscription type</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $plan; ?>
                    </h5>
                   
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              
            
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <h2 class="fs-2 text-center mb-4">Intuitive, Secure, and Dynamic</h2>
                    <p class="fs-5 text-center">Boost your campaigns by creating dynamic links, QR codes, and bio pages, and get instant analytics.</p>
                     <form action="shortendash.php" method="POST">
                    <div class="mb-3">
                        <label for="url" class="form-label">Paste a long URL</label>
                        <input type="url" class="form-control" id="url" name="url" placeholder="https://example.com" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Shorten URL</button>
                    </div>
                </form>
                  <!-- Mensajes de Alerta -->
                <?php if (isset($_GET['shortened_url'])): ?><br>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Shortened link generated!</strong> Tu enlace es: <a href="<?= htmlspecialchars($_GET['shortened_url']); ?>" target="_blank"><?= htmlspecialchars($_GET['shortened_url']); ?></a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['limit_reached'])): ?><br> 
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>¡Limit reached!</strong> You have reached the maximum number of links allowed this month.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card card-carousel overflow-hidden h-100 p-0">
            <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
              <div class="carousel-inner border-radius-lg h-100">
                <div class="carousel-item h-100 active" style="background-image: url('images/acortador-url.png');
      background-size: cover;">
                  <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      <i class="ni ni-camera-compact text-dark opacity-10"></i>
                    </div>
                    <h5 class="text-black mb-1">Start building links.</h5>
                    <p >Make links in a more professional way for your clients</p>
                  </div>
                </div>
                
          </div>
        </div>
      </div>

    
    </div>
  </main>
  
  <!--   Core JS Files   -->
  <script src="css/assets/js/core/popper.min.js"></script>
  <script src="css/assets/js/core/bootstrap.min.js"></script>
  <script src="css/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="css/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="css/assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
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
