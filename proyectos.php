<?php
// Configuración de la Base de Datos
$host = 'localhost';$db   = 'feria_tecnologica';
$user = 'root'; // Cambia por tu usuario$pass = '';     // Cambia por tu contraseña

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $nombre_equipo = trim($_POST['nombre_equipo'] ?? '');
        $descripcion   = trim($_POST['descripcion'] ?? '');
        $nombres       =$_POST['nombres'] ?? [];
        $apellidos     =$_POST['apellidos'] ?? [];
        $jefe_index    =$_POST['jefe'] ?? 0;

        if (!empty($nombre_equipo) && !empty($nombres)) {$integrantes = [];

            for ($i = 0; $i < count($nombres);$i++) {
                $nom = trim($nombres[$i]);$ape = trim($apellidos[$i]);
                if (!empty($nom) && !empty($ape)) {$integrantes[] = [
                        'nombre'   => $nom,
                        'apellido' => $ape,
                        'es_jefe'  => ($i ==$jefe_index)
                    ];
                }
            }

            if (count($integrantes) > 0) {
                $stmt =$pdo->prepare("INSERT INTO equipos (nombre_equipo, descripcion, integrantes) VALUES (:nombre, :descripcion, :integrantes)");
                $stmt->execute([
                    ':nombre'      => $nombre_equipo,
                    ':descripcion' => $descripcion,
                    ':integrantes' => json_encode($integrantes, JSON_UNESCAPED_UNICODE)
                ]);

                $mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                              ¡El equipo <strong>' . htmlspecialchars($nombre_equipo) . '</strong> ha sido registrado con éxito!
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
            } else {
                $mensaje = '<div class="alert alert-warning" role="alert">Debes agregar al menos un integrante completo.</div>';
            }
        } else {
            $mensaje = '<div class="alert alert-danger" role="alert">Por favor ingresa el nombre del equipo.</div>';
        }
    } catch (PDOException $e) {$mensaje = '<div class="alert alert-danger" role="alert">Error de conexión: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Equipos | Feria Tecnológica</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div id="navbar"></div>
  <main>
    <section class="page-header">
      <div class="container">
        <h1>Registro de Equipos</h1>
        <p class="mb-0">Regístra a tu equipo para participar en la Feria Tecnológica.</p>
      </div>
    </section>
    <section class="page-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            
            <?= $mensaje ?>

            <div class="card shadow-sm p-4 mb-4">
              <h2 class="h4 mb-3">Formulario de Registro de Equipo</h2>
              <form action="" method="POST">
                
                <div class="mb-3">
                  <label for="nombre_equipo" class="form-label font-weight-bold">Nombre del Equipo</label>
                  <input type="text" class="form-control" id="nombre_equipo" name="nombre_equipo" placeholder="Ej. Los Innovadores" required>
                </div>

                <div class="mb-3">
                  <label for="descripcion" class="form-label font-weight-bold">Descripción del Equipo</label>
                  <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Breve descripción del proyecto o equipo..."></textarea>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h3 class="h5 mb-0">Integrantes del Equipo</h3>
                  <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarIntegrante()">+ Agregar Integrante</button>
                </div>

                <div id="contenedor-integrantes">
                  <div class="card mb-3 bg-light border integrante-row">
                    <div class="card-body py-3">
                      <div class="row g-2 align-items-center">
                        <div class="col-md-5">
                          <input type="text" name="nombres[]" class="form-control" placeholder="Nombre(s)" required>
                        </div>
                        <div class="col-md-5">
                          <input type="text" name="apellidos[]" class="form-control" placeholder="Apellido(s)" required>
                        </div>
                        <div class="col-md-2 text-center">
                          <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" type="radio" name="jefe" value="0" id="jefe_0" checked>
                            <label class="form-check-label" for="jefe_0">Jefe</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-4">
                  <button type="submit" class="btn btn-primary w-100">Registrar Equipo</button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>
  <div id="footer"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/main.js"></script>

  <script>
    let contadorIntegrantes = 1;

    function agregarIntegrante() {
        const contenedor = document.getElementById('contenedor-integrantes');
        const div = document.createElement('div');
        div.className = 'card mb-3 bg-light border integrante-row';
        div.innerHTML = `
            <div class="card-body py-3">
              <div class="row g-2 align-items-center">
                <div class="col-md-5">
                  <input type="text" name="nombres[]" class="form-control" placeholder="Nombre(s)" required>
                </div>
                <div class="col-md-5">
                  <input type="text" name="apellidos[]" class="form-control" placeholder="Apellido(s)" required>
                </div>
                <div class="col-md-2 text-center">
                  <div class="form-check form-check-inline m-0">
                    <input class="form-check-input" type="radio" name="jefe" value="${contadorIntegrantes}" id="jefe_${contadorIntegrantes}">
                    <label class="form-check-label" for="jefe_${contadorIntegrantes}">Jefe</label>
                  </div>
                </div>
              </div>
            </div>
        `;
        contenedor.appendChild(div);
        contadorIntegrantes++;
    }
  </script>
</body>
</html>