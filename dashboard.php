<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    die();
}
include_once 'class/User.php';
;
$user = new User();
if (isset($_GET['logout'])) {
    $user->signoutUser();
    header('Location: index.php');
    die();
}
$_user = $user->getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <title>Babysitting - Dashboard</title>
        <link rel='stylesheet prefetch' href='css/bootstrap.min.css'>
        <link rel='stylesheet prefetch' href='css/bootstrap-datepicker.min.css'>
        <link rel="stylesheet" href="css/dashboard.css">
    </head>

    <body class="sidebar-is-reduced">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a href="#" class="navbar-brand">Babysitting</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="#" class="nav-item nav-link active">Home</a>
                    <a href="#" class="nav-item nav-link">About</a>
                    <a href="#" class="nav-item nav-link">Products</a>
                </div>
                <form class="form-inline ml-auto">
                    <input type="text" class="form-control mr-sm-2" placeholder="Search">
                    <button type="submit" class="btn btn-outline-light">Search</button>
                </form>
                <div class="navbar-nav">
                    <a href="dashboard.php?logout=1" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </nav>
        <div class="container first">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#overview" class="nav-link active" data-toggle="tab">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="#appoint" class="nav-link" data-toggle="tab">Add an appointment</a>
                </li>
                <li class="nav-item">
                    <a href="#child" class="nav-link" data-toggle="tab">Add a child</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="overview">
                    <div class="container first">
                        <div class="jumbotron">
                            <h1 class="display-4">Welcome back, <?= $_user['name'] ?>!</h1>
                            <p class="lead">Looks like you have no appointment yet!</p>
                            <hr class="my-4">
                            <p>This is a place where you'll be seeing all your appointments and monitor them in one place, to order a babysitting service please <i>create an appointment.</i></p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="appoint">
                    <div class="col-md-6 first">
                        <form class="form" method="POST" id="appointment">
                            <div class="form-group">
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" name="date" class="form-control" placeholder="Select the date">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="custom-select" name="child">
                                    <option value="1">Child 1</option>
                                    <option value="2">Child 2</option>
                                    <option value="3">Child 3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="custom-select" name="service">
                                    <option value="1">Day service</option>
                                    <option value="2">Evening service</option>
                                    <option value="3">Night service</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" id="btnSignup" class="btnSubmit" value="Add an appointment" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="child">
                    <p>Messages tab content ...</p>
                </div>
            </div>
        </div>


        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src='js/bootstrap.min.js'></script>
        <script src='js/bootstrap-datepicker.min.js'></script>
        <script src="js/dashboard.js"></script>
    </body>
</html>