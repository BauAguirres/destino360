<?php include '../layouts/header.php'; ?>


    <main>
        <div class=" bg-primary-subtle py-3">
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
                    <div class="col-md-4 mb-4">
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
                    <div class="col-md-4 mb-4">
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
                    <div class="col-md-4 mb-4">
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

                <div class="container text-center mt-2">
                        <h1 class="mb-4">Destinos Destacados</h1>
                    <div class="row justify-content-center gap-4">
                        <div class="col-12 col-md-3">
                            <div class="card">
                                <img src="..." class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <a href="detalle.html" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="..." class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <a href="detalle.html" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="..." class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <a href="detalle.html" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-md-end mt-4">
                            <button class="btn btn-primary">Mostrar Todos</button>
                        </div>
                    </div>



                </div>






            </div>
        </div>
    </main>






<?php include '../layouts/footer.php'; ?>

