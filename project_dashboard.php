<?php
session_start();
include_once('includes/config.php');

// Check if user is a student
if ($_SESSION['designation'] != 'Student') {
    header('location:logout.php');
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_ids = $_POST["course_id"];
    $name = $_POST["name"];

    // Check if the "description" key exists in $_POST before trying to access it
    $description = isset($_POST["description"]) ? $_POST["description"] : '';

    // Check if the "deadline" key exists in $_POST before trying to access it
    $deadline = isset($_POST["deadline"]) ? date('Y-m-d H:i:s', strtotime($_POST["deadline"])) : '';

    $members = array();
    if (isset($_POST['members']) && !empty($_POST['members'])) {
        foreach ($_POST['members'] as $course_id => $user_ids) {
            foreach ($user_ids as $user_id) {
                // Check if student is already assigned to another project for this course
                $sql_check = "SELECT * FROM projects WHERE course_id = $course_id AND members LIKE '%$user_id%'";
                $result_check = mysqli_query($con, $sql_check);

                if (mysqli_num_rows($result_check) > 0) {
                    $error_msg = "Error: Student $user_id is already assigned to another project for this course";
                } else {
                    $members[] = "$user_id";
                }
            }
        }
    }

    if (isset($error_msg)) {
        // Output the error message if the student is already assigned to another project for this course
        echo '<script>alert("' . $error_msg . '")</script>';
    } else {
        // Insert the project data into the projects table if the student is not already assigned to another project for this course
        $members_string = implode(', ', $members);

        $sql = "INSERT INTO projects (course_id, name, description, deadline, members)
                VALUES ";

        $valueStrings = array();
        foreach ($course_ids as $course_id) {
            $valueStrings[] = "('$course_id', '$name', '$description', '$deadline', '$members_string')";
        }
        $sql .= implode(',', $valueStrings);

        if (mysqli_query($con, $sql)) {
            $success_msg = "Project submitted successfully!";
        } else {
            $error_msg = "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}


// Retrieve enrolled courses and check if project already submitted for each course
$user_id = $_SESSION['id'];
$sql = "SELECT enrolledcourse.course_id, courses.course_name as subject_name 
        FROM enrolledcourse 
        INNER JOIN courses ON enrolledcourse.course_id = courses.course_id
        WHERE enrolledcourse.student_id = $user_id";
$result = mysqli_query($con, $sql);

$submitted_projects = array();
$sql_projects = "SELECT course_id FROM projects WHERE members LIKE '%$user_id%'";
$result_projects = mysqli_query($con, $sql_projects);
while ($row_project = mysqli_fetch_assoc($result_projects)) {
    $submitted_projects[] = $row_project['course_id'];
}
?>




<!DOCTYPE html>
<html>

<head>
    <title>Project Submission Form</title>
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
            flex-direction: column;
            margin-top: 1rem;
        }

        .c label {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .c input[type="text"],
        .c textarea,
        .c select {
            padding: 0.5rem;
            border-radius: 3px;
            border: 1px solid #ddd;
            margin-bottom: 1rem;
            width: 100%;
            font-size: 1rem;
        }

        .c textarea {
            height: 8rem;
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

        .c .success-msg {
            color: green;
        }

        .c .error-msg {
            color: red;
        }

        .c input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .c .member-name {
            margin-bottom: 0.5rem;
        }

        .c .already-assigned {
            color: red;
        }

        @media only screen and (max-width: 600px) {
            .c table {
                font-size: 0.9rem;
            }
        }
    </style>

</head>


</head>


<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main class="c">
                <h1>Project Submission Form</h1>
                <?php if (isset($success_msg)) { ?>
                    <div style="color: green"><?php echo $success_msg; ?></div>
                <?php } ?>
                <?php if (isset($error_msg)) { ?>
                    <div style="color: red"><?php echo $error_msg; ?></div>
                <?php } ?>
                <form method="post">
                    <label>Courses:</label>
                    <?php
                    $sql = "SELECT * FROM courses";
                    $result = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($result)) :
                        $course_id = $row['course_id'];
                        $course_name = $row['course_name'];
                        $sql2 = "SELECT * FROM projects WHERE course_id = $course_id AND members LIKE '%{$_SESSION['id']}%'";
                        $result2 = mysqli_query($con, $sql2);
                        $project_count = mysqli_num_rows($result2);
                    ?>
                        <input type="checkbox" class="course-checkbox" name="course_id[]" value="<?php echo $course_id; ?>" <?php if ($project_count > 0) {
                                                                                                                                echo 'disabled';
                                                                                                                            } ?>> <?php echo $course_name; ?><br>
                        <div class="members-list" id="members-list-<?php echo $course_id; ?>" <?php if ($project_count == 0) {
                                                                                                    echo 'style="display:none;"';
                                                                                                } ?>>
                            <?php
                            $sql3 = "SELECT u.id, CONCAT(u.fname, ' ', u.lname) AS username FROM enrolledcourse ec JOIN users u ON ec.student_id = u.id WHERE ec.course_id = $course_id AND u.designation = 'student'";
                            $result3 = mysqli_query($con, $sql3);
                            while ($member_row = mysqli_fetch_assoc($result3)) :
                                $member_id = $member_row['id'];
                                $sql4 = "SELECT * FROM projects WHERE course_id = $course_id AND members LIKE '%$member_id%'";
                                $result4 = mysqli_query($con, $sql4);
                                $member_project_count = mysqli_num_rows($result4);
                            ?>
                                <input type="checkbox" name="members[<?php echo $course_id; ?>][]" value="<?php echo $member_row['username']; ?>" data-course-id="<?php echo $course_id; ?>" <?php if ($member_project_count > 0) {
                                                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                                                } ?>> <?php echo htmlentities($member_row['username']); ?><br>
                            <?php endwhile; ?>
                        </div>
                    <?php endwhile; ?>
                    <label>Name:</label>
                    <input type="text" name="name" required><br>
                    <label>Description:</label>
                    <textarea name="description" required></textarea><br>
                    <label>Deadline:</label>
                    <input type="datetime-local" name="deadline" required><br>
                    <input type="submit" value="Submit">
                </form>

                <script>
                    // Get all the course checkboxes
                    const courseCheckboxes = document.querySelectorAll('.course-checkbox');

                    // Hide all members lists by default
                    const membersLists = document.querySelectorAll('.members-list');
                    membersLists.forEach((list) => {
                        list.style.display = 'none';
                    });

                    // Add event listener for when a course is selected
                    courseCheckboxes.forEach((checkbox) => {
                        checkbox.addEventListener('change', () => {
                            const courseID = checkbox.value;
                            const membersList = document.querySelector(`#members-list-${courseID}`);

                            if (checkbox.checked) {
                                membersList.style.display = 'block';
                            } else {
                                membersList.style.display = 'none';
                            }
                        });
                    });
                </script>
                <?php
                mysqli_close($con);
                ?>
            </main>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
            <script src="js/scripts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
            <script src="js/datatables-simple-demo.js"></script>

</body>

</html>