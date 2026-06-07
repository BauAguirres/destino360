function abrirMenuPas() {
    document.getElementById("menuFlotante").classList.toggle("mostrar");
}



// CRUDvUELOS

function cambiarTipoViaje() {
    const tipoVuelo = document.getElementById('tipoVuelo').value;
    const seccionVuelta = document.getElementById('seccionVuelta');

    if (tipoVuelo === 'idaVuelta') {
        seccionVuelta.style.display = 'block';
    } else {
        seccionVuelta.style.display = 'none';
    }
}

function cambiarOpcionVuelta() {
    const opcion = document.querySelector('input[name="opcionVuelta"]:checked').value;
    const seleccionarVueltaDiv = document.getElementById('seleccionarVueltaDiv');
    const formVuelta = document.getElementById('formVuelta');

    if (opcion === 'seleccionar') {
        seleccionarVueltaDiv.style.display = 'block';
        formVuelta.style.display = 'none';
    } else {
        seleccionarVueltaDiv.style.display = 'none';
        formVuelta.style.display = 'block';
    }
}









// RESERVAS
let precioIda = 0;
const elPrecioIda = document.getElementById('precioIda');
if (elPrecioIda) {
    precioIda = parseFloat(elPrecioIda.innerText.replace('$', ''));
}

let precioVuelta = 0;

function confirmarVueloVuelta(){

    const select = document.querySelector('input[name="vueloVuelta"]:checked');

    if(!select){
        alert("Seleccioná un vuelo");
        return;
    }

    const idVueloVuelta = select.getAttribute('data-vuelo-id');
    const origen = select.getAttribute('data-origen');
    const destino = select.getAttribute('data-destino');
    const fechaSalida = select.getAttribute('data-fecha-salida');
    const horaSalida = select.getAttribute('data-hora-salida');
    precioVuelta = parseFloat(select.getAttribute('data-precio'));

    // Guardar ID en input hidden
    document.getElementById('idVueloVuelta').value = idVueloVuelta;

    const contenedor = document.getElementById('vueloVueltaSeleccionado');

    contenedor.innerHTML = `
        <div class="card border-0 mb-4 bg-primary-subtle">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="bi bi-airplane-fill"></i> Vuelo de VUELTA</h5>
                
                <div class="row text-center mb-3">
                    <div class="col-md-4">
                        <small class="text-muted">ORIGEN</small>
                        <p class="fw-bold fs-4 text-dark">${origen}</p>
                    </div>
                    <div class="col-md-4">
                        <i class="bi bi-arrow-right" style="font-size: 24px; color: #0d6efd;"></i>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">DESTINO</small>
                        <p class="fw-bold fs-4 text-dark">${destino}</p>
                    </div>
                </div>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-md-4">
                        <small class="text-muted">SALIDA</small>
                        <p class="fw-bold text-dark">${fechaSalida}</p>
                        <p class="text-primary fw-bold">${horaSalida}</p>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">DURACIÓN</small>
                        <p class="fw-bold text-dark">2h 30min</p>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">PRECIO</small>
                        <p class="fw-bold fs-5 text-success">$${precioVuelta}</p>
                    </div>
                </div>
                
                <button type="button" class="btn btn-outline-danger w-100 mt-3" onclick="eliminarVueloVuelta()">
                    <i class="bi bi-trash"></i> Eliminar vuelo de vuelta
                </button>
            </div>
        </div>
    `;

    actualizarPrecioTotal();

    // Deshabilitar botón de agregar
    document.getElementById('btnAgregarVuelta').disabled = true;
    document.getElementById('btnAgregarVuelta').classList.add('disabled');
    document.getElementById('btnAgregarVuelta').style.display = 'none';

    // Cerrar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalVuelta'));
    modal.hide();

    
}

function eliminarVueloVuelta() {
    // Limpiar el vuelo de vuelta
    document.getElementById('idVueloVuelta').value = '';
    document.getElementById('vueloVueltaSeleccionado').innerHTML = '';

    // Habilitar botón de agregar
    document.getElementById('btnAgregarVuelta').disabled = false;
    document.getElementById('btnAgregarVuelta').classList.remove('disabled');
    document.getElementById('btnAgregarVuelta').style.display = 'block';

    // Desmarcar radio buttons
    document.querySelectorAll('input[name="vueloVuelta"]').forEach(input => {
        input.checked = false;
    });

    precioVuelta = 0;

    actualizarPrecioTotal();
}

function actualizarPrecioTotal(){

    const mayores = parseInt(document.getElementById('cantidadMayores').value) || 0;

    const menores = parseInt(document.getElementById('cantidadMenores').value) || 0;

    const elPrecioVuelta = document.getElementById('precioVuelta');
    if (elPrecioVuelta && elPrecioVuelta.dataset.precio) {
        precioVuelta = parseFloat(elPrecioVuelta.dataset.precio);
    }

    const totalPasajeros = mayores + menores;

    const totalVuelos = Number(precioIda) + Number(precioVuelta);

    const total = totalPasajeros * totalVuelos;

    document.getElementById('precioTotal').innerText = '$' + total;
}

document.getElementById('cantidadMayores')
    .addEventListener('change', actualizarPrecioTotal);

document.getElementById('cantidadMenores')
    .addEventListener('change', actualizarPrecioTotal);