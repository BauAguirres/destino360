


<div class="card" style="width: 18rem;">
  <img src="../assets/img/logosAerolineas/<?php echo ($aerolinea['urlLogo']??'default-logo.png'); ?>" 
       class="card-img-top" alt="Logo" style="height: 200px; object-fit: cover;">
  <div class="card-body">
    <h5 class="card-title">Nombre: <?php echo ($aerolinea['nombre']??'Nombre no disponible'); ?></h5>
    <p class="card-text">Código IATA: <?php echo ($aerolinea['codIATA']??'Código no disponible'); ?></p>
    <p class="card-text">Código País: <?php echo ($aerolinea['codPais']??'Código no disponible'); ?></p>
    <p class="card-text">
      <strong>Estado:</strong> 
      <?php if (($aerolinea['estado'] ?? 0) == 1): ?>
        <span class="badge bg-success">Activa</span>
      <?php else: ?>
        <span class="badge bg-danger">Inactiva</span>
      <?php endif; ?>
    </p>
    <p class="card-text">Descripción: <?php echo ($aerolinea['descripcion']??'Descripción no disponible'); ?></p>
  </div>
</div>