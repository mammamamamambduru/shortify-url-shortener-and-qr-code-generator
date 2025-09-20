<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Plans</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .price {
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(to right, blue, purple);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
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

    <!-- Pricing Section -->
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Choose Your Plan</h2>
            <p class="text-muted">Select the plan that fits your needs and start shortening your URLs today!</p>
        </div>
        <div class="row">
            <!-- Free Plan -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Free</h5>
                        <p class="price">$0</p>
                        <p class="text-muted">No registration required</p>
                        <ul class="list-unstyled">
                            <li>Up to <strong>50 shortened URLs</strong></li>
                            <li>Free statistics</li>
                            <li>Reports</li>
                            <li>QR code generator included</li>
                        </ul>
                        <a href="payment.php" class="btn btn-outline-primary w-100">Get Started</a>
                    </div> 
                </div>
            </div>
            <!-- Medium Plan -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Medium</h5>
                        <p class="price">$9.99</p>
                        <p class="text-muted">Perfect for small businesses</p>
                        <ul class="list-unstyled">
                            <li><strong>1500 shortened URLs</strong></li>
                            <li>Unlimited statistics</li>
                            <li>Reports</li>
                            <li>Standard support</li>
                            <li>QR code generator included</li>
                        </ul>
                        <a href="#" class="btn btn-primary w-100">Choose Plan</a>
                    </div>
                </div>
            </div>
            <!-- Premium Plan -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Premium</h5>
                        <p class="price">$19.99</p>
                        <p class="text-muted">For professionals and enterprises</p>
                        <ul class="list-unstyled">
                            <li><strong>10000 URL shortening</strong></li>
                            <li>Premium statistics</li>
                            <li>Reports</li>
                            <li>24/7 support</li>
                            <li>QR code generator included</li>
                        </ul>
                        <a href="#" class="btn btn-primary w-100">Choose Plan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
