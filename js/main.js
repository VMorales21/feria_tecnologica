const esPaginaInterna = window.location.pathname.includes('/pages/');

// Los componentes traen sus enlaces escritos desde pages/ (con ../).
// En la portada, que esta en la raiz, ese ../ saca de la carpeta del proyecto.
function ajustarEnlaces(contenedor) {
  if (esPaginaInterna) return;
  contenedor.querySelectorAll('a[href^="../"]').forEach(function (enlace) {
    enlace.setAttribute('href', enlace.getAttribute('href').slice(3));
  });
}

async function cargarComponente(id, archivo) {
  const contenedor = document.getElementById(id);
  if (!contenedor) return;
  try {
    const respuesta = await fetch(archivo);
    if (!respuesta.ok) throw new Error(`No se pudo cargar ${archivo}`);
    contenedor.innerHTML = await respuesta.text();
    ajustarEnlaces(contenedor);
  } catch (error) {
    console.error(error);
    contenedor.innerHTML = '<div class="container py-2"><small class="text-danger">No se pudo cargar el componente.</small></div>';
  }
}

cargarComponente('navbar', esPaginaInterna ? '../components/navbar.html' : 'components/navbar.html');
cargarComponente('footer', esPaginaInterna ? '../components/footer.html' : 'components/footer.html');
