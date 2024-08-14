import 'flowbite';
import Quill from 'quill';
import { createApp } from 'vue'
import Toaster from "@meforma/vue-toaster";
import VueSweetalert2 from 'vue-sweetalert2';
import CreatePostButton from './components/CreatePostButton'
import CreatePost from './components/CreatePost'
import CreateCategory from './components/CreateCategory'
import CreateSeries from './components/CreateSeries'
import CreateTag from './components/CreateTag';
import CreateUploader from "./components/CreateUploader";
import CreateFileManagerModal from './components/CreateFileManagerModal';
import FileManager from './components/FileManager';
import DashboardIndex from './Dashboard/DashboardIndex';
import CreateSearch from './components/CreateSearch';
import PageIndex from './Page/PageIndex';
import 'sweetalert2/dist/sweetalert2.min.css';

///Use only when offline
// import Alpine from 'alpinejs'
// window.Alpine = Alpine
// Alpine.start()

window.$ = window.jQuery = require('jquery');

const app = createApp({})

app.component('CreatePost', CreatePost);
app.component('CreatePostButton', CreatePostButton)
app.component('CreateCategory', CreateCategory)
app.component('CreateSeries', CreateSeries)
app.component('CreateTag', CreateTag)
app.component('CreateUploader', CreateUploader)
app.component('CreateFileManagerModal', CreateFileManagerModal)
app.component('FileManager', FileManager)
app.component('DashboardIndex', DashboardIndex)
app.component('CreateSearch', CreateSearch)
app.component('PageIndex', PageIndex)
app.use(Toaster);
app.use(VueSweetalert2);
app.mount('#app')

window.quill = new Quill('#content', {
    placeholder: 'Write new story...',
    theme: 'bubble',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, 4, false] }],
            ['bold', 'italic'],
            ['image']
        ]
    }
});