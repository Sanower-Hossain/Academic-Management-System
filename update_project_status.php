<?php
session_start();
include_once('includes/config.php');

// Check if teacher ID is set in the session and the user is a teacher
if (strlen($_SESSION['id']) == 0 || $_SESSION['designation'] != 'Teacher') {
    header('location:logout.php');
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_id = $_POST["project_id"];
    $status = $_POST["status"];

    $sql = "UPDATE projects SET status='$status' WHERE id='$project_id'";

    if (mysqli_query($con, $sql)) {
        $success_message = "Project status updated successfully!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

// Fetch teacher data from database using teacher ID from session
$query = "SELECT * FROM users WHERE id='" . $_SESSION['id'] . "'";
$result = $con->query($query);
$teacher = $result->fetch_assoc();

// Get submitted projects for each assigned course
$submitted_projects_query = "SELECT projects.id, projects.name, projects.description, projects.deadline, projects.status, courses.course_code FROM projects INNER JOIN courses ON projects.course_id = courses.course_id INNER JOIN assigned_courses ON courses.course_id = assigned_courses.course_id WHERE assigned_courses.teacher_id=" . $teacher['id'] . " AND projects.status='submitted'";
$submitted_projects_result = $con->query($submitted_projects_query);

header('Location: submit_projects.php');
exit;
?>
