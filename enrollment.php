<?php 
session_start();
include_once('includes/config.php');

if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {
    if(isset($_POST['enroll'])) {
        $course_id = $_POST['course_id'];
        $user_id = $_SESSION['id'];
        $enrollment_date = date('Y-m-d H:i:s');
        
        // Check if the course is already enrolled
        $check_enroll = mysqli_query($con, "SELECT * FROM enrolledcourse WHERE student_id='$user_id' AND course_id='$course_id'");
        if(mysqli_num_rows($check_enroll) > 0) {
            $_SESSION['error'] = "You have already enrolled for this course.";
            header('location: student.php');
            exit();
        }
        
        $enroll_query = mysqli_query($con, "INSERT INTO enrolledcourse(student_id, course_id, enrollment_date) VALUES ('$user_id', '$course_id', '$enrollment_date')");
        
        if($enroll_query) {
            $_SESSION['success'] = "You have successfully enrolled for the course.";
            header('location: viewenrolledcourse.php');
            exit();
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header('location: student.php');
            exit();
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard | Registration and Login System</title>
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
                    <h1 class="mt-4">Enrollment</h1>
                    <hr />
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Enrollment</li>
                    </ol>
                    <?php
                    $userid = $_SESSION['id'];
                    $query = mysqli_query($con, "select * from users where id='$userid'");
                    while ($result = mysqli_fetch_array($query)) { ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-table me-1"></i>
                                        Available Courses
                                    </div>
                                    <div class="card-body">
                                        <table id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php 
                                                $sql = mysqli_query($con, "SELECT * FROM courses");
                                                while($row=mysqli_fetch_array($sql)) { ?>
                                                <tr>
                                                    <td><?php echo $row['course_code']; ?></td>
                                                    <td><?php echo $row['course_name']; ?></td>
                                                    <td>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>">
                                                            <input type="submit" name="enroll" value="Enroll">
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
