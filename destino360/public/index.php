<?php include '../layouts/header.php'; ?>

<?php
require_once BASE_PATH . 'controllers/crudCarrusel.php';
require_once BASE_PATH . 'controllers/crudVuelos.php';

$crudCarrusel = new CrudCarrusel();
$crudVuelos = new CrudVuelos();

$resultadoCarrusel = $crudCarrusel->listarImagenes();
$imagenes = [];
if ($resultadoCarrusel) {
    while ($fila = mysqli_fetch_assoc($resultadoCarrusel)) {
        $imagenes[] = $fila;
    }
}

$resultadoDestinos = $crudVuelos->destinosDestacados(3);
$destinos = [];
if ($resultadoDestinos) {
    while ($fila = mysqli_fetch_assoc($resultadoDestinos)) {
        $destinos[] = $fila;
    }
}
?>

<main>
    <div class="bg-primary-subtle py-3">
        <div class="container hero py-5 rounded-2">
            <form action="<?php echo BASE_URL; ?>/public/vuelos.php" method="GET" class="bg-light p-4 rounded-2">
                <div class="row align-items-center justify-content-center g-3">
                    <div class="col-md-2">
                        <label class="form-label">Tipo</label>
                        <select class="form-select p-2" name="tipo">
                            <option value="idaVuelta">Ida y Vuelta</option>
                            <option value="idaSolo">Ida</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="origen" class="form-label">Origen</label>
                        <input type="text" class="p-2 form-control" name="origen" id="origen" placeholder="Ciudad de origen">
                    </div>
                    <div class="col-md-2">
                        <label for="destino" class="form-label">Destino</label>
                        <input type="text" class="p-2 form-control" name="destino" id="destino" placeholder="Ciudad de destino">
                    </div>
                    <div class="col-md-2">
                        <label for="fechaIda" class="form-label">Fecha de ida</label>
                        <input type="date" class="p-2 form-control" name="fechaIda" id="fechaIda">
                    </div>
                    <div class="col-md-2">
                        <label for="fechaVuelta" class="form-label">Fecha de Vuelta</label>
                        <input type="date" class="p-2 form-control" name="fechaVuelta" id="fechaVuelta">
                    </div>
                    <div class="col-md-1 text-center">
                        <label for="pasajeros" class="form-label">Pasajeros</label>
                        <div class="position-relative">
                            <button class="p-2 btn btn-outline-primary" type="button" onclick="abrirMenuPas()">
                                <span id="pasajerosText">P 1</span>
                            </button>
                            <div id="menuFlotante" class="menu-flotante">
                                <div class="d-flex align-items-center justify-content-between mb-2 gap-2">
                                    <input type="hidden" name="pasajeros" id="pasajerosInput" value="1">
                                    <span>Adultos</span>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-secondary rounded-circle btn-sm btnPasajero m-2" type="button"><i class="bi bi-dash"></i></button>
                                        <span id="adultosCount">1</span>
                                        <button class="btn btn-outline-secondary rounded-circle btn-sm btnPasajero m-2" type="button"><i class="bi bi-plus"></i></button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span>Niños</span>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-secondary rounded-circle btn-sm btnPasajero m-2" type="button"><i class="bi bi-dash"></i></button>
                                        <span id="ninosCount">0</span>
                                        <button class="btn btn-outline-secondary rounded-circle btn-sm btnPasajero m-2" type="button"><i class="bi bi-plus"></i></button>
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
                    <?php if (empty($imagenes)): ?>
                        <div class="carousel-item active">
                            <img src="<?php echo BASE_URL; ?>/public/assets/img/paisaje1.webp" class="d-block w-100" alt="">
                        </div>
                    <?php else: ?>
                        <?php foreach ($imagenes as $i => $img): ?>
                            <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo BASE_URL; ?>/public/assets/img/<?php echo $img['urlImagen']; ?>"
                                     class="d-block w-100" alt="">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="row justify-content-center gap-0 text-start info">
                <div class="col-md-4 mb-4">
                    <a href="<?php echo BASE_URL; ?>/public/aerolineas.php" class="text-decoration-none text-reset">
                        <div class="cardCustom h-100">
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-buildings fs-2 icono"></i>
                                <div>
                                    <h5 class="fw-bold mb-1">Nuestras Aerolíneas</h5>
                                    <p class="mb-0">Conocé todas las aerolíneas disponibles y sus vuelos</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="<?php echo BASE_URL; ?>/public/novedades.php" class="text-decoration-none text-reset">
                        <div class="cardCustom h-100">
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-megaphone fs-2 icono"></i>
                                <div>
                                    <h5 class="fw-bold mb-1">Novedades</h5>
                                    <p class="mb-0">Enterate de las últimas noticias y anuncios del sistema</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="<?php echo BASE_URL; ?>/public/vuelos.php?promo=1" class="text-decoration-none text-reset">
                        <div class="cardCustom h-100">
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-tag-fill fs-2 icono"></i>
                                <div>
                                    <h5 class="fw-bold mb-1">Promociones</h5>
                                    <p class="mb-0">Descubrí los vuelos con descuentos y ofertas vigentes</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="container text-center mt-2">
                <h1 class="mb-4">Destinos Destacados</h1>
                <div class="row justify-content-center gap-4">
                    <?php if (empty($destinos)): ?>
                        <p class="text-muted">No hay destinos disponibles por el momento.</p>
                    <?php else: ?>
                        <?php foreach ($destinos as $destino): ?>
                            <div class="col-12 col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <i class="bi bi-geo-alt-fill fs-1 text-primary"></i>
                                        <h5 class="card-title mt-2"><?php echo $destino['destino']; ?></h5>
                                        <p class="card-text"><?php echo $destino['cantidad']; ?> vuelo(s) disponible(s)</p>
                                        <a href="<?php echo BASE_URL; ?>/public/vuelos.php?destino=<?php echo urlencode($destino['destino']); ?>"
                                           class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="col-12 text-md-end mt-4">
                        <a href="<?php echo BASE_URL; ?>/public/vuelos.php" class="btn btn-primary">Mostrar Todos</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>