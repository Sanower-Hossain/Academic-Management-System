<?php
session_start();
include_once('../includes/config.php');

if (strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
} else {
    $session_id = $_GET['id'];

    // Check if the session exists in the database
    $session_query = "SELECT * FROM sessions WHERE session_id = '$session_id'";
    $session_result = mysqli_query($con, $session_query);

    if (mysqli_num_rows($session_result) == 0) {
        $_SESSION['error'] = 'Session not found';
        header('location:view-sessions.php');
    } else {
        // Delete the session from the database
        $delete_query = "DELETE FROM sessions WHERE session_id = '$session_id'";
        mysqli_query($con, $delete_query);

        $_SESSION['success'] = 'Session deleted successfully';
        header('location:viewsession.php');
    }
}
?>
