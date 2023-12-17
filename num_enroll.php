<?php
session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {
    $userid = $_SESSION['id'];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Number of Enrollments | Registration and Login System</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>

    <body class="sb-nav-fixed">
        <?php include_once('includes/navbar.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Number of Enrollments</h1>
                        <div class="card mb-4">
                            <div class="card-body">
                                <form method="post" name="search" id="search">
                                    <div class="form-group mb-2">
                                        <label for="course_id">Select Course:</label>
                                        <select class="form-control" name="course_id" required>
                                            <option value="">Select Course</option>
                                            <?php
                                            $query = mysqli_query($con, "SELECT id, course_name FROM courses");
                                            while ($result = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $result['id']; ?>"><?php echo $result['course_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="search_btn" id="search_btn" class="btn btn-primary mb-2">Search</button>
                                </form>

                                <?php
                                if (isset($_POST['search_btn'])) {
                                    $course_id = $_POST['course_id'];
                                    $query = mysqli_query($con, "SELECT COUNT(*) as total_enrollments FROM enrollments WHERE course_id='$course_id'");
                                    $result = mysqli_fetch_array($query);
                                    $total_enrollments = $result['total_enrollments'];
                                ?>

                                    <div class="alert alert-info" role="alert">
                                        Total number of enrollments for <strong><?php echo $course_id; ?></strong> course is: <strong><?php echo $total_enrollments; ?></strong>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    </html>
<?php } ?>