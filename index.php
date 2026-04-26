<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destino360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <header>
        <nav class="navbar navbar-dark navbar-expand-lg bg-secondary">
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
                <form action="" class="bg-light p-4 rounded-2">
                    <div class="row align-items-center justify-content-center g-3 ">
                        <div class="col-md-2">
                            <label for="origen" class="form-label">Tipo</label>
                            <select class="form-select p-2" aria-label="Default select example">
                                <option selected value="1">Ida y Vuelta</option>
                                <option value="2">Ida</option>
                                <option value="3">Vuelta</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="origen" class="form-label">Origen</label>
                            <input type="text" class=" p-2 form-control" id="origen" placeholder="Ciudad de origen">
                        </div>
                        <div class="col-md-2">
                            <label for="destino" class="form-label">Destino</label>
                            <input type="text" class=" p-2 form-control" id="destino" placeholder="Ciudad de destino">
                        </div>
                        <div class="col-md-2">
                            <label for="fechaIda" class="form-label">Fecha de ida</label>
                            <input type="date" class=" p-2 form-control" id="fechaIda">
                        </div>
                        <div class="col-md-2">
                            <label for="fechaIda" class="form-label">Fecha de Vuelta</label>
                            <input type="date" class=" p-2 form-control" id="fechaIda">
                        </div>
                        <div class="col-md-1 text-center">
                            <label for="pasajeros" class="form-label">Pasajeros</label>
                            <div class="position-relative">
                                <button class=" p-2 btn btn-outline-primary" type="button" onclick="abrirMenuPas()">
                                    <span id="pasajerosText">P 1</span>
                                </button>
                                <!--Menu flotante-->
                                <div id="menuFlotante" class="menu-flotante">
                                    <div class="d-flex align-items-center justify-content-between mb-2 gap-2">
                                        <span>Adultos</span>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-secondary rounded-circle btn-sm btnPasajero m-2">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <span id="adultosCount">1</span>
                                            <button class="btn btn-outline-secondary rounded-circle btn-sm btnPasajero m-2">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span>Niños</span>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-secondary rounded-circle btn-sm btnPasajero m-2">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <span id="ninosCount">0</span>
                                            <button class="btn btn-outline-secondary rounded-circle btn-sm btnPasajero m-2">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 text-center align-self-end">
                            <button type="submit" class="btn btn-primary p-2">Buscar</button>
                        </div>
                    </div>
                </form>


            </div>

            <div class="container shadow-lg p-3 mb-5 bg-body-tertiary rounded mt-5">
                <div id="carouselExampleFade" class="carousel slide carousel-fade">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="assets/img/paisaje1.webp" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/img/paisaje2.webp" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/img/paisaje3.webp" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>


                <div class="row justify-content-center gap-0 text-start info">
                    <div class="col-md-4">
                        <div class="cardCustom h-100">
                            
                            <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-credit-card-2-front fs-2 icono"></i>

                            <div>
                                <h5 class="fw-bold mb-1">Medios de Pago</h5>
                                <p class="mb-0">Cuotas con tarjetas, promociones bancarias y más</p>
                            </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cardCustom h-100">
                            
                            <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-gift fs-2 icono"></i>

                            <div>
                                <h5 class="fw-bold mb-1">Beneficios y Cupones</h5>
                                <p class="mb-0">Acumulá puntos Pasaporte y aprovechá todos los cupones que tenemos para vos</p>
                            </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cardCustom h-100">
                            
                            <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-person-circle fs-2 icono"></i>

                            <div>
                                <h5 class="fw-bold mb-1">Atención al cliente</h5>
                                <p class="mb-0">Soporte 24/7 para ayudarte</p>
                            </div>
                            </div>

                        </div>
                    </div>

                </div>




            </div>
        </div>
    </main>















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>