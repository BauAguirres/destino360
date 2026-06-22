<?php
define('BASE_PATH', __DIR__ . '/../');

$exito = isset($_GET['exito']);

include BASE_PATH . 'layouts/header.php';
?>

<main>
    <div class="bg-primary-subtle py-3">
        <div class="shadow-lg p-3 mb-5 bg-body rounded container">
            <div class="text-center">
                <h1>Verificación de cuenta</h1>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-2 py-3">
                <span class="badge rounded-pill bg-primary text-white">1</span>
                <span class="text-black fw-semibold small">Tus datos</span>

                <hr class="border-primary opacity-100 m-0" style="width: 36px;">

                <span class="badge rounded-pill bg-primary text-white" id="badge2">2</span>
                <span class="text-black fw-semibold small" id="label2">Verificar email</span>

                <hr class="border-primary opacity-100 m-0" id="linea2" style="width: 36px;">

                <span class="badge rounded-pill bg-primary text-white" id="badge3">3</span>
                <span class="text-black fw-semibold small" id="label3">¡Listo!</span>
            </div>

            <div class="progress mb-1 mx-auto" style="height: 5px; width: 60%;">
                <div class="progress-bar bg-primary" role="progressbar"
                    style="width: 100%; transition: width .5s ease;">
                </div>
            </div>

            <div class="row justify-content-center my-5">
                <div class="col-md-6">
                    <?php if ($exito): ?>
                        <div class="card p-4 text-center border-0 shadow-sm">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 56px;"></i>
                            <p class="mt-3 mb-1 fw-bold">¡Tu cuenta fue verificada exitosamente!</p>
                            <p class="text-muted small">Ahora podés iniciar sesión y comenzar a reservar vuelos.</p>
                            <a href="index.php?login=1" class="btn btn-primary">Iniciar Sesión</a>
                        </div>
                    <?php else: ?>
                        <div class="card p-4 text-center border-0 shadow-sm">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 56px;"></i>
                            <p class="mt-3 mb-1 fw-bold">No se pudo verificar la cuenta</p>
                            <p class="text-muted small">El enlace no es válido o ya fue utilizado.</p>
                            <a href="index.php" class="btn btn-outline-primary">Volver al inicio</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</main>

<?php include BASE_PATH . 'layouts/footer.php'; ?>