export default {
	name: 'Create-File-Manager-Modal',
	template: '<slot v-bind="self"/>',
	computed: {
		self() {
			return this;
		},
	},
	data() {
		return {
			isOpen: false,
		}
	},
	methods: {
		show() {
			this.isOpen = true;
		},
		close() {
			this.isOpen = false;
		}
	},
}; 
