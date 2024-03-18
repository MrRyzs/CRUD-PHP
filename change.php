<?php
include "Connection.php";

// Function to handle file upload
function uploadFile($tmp, $uploadDirectory, $gambar)
{
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true);
    }

    move_uploaded_file($tmp, $uploadDirectory . $gambar);
}

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Fetch book details from the database using the ID
    $sql = "SELECT * FROM list_buku WHERE id_buku = ?";
    $stmt = mysqli_prepare($host, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $bookId);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                if ($row = mysqli_fetch_assoc($result)) {
                    // Fetch book details from the result set
                    $judulBuku = $row['judul_buku'];
                    $pengarang = $row['pengarang'];
                    $genre = $row['genre'];
                    $tahunTerbit = $row['tahun_terbit'];

                    if (isset($_POST['submit'])) {
                        $judulBuku = $_POST['judul_buku'];
                        $pengarang = $_POST['pengarang'];
                        $genre = $_POST['genre'];
                        $tahunTerbit = $_POST['tahun_terbit'];
                        $gambar = $_FILES['gambar']['name'];
                        $tmp = $_FILES['gambar']['tmp_name'];
                        $uploadDirectory = 'C:/laragon/data/mysql-8/percobaansaya/img/';

                        if (!empty($gambar)) {
                            // If a new image is provided, upload and update the database
                            uploadFile($tmp, $uploadDirectory, $gambar);
                            $imagedata = file_get_contents($uploadDirectory . $gambar);
                            $update = mysqli_prepare($host, "UPDATE list_buku SET judul_buku=?, pengarang=?, genre=?, tahun_terbit=?, gambar_data=? WHERE id_buku=?");
                            mysqli_stmt_bind_param($update, "ssssss", $judulBuku, $pengarang, $genre, $tahunTerbit, $imagedata, $bookId);
                        } else {
                            // If no new image is provided, update other fields
                            $update = mysqli_prepare($host, "UPDATE list_buku SET judul_buku=?, pengarang=?, genre=?, tahun_terbit=? WHERE id_buku=?");
                            mysqli_stmt_bind_param($update, "sssss", $judulBuku, $pengarang, $genre, $tahunTerbit, $bookId);
                        }

                        if ($update && mysqli_stmt_execute($update)) {
                            header('location: index.php');
                            exit;
                        } else {
                            echo 'Gagal: ' . mysqli_error($host);
                        }
                    }
                } else {
                    echo "Debugging: No rows found for Book ID: \"$bookId\"";
                }
            } else {
                echo "Error in fetching results: " . mysqli_error($host);
            }
        } else {
            echo "Error in executing statement: " . mysqli_error($host);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error in preparing SQL statement: " . mysqli_error($host);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Buku</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="book_id" value="<?= $bookId ?>">

            <div class="mb-3">
                <label for="judul_buku" class="form-label">Judul Buku:</label>
                <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="<?= $judulBuku ?>" required>
            </div>

            <div class="mb-3">
                <label for="pengarang" class="form-label">Pengarang:</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= $pengarang ?>" required>
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre:</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?= $genre ?>" required>
            </div>

            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit:</label>
                <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= $tahunTerbit ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar:</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>