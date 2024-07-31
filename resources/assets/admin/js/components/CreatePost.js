import axios from 'axios';
import MediaPicker from '../media/MediaPicker';
import ImagePicker from '../media/ImagePicker';
import TomSelect from 'tom-select';
import CreateFileManagerModal from './CreateFileManagerModal';
import FileManager from './FileManager';

import 'tom-select/dist/css/tom-select.css'

export default {
    name: 'Create-Post',
    template: '<slot v-bind="self"/>',
    props: ['posts'],
    computed: {
        self() {
            return this;
        },
        getFirstCategory() {
            return this.getFirstCategoryName;
        },
        getPostTitle() {
            // Get Post Raw Slug
            let PostSlug = (typeof (this.posts.slug) === 'number') ? '' : this.posts.slug;
            let oldSlug = (PostSlug) ? PostSlug : this.form.title;

            // Genarate Automatic Permalink
            let slug = this.makeSlug(oldSlug);
            slug = (!slug) ? this.form.id : slug;

            // Genarate Custom Permalink 
            if (this.form.permalink.custom) {
                slug = this.makeSlug(this.form.permalink.link);
                slug = (!slug) ? this.form.id : slug;
            }

            // Set post new slug for database. 
            this.form.slug = slug;

            return slug;
        },
        getPostThumbnail() {
            return this.form.thumbnail[0];
        }
    },
    data() {
        return {
            form: {
                ...this.posts,
                category: this.selectedCategories(),
                series: this.selectedSeries(),
                tag: this.selectedTags(),
                permalink: {
                    custom: false,
                    link: ''
                },
            },
            isloading: false,
            openModal: false,
            getFirstCategoryName: 'draft',
        }
    },
    methods: {
        open() {
            $("body").css({ overflow: "hidden" });
            this.openModal = true;
        },
        close() {
            this.openModal = false;
        },
        select(files) {
            this.form.thumbnail = []; // Make it empty first
            this.form.thumbnail.push(files);
        },
        remove() {
            this.form.thumbnail = [];
        },
        makeSlug(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
            var to = "aaaaaeeeeeiiiiooooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        },
        updateFirstCategory() {
            if (typeof this.posts.category !== 'undefined' && this.posts.category.length > 0) {
                /* the array is defined and has no elements */
                const catName = (this.posts.category[0].slug != 'undefined') ? this.posts.category[0].slug : 'uncategory';
                this.getFirstCategoryName = catName;
            }
        },
        selectedCategories() {
            const array = []
            this.posts.category.forEach(element => {
                array.push(element.id)
            });
            return array;
        },
        selectedSeries() {
            const array = []
            console.log(this.posts);
            this.posts.series.forEach(element => {
                array.push(element.id)
            });
            return array;
        },
        selectedTags() {
            const array = []
            this.posts.tag.forEach(element => {
                array.push(element.id)
            });
            return array;
        },
        viewPost() {
            const url = route('post.show', {
                slug: this.posts.slug,
                category: this.getFirstCategoryName
            });

            if (this.form.category.length == 0) {
                this.$toast.info(`Please select any category then save post. Without publish you can't preview.`, {
                    position: "bottom-left",
                    queue: true,
                    duration: 5000,
                });
                return;
            }

            window.open(url, '_blank');
        },
        post(arg = [], callback) {
            this.updateFirstCategory();
            window.EditorJS.save().then((savedData) => {

                this.form.content = savedData;

                if (arg.status) {
                    this.form.status = arg.status;
                }

                axios.post(route('admin.update.post'), this.form)
                    .then((res) => {
                        callback(res);
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

                        } else {
                            console.log(err);
                            alert(err.message)
                        }
                        this.isloading = false;
                    });
            });
        },
        save() {
            this.post({},
                (res) => {
                    if (res.data.success) {
                        this.$toast.success('The post was saved successfully.', {
                            position: "bottom-left",
                            queue: true,
                            duration: 2000,
                        });

                        if (['draft', 'scheduled', 'trash'].includes(this.form.status)) {
                            this.$toast.error(`Remember! Post has already ${this.form.status}`, {
                                position: "bottom-left",
                                queue: true,
                                duration: 5000,
                            });
                        }

                        if (this.form.category.length == 0) {
                            this.$toast.info(`Remember! Post has not select any category`, {
                                position: "bottom-left",
                                queue: true,
                                duration: 5000,
                            });
                        }
                    }
                }
            );
        },
        draft() {
            this.post({
                status: 'draft'
            },
                (res) => {
                    if (res.data.success) {
                        this.$toast.info('The post was drafted.', {
                            position: "bottom-left"
                        });
                    }
                    const url = route('admin.dashboard', {
                        'status': 'draft',
                    });
                    window.location.href = url;
                }
            );
        },
        trash() {
            this.post({
                status: 'trash'
            },
                (res) => {
                    if (res.data.success) {
                        this.$toast.error('The post has move to trash.', {
                            position: "bottom-left"
                        });
                        const url = route('admin.dashboard', {
                            'status': 'trash',
                        });
                        window.location.href = url;
                    }
                }
            );
        },
        publish() {
            this.isloading = true;
            this.post({
                status: 'publish',
            },
                (res) => {
                    if (res.data.success) {
                        this.$toast.success(res.data.message, {
                            position: "bottom-left"
                        });
                        setTimeout(() => {
                            this.isloading = false;
                            window.location = route("admin.dashboard")
                        }, 1000);
                    }
                }
            );
        },
    },
    mounted() {
        this.updateFirstCategory();
        let that = this;
        new TomSelect('#select-categories', {
            plugins: {
                remove_button: {
                    title: 'Remove this item',
                },
            },
            persist: false,
            create: true,
            maxItems: 10, // max added items
            onOptionAdd: (params) => {
                // const OptionName = params;
                // this.$swal({
                // 	title: 'Create Category?',
                // 	html: `Do yo want to create category <b>${OptionName}</b> ?`,
                // 	showCancelButton: true,
                // 	confirmButtonColor: '#389b00',
                // 	confirmButtonText: 'create'
                // }).then((result) => {
                // 	if (result.isConfirmed) {
                // 		const data = {
                // 			name: params,
                // 		};
                // 		axios.post(route('admin.category.store'), data)
                // 			.then((res) => {
                // 				if (res.data.success) {
                // 					this.$toast.success(res.data.message, {
                // 						position: "bottom-right"
                // 					});
                // 				}
                // 			})
                // 			.catch((err) => {
                // 				console.log(err);
                // 				const status = err.response.status;
                // 				const data = err.response.data;

                // 				if (status == 422) {
                // 					Object.entries(data.errors).forEach(element => {
                // 						this.$toast.error(element[1], {
                // 							position: "bottom-right"
                // 						});
                // 					});

                // 				}
                // 			});
                // 	}
                // })
            },
            // Before create option Minimum Length word length must be 3 charaters
            createFilter: function (input) {
                return input.length >= 3;
            },
            onChange: function (element) {
                element.forEach((value, key) => {
                    if (key == 0) {
                        const nodeEl = this.getItem(value);
                        const slug = nodeEl.dataset.slug;
                        that.getFirstCategoryName = slug;
                    }
                });
            },
            valueField: 'value',
            labelField: 'title',
            searchField: 'title',
            render: {
                item: function (data, escape) {
                    return `<div data-slug="${data.slug}">${escape(data.title)}</div>`;
                },
            }
        });

        new TomSelect('#select-series', {
            plugins: {
                remove_button: {
                    title: 'Remove this item',
                },
            },
            persist: false,
            create: true,
            maxItems: 10, // max added items
            onOptionAdd: (params) => {
            },
            // Before create option Minimum Length word length must be 3 charaters
            createFilter: function (input) {
                return input.length >= 3;
            },
            onChange: function (element) {
                element.forEach((value, key) => {
                    if (key == 0) {
                        const nodeEl = this.getItem(value);
                        const slug = nodeEl.dataset.slug;
                        that.getFirstCategoryName = slug;
                    }
                });
            },
            valueField: 'value',
            labelField: 'title',
            searchField: 'title',
            render: {
                item: function (data, escape) {
                    return `<div data-slug="${data.slug}">${escape(data.title)}</div>`;
                },
            }
        });

        new TomSelect('#select-tags', {
            plugins: {
                remove_button: {
                    title: 'Remove this item',
                },
            },
            persist: false,
            create: true,
            maxItems: 20, // max added items
            create: (input) => {
                var OptionID = '';
                const OptionName = input;
                this.$swal({
                    title: 'Create Tag?',
                    html: `Do yo want to create tag <b>${OptionName}</b> ?`,
                    showCancelButton: true,
                    confirmButtonColor: '#389b00',
                    confirmButtonText: 'create'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = {
                            name: OptionName,
                        };
                        axios.post(route('admin.tags.store'), data)
                            .then((res) => {
                                console.log(res);
                                if (res.data.success) {
                                    this.$toast.success(res.data.message, {
                                        position: "bottom-right"
                                    });
                                    OptionID = res.data.tag.id;
                                }
                            })
                            .catch((err) => {
                                console.log(err);
                                const status = err.response.status;
                                const data = err.response.data;

                                if (status == 422) {
                                    Object.entries(data.errors).forEach(element => {
                                        this.$toast.error(element[1], {
                                            position: "bottom-right"
                                        });
                                    });

                                }
                            });
                    }
                })
                console.log(OptionID);
                return { value: OptionID, title: OptionName };
            },
            // Before create option Minimum Length word length must be 3 charaters
            createFilter: function (input) {
                return input.length >= 3;
            },
            valueField: 'value',
            labelField: 'title',
            searchField: 'title',
        });

        window.MediaPicker = MediaPicker;

        if ($('.image-picker').length !== 0) {
            new ImagePicker($('.modal'));
        }

    },
};

