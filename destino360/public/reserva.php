<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../');
}
require_once BASE_PATH . 'config/app.php';

if (empty($_SESSION['idUsuario'])) {
    header("Location: " . BASE_URL . "/public/index.php?login=1");
    exit;
}
include '../layouts/header.php'; 

$estadoLogin = !empty($_SESSION['idUsuario']);

require_once '../controllers/crudVuelos.php';
require_once '../controllers/crudPromociones.php';

$idVuelo = $_GET['idVuelo'] ?? null;

if (empty($idVuelo)) {
    header("Location: " . BASE_URL . "/public/vuelos.php");
    exit;
}

$crudPromociones = new CrudPromociones();
$crud = new CrudVuelos();

$vueloIda = $crud->obtenerVuelo((int) $idVuelo);

if (empty($vueloIda)) {
    header("Location: " . BASE_URL . "/public/vuelos.php");
    exit;
}

$promoIda = $crudPromociones->obtenerPromocionVuelos($idVuelo);
$precioIdaOriginal = $vueloIda['precio'];
$precioIdaFinal = $precioIdaOriginal;
$idPromoIda = null;

if ($promoIda) {
    $idPromoIda = $promoIda['idPromo'];
    $precioIdaFinal = $precioIdaOriginal - ($precioIdaOriginal * $promoIda['porcDesc'] / 100);
}

$vueloVuelta = null;
if (!empty($vueloIda['idVueloRelacionado'])) {
    $vueloVuelta = $crud->obtenerVuelo($vueloIda['idVueloRelacionado']);
}

$esIdaYVuelta = $vueloVuelta !== null;

$promoVuelta = null;
$idPromoVuelta = null;
$precioVueltaFinal = 0;

if ($esIdaYVuelta) {
    $promoVuelta = $crudPromociones->obtenerPromocionVuelos($vueloVuelta['idVuelo']);
    $precioVueltaFinal = $vueloVuelta['precio'];

    if ($promoVuelta) {
        $idPromoVuelta = $promoVuelta['idPromo'];
        $precioVueltaFinal = $vueloVuelta['precio'] - ($vueloVuelta['precio'] * $promoVuelta['porcDesc'] / 100);
    }
}

$vuelos = [];
if (!$esIdaYVuelta) {
    $resultado = $crud->listarVuelosVuelta($vueloIda['origen'], $vueloIda['destino'], $vueloIda['fechaSalida']);
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $vuelos[] = $fila;
        }
    }
}
?>

<main>
    <div class="bg-primary-subtle py-5">
        <div class="row m-auto p-2">
            <div class="col-lg-8 col-12 m-auto">
                <div class="container shadow-lg p-5 bg-body rounded">
                    <h1 class="mb-5"><i class="bi bi-ticket"></i> Reservar Vuelo</h1>
                    
                    <div class="border-0 mb-4 bg-primary-subtle p-4">
                        <h5 class="mb-3"><i class="bi bi-airplane-fill"></i> Vuelo de IDA</h5>
                        
                        <div class="row text-center mb-3">
                            <div class="col-md-4">
                                <small class="text-muted">ORIGEN</small>
                                <p class="fw-bold fs-4 text-dark"><?= $vueloIda['origen'] ?></p>
                            </div>
                            <div class="col-md-4">
                                <i class="bi bi-arrow-right" style="font-size: 24px; color: #0d6efd;"></i>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">DESTINO</small>
                                <p class="fw-bold fs-4 text-dark"><?= $vueloIda['destino'] ?></p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row text-center">
                            <div class="col-md-4">
                                <small class="text-muted">SALIDA</small>
                                <p class="fw-bold text-dark"><?= $vueloIda['fechaSalida'] ?></p>
                                <p class="text-primary fw-bold"><?= $vueloIda['horaSalida'] ?></p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">DURACIÓN</small>
                                <p class="fw-bold text-dark">2h 30min</p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">PRECIO</small>
                                <?php if ($promoIda): ?>
                                    <p class="mb-0">
                                        <span class="text-muted text-decoration-line-through">$<?= $precioIdaOriginal ?></span>
                                    </p>
                                    <p class="fw-bold fs-5 text-success mb-0" id="precioIda" data-precio="<?= $precioIdaFinal ?>">
                                        $<?= number_format($precioIdaFinal, 2) ?>
                                    </p>
                                    <span class="badge bg-success">
                                        <i class="bi bi-tag"></i> <?= $promoIda['porcDesc'] ?>% OFF
                                    </span>
                                <?php else: ?>
                                    <p class="fw-bold fs-5 text-success" id="precioIda" data-precio="<?= $precioIdaOriginal ?>">
                                        $<?= $precioIdaOriginal ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($promoIda): ?>
                            <div class="text-center mt-2">
                                <small class="text-success"><i class="bi bi-tag-fill"></i> <?= htmlspecialchars($promoIda['nombrePromo']) ?></small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($esIdaYVuelta): ?>
                        <div class="border-0 mb-4 bg-primary-subtle p-4">
                            <h5 class="mb-3"><i class="bi bi-airplane-fill"></i> Vuelo de VUELTA</h5>

                            <div class="row text-center mb-3">
                                <div class="col-md-4">
                                    <small class="text-muted">ORIGEN</small>
                                    <p class="fw-bold fs-4 text-dark"><?= $vueloVuelta['origen'] ?></p>
                                </div>
                                <div class="col-md-4">
                                    <i class="bi bi-arrow-right" style="font-size: 24px; color: #0d6efd;"></i>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">DESTINO</small>
                                    <p class="fw-bold fs-4 text-dark"><?= $vueloVuelta['destino'] ?></p>
                                </div>
                            </div>

                            <hr>

                            <div class="row text-center">
                                <div class="col-md-4">
                                    <small class="text-muted">SALIDA</small>
                                    <p class="fw-bold text-dark"><?= $vueloVuelta['fechaSalida'] ?></p>
                                    <p class="text-primary fw-bold"><?= $vueloVuelta['horaSalida'] ?></p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">DURACIÓN</small>
                                    <p class="fw-bold text-dark">2h 30min</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">PRECIO</small>
                                    <?php if ($promoVuelta): ?>
                                        <p class="mb-0">
                                            <span class="text-muted text-decoration-line-through">$<?= $vueloVuelta['precio'] ?></span>
                                        </p>
                                        <p class="fw-bold fs-5 text-success mb-0" id="precioVuelta" data-precio="<?= $precioVueltaFinal ?>">
                                            $<?= number_format($precioVueltaFinal, 2) ?>
                                        </p>
                                        <span class="badge bg-success">
                                            <i class="bi bi-tag"></i> <?= $promoVuelta['porcDesc'] ?>% OFF
                                        </span>
                                    <?php else: ?>
                                        <p class="fw-bold fs-5 text-success" id="precioVuelta" data-precio="<?= $precioVueltaFinal ?>">
                                            $<?= $vueloVuelta['precio'] ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if ($promoVuelta): ?>
                                <div class="text-center mt-2">
                                    <small class="text-success"><i class="bi bi-tag-fill"></i> <?= htmlspecialchars($promoVuelta['nombrePromo']) ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div id="vueloVueltaSeleccionado"></div>
                    <?php endif; ?>

                    <form action="../controllers/procesarReserva.php" method="POST">
                        <input type="hidden" name="idVueloIda" value="<?= (int) $idVuelo ?>">
                        <input type="hidden" name="idVueloVuelta" id="idVueloVuelta"
                               value="<?= $esIdaYVuelta ? (int) $vueloVuelta['idVuelo'] : '' ?>">
                        <input type="hidden" name="idPromoIda" value="<?= $idPromoIda ?? '' ?>">
                        <input type="hidden" name="idPromoVuelta" id="idPromoVuelta" value="<?= $idPromoVuelta ?? '' ?>">

                        <h3 class="mt-5 mb-4"><i class="bi bi-people"></i> Cantidad de Pasajeros</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Mayores de 18 años</label>
                                <select class="form-select form-select-lg" id="cantidadMayores" name="cantidadMayores" required>
                                    <option value="">-- Selecciona --</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Hasta 17 Años</label>
                                <select class="form-select form-select-lg" id="cantidadMenores" name="cantidadMenores" required>
                                    <option value="">-- Selecciona --</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>

                        <?php if (!$esIdaYVuelta): ?>
                            <button type="button" class="btn btn-outline-primary w-100 mb-4 py-3" id="btnAgregarVuelta" data-bs-toggle="modal" data-bs-target="#modalVuelta">
                                <i class="bi bi-arrow-left-right"></i> Agregar vuelo de vuelta
                            </button>

                            <button type="button" class="btn btn-outline-danger w-100 mb-4 py-3" id="btnEliminarVuelta" style="display: none;" onclick="eliminarVueloVuelta()">
                                <i class="bi bi-trash"></i> Eliminar vuelo de vuelta
                            </button>
                        <?php endif; ?>

                        <div class="bg-light border-0 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">TOTAL A PAGAR</h5>
                                <p class="fw-bold fs-3 mb-0 text-success" id="precioTotal">
                                    $0
                                </p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-5">
                            <i class="bi bi-check-circle"></i> Confirmar Reserva
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php if (!$esIdaYVuelta): ?>
        <div class="modal fade" id="modalVuelta" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-airplane-fill"></i> Selecciona vuelo de vuelta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($vuelos as $vuelo): ?>
                                <input 
                                    class="btn-check" 
                                    type="radio" 
                                    name="vueloVuelta"
                                    id="vuelo_<?= $vuelo['idVuelo'] ?>"
                                    data-vuelo-id="<?= $vuelo['idVuelo'] ?>"
                                    data-origen="<?= $vuelo['origen'] ?>"
                                    data-destino="<?= $vuelo['destino'] ?>"
                                    data-fecha-salida="<?= $vuelo['fechaSalida'] ?>"
                                    data-hora-salida="<?= $vuelo['horaSalida'] ?>"
                                    data-precio="<?= $vuelo['precio'] ?>">
                                
                                <label class="btn btn-outline-primary p-3 text-start" for="vuelo_<?= $vuelo['idVuelo'] ?>">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div>
                                            <strong><?= $vuelo['origen'] ?> → <?= $vuelo['destino'] ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <?= $vuelo['fechaSalida'] ?> | 
                                                <?= $vuelo['horaSalida'] ?>
                                            </small>
                                        </div>
                                        <span class="fw-bold fs-5">$<?= $vuelo['precio'] ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="confirmarVueloVuelta()">Confirmar Selección</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php include '../layouts/footer.php'; ?>