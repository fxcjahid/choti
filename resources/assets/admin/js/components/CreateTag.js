import axios from 'axios';

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
            isEditTag: false,
            form: {},
            tables: [],
        }
    },
    methods: {
        updateSlug() {
            this.form.slug = this.slugify(this.form.name);
        },
        validationSlug() {
            this.form.slug = this.slugify(this.form.slug);
        },
        slugify(text = '', ampersand = 'and') {
            return text.toString().toLowerCase()
                .replace(/[\s_]+/g, '-')
                .replace(/&/g, `-${ampersand}-`)
                .replace(/[^a-zA-Z0-9ঀ-৿\u0980-\u09FF-]+/g, '')
                .replace(/^-+|-+$/g, '')
                .replace(/--+/g, '-');
        },
        store() {
            this.isloading = 1,
                axios.post(route('admin.tags.store'), this.form)
                    .then((res) => {
                        if (res.data.success) {
                            this.$toast.success(res.data.message, {
                                position: "bottom-left"
                            });
                            this.show();
                            this.form = {};
                            this.isloading = false;
                        }
                    })
                    .catch((err) => {
                        const status = err.response.status;
                        const data = err.response.data;

                        if (status == 422) {
                            Object.entries(data.errors).forEach(element => {
                                this.$toast.error(element[1], {
                                    position: "bottom-left"
                                });
                            });

                        }
                        this.isloading = false;
                    });
        },
        show() {
            axios.post(route('admin.tags.show'))
                .then((res) => {
                    this.tables = res.data;
                })
        },
        edit(item) {
            this.isEditTag = true;
            this.form = item;
        },
        editClose() {
            this.isEditTag = false;
            this.form = {};
            this.show();
        },
        update() {
            this.isloading = 1,
                axios.post(route('admin.tags.update'), this.form)
                    .then((res) => {
                        if (res.data.success) {
                            this.$toast.success(res.data.message, {
                                position: "bottom-left"
                            });
                            this.show();
                            this.form = {};
                            this.isloading = false;
                            this.isEditTag = false;
                        }
                    })
                    .catch((err) => {
                        const status = err.response.status;
                        const data = err.response.data;

                        if (status == 422) {
                            Object.entries(data.errors).forEach(element => {
                                this.$toast.error(element[1], {
                                    position: "bottom-left"
                                });
                            });

                        }
                        this.isloading = false;
                    });
        },
        destroy(id, name) {
            this.$swal({
                title: 'Are you sure?',
                html: `Really! Do yo want to remove <b>${name}</b> tag?`,
                showCancelButton: true,
                confirmButtonColor: '#a82730',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    axios.delete(route("admin.tags.destroy", { id: id }))
                        .then((res) => {
                            this.show();
                            this.$swal(
                                'Deleted!',
                                'Tag has been deleted.',
                                'success'
                            )
                        });
                }
            })
        },
        openPager(slug) {
            let url = route('tag', { tag: slug });
            /** Open New Tab */
            window.open(url, '_blank');
        }
    },
    beforeMount() {
        this.show()
    },
    mounted() {

    },
};

