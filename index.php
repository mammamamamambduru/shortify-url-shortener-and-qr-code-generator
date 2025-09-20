<?php 

session_start();

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ApexCharts CSS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        body {
            background-color: #ffffff;
            color: #333333;
            font-family: 'Open Sans', sans-serif !important;
            overflow-x: hidden;
        }
        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('imagses/url.svg') repeat;
            z-index: -1;
            animation: moveBackground 14s linear infinite;
        }
        @keyframes moveBackground {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 0 100%;
            }
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #6a11cb;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2575fc;
        }
        .blk {
            color: #343f52;
            font-weight: 700 !important;
            background: white;
            border-radius: 10px;
            padding: 10px;
        }
        .navbar {
            background-color: white;
            padding: 1rem;
        }
        .navbar-brand {
            color: #6a11cb;
            font-size: 2rem;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: #2575fc;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #6a11cb;
        }
        .left-column, .right-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }
        .card-large {
            height: 100%;
            padding: 20px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
        }
        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }
        .chart-container {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
        }
        .form-control {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="background-animation"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Solutions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pricing.php">Pricing</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Support</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-custom" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="register.php">Get Started</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container mt-5">
        <div class="row align-items-center">
            <!-- Left Column with Form -->
            <div class="col-md-6 left-column">
                <div class="card p-4">
                    <h2 class="fs-2 text-center mb-4">Intuitive, Secure, and Dynamic</h2>
                    <p class="fs-5 text-center">Boost your campaigns by creating dynamic links, QR codes, and bio pages, and get instant analytics.</p>
                    <!-- Formulario para Shorten URL -->
                <form action="shorten.php" method="POST">
                    <div class="mb-3">
                        <label for="url" class="form-label">Pega una URL larga</label>
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
                        <strong>¡Limit reached!</strong> Has alcanzado el número máximo de enlaces permitidos este mes.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                </div>
            </div>

            <!-- Right Column with Chart -->
            <div class="col-md-6 right-column d-none d-md-block">
                <div class="card-large">
                    <div class="blk text-center mb-4 d-flex align-items-center">
                        <i class="fs-3 fas fa-link me-2"></i>
                        <div>
                            <span class="fs-3 d-block">Premium</span>
                            <p class="mb-0">https://examples.scattered.com/shortener/</p>
                        </div>
                    </div>
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
                    <div class="chart-container" id="chartContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="container mt-5">
        <div class="row text-center">
            <h2 class="fw-bold mb-4">Why Choose Our URL Shortener?</h2>
        </div>
        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 h-100 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="icon mb-3">
                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Real-Time Analytics</h5>
                    <p>Get detailed link analytics, including clicks, location, and devices used.</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 h-100 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="icon mb-3">
                        <i class="fas fa-lock fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Security and Privacy</h5>
                    <p>Your links are protected with advanced technology to ensure data safety.</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 h-100 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="icon mb-3">
                        <i class="fas fa-qrcode fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">QR Code Generation</h5>
                    <p>Create custom QR codes for your links and share them easily anywhere.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="container mt-5">
        <div class="row text-center">
            <h2 class="fw-bold mb-4">What Our Users Say</h2>
            <p class="text-muted mb-4">Thousands of users trust us to enhance their campaigns and links.</p>
        </div>
        <div class="row">
            <!-- Testimonial 1 -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 h-100 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="images/carlosgarcia.png" alt="User 1" class="rounded-circle me-3">
                        <div>
                            <h6 class="fw-bold mb-0">Basharul Alam Siddiki</h6>
                            <p class="text-muted mb-0">Digital Marketing</p>
                        </div>
                    </div>
                    <p>"This URL shortener has transformed the way I manage my links. The analytics are amazing!"</p>
                </div>
            </div>
            <!-- Testimonial 2 -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 h-100 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="images/marialopez.png" alt="User 2" class="rounded-circle me-3">
                        <div>
                            <h6 class="fw-bold mb-0">Hafijul Islam</h6>
                            <p class="text-muted mb-0">Entrepreneur</p>
                        </div>
                    </div>
                    <p>"I love how easy it is to use and how I can generate QR codes for my campaigns in seconds."</p>
                </div>
            </div>
            <!-- Testimonial 3 -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 h-100 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="images/juanperez.png" alt="User 3" class="rounded-circle me-3">
                        <div>
                            <h6 class="fw-bold mb-0">Nazmul</h6>
                            <p class="text-muted mb-0">Freelancer</p>
                        </div>
                    </div>
                    <p>"The design and functionality of this URL shortener are top-notch. I 100% recommend it."</p>
                </div>
            </div>
        </div>
    </div>
    <!-- New modern and attractive section -->
<div class="container mt-5">
    <div class="p-4 rounded-3 shadow-sm h-100" style="background: linear-gradient(135deg, #6a11cb, #2575fc); color: white; border-radius: 20px;">
        <div class="text-center">
            <h4 class="fw-bold mb-3">Discover the Future of Links</h4>
            <p class="mb-4">Boost your digital strategy with tools designed to stand out.</p>
        </div>
        <div class="d-flex justify-content-between text-center">
            <!-- Card 1 -->
            <div class="card border-0 p-3" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 15px;">
                <i class="fas fa-chart-line fa-2x mb-3"></i>
                <h6 class="fw-bold">Advanced Analytics</h6>
                <p class="small">Get detailed metrics for every click.</p>
            </div>
            <!-- Card 2 -->
            <div class="card border-0 p-3" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 15px;">
                <i class="fas fa-lock fa-2x mb-3"></i>
                <h6 class="fw-bold">Total Security</h6>
                <p class="small">Protect your links with advanced encryption.</p>
            </div>
            <!-- Card 3 -->
            <div class="card border-0 p-3" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 15px;">
                <i class="fas fa-magic fa-2x mb-3"></i>
                <h6 class="fw-bold">Customization</h6>
                <p class="small">Create unique and memorable links.</p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="register.php" class="btn btn-light text-primary fw-bold px-4 py-2" style="border-radius: 25px;">Get Started Now!</a>
        </div>
    </div>
</div>
<!-- "Sign Up Now" section -->
<div class="col-md-12 mt-5">
    <div class="p-5 rounded-3 shadow-sm">
        <div class="text-center">
            <h3 class="fw-bold mb-3">Sign Up Now</h3>
            <p class="mb-4 fs-5">Get advanced statistics, improve your URLs, and access exclusive benefits.</p>
        </div>
        <div class="d-flex justify-content-center">
            <!-- Benefit 1 -->
            <div class="card border-0 mx-3 p-4 text-center" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 15px; width: 250px;">
                <i class="fas fa-chart-pie fa-3x mb-3" style="background: linear-gradient(135deg, #6a11cb, #2575fc); color: white; border-radius: 20px;"></i>
                <h6 class="fw-bold">Advanced Statistics</h6>
                <p class="small">Visualize the performance of your links with detailed data.</p>
            </div>
            <!-- Benefit 2 -->
            <div class="card border-0 mx-3 p-4 text-center" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 15px; width: 250px;">
                <i class="fas fa-tools fa-3x mb-3" style="background: linear-gradient(135deg, #6a11cb, #2575fc); color: white; border-radius: 20px;"></i>
                <h6 class="fw-bold">Customized Improvements</h6>
                <p class="small">Optimize your URLs with unique customization options.</p>
            </div>
            <!-- Benefit 3 -->
            <div class="card border-0 mx-3 p-4 text-center" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 15px; width: 250px;">
                <i class="fas fa-gift fa-3x mb-3" style="background: linear-gradient(135deg, #6a11cb, #2575fc); color: white; border-radius: 20px;"></i>
                <h6 class="fw-bold">Exclusive Benefits</h6>
                <p class="small">Access premium tools designed for you.</p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="register.php" class="btn btn-light text-primary fw-bold px-5 py-3" style="border-radius: 30px; font-size: 1.2rem;">Sign Up Now!</a>
        </div>
    </div>
</div>
<footer style="background: linear-gradient(135deg, #6a11cb, #2575fc); color: white; padding: 3rem 0;">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">About Us</h5>
                <p class="small">We provide tools to create dynamic links, QR codes, and bio pages, helping you optimize your campaigns and access real-time analytics.</p>
            </div>
            <!-- Quick Links -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light text-decoration-none small">Home</a></li>
                    <li><a href="#" class="text-light text-decoration-none small">Features</a></li>
                    <li><a href="#" class="text-light text-decoration-none small">Pricing</a></li>
                    <li><a href="#" class="text-light text-decoration-none small">Contact</a></li>
                </ul>
            </div>
            <!-- Contact Section -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Contact Us</h5>
                <p class="small mb-2"><i class="fas fa-envelope me-2"></i> support@example.com</p>
                <p class="small mb-2"><i class="fas fa-phone me-2"></i> +1 234 567 890</p>
                <p class="small"><i class="fas fa-map-marker-alt me-2"></i> 123 Main Street, City, Country</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <p class="small text-muted mb-0">&copy; 2025 Your Company. All Rights Reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" class="text-light"><i class="fab fa-linkedin fa-lg"></i></a>
            </div>
        </div>
    </div>
</footer>

</body>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
            chart: {
                type: 'line',
                height: 350,
                toolbar: { show: false }
            },
            series: [{
                name: "Clicks",
                data: [10, 20, 30, 40, 50, 60, 70]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ['#2575fc'],
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 5
            },
            markers: {
                size: 5,
                colors: '#2575fc',
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: { size: 7 }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartContainer"), options);
        chart.render();
    </script>
</body>
</html>
