<?php 
session_start();
include_once('../includes/config.php');
if (strlen($_SESSION['adminid'] == 0)) {
    header('location:logout.php');
} else {
    // for creating new session
    if (isset($_POST['submit'])) {
        $session_name = $_POST['session_name'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $query = mysqli_query($con, "insert into sessions(session_name,start_date,end_date) values('$session_name','$start_date','$end_date')");
        if ($query) {
            echo "<script>alert('Session Created successfully.');</script>";
            header('location:viewsession.php');
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
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
        <title>Create Session | Registration and Login System</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>

    <body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="layoutSidenav_content">
        <?php include_once('includes/navbar.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Create Session</h1>
                      

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Create New Session
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <div class="form-group">
                                        <label for="session_name">Session Name</label>
                                        <input type="text" name="session_name" class="form-control" id="session_name" placeholder="Enter session name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date" required>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Create Session</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
</body>
</html>
<?php } ?>