<?php
session_start();
include_once('includes/config.php');

// Check if teacher ID is set in the session
if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
}

// Check if course ID is set in the URL parameter
if (!isset($_GET['course_id']) || strlen($_GET['course_id']) == 0) {
    header('location:dashboard.php');
} else {
    $course_id = $_GET['course_id'];

    // Fetch course data from database using course ID from URL parameter
    $query = "SELECT * FROM courses WHERE course_id='" . $course_id . "'";
    $result = $con->query($query);
    $course = $result->fetch_assoc();

    // Fetch enrolled students data from database using course ID from URL parameter
    $query = "SELECT users.fname, users.lname, users.email,users.id FROM users INNER JOIN enrolledcourse ON users.id=enrolledcourse.student_id WHERE enrolledcourse.course_id='" . $course_id . "'";
    $result = $con->query($query);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Students</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        /* table styles */


        table {
            border-collapse: collapse;
            width: 100%;

            margin: 0 auto;
            font-family: Arial, sans-serif;
            font-size: 14px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            padding: 10px;
            text-align: center;
        }

        table td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        /* responsive styles */
        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }

            table th,
            table td {
                padding: 5px;
            }
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main class="c">
                <h1>Enrolled Students</h1>
                <hr>
                <h2><?php echo $course['course_code']; ?> - <?php echo $course['course_name']; ?></h2>
                <p>Total number of enrolled students: <?php echo $result->num_rows; ?></p>

                <table class="table-container">
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['fname'] . '</td>';
                            echo '<td>' . $row['lname'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">No students enrolled in this course.</td></tr>';
                    }
                    ?>
                </table>
            </main>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
          
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
            <script src="js/datatables-simple-demo.js"></script>
</body>

</html>

<?php
// Close the database connection after the query results have been processed
$con->close();
?>