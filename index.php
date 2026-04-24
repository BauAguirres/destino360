<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destino360</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-secondary">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <img src="assets/img/logo.png" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Disabled</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class=" bg-primary-subtle py-5">
            <div class="container hero py-5 rounded-2">
                <form action="" class="form-control">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="origen" class="form-label">Origen</label>
                            <input type="text" class="form-control" id="origen" placeholder="Ciudad de origen">
                        </div>
                        <div class="col-md-3">
                            <label for="destino" class="form-label">Destino</label>
                            <input type="text" class="form-control" id="destino" placeholder="Ciudad de destino">
                        </div>
                        <div class="col-md-2">
                            <label for="fechaIda" class="form-label
">Fecha de ida</label>
                            <input type="date" class="form-control" id="fechaIda">
                        </div>
                    </div>
                </form>


            </div>


        </div>
    </main>















  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>