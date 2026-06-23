<?php
define('BASE_PATH', __DIR__ . '/../../');
session_start();

require_once BASE_PATH . 'controllers/CrudUsuarios.php';

include '../../layouts/header.php';

$crudUsuarios = new CrudUsuarios();

$error = $_GET['error'] ?? null;
$exito = $_GET['exito'] ?? null;

$idUsuario = $_GET['idUsuario'];
$usuario = $crudUsuarios->obtenerCEO($idUsuario);
$idAerolinea = $usuario['idAerolinea'];

$estado = $usuario['estadoUsuario'] ?? 'rechazado';
$estadoBadge = [
    'verificado'    => ['bg-success', 'Verificado'],
    'pendiente'     => ['bg-warning text-dark', 'Pendiente'],
    'deshabilitado' => ['bg-danger', 'Deshabilitado'],
];
[$badgeClase, $badgeTexto] = $estadoBadge[$estado] ?? ['bg-danger', 'Rechazado'];
?>


<main class="bg-primary-subtle py-5">
    <div class="container shadow-lg p-5 bg-body rounded">

        <a href="dashboard.php" class="btn btn-outline-primary mb-4">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($exito): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $exito; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="text-center border-bottom pb-4 mb-4">
            <div class="d-flex justify-content-center mb-3">
                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                        style="width: 90px; height: 90px;">
                    <i class="bi bi-person-fill text-primary" style="font-size: 48px;"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-1"><?php echo htmlspecialchars($usuario['nombreUsuario']); ?></h2>
            <p class="text-muted mb-2">CEO de Aerolínea · ID #<?php echo $usuario['idUsuario']; ?></p>
            <span class="badge <?php echo $badgeClase; ?> fs-6"><?php echo $badgeTexto; ?></span>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <small class="text-muted d-block">
                    <i class="bi bi-envelope"></i> Email
                </small>
                <span class="fw-semibold"><?php echo $usuario['email'] ?? 'No disponible'; ?></span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">
                    <i class="bi bi-telephone"></i> Teléfono
                </small>
                <span class="fw-semibold"><?php echo $usuario['telefono'] ?? 'No disponible'; ?></span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">
                    <i class="bi bi-building"></i> Aerolínea asignada
                </small>
                <span class="fw-semibold"><?php echo $usuario['nombre'] ?? 'No disponible'; ?></span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">
                    <i class="bi bi-calendar-event"></i> Fecha de registro
                </small>
                <span class="fw-semibold">
                    <?php echo !empty($usuario['creado']) ? date('d/m/Y', strtotime($usuario['creado'])) : 'No disponible'; ?>
                </span>
            </div>
        </div>

        <div class="border-top pt-4">
            <h6 class="text-muted mb-3"><i class="bi bi-gear"></i> Acciones</h6>
            <div class="d-flex flex-wrap gap-2">
                <?php if ($estado == 'pendiente'): ?>
                    <a href="actions/cambiarEstadoCEO.php?idUsuario=<?= $usuario['idUsuario'] ?>&accion=verificar"
                        class="btn btn-success"
                        onclick="return confirm('¿Estás seguro que deseas aprobar este usuario?')">
                        <i class="bi bi-check-circle"></i> Aprobar
                    </a>
                    <a href="actions/cambiarEstadoCEO.php?idUsuario=<?= $usuario['idUsuario'] ?>&accion=rechazar"
                        class="btn btn-outline-danger"
                        onclick="return confirm('¿Estás seguro que deseas rechazar este usuario?')">
                        <i class="bi bi-x-circle"></i> Rechazar
                    </a>
                <?php elseif ($estado != 'verificado'): ?>
                    <a href="actions/cambiarEstadoCEO.php?idUsuario=<?= $usuario['idUsuario'] ?>&accion=verificar"
                        class="btn btn-success"
                        onclick="return confirm('¿Estás seguro que deseas habilitar este usuario?')">
                        <i class="bi bi-check-circle"></i> Habilitar
                    </a>
                <?php elseif ($estado == 'verificado'): ?>
                    <a href="actions/cambiarEstadoCEO.php?idUsuario=<?= $usuario['idUsuario'] ?>&accion=deshabilitar"
                        class="btn btn-warning"
                        onclick="return confirm('¿Estás seguro que deseas deshabilitar este usuario?')">
                        <i class="bi bi-pause-circle"></i> Deshabilitar
                    </a>
                <?php endif; ?>
                
                <a href="editarUsuario.php?idUsuario=<?php echo $usuario['idUsuario']; ?>"
                    class="btn btn-outline-primary">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="actions/eliminarUsuario.php?idUsuario=<?php echo $usuario['idUsuario']; ?>"
                    class="btn btn-outline-danger ms-auto"
                    onclick="return confirm('¿Estás seguro que deseas eliminar este usuario?')">
                    <i class="bi bi-trash"></i> Eliminar
                </a>
            </div>
        </div>

    </div>
</main>
    
<?php include '../../layouts/footer.php'; ?>