<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            text-align: center;
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        .error-code {
            font-size: 100px;
            font-weight: 900;
            color: #dc3545;
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 4px 4px 0px rgba(220, 53, 69, 0.2);
        }
    </style>
</head>

<body>

    <div class="error-container">
        <div class="error-code">404</div>
        <h2 class="fw-bold mb-3">Oops! Akses Dibatasi.</h2>
        <p class="text-muted mb-4">
            Kamu tidak memiliki izin untuk mengakses halaman ini.
        </p>
        <a href="index.php" class="btn btn-primary btn-lg rounded-pill px-5">Kembali ke Beranda</a>
    </div>

</body>

</html>