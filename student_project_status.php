<?php
session_start();
include_once('includes/config.php');

// Check if student ID is set in the session and the user is a student
if (strlen($_SESSION['id']) == 0 || $_SESSION['designation'] != 'Student') {
    header('location:logout.php');
    exit;
}

// Get submitted projects for the logged in student
$submitted_projects_query = "SELECT projects.id, projects.name, projects.description, projects.deadline, projects.status, courses.course_code FROM projects INNER JOIN courses ON projects.course_id = courses.course_id INNER JOIN enrolledcourse ON courses.course_id = enrolledcourse.course_id WHERE enrolledcourse.student_id=" . $_SESSION['id'] . " AND projects.status != 'pending'";
$submitted_projects_result = $con->query($submitted_projects_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submitted Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        /* CSS for making the table responsive */
        .h1.c {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* CSS for making the table responsive */
        @media screen and (max-width: 600px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }

            td:nth-of-type(1):before {
                content: "Project ID:";
            }

            td:nth-of-type(2):before {
                content: "Project Name:";
            }

            td:nth-of-type(3):before {
                content: "Project Description:";
            }

            td:nth-of-type(4):before {
                content: "Deadline:";
            }

            td:nth-of-type(5):before {
                content: "Course Code:";
            }

            td:nth-of-type(6):before {
                content: "Status:";
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
                <h1 class="c">View Submitted Projects</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Project Name</th>
                            <th>Project Description</th>
                            <th>Deadline</th>
                            <th>Course Code</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $submitted_projects_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['deadline']; ?></td>
                                <td><?php echo $row['course_code']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </main>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
            <script src="js/datatables-simple-demo.js"></script>
</body>

</html>