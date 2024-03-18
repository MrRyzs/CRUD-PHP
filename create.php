<?php
// Connection to database
include "Connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $genre = $_POST['genre'];
    $tahun_terbit = $_POST['tahun_terbit'];

    // Process image upload
    $gambar_data = null;
    if ($_FILES['gambar']['size'] > 0) {
        $gambar_data = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
    }

    // Insert query
    $insert_query = "INSERT INTO list_buku (judul_buku, pengarang, genre, tahun_terbit, gambar_data) VALUES ('$judul_buku', '$pengarang', '$genre', '$tahun_terbit', '$gambar_data')";

    // Execute query
    if (mysqli_query($host, $insert_query)) {
        // Redirect to the main page after successful insertion
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($host);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<main class="container mt-5">
    <h1 class="fw-bold mb-4">Tambah Buku</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="judul_buku" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
        </div>
        <div class="mb-3">
            <label for="pengarang" class="form-label">Pengarang</label>
            <input type="text" class="form-control" id="pengarang" name="pengarang" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>
        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Buku</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</main>
</body>
</html>
