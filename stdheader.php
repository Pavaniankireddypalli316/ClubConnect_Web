<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <!--javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <style>
        .navbar {
            background-color: #f03248 !important;
        }

        .navbar-brand img {
            border-radius: 50%; /* Make the logo round */
        }

        .navbar-toggler {
            border: 2px solid white; /* Add border to the toggle button */
        }

        .navbar-nav {
            display: flex;
            align-items: center;
        }

        .nav-item {
            margin: 0 10px;
        }

        .nav-link {
            font-family: 'Saira Semi Condensed', sans-serif;
            font-weight: bold;
            color: white;
            position: relative;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 10px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #dcb3ff; /* Updated color on hover */
            border-radius: 10px;
            z-index: -1;
            transition: opacity 0.3s;
            opacity: 0;
        }

        .nav-link:hover {
            color: black;
            background-color: transparent; /* Updated background color on hover */
        }

        .nav-link:hover::before {
            opacity: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="logo.png" alt="logo" height="35" width="45" style="margin: 1rem 2rem;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="stdhome.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stdenroll.php">Enrollment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stdattendance.php">Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stdprofile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stdmycourse.php">My Clubs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Logout</a>
                </li>
            </ul>
        </div>
    </nav>    
</body>
</html>
