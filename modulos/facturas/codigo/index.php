<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Codigo de Control</title>
</head>
<body>
    <form action="CodigoControl.php" method="post">
      <div>
          <label for="">Nº Autorizacion</label>
          <input type="text" name="numautorizacion">
      </div>
      <div>
          <label for="">Nº Factura</label>
          <input type="text" name="numfactura">
      </div>
      <div>
          <label for="">NIT Cliente</label>
          <input type="text" name="nitcliente">
      </div>
      <div>
          <label for="">Fecha</label>
          <input type="text" name="fecha">
      </div>
      <div>
          <label for="">Monto</label>
          <input type="text" name="monto">
      </div>
      <div>
          <label for="">Clave</label>
          <input type="text" name="clave">
      </div>
      <div>
          <input type="submit" value="Generar">
          <input type="reset" value="Limpiar">
      </div>
    </form>
</body>
</html>
