<?php
session_start();
include_once('../includes/config.php');

if (strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['update'])) {
        $session_id = $_POST['session_id'];
        $session_name = $_POST['session_name'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $update_query = "UPDATE sessions SET session_name='$session_name', start_date='$start_date', end_date='$end_date' WHERE session_id='$session_id'";
        $result = mysqli_query($con, $update_query);

        if ($result) {
            header('location: viewsession.php');
            exit();
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }

    if (isset($_GET['id'])) {
        $session_id = $_GET['id'];
        $session_query = "SELECT * FROM sessions WHERE session_id='$session_id'";
        $session_result = mysqli_query($con, $session_query);

        if (mysqli_num_rows($session_result) > 0) {
            $session_row = mysqli_fetch_assoc($session_result);
            $session_name = $session_row['session_name'];
            $start_date = $session_row['start_date'];
            $end_date = $session_row['end_date'];
        } else {
            header('location:viewsession.php');
        }
    } else {
        header('location:viewsession.php');
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
    <title>Edit Session</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        /* Main container */
        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Heading styles */
        h2 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            font-size: 1.2rem;
            font-weight: bold;
            display: block;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: 2px solid #ccc;
        }

        button[type="submit"] {
            display: block;
            margin: 0 auto;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }


        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <body class="sb-nav-fixed">
        <?php include_once('includes/navbar.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container mt-5">
                        <h2 class="text-center mb-4">Edit Session</h2>

                        <form method="post">
                            <div class="form-group">
                                <label for="session_name">Session Name</label>
                                <input type="text" name="session_name" class="form-control" id="session_name" value="<?php echo $session_name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" class="form-control" id="start_date" value="<?php echo $start_date; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" class="form-control" id="end_date" value="<?php echo $end_date; ?>" required>
                            </div>
                            <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
                            <button type="submit" name="update" class="btn btn-primary">Update Session</button>
                        </form>
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
?>