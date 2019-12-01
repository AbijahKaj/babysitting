<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    die();
}
include_once 'class/User.php';
include_once 'class/Appointment.php';
$user = new User();
if (isset($_GET['logout'])) {
    $user->signoutUser();
    header('Location: index.php');
    die();
}
$_user = $user->getCurrentUser();
$children = $user->getChildren();
$appointments = $user->getAppointments();
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
                        <?php if (empty($appointments)) { ?>
                            <div class="jumbotron">
                                <h1 class="display-4">Welcome back, <?= $_user['name'] ?>!</h1>
                                <p class="lead">Looks like you have no appointment yet!</p>
                                <hr class="my-4">
                                <p>This is a place where you'll be seeing all your appointments and monitor them in one place, to order a babysitting service please <i>create an appointment.</i></p>
                            </div>
                            <?php
                        } else {
                            ?>
                        <h2 class="h3">Your appointments</h2>
                            <div class="list-group col-md-8">
                                <?php
                                foreach ($appointments as $appointment) {
                                    ?>
                                    <div class="list-group-item col-md-12">
                                        <span class="col-md-4">
                                            <?= $appointment['child'] ?>
                                        </span>
                                        <span class="col-md-5">
                                            <i><?= $appointment['price'] ?>ugx</i>
                                        </span>
                                        <span class="col-md-5">
                                            Created on: <b><?= date("d-m-Y", $appointment['created']) ?></b>
                                        </span>
                                        <span class="col-md-5">
                                            Status: <i class=""><?= Appointment::getStatus($appointment['status']) ?></i>
                                        </span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        if(!empty($children)) {
                            ?>
                        <h2 class="h3 first">Your Children</h2>
                            <div class="list-group col-md-8">
                                <?php
                                foreach ($children as $child) {
                                    ?>
                                    <div class="list-group-item col-md-12">
                                        <span class="col-md-4">
                                            <?= $child['name'] ?>
                                        </span>
                                        <span class="col-md-5">
                                            <i><?= $child['age'] ?> years old</i>
                                        </span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="appoint">
                    <div class="col-md-6 first">
                        <form class="form" method="POST" id="appointment">
                            <div class="form-group">
                                <select class="custom-select" name="child">
                                    <?php foreach ($children as $child) {
                                        ?>
                                        <option value="<?= $child['id'] ?>"><?= $child['name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="custom-select" name="service">
                                    <option value="1">Morning service</option>
                                    <option value="2">Day service</option>
                                    <option value="3">Evening service</option>
                                    <option value="4">Night service</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="hours" class="form-control" placeholder="How many hours?" value="" />
                            </div>

                            <div class="form-group">
                                <input type="submit" id="btnAppoint" class="btnSubmit" value="Add an appointment" />
                            </div>
                        </form>
                    </div>
                </div>


                <div class="tab-pane fade" id="child">
                    <div class="col-md-6 first">
                        <form class="form" method="POST" id="child-form">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Name of your child" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="age" class="form-control" placeholder="Age of your child" value="" />
                            </div>
                            <div class="form-group">
                                <input type="submit" id="btnChild" class="btnSubmit" value="Add a child" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src='js/bootstrap.min.js'></script>
        <script src='js/bootstrap-datepicker.min.js'></script>
        <script src="js/dashboard.js"></script>
    </body>
</html>