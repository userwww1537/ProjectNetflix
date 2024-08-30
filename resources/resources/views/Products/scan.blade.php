<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quét mã</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4">
            <h2 class="card-title text-center">Quét mã</h2>
            <form>
                <div class="mb-3">
                    <label for="code" class="form-label">Nhập mã code:</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="scanCode()">Quét mã</button>
            </form>
        </div>
    </div>
</body>

</html>