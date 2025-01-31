import Alpine from 'alpinejs'
import auth from './components/auth';
import imageUploader from './components/image-uploader';
import TomSelectWrapper from './components/tom-select';
// import 'flowbite';
import 'preline';

window.Alpine = Alpine;

Alpine.data('setup', auth);
Alpine.data('imageUploader', imageUploader);
Alpine.start();

new TomSelectWrapper('.tom-select', {
    create: true,
    sortField: 'text'
});
