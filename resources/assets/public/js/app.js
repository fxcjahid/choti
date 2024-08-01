import Alpine from 'alpinejs'
import auth from './components/auth';
import 'flowbite';
import 'preline';

window.Alpine = Alpine

Alpine.data('setup', auth);

Alpine.start();