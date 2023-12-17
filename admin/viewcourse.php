<?php
session_start();
include_once('../includes/config.php');

if (strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
} else {
    $query = "SELECT courses.*, sessions.session_name FROM courses INNER JOIN sessions ON courses.session_id = sessions.session_id";
    $result = mysqli_query($con, $query);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>View Courses</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <style>
          h1.c{
            text-align: center;
          }

            /* CSS for responsive table */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* CSS for responsive navigation bar */
            .navbar-collapse {
                overflow-x: visible;
            }

            /* CSS for adjusting layout on small screens */
            @media screen and (max-width: 768px) {
                #layoutSidenav {
                    padding-top: 60px;
                }

                #layoutSidenav_content {
                    margin-left: 0;
                }
            }

            /* Responsive table */
            @media (max-width: 767px) {
                .table-responsive {
                    overflow-x: auto;
                }
            }

            /* Table styles */
            table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
                border-collapse: collapse;
            }

            thead {
                background-color: #f8f9fa;
            }

            th,
            td {
                padding: 0.75rem;
                vertical-align: middle;
                text-align: center;
                border: 1px solid #dee2e6;
            }

            th {
                font-weight: 500;
                text-transform: uppercase;
            }

            /* Table hover */
            tbody tr:hover {
                background-color: #f5f5f5;
            }

            /* Action buttons */
            .action-buttons {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .action-buttons a {
                display: inline-block;
                margin-right: 10px;
                padding: 6px 12px;
                background-color: #007bff;
                color: #fff;
                border-radius: 50px;
                transition: background-color 0.2s ease-in-out;
                text-align: center;
            }

            .action-buttons a:hover {
                background-color: #0069d9;
                color: #fff;
                text-decoration: none;
            }

            /* Responsive layout */
            @media (max-width: 767px) {
                .container {
                    max-width: 100%;
                    padding-right: 15px;
                    padding-left: 15px;
                }
            }

            .edit-button,
            .delete-button {
                display: inline-block;
                padding: 6px 12px;
                background-color: transparent;
                color: #007bff;
                border: 1px solid #007bff;
                border-radius: 5px;
                cursor: pointer;
                transition: all 0.2s ease-in-out;
                text-align: center;
                text-decoration: none;
                margin-right: 10px;
            }

            .edit-button:hover,
            .delete-button:hover {
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
            }

            .delete-button {
                color: #dc3545;
                border-color: #dc3545;
            }

            .delete-button:hover {
                background-color: #dc3545;
            }
        </style>
    </head>

    <body class="sb-nav-fixed">
        <?php include_once('includes/navbar.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <h1 class="c">View Courses</h1>

                    <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div>' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    }
                    ?>

                    <table class="c">
                        <tr>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Course Credit</th>
                            <th>Session</th>
                            <th>Actions</th>
                        </tr>

                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['course_name']; ?></td>
                                <td><?php echo $row['course_code']; ?></td>
                                <td><?php echo $row['course_credit']; ?></td>
                                <td><?php echo $row['session_name']; ?></td>
                                <td>
                                    <a class="edit-button" href="editcourse.php?course_id=<?php echo $row['course_id']; ?>">Edit</a>
                                    <a href="deletecourse.php?id=<?php echo $row['course_id']; ?>" class="delete-button">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </main>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                <script src="../js/scripts.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
                <script src="../js/datatables-simple-demo.js"></script>
    </body>

    </html>
<?php
}
?>