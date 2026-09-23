(function () {
  const form = document.getElementById('profileForm');
  const photoInput = document.getElementById('photoInput');
  const avatar = document.getElementById('profileAvatar');
  const removePhoto = document.getElementById('removePhoto');
  const alertBox = document.getElementById('profileAlert');
  const nameInput = document.getElementById('fullName');
  const roleInput = document.getElementById('role');
  const nameLabel = document.getElementById('profileName');
  const roleLabel = document.getElementById('profileRole');
  const storageKey = 'feriaTecnologicaPerfil';

  function showMessage(message, type) {
    alertBox.textContent = message;
    alertBox.className = `alert alert-${type}`;
    window.setTimeout(() => alertBox.classList.add('d-none'), 3500);
  }

  function renderPhoto(photo) {
    const previous = avatar.querySelector('img');
    const fallback = avatar.querySelector('svg');
    if (previous) previous.remove();
    if (!photo) {
      if (fallback) fallback.style.display = 'block';
      return;
    }
    if (fallback) fallback.style.display = 'none';
    const image = document.createElement('img');
    image.src = photo;
    image.alt = 'Foto de perfil';
    avatar.appendChild(image);
  }

  function readProfile() {
    try { return JSON.parse(localStorage.getItem(storageKey)) || {}; }
    catch (_) { return {}; }
  }

  function saveProfile(profile) { localStorage.setItem(storageKey, JSON.stringify(profile)); }

  const profile = readProfile();
  if (profile.name) { nameInput.value = profile.name; nameLabel.textContent = profile.name; }
  if (profile.role) { roleInput.value = profile.role; roleLabel.textContent = profile.role; }
  if (profile.photo) renderPhoto(profile.photo);

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (!form.checkValidity()) { form.classList.add('was-validated'); return; }
    const current = readProfile();
    current.name = nameInput.value.trim();
    current.email = document.getElementById('email').value.trim();
    current.phone = document.getElementById('phone').value.trim();
    current.role = roleInput.value;
    current.bio = document.getElementById('bio').value.trim();
    saveProfile(current);
    nameLabel.textContent = current.name;
    roleLabel.textContent = current.role;
    showMessage('Los cambios del perfil se guardaron correctamente.', 'success');
  });

  photoInput.addEventListener('change', function () {
    const file = photoInput.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) { showMessage('Selecciona una imagen válida.', 'danger'); return; }
    const reader = new FileReader();
    reader.onload = function () {
      const current = readProfile();
      current.photo = reader.result;
      saveProfile(current);
      renderPhoto(current.photo);
      showMessage('La foto de perfil se actualizó.', 'success');
    };
    reader.readAsDataURL(file);
  });

  removePhoto.addEventListener('click', function () {
    const current = readProfile();
    delete current.photo;
    saveProfile(current);
    renderPhoto(null);
    photoInput.value = '';
    showMessage('Se restauró la imagen predeterminada.', 'success');
  });
})();
