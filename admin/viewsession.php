<?php
session_start();
include_once('../includes/config.php');

if (strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
} else {
    // Fetch sessions data
    $sessions_query = "SELECT * FROM sessions";
    $sessions_result = mysqli_query($con, $sessions_query);

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>View Sessions</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <!-- Add necessary CSS and JS files here -->
        <style>
           
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
                    <div class="container mt-5">
                        <h2 class="text-center mb-4">View Sessions</h2>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Session Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($sessions_result)) {
                                        echo '<tr>';
                                        echo '<td>' . $row['session_id'] . '</td>';
                                        echo '<td>' . $row['session_name'] . '</td>';
                                        echo '<td>' . $row['start_date'] . '</td>';
                                        echo '<td>' . $row['end_date'] . '</td>';
                                        echo '<td>';
                                        echo '<button class="edit-button" onclick="location.href=\'editsession.php?id=' . $row['session_id'] . '\'">Edit</button>';
                                        echo '<button class="delete-button" onclick="if(confirm(\'Are you sure you want to delete this session?\')){location.href=\'deletesession.php?id=' . $row['session_id'] . '\';}">Delete</button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
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