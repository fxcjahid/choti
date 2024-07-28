// import grapesjs from 'grapesjs'
// import 'grapesjs/dist/css/grapes.min.css'
// import 'grapesjs/dist/grapes.min.js'

// const editor = grapesjs.init({
// 	container: '#gjs',
// 	components: '<div class="txt-red">Hello world!</div>',
// });

import axios from "axios";
export default {
    template: '<slot v-bind="self"/>',
    computed: {
        self() {
            return this;
        },
    },
    data() {
        return {
            isloading: false,
        };
    },
    methods: {
        delete(pageID) {
            let data = {
                id: pageID,
                status: 'delete'
            };

            this.$swal({
                title: 'Are you sure?',
                html: `Really! Do yo want to <b>Delete</b> permanently?`,
                showCancelButton: true,
                confirmButtonColor: '#a82730',
                confirmButtonText: 'Yes, Delete Permanently!'
            }).then((result) => {
                if (result.isConfirmed) {

                    axios.post(route('admin.post.update'), data)
                        .then((res) => {
                            const Toast = this.$swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: false,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Post was permanently deleted.'
                            })
                            window.location.reload();
                        })
                        .catch((err) => {
                            console.log(err);
                            this.$swal(
                                'Error',
                                'Something went wrong!',
                                'error'
                            )
                        });
                }
            })
        },
        moveTrash(pageID, pageName) {
            let data = {
                id: pageID,
                status: 'trash'
            };

            this.$swal({
                title: 'Are you sure?',
                html: `Really! Do yo want <b>${pageName}</b> to move trash?`,
                showCancelButton: true,
                confirmButtonColor: '#a82730',
                confirmButtonText: 'Yes, Move Trash!'
            }).then((result) => {
                if (result.isConfirmed) {

                    axios.post(route('admin.post.update'), data)
                        .then((res) => {
                            const Toast = this.$swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: false,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Page has move to Trash.'
                            })
                            window.location.reload();
                        })
                        .catch((err) => {
                            console.log(err);
                            this.$swal(
                                'Error',
                                'Something went wrong!',
                                'error'
                            )
                        });
                }
            })
        },
        create() {
            this.isloading = true;
            axios
                .post(route("admin.page.CreateOrEdit", { slug: 'new' }), {
                    slug: 'new'
                })
                .then((res) => {
                    const data = res.data;
                    window.location = route("admin.page.CreateOrEdit", {
                        slug: data.slug,
                    });
                    this.isloading = false;
                })
                .catch((err) => {
                    alert(err);
                    console.log(err);
                    this.isloading = false;
                });
        },
    },
    mounted() {

        // grapesjs.init({
        // 	container: '#gjs',
        // 	height: '1000px',
        // 	width: '100%',
        // 	// Get the content for the canvas directly from the element
        // 	// As an alternative we could use: `components: '<h1>Hello World Component!</h1>'`,
        // 	fromElement: true,

        // 	// Disable the storage manager for the moment
        // 	storageManager: false,
        // 	// Avoid any default panel
        // 	panels: { defaults: [] },
        // })

    },
}
