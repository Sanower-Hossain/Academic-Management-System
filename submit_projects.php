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

    // Get assigned courses for the teacher
    $assigned_courses_query = "SELECT * FROM assigned_courses WHERE teacher_id='" . $_SESSION['id'] . "'";
    $assigned_courses_result = $con->query($assigned_courses_query);

    // Get course IDs assigned to the teacher
    $course_ids = array();
    while ($row = $assigned_courses_result->fetch_assoc()) {
        $course_ids[] = $row['course_id'];
    }

    // Get submitted projects for the assigned courses
    if (!empty($course_ids)) {
        $course_ids_str = implode(',', $course_ids);
        $projects_query = "SELECT * FROM projects WHERE course_id IN ($course_ids_str)";
        $projects_result = $con->query($projects_query);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Submission Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .c {
            margin: 0 auto;
            max-width: 800px;
        }

        .c h1 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .c p {
            margin-bottom: 1rem;
        }

        .c table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .c th,
        .c td {
            padding: 0.5rem;
            text-align: left;
            vertical-align: top;
            border: 1px solid #ddd;
        }

        .c th {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .c tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .c form {
            display: flex;
            align-items: center;
        }

        .c select {
            margin-right: 0.5rem;
        }

        .c button[type="submit"] {
            padding: 0.5rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        @media only screen and (max-width: 600px) {
            .c table {
                font-size: 0.9rem;
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
                <h1>Project Submission Dashboard</h1>
                <?php if ($projects_result->num_rows == 0) { ?>
                    <p>No projects have been submitted yet.</p>
                <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Project ID</th>
                                <th>Project Name</th>
                                <th>Project Description</th>
                                <th>Submission Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $projects_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['submission_date']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <form action="update_project_status.php" method="post">
                                            <input type="hidden" name="project_id" value="<?php echo $row['id']; ?>">
                                            <select name="status">
                                                <option value="accepted">Accept</option>
                                                <option value="unaccepted">Reject</option>
                                            </select>
                                            <button type="submit">Submit</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </main>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
            <script src="js/datatables-simple-demo.js"></script>
</body>

</html>