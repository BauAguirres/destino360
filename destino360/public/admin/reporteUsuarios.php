<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

include_once '../../seguridad/seguridadAdmin.php';

include '../../layouts/header.php';

require_once BASE_PATH . 'controllers/crudUsuarios.php';

$crud = new CrudUsuarios();
$resultado = $crud->reporteUsuarios();

$usuarios = [];
$clientes = 0;
$ceos = 0;
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $usuarios[] = $fila;
        if ($fila['rol'] == 'CEO') {
            $ceos++;
        } elseif ($fila['rol'] == 'user') {
            $clientes++;
        }
    }
}

$totalUsuarios = count($usuarios);
?>

<main>
    <div class="bg-primary-subtle py-4">
        <div class="container">
            <div class="row">
                <?php include '../../layouts/sidebar.php'; ?>
                <div class="col-md-9 col-lg-10">
                    <div class="shadow-lg p-4 bg-body rounded">

                        <a href="reportes.php" class="btn btn-outline-primary mb-4">&lt; Volver</a>
                        <h3 class="mb-4"><i class="bi bi-people"></i> Reporte de Usuarios</h3>

                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-people fs-1 text-primary"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $totalUsuarios; ?></h2>
                                    <small class="text-muted">Usuarios totales</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-person fs-1 text-info"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $clientes; ?></h2>
                                    <small class="text-muted">Clientes</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 text-center">
                                    <i class="bi bi-person-badge fs-1 text-success"></i>
                                    <h2 class="fw-bold mb-0"><?php echo $ceos; ?></h2>
                                    <small class="text-muted">CEOs</small>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-3"><i class="bi bi-list-ul"></i> Detalle de usuarios</h4>

                        <?php if (empty($usuarios)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                No hay usuarios registrados.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Tipo</th>
                                            <th>Aerolínea</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <tr>
                                                <td><?php echo $usuario['idUsuario']; ?></td>
                                                <td><?php echo $usuario['nombreUsuario']; ?></td>
                                                <td><?php echo $usuario['email']; ?></td>
                                                <td>
                                                    <?php if ($usuario['rol'] == 'CEO'): ?>
                                                        <span class="badge bg-success">CEO</span>
                                                    <?php elseif ($usuario['rol'] == 'user'): ?>
                                                        <span class="badge bg-info text-dark">Cliente</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Admin</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $usuario['nombreAerolinea'] ?? '—'; ?></td>
                                                <td>
                                                    <?php
                                                        $estado = $usuario['estadoUsuario'] ?? 'pendiente';
                                                        $estadoBadge = [
                                                            'verificado'    => ['bg-success', 'Verificado'],
                                                            'pendiente'     => ['bg-warning text-dark', 'Pendiente'],
                                                            'deshabilitado' => ['bg-danger', 'Deshabilitado'],
                                                            'rechazado'     => ['bg-danger', 'Rechazado'],
                                                        ];
                                                        [$badgeClase, $badgeTexto] = $estadoBadge[$estado] ?? ['bg-secondary', 'Sin estado'];
                                                    ?>
                                                    <span class="badge <?php echo $badgeClase; ?>"><?php echo $badgeTexto; ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include '../../layouts/footer.php'; ?>