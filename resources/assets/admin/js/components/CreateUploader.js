import axios from "axios";
import { useDropzone } from "vue3-dropzone";


export default {
	name: "Dropzone",
	template: '<slot v-bind="self"/>',
	computed: {
		self() {
			return this;
		},
	},
	setup() {
		const saveFiles = (files) => {
			const formData = new FormData(); // pass data as a form
			for (var x = 0; x < files.length; x++) {
				// append files as array to the form, feel free to change the array name
				formData.append("file[]", files[x]);
			}

			axios
				.post(route('admin.file.upload'), formData, {
					headers: {
						"Content-Type": "multipart/form-data",
					},
				})
				.then((response) => {
					window.location.reload();
				})
				.catch((err) => {
					console.error(err);
				});
		};

		function onDrop(acceptFiles, rejectReasons) {
			saveFiles(acceptFiles);
		}

		const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

		return {
			getRootProps,
			getInputProps,
			...rest,
		};
	},
	mounted() {
	},
};
