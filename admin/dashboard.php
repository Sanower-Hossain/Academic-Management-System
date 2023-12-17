<?php session_start();
include_once('../includes/config.php');
if (strlen($_SESSION['adminid'] == 0)) {
    header('location:logout.php');
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin Dashboard | Registration and Login System </title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            body {
                display: flex;
                justify-content: center;
            }

            h1.mt-4 {
                text-align: center;
            }

            /* For screens smaller than 576px */
            @media (max-width: 575.98px) {
                .col-md-6 {
                    flex: 0 0 100%;
                    max-width: 100%;
                }
            }

            /* For screens between 576px and 767.98px */
            @media (min-width: 576px) and (max-width: 767.98px) {
                .col-md-6 {
                    flex: 0 0 50%;
                    max-width: 50%;
                }
            }

            /* For screens between 768px and 991.98px */
            @media (min-width: 768px) and (max-width: 991.98px) {
                .col-md-6 {
                    flex: 0 0 50%;
                    max-width: 50%;
                }
            }

            /* For screens between 992px and 1199.98px */
            @media (min-width: 992px) and (max-width: 1199.98px) {
                .col-md-6 {
                    flex: 0 0 33.333333%;
                    max-width: 33.333333%;
                }
            }

            /* For screens larger than or equal to 1200px */
            @media (min-width: 1200px) {
                .col-md-6 {
                    flex: 0 0 25%;
                    max-width: 25%;
                }
            }

            .card {
                border-radius: 10px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                padding: 20px;
                background-color: #ffffff;
                color: #333333;
                height: 150px;
                width: 230px;
                padding: 20px;
                margin: 20px;
                border: 1px solid black;
                border-radius: 10px;
                box-shadow: 5px 5px 10px grey
            }

            .card-title {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .card-text {
                font-size: 16px;
                line-height: 1.5;
                margin-bottom: 20px;
            }

            .card-button {
                display: inline-block;
                padding: 10px 20px;
                border-radius: 5px;
                background-color: #0066cc;
                color: #ffffff;
                text-decoration: none;
                transition: all 0.2s ease-in-out;
            }

            .card-button:hover {
                background-color: #0052a3;
            }
        </style>
    </head>

    <body class="sb-nav-fixed">
        <?php include_once('includes/navbar.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"> Dashboard</h1>
                        <div class="row">
                            <?php
                            $query = mysqli_query($con, "select id from users");
                            $totalusers = mysqli_num_rows($query);
                            ?>

                            <?php
                            $query3 = "SELECT COUNT(*) as session_count FROM sessions";
                            $result = mysqli_query($con, $query3);
                            $row = mysqli_fetch_assoc($result);
                            $createdSessions = $row['session_count'];
                            ?>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card bg-primary text-white shadow">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-uppercase mb-1">Session</div>
                                                <div class="h5 mb-0 font-weight-bold text-white"><?php echo $createdSessions; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar-plus fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="sessions.php">Create New Session</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $query3 = "SELECT COUNT(*) as session_count FROM sessions";
                            $result = mysqli_query($con, $query3);
                            $row = mysqli_fetch_assoc($result);
                            $createdSessions = $row['session_count'];
                            ?>

                            <?php
                            $query3 = "SELECT COUNT(*) as session_count FROM sessions";
                            $result = mysqli_query($con, $query3);
                            $row = mysqli_fetch_assoc($result);
                            $createdSessions = $row['session_count'];
                            ?>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card bg-primary text-white shadow">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-uppercase mb-1">Session</div>
                                                <div class="h5 mb-0 font-weight-bold text-white"><?php echo $createdSessions; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar-plus fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="viewsession.php">View All Sessions</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $query3 = "SELECT COUNT(*) as session_count FROM sessions";
                            $result = mysqli_query($con, $query3);
                            $row = mysqli_fetch_assoc($result);
                            $createdSessions = $row['session_count'];
                            ?>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <?php
                                $query = "SELECT COUNT(*) AS total_sessions FROM sessions";
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($result);
                                $total_sessions = $row['total_sessions'];
                                ?>
                                <div class="card bg-success text-white shadow">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-uppercase mb-1">Create Course</div>
                                                <div class="h5 mb-0 font-weight-bold text-white"><?php echo $total_sessions; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="createcourse.php"></a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <?php
                                $query = "SELECT COUNT(*) AS total_courses FROM courses";
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($result);
                                $total_courses = $row['total_courses'];
                                ?>
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total Courses
                                        <span style="font-size:22px;"><?php echo $total_courses; ?></span>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="viewcourse.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total Registered Users
                                        <span style="font-size:22px;"> <?php echo $totalusers; ?></span>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="manage-users.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $query1 = mysqli_query($con, "select id from users where date(posting_date)=CURRENT_DATE()-1");
                            $yesterdayregusers = mysqli_num_rows($query1);
                            ?>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <?php
                                $query = "SELECT COUNT(*) AS total_courses FROM assigned_courses";
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($result);
                                $total_courses = $row['total_courses'];
                                ?>
                                <div class="card bg-info text-white shadow">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-uppercase mb-1">Assign Courses</div>
                                                <div class="h5 mb-0 font-weight-bold text-white"><?php echo $total_courses; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="assigncourses.php"></a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>

    </html>
<?php } ?>