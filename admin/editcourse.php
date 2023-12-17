<?php
session_start();
include_once('../includes/config.php');

if (strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
        $course_name = mysqli_real_escape_string($con, $_POST['course_name']);
        $course_code = mysqli_real_escape_string($con, $_POST['course_code']);
        $course_credit = mysqli_real_escape_string($con, $_POST['course_credit']);
        $session_id = mysqli_real_escape_string($con, $_POST['session_id']);

        $update_query = "UPDATE courses SET course_name='$course_name', course_code='$course_code', course_credit='$course_credit', session_id='$session_id' WHERE course_id='$course_id'";
        $result = mysqli_query($con, $update_query);

        if ($result) {
            $_SESSION['success'] = 'Course updated successfully';
            header('location:viewcourse.php');
        } else {
            $_SESSION['error'] = 'Something went wrong. Please try again.';
        }
    }

    $course_id = mysqli_real_escape_string($con, $_GET['course_id']);

    $course_query = "SELECT * FROM courses WHERE course_id='$course_id'";
    $course_result = mysqli_query($con, $course_query);
    $course = mysqli_fetch_assoc($course_result);

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
        <title>Edit Course</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            h1.c{
                text-align: center;
            }
            form.c {
                width: 300px;
                margin: 0 auto;
                text-align: center;
            }

            form.c label {
                display: block;
                text-align: left;
            }

            form.c input,
            form.c select {
                display: block;
                margin: 10px auto;
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            form.c button {
                display: block;
                margin: 20px auto 0;
                padding: 10px 20px;
                border-radius: 50px;
                background-color: #007bff;
                color: #fff;
                border: none;
                cursor: pointer;
            }

            form.c button:hover {
                background-color: #0062cc;
            }
        </style>

    </head>


    <body class="sb-nav-fixed">
        <?php include_once('includes/navbar.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <h1 class="c">Edit Course</h1>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div>' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>

                    <form class="c" method="POST">
                        <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">

                        <label>Course Name:</label>
                        <input type="text" name="course_name" value="<?php echo $course['course_name']; ?>" required>

                        <label>Course Code:</label>
                        <input type="text" name="course_code" value="<?php echo $course['course_code']; ?>" required>

                        <label>Course Credit:</label>
                        <input type="number" name="course_credit" value="<?php echo $course['course_credit']; ?>" required>

                        <label>Session:</label>
                        <select name="session_id">
                            <?php while ($row = mysqli_fetch_assoc($sessions_result)) { ?>
                                <option value="<?php echo $row['session_id']; ?>" <?php if ($row['session_id'] == $course['session_id']) echo 'selected'; ?>><?php echo $row['session_name']; ?></option>
                            <?php } ?>
                        </select><br><br>

                        <button type="submit" name="submit">Save Changes</button>
                    </form>
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