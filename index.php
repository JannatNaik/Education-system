<?php
session_start();    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Education Platform</title>
    <style>
        .foot{
            bottom:0%;
        }
        .fs{
            font-size: 100px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <div class="container dark text-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-primary text-light">
        <a class="navbar-brand text-ligh" href="#">SMART EDUCATION PLATFORM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Register</a>
                </li>
            </ul>
        </div> -->
    </nav>
</div>
<div class="container text-center ">
<!--  -->
<?php
echo "<p class='fs'>Welcome User</p>";          
                    ?></div>
        <!-- Registration Links -->
        <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Register as Student</h5>
                        <!-- <a href="#" class="btn btn-success">Register</a> -->
                        <a href="register_student.php" class="btn btn-success">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Register as Teacher</h5>
                        <a href="register_teacher.php" class="btn btn-success">Register</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
    <!-- Footer -->
     <div class="foot">
    <footer class="bg-light text-center text-lg-start mt-5 foot">
        <div class="text-center p-3 ">
            © 2024 Smart Education Platform. All rights reserved.
        </div>
    </footer>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
