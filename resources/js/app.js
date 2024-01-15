import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


picture.onchange = evt => {
    let preview = document.getElementById('preview');
    preview.style.display = 'block';
    const [file] = picture.files
    if (file) {
        preview.src = URL.createObjectURL(file)
    }
}
