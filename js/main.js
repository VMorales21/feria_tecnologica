async function cargarComponente(id, archivo) {
  const contenedor = document.getElementById(id);
  if (!contenedor) return;
  try {
    const respuesta = await fetch(archivo);
    if (!respuesta.ok) throw new Error(`No se pudo cargar ${archivo}`);
    contenedor.innerHTML = await respuesta.text();
  } catch (error) {
    console.error(error);
    contenedor.innerHTML = '<div class="container py-2"><small class="text-danger">No se pudo cargar el componente.</small></div>';
  }
}

const esPaginaInterna = window.location.pathname.includes('/pages/');
cargarComponente('navbar', esPaginaInterna ? '../components/navbar.html' : 'components/navbar.html');
cargarComponente('footer', esPaginaInterna ? '../components/footer.html' : 'components/footer.html');
