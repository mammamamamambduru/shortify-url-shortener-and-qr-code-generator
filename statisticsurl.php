<?php
include "connection/connection.php";
if (!isset($_SESSION['id'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Stop script execution
}
// Check if the 'id' parameter was passed
if (isset($_GET['id'])) {
    $short_id = $conn->real_escape_string($_GET['id']);

    // Query to verify if the link exists
    $sql = "SELECT original_url, created_at FROM urls WHERE short_id = '$short_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $link = $result->fetch_assoc();

        // Total clicks
        $total_clicks_sql = "SELECT COUNT(*) AS total_clicks FROM visits WHERE short_id = '$short_id'";
        $total_clicks = $conn->query($total_clicks_sql)->fetch_assoc()['total_clicks'];

        // Clicks of the day
        $today = date('Y-m-d');
        $daily_clicks_sql = "SELECT COUNT(*) AS daily_clicks FROM visits WHERE short_id = '$short_id' AND DATE(visit_time) = '$today'";
        $daily_clicks = $conn->query($daily_clicks_sql)->fetch_assoc()['daily_clicks'];

        // Clicks of the month
        $current_month = date('Y-m');
        $monthly_clicks_sql = "SELECT COUNT(*) AS monthly_clicks FROM visits WHERE short_id = '$short_id' AND DATE_FORMAT(visit_time, '%Y-%m') = '$current_month'";
        $monthly_clicks = $conn->query($monthly_clicks_sql)->fetch_assoc()['monthly_clicks'];

        // Month with the most visits
        $most_active_month_sql = "
            SELECT DATE_FORMAT(visit_time, '%Y-%m') AS month, COUNT(*) AS visits
            FROM visits
            WHERE short_id = '$short_id'
            GROUP BY month
            ORDER BY visits DESC
            LIMIT 1";
        $most_active_month_result = $conn->query($most_active_month_sql);
        $most_active_month = $most_active_month_result->fetch_assoc();

        // Visits by country
        $country_visits_sql = "
            SELECT country, COUNT(*) AS visits
            FROM visits
            WHERE short_id = '$short_id'
            GROUP BY country
            ORDER BY visits DESC";
        $country_visits = $conn->query($country_visits_sql);

        // Last visits with referrer
        $latest_visits_sql = "
            SELECT ip_address, country, visit_time, referrer
            FROM visits
            WHERE short_id = '$short_id'
            ORDER BY visit_time DESC
            LIMIT 10";
        $latest_visits = $conn->query($latest_visits_sql);
    } else {
        die("The link does not exist.");
    }
} else {
    die("A valid ID was not provided.");
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
    Statistics - Link Shortener
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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="statistics.php">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">statistics</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">statistics</h6>
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Clicks today</p>
                    <h5 class="font-weight-bolder">
                      <?= $daily_clicks ?> clicks
                    </h5> 
                    <p class="mb-0">
                  
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">
					Clicks this month</p>
                    <h5 class="font-weight-bolder">
                     <?= $monthly_clicks ?> clicks
                    </h5>
                  
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total clicks</p>
                    <h5 class="font-weight-bolder">
                      <?= $total_clicks ?> clicks
                    </h5>
      
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Month with the most visits</p>
                    <h5 class="font-weight-bolder">
                      <?= isset($most_active_month['month']) ? $most_active_month['month'] : 'Sin datos' ?> 
                (<?= isset($most_active_month['visits']) ? $most_active_month['visits'] : 0 ?> clics)
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
  
                     
            </div>
          </div>
        </div>



  <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Visit Statistics for the Link: <?= $short_id ?></h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">IP</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">País</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Referer</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($latest_visits && $latest_visits->num_rows > 0): ?>
                                    <?php while ($visit = $latest_visits->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $visit['ip_address'] ?></td>
                                            <td><?= $visit['country'] ?></td>
                                            <td><?= date("d/m/Y H:i", strtotime($visit['visit_time'])) ?></td>
                                            <td>
                                                <?= $visit['referrer'] ? "<a href='{$visit['referrer']}' target='_blank'>{$visit['referrer']}</a>" : 'N/A' ?>
                                            </td>
                                            <td class="text-end">
                                                <!-- Here you can add any additional actions, such as editing or deleting. -->
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">There are no registered visits.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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