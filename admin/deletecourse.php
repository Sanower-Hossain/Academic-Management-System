<?php
session_start();
include_once('../includes/config.php');

if (strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
} else {
    $course_id = $_GET['id'];

    // Check if the course exists in the database
    $course_query = "SELECT * FROM courses WHERE course_id = '$course_id'";
    $course_result = mysqli_query($con, $course_query);

    if (mysqli_num_rows($course_result) == 0) {
        $_SESSION['error'] = 'Course not found';
        header('location:viewcourse.php');
    } else {
        // Delete the course from the database
        $delete_query = "DELETE FROM courses WHERE course_id = '$course_id'";
        mysqli_query($con, $delete_query);

        $_SESSION['success'] = 'Course deleted successfully';
        header('location:viewcourse.php');
    }
}
?>
