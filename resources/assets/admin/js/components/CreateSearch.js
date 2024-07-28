import axios from "axios";

export default {
    template: '<slot v-bind="self"/>',
    computed: {
        self() {
            return this
        }
    },
    data() {
        return {
            searchKeyword: '',
            searckResults: '',
        }
    },
    methods: {
        cancelSearch(event) {
            if (event.target.value.length < 3 || this.searckResults.results == 0) {
                this.searchKeyword = '';
                this.searckResults = '';
                return;
            }
        },
        startSearching(event) {
            if (event.target.value.length < 3) {
                this.searckResults = '';
                return;
            }
            if (event.target.value.length >= 3) {

                axios.post(route('admin.search.show'), {
                    keyword: event.target.value
                })
                    .then((res) => {
                        this.searckResults = res.data;
                        console.log(res);
                    })
                    .catch((res) => {

                    });
            }
        },
        matchingKeyword(current) {
            let reggie = new RegExp(this.searchKeyword, "ig");
            let found = current.search(reggie) !== -1;
            return !found ? current : current.replace(reggie, '<span class="font-semibold">' + this.searchKeyword + '</span>');
        },
        openPost(postid) {
            let url = route('admin.create.get', postid);
            /** Open New Tab */
            window.open(url, '_self');
        },
        openPager(slug, category, target = '_self') {
            let url = route('post.show', { slug: slug, category: category });
            /** Open New Tab */
            window.open(url, target);
        }
    }

}
