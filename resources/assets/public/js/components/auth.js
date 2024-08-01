export default () => ({
    openTab: '',

    init() {
        this.openTab = this.getQueryParam('tab') || 'login';
    },

    updateUrl() {
        const url = new URL(window.location);
        url.searchParams.set('tab', this.openTab);
        window.history.pushState({}, '', url);
    },

    getQueryParam(name) {
        return new URLSearchParams(window.location.search).get(name);
    }
});