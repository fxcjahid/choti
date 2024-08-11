import TomSelect from 'tom-select';

class TomSelectWrapper {
    constructor(selector, options = {}) {
        this.selector = selector;
        this.options = options;
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll(this.selector);
            elements.forEach((element) => {
                new TomSelect(element, this.options);
            });
        });
    }
}

export default TomSelectWrapper;
