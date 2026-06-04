<?php include '../layouts/header.php'; 

require_once '../controllers/crudAerolineas.php';

$crud = new CrudAerolineas();
$resultado = $crud->listarAerolineasActivas();

$aerolineas = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $aerolineas[] = $fila;
    }
}




?>


<main>
    <div class=" bg-primary-subtle py-3">
        <div class="container shadow-lg p-3 mb-5 bg-body rounded">
            <h1 class="text-center my-5">Aerolíneas</h1>
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-outline-primary" href="">Filtro</a>
                </div>
                <div class="col-md-6">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar aerolínea" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                </div>
                <div class="col-12 m-auto my-4">
                    <div class="row m-auto">
                        <?php foreach ($aerolineas as $aerolinea): ?>
                            <div class="col-md-3 col-6 d-flex justify-content-center my-5">
                                <div class="card" style="width: 18rem;">
                                    <img src="assets/img/logosAerolineas/<?php echo ($aerolinea['urlLogo']??'default-logo.png'); ?>" 
                                        class="card-img-top" alt="Logo" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo ($aerolinea['nombre']??'Nombre no disponible'); ?></h4>
                                        <p class="card-text">Descripción: <?php echo ($aerolinea['descripcion']??'Descripción no disponible'); ?></p>
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

