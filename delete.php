<?php
include "Connection.php";

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Perform deletion from the database
    $delete = mysqli_prepare($host, "DELETE FROM list_buku WHERE id_buku = ?");
    mysqli_stmt_bind_param($delete, "s", $bookId);

    if (mysqli_stmt_execute($delete)) {
        // Deletion successful
        header('location: listbuku.php');
        exit;
    } else {
        // Error during deletion
        echo 'Error: ' . mysqli_error($host);
    }

    mysqli_stmt_close($delete);
} else {
    // Invalid request, no book ID provided
    echo 'Invalid request';
}
?>