




  <div class="card-body">

    <h5 class="card-title">Nombre: <?php echo ($usuario['nombreUsuario']??'Nombre no disponible'); ?></h5>
    <p class="card-text">Email: <?php echo ($usuario['email']??'email no disponible'); ?></p>
    <p class="card-text">Aerolinea: <?php echo ($usuario['nombre']??'Código no disponible'); ?></p>
    <p class="card-text">
      <strong>Estado:</strong> 
      <?php if (($usuario['estadoUsuario'] ?? 'rechazado') == 'verificado'): ?>
        <span class="badge bg-success">Verificado</span>
      <?php elseif (($usuario['estadoUsuario'] ?? 'rechazado') == 'rechazado'): ?>
        <span class="badge bg-danger">Rechazado</span>
      <?php else: ?>
        <span class="badge bg-warning">Pendiente</span>
      <?php endif; ?>
    </p>
  </div>
