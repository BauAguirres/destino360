


    <main>
        <div class=" bg-primary-subtle">
            <div class="container shadow-lg p-3 bg-body rounded">
                <h3><i class="bi bi-sliders"></i> Administrar Vuelos</h3>
                <div class="row align-items-center mx-auto">
                    <div class="col-md-12 d-flex justify-content-around m-auto ">
                        <a href="crearVuelo.php" class="btn btn-primary">Crear Vuelo</a>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar vuelo" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                    <div class="col-12 m-auto my-4">
                        <div class="row m-auto">
                            <?php 
                            /** @var array $vuelos*/
                            foreach ($vuelos as $vuelo): ?>
                                <div class="col-md-4 col-6 mb-4">
                                    <a href="opcionesVuelo.php?idVuelo=<?= $vuelo['idVuelo'] ?>" class="text-decoration-none">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Destino: <?php echo ($vuelo['destino']??'Nombre no disponible'); ?></h5>
                                                <p class="card-text">Origen: <?php echo ($vuelo['origen']??'Código no disponible'); ?></p>
                                                <p class="card-text">Aerolinea: <?php echo ($vuelo['nombre']??'Código no disponible'); ?></p>
                                                <p class="card-text">
                                                <strong>Estado:</strong> 
                                                <?php if (($vuelo['estadoVuelo'] ?? 0) == 1): ?>
                                                    <span class="badge bg-success">Activa</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactiva</span>
                                                <?php endif; ?>
                                                </p>
                                                <p class="card-text">Asiento Totales: <?php echo ($vuelo['asientosTotales']??'Asientos no disponibles'); ?></p>
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