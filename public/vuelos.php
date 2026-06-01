<?php 

include '../layouts/header.php'; 


$estadoLogin = !empty($_SESSION['idUsuario']);


require_once '../controllers/crudVuelos.php';

$crud = new CrudVuelos();
$resultado = $crud->listarVuelosActivos();

$vuelos = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $vuelos[] = $fila;
    }
}

?>


<main>
    <div class=" bg-primary-subtle py-3">
        <div class="container shadow-lg p-3 mb-5 bg-body rounded">
            <h1 class="text-center my-5">Vuelos</h1>
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-outline-primary" href="">Filtro</a>
                </div>
                <div class="col-md-6">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar vuelo" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                </div>
                <div class="col-12 m-auto my-4">
                    <div class="row m-auto">
                        <?php foreach ($vuelos as $vuelo): ?>
                            <div class="col-md-4 col-6 d-flex justify-content-center my-5">
                                <div class="card" style="width: 25rem;">
                                    <div class="card-header">
                                        <div class="card-title d-flex align-items-center justify-content-center m-0">
                                            <img src="assets/img/logosAerolineas/<?php echo ($vuelo['urlLogo']??'logo no disponible'); ?>" alt="Logo de la aerolínea" style="width: 30px; height: 30px; object-fit: cover; margin-right: 10px;">
                                            <h4 class="card-title"><?php echo ($vuelo['nombre']??'Nombre no disponible'); ?></h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 py-2">
                                                <p class="card-text"><strong> Origen: </strong> <?php echo ($vuelo['origen']??'Origen no disponible'); ?></p>
                                                <p class="card-text"><strong> Fecha de Salida: </strong> <?php echo ($vuelo['fechaSalida']??'Fecha de salida no disponible'); ?></p>
                                            </div>
                                            <div class="col-6 py-2">
                                                <p class="card-text"><strong> Destino: </strong> <?php echo ($vuelo['destino']??'Destino no disponible'); ?></p>
                                                <p class="card-text"><strong> Fecha de Llegada: </strong> <?php echo ($vuelo['fechaLlegada']??'Fecha de llegada no disponible'); ?></p>
                                            </div>
                                            <p class="card-text fw-bold py-2">Precio: $<?php echo ($vuelo['precio']??'Precio no disponible'); ?></p>
                                            
                                            <div class="btn-group col-12" role="group" aria-label="Basic outlined example">
                                                <a href="reserva.php?idVuelo=<?= $vuelo['idVuelo'] ?>" type="button" class="btn btn-outline-primary" onclick="new bootstrap.Modal(document.getElementById('staticBackdrop')).show()">
                                                    <i class="bi bi-eye"></i> Detalles Vuelo
                                                </a>
                                                <?php if ($estadoLogin): ?>
                                                    <a href="reserva.php?idVuelo=<?= $vuelo['idVuelo'] ?>" 
                                                    class="btn btn-outline-primary">
                                                        <i class="bi bi-ticket"></i> Reservar Vuelo
                                                    </a>
                                                <?php else: ?>
                                                        <button type="button" class="btn btn-outline-primary " 
                                                                onclick="new bootstrap.Modal(document.getElementById('staticBackdrop')).show()">
                                                            <i class="bi bi-ticket"></i> Reservar Vuelo
                                                        </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
                
        </div>
    </div>


</main>






<?php include '../layouts/footer.php'; ?>

