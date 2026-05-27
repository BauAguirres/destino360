


    <main>
        <div class=" bg-primary-subtle">
            <div class="container shadow-lg p-3 bg-body rounded">
                <h3><i class="bi bi-sliders"></i> Administrar Promociones</h3>
                <div class="row align-items-center mx-auto">
                    <div class="col-md-12 d-flex justify-content-around m-auto ">
                        <a href="solicitudesPromos.php" class="btn btn-primary">solicitudes Pendientes</a>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar promoción" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                    <div class="col-12 m-auto my-4">
                        <div class="row m-auto">
                            <?php 
                            /** @var array $promociones*/
                            foreach ($promociones as $promocion): ?>
                                <div class="col-md-4 col-6 mb-4">
                                    <a href="opcionesPromo.php?idPromo=<?php echo $promocion['idPromo'] ?>" class="text-decoration-none">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Nombre: <?php echo ($promocion['nombrePromo']??'Nombre no disponible'); ?></h5>
                                                <p class="card-text">porcentaje: <?php echo ($promocion['porcDesc']??'Código no disponible'); ?></p>
                                                <p class="card-text">fecha Inicio: <?php echo ($promocion['fechaInicio']??'Código no disponible'); ?></p>
                                                <p class="card-text">fecha Fin: <?php echo ($promocion['fechaFin']??'Código no disponible'); ?></p>
                                                <p class="card-text">
                                                    <strong>Estado:</strong> 
                                                    <?php if (($promocion['estadoPromo'] ?? 'rechazado') == 'aprobado'): ?>
                                                        <span class="badge bg-success">Aprobado</span>
                                                    <?php elseif ($promocion['estadoPromo'] == 'pendiente') : ?>
                                                        <span class="badge bg-warning">Pendiente</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Rechazado</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
                
            </div>





            
        </div>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>