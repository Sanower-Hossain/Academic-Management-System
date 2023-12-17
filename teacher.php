<?php
session_start();
include_once('includes/config.php');

// Check if teacher ID is set in the session and the user is a teacher
if (strlen($_SESSION['id']) == 0 || $_SESSION['designation'] != 'Teacher') {
    header('location:logout.php');
    exit;
} else {
    // Fetch teacher data from database using teacher ID from session
    $query = "SELECT * FROM users WHERE id='" . $_SESSION['id'] . "'";
    $result = $con->query($query);
    $teacher = $result->fetch_assoc();

    // Get assigned courses and number of enrolled students for each course
    $assigned_courses_query = "SELECT courses.course_id, courses.course_code, COUNT(enrolledcourse.student_id) AS num_students FROM courses LEFT JOIN assigned_courses ON courses.course_id = assigned_courses.course_id LEFT JOIN enrolledcourse ON courses.course_id = enrolledcourse.course_id WHERE assigned_courses.teacher_id=" . $teacher['id'] . " GROUP BY courses.course_id";
    $assigned_courses_result = $con->query($assigned_courses_query);

    // Get number of submitted projects for each assigned course
    $submitted_projects_query = "SELECT courses.course_id, COUNT(projects.id) AS num_projects FROM courses LEFT JOIN assigned_courses ON courses.course_id = assigned_courses.course_id LEFT JOIN projects ON courses.course_id = projects.course_id WHERE assigned_courses.teacher_id=" . $teacher['id'] . " AND projects.status='submitted' GROUP BY courses.course_id";
    $submitted_projects_result = $con->query($submitted_projects_query);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        /* Add a custom font */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            line-height: 1.5;
        }

        /* Add a background color */
        body {
            background-color: #f2f2f2;
        }

        /* Center the main content */
        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* Add styles for headings */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 36px;
        }

        h2 {
            font-size: 24px;
        }

        h3 {
            font-size: 20px;
        }

        h4 {
            font-size: 18px;
        }

        h5 {
            font-size: 16px;
        }

        h6 {
            font-size: 14px;
        }

        /* Add styles for links */
        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Add styles for buttons */
        #c.btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        #c.btn:hover {
            background-color: #0062cc;
        }

        /* Add styles for tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        /* Add responsive styles */
        @media (max-width: 767px) {
            main {
                padding: 20px;
            }

            h1 {
                font-size: 28px;
            }

            h2 {
                font-size: 20px;
            }

            h3 {
                font-size: 18px;
            }

            h4 {
                font-size: 16px;
            }

            h5 {
                font-size: 14px;
            }

            h6 {
                font-size: 12px;
            }

            table {
                font-size: 14px;
            }

            #c.btn {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>

</head>

<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <h1>Teacher Dashboard</h1>
                <hr>
                <h2>Welcome, <?php echo $teacher['fname'] . ' ' . $teacher['lname']; ?></h2>
                <p>Your ID is: <?php echo $teacher['id']; ?></p>

                <h3>Assigned Courses</h3>
                <?php
                if ($assigned_courses_result->num_rows > 0) {
                    while ($row = $assigned_courses_result->fetch_assoc()) {
                        echo '<div>';
                        echo '<h4>' . $row['course_code'] . '</h4>';
                        echo '<p>Number of Enrolled Students: ' . $row['num_students'] . ' <button id="c" class="btn btn-primary btn-sm" onclick="location.href=\'viewenrolled.php?course_id=' . $row['course_id'] . '\'">View</button></p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No courses assigned.</p>';
                }
                ?>

                <h3 class="d-flex align-items-center">
                    Submitted Projects
                    <a href="submit_projects.php" id="c" class="btn btn-primary ml-auto">View</a>
                </h3>
                <?php
                if ($submitted_projects_result->num_rows > 0) {
                    while ($row = $submitted_projects_result->fetch_assoc()) {
                        echo '<div>';
                        echo '<h4>Course ID: ' . $row['course_id'] . '</h4>';
                        echo '<p>Number of Submitted Projects: <a href="viewsubmitted.php?course_id=' . $row['course_id'] . '">' . $row['num_projects'] . '</a></p>';
                        echo '</div>';
                    }
                } 
                ?>
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