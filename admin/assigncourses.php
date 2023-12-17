<?php
include_once('../includes/config.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get teacher id and courses array
    $teacher_id = $_POST['teacher_id'];
    $courses = $_POST['courses'];

    // Delete all previously assigned courses for this teacher
    $delete_query = "DELETE FROM assigned_courses WHERE teacher_id='$teacher_id'";
    mysqli_query($con, $delete_query);

    // Assign the selected courses to this teacher
    foreach ($courses as $course_id) {
        $insert_query = "INSERT INTO assigned_courses (teacher_id, course_id) VALUES ('$teacher_id', '$course_id')";
        mysqli_query($con, $insert_query);
    }

    // Redirect to assigned_courses.php with success message
    header('Location: assigncourses.php?success=1');
    exit;
}

// Fetch teachers and courses from database
$teachers_query = "SELECT * FROM users WHERE designation='Teacher'";
$teachers_result = mysqli_query($con, $teachers_query);

$courses_query = "SELECT * FROM courses";
$courses_result = mysqli_query($con, $courses_query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Assign Courses</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <style>
        /* Global styles */
        h2{
            text-align: center;
        }
        .c {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .c h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Form styles */
        .c label {
            font-weight: bold;
        }

        .c .alert {
            margin-top: 20px;
        }

        .c .form-check-label {
            font-weight: normal;
        }

        .c .btn-primary {
            margin-top: 20px;
            background-color: #007bff;
            border-color: #007bff;
        }

        .c .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        /* Responsive styles */
        @media screen and (max-width: 600px) {
            .c {
                padding: 10px;
            }

            .c h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .c .form-check-label {
                font-size: 14px;
            }

            .c .btn-primary {
                margin-top: 10px;
                font-size: 14px;
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
                <div class="container">
                    <h2>Assign Courses</h2>
                    <?php if (isset($_GET['success'])) { ?>
                        <div class="alert alert-success" role="alert">
                            Courses assigned successfully!
                        </div>
                    <?php } ?>
                    <form class="c" method="POST">
                        <div class="form-group">
                            <label for="teacher_id">Select Teacher:</label>
                            <select class="form-control" name="teacher_id" id="teacher_id">
                                <?php while ($teacher = mysqli_fetch_assoc($teachers_result)) { ?>
                                    <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['fname'] . ' ' . $teacher['lname']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Courses:</label>
                            <div class="form-check">
                                <?php while ($course = mysqli_fetch_assoc($courses_result)) { ?>
                                    <input class="form-check-input" type="checkbox" name="courses[]" value="<?php echo $course['course_id']; ?>" id="course_<?php echo $course['course_id']; ?>">
                                    <label class="form-check-label" for="course_<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></label>
                                    <br>
                                <?php } ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Courses</button>
                    </form>
                </div>
                <script src="../assets/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                <script src="../js/scripts.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
                <script src="../js/datatables-simple-demo.js"></script>
            </main>
</body>

</html>