<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <input type="text" id="Input" class="d-flex" onkeyup="Fungsi()" placeholder="Cari Buku...">
    </div>
  </div>
</nav>
    
    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Daftar Buku</h1>
            <a href="create.php" class="btn btn-primary">Tambah Buku</a>
        </div>

        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
                include "Connection.php";
                $sql = "SELECT * FROM list_buku";
                $show = mysqli_query($host, $sql);
                while ($e = mysqli_fetch_array($show)){
            ?>
            <div class="col">
                <div class="card h-100">
                    <?php
                        // Check if there's image data
                        if (!empty($e['gambar_data'])) {
                            $imageData = base64_encode($e['gambar_data']);
                            $src = "data:image/jpeg;base64,{$imageData}";
                            echo "<img src='{$src}' class='card-img-top' alt='' style='height:400px;width:auto;'>";
                        }
                    ?>            
                    <div class="card-body">
                        <h5 class="card-title"><?= $e['judul_buku'] ?></h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?= $e['pengarang'] ?></li>
                        <li class="list-group-item"><?= $e['genre'] ?></li>
                        <li class="list-group-item"><?= $e['tahun_terbit'] ?></li>
                    </ul>
                    <div class="card-body">
                        <a href="change.php?id=<?= $e['id_buku'] ?>" class="btn btn-info">Change</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('<?= $e['id_buku'] ?>')">Delete</button>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function Fungsi() {
            var input, filter, card;
            var input = document.getElementById("Input");
            filter = input.value.toUpperCase();
            card = document.getElementsByClassName("card");
            for (var i = 0; i < card.length; i++) {
                var title = card[i].getElementsByClassName("card-title")[0];
                if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                    card[i].style.display = "";
                } else {
                    card[i].style.display = "none";
                }
            }
        }
        function confirmDelete(bookId) {
            var confirmation = window.confirm('Are you sure you want to delete this book?');
            if (confirmation) {
                // If user confirms, redirect to delete script
                window.location.href = 'delete.php?id=' + bookId;
            }
        }
    </script>
</body>
</html>