import Alpine from 'alpinejs'
import auth from './components/auth';
import TomSelectWrapper from './components/tom-select';
// import 'flowbite'; 
import 'preline';

window.Alpine = Alpine;

Alpine.data('setup', auth);
Alpine.start();

new TomSelectWrapper('.tom-select', {
    create: true,
    sortField: 'text'
});