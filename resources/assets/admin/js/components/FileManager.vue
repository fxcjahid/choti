<template>
	<div class="relative flex justify-center">
		<div x-transition:enter="transition duration-300 ease-out"
			x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
			x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
			x-transition:leave="transition duration-150 ease-in"
			x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
			x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
			class="fixed inset-0 z-50 overflow-y-auto bg-slate-500 bg-opacity-60"
			aria-labelledby="modal-title" role="dialog" aria-modal="true">
			<div class="flex justify-center align-middle">
				<div
					class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-7xl">
					<div
						class="flex justify-between border-b border-b-slate-200 p-3 text-sm font-light text-gray-500 dark:text-gray-400">
						<div
							class="modal-title text-xl font-semibold text-gray-900 dark:text-white">
							File Manager
						</div>
						<div v-on:click="close" class="cursor-pointer pr-1 text-lg">
							<i class="fa fa-window-close"></i>
						</div>
					</div>
					<main class="w-full" areia-label="content">
						<div role="file-manager" class="w-full py-4 px-5">
							<file-upload 
								ref="upload" 
								v-model="files" 
								:accept="accept"
								:drop="true" 
								:multiple="true" 
								:post-action="FileUrl()"
								:headers="FileHeaders()" 
								@input-file="inputFile"
								@input-filter="inputFilter" 
								class="!block">
								<div
									class="cursor-pointer flex w-full items-center justify-center">
									<div for="dropzone-file" :class="
										$refs.upload &&
											$refs.upload.dropActive
											? ' bg-orange-50 border-orange-200 '
											: 'bg-gray-50 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600 border-gray-300  hover:bg-gray-100 dark:border-gray-600'
									" class="dark:hover:bg-bray-800 flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed">
										<div
											class="flex flex-col items-center justify-center pt-5 pb-6">
											<div>
												<svg aria-hidden="true"
													class="mx-auto mb-3 h-10 w-10 text-gray-400"
													fill="none" stroke="currentColor"
													viewBox="0 0 24 24"
													xmlns="http://www.w3.org/2000/svg">
													<path stroke-linecap="round"
														stroke-linejoin="round"
														stroke-width="2"
														d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
													</path>
												</svg>
												<p v-if="
													$refs.upload &&
													$refs.upload.dropActive
												" class="mb-2 text-base font-semibold text-indigo-600 dark:text-gray-400">
													Drop the files here ...
												</p>
												<p v-else
													class="mb-2 text-sm text-gray-500 dark:text-gray-400">
													<span class="font-semibold">
														Click to upload
													</span>
													or drag and drop
												</p>
												<p
													class="text-xs text-gray-500 dark:text-gray-400">
													JPEG, JPG, PNG or WEBP
													(MAX. <span>{{ maxWidth }}</span> x <span>{{ maxHeight }}</span> px)
												</p>
												<p
													class="text-xs text-gray-500 dark:text-gray-400">
													Maximum upload size {{ Math.floor(maxSize / 1024 / 1024)   }} MB
												</p>
											</div>
											<div
												class="hidden h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
												<div class="h-2.5 rounded-full bg-blue-600"
													style="width: 45%"></div>
											</div>
										</div>
									</div>
								</div>
							</file-upload>
							<div v-for="file in files" class="inline-block">
								<div class="m-2 w-56 h-56 inline-block" :id="file.id"
									:key="file.id">
									<img :src="file.blob" :data-name="file.name"
										class="w-56 h-56 rounded object-cover" />
									<div class="-mt-4">
										<div
											class="bg-blue-500 relative h-3 w-[97%] rounded-2xl m-auto">
											<div class="bg-green-500 absolute top-0 left-0 flex h-full items-center justify-center rounded-2xl text-xs font-semibold text-white"
												:style="{
													width:
														Math.round(
															file.progress
														) + '%',
												}" v-text="
												Math.round(file.progress) +
												'%'
											"></div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- table of file -->
						<div
							class="relative overflow-x-auto shadow-md sm:rounded-lg md:my-20">
							<table
								class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
								<thead
									class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
									<tr>
										<th scope="col" class="py-3 px-6">
											Thumbnail
										</th>
										<th scope="col" class="py-3 px-6">
											File Name
										</th>
										<th scope="col" class="py-3 px-6">
											Created
										</th>
										<th scope="col" class="py-3 px-6">
											User
										</th>
										<th scope="col" class="py-3 px-6 text-center">
											Action
										</th>
									</tr>
								</thead>
								<tbody>
									<tr class="m-auto text-center" v-if="isLoading">
										<td colspan="5">
											<div class="my-6 animate-spin inline-block w-8 h-8 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"
												role="status" aria-label="loading">
												<span class="sr-only">Loading...</span>
											</div>
										</td>
									</tr>
									<tr v-for="table in tables"
										class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
										<th scope="row"
											class="whitespace-nowrap py-4 px-6 font-medium text-gray-900 dark:text-white">
											<div class="m-1 h-16 w-16 rounded-md border">
												<img class="h-16 w-16 rounded-md p-1"
													:src="table.small" alt="thumbnail"
													draggable="false" />
											</div>
										</th>
										<td class="py-4 px-6">
											<div
												class="w-56 overflow-hidden text-ellipsis whitespace-nowrap">
												{{ table.filename }}
											</div>
										</td>
										<td class="py-4 px-6">
											{{ table.create }}
										</td>
										<td class="py-4 px-6">
											{{ table.user.username }}
										</td>
										<td class="py-4 px-6 text-center">
											<button type="button" @click="select(table)"
												class="select-media bg-slate-200 py-2 px-3">
												<i class="fa fa-check"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</main>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import ImageCompressor from '@xkeshi/image-compressor'
import VueUploadComponent from "vue-upload-component";
export default {
	data() {
		return {
			accept: "image/png, image/jpeg, image/jpg, image/webp",
			minSize: 10240, // 10 KB(Kibibyte)  | amount in byte
			maxSize:  window.FILES.upload_max_filesize * 125000, // Convert amount in byte
			maxWidth:  window.FILES.IMAGE.maxWidth,
			maxHeight:  window.FILES.IMAGE.maxHeight,
			files: [],
			tables: [],
			show: false,
			isLoading: true,
			addNewFile: false,
			autoCompress: 1024 * 1024,
		};
	},
	components: {
		FileUpload: VueUploadComponent,
	},
	methods: {
		/**
		 * Close File manager modal
		 */
		close() {
			$("body").css({ overflow: "" });
			this.$emit("close");
		},

		/**
		 * Select File
		 * @return array
		 */
		select(table) {
			this.$emit("select", table);
			this.close();
		},

		/**
		 * Set File upload url
		 * @return string
		 */
		FileUrl() {
			return route("admin.file.upload");
		},

		/**
		 * Set Http Request Header
		 * @return array
		 */
		FileHeaders() {
			return {
				"X-CSRF-TOKEN": document
					.querySelector('meta[name="csrf-token"]')
					.getAttribute("content"),
			};
		},

		/**
		 * Pretreatment
		 * @param  Object|undefined   newFile   Read and write
		 * @param  Object|undefined   oldFile   Read only
		 * @param  Function           prevent   Prevent changing
		 * @return undefined
		 */
		inputFilter: function (newFile, oldFile, prevent) { 
			/**
			 * Filter non-image file
			 */
			if (newFile && !oldFile) {
				if (!/\.(jpeg|jpg|png|webp)$/i.test(newFile.name)) {
					this.$toast.error(
						"Please select only jpeg | jpg | png | webp format",
						{
							position: "bottom-left",
						}
					);
					return prevent();
				}
			}

			/**
			 * Check min size
			 */
			if (newFile.size >= 0 && newFile.size < this.minSize) {
				let min = this.minSize / 1024; // Convert byte to Kibibyte
				let max = Math.floor(this.maxSize / 1024 / 1024); // Convert Kibibyte to MB
				this.$toast.error(
					"Image size should be minimum " +
					min +
					" KB and maximum " +
					max +
					" MB",
					{
						position: "bottom-left",
					}
				);
				return prevent();
			}

			/**
			 * Check max size
			 */
			if (newFile.size >= 0 && newFile.size > this.maxSize) {
				let min = this.minSize / 1024; // Convert byte to Kibibyte
				let max = Math.floor(this.maxSize / 1024 / 1024); // Convert byte to MB
				this.$toast.error(
					"Image size should be minimum " +
					min +
					" KB and maximum " +
					max +
					" MB",
					{
						position: "bottom-left",
					}
				);
				return prevent();
			}


			/**
			 * Set Image width & height
			 */
			// if (
			//     newFile &&
			//     newFile.error === "" &&
			//     newFile.type.substr(0, 6) === "image/" &&
			//     newFile.blob &&
			//     (!oldFile || newFile.blob !== oldFile.blob)
			// ) {
			//     newFile.error = "image parsing";
			//     let img = new Image();
			//     img.onload = () => {
			//         this.$refs.upload.update(newFile, {
			//             error: "",
			//             height: img.height,
			//             width: img.width,
			//         });
			//     };
			//     img.οnerrοr = (e) => {
			//         this.$refs.upload.update(newFile, {
			//             error: "parsing image size",
			//         });
			//     };
			//     img.src = newFile.blob;
			// }


			/**
			 * Automatic compression
			 */
			if (newFile.file && newFile.error === "" && newFile.type.substr(0, 6) === 'image/' && this.autoCompress > 0 && this.autoCompress < newFile.size) {
				newFile.error = 'compressing'

				const imageCompressor = new ImageCompressor();

				imageCompressor.compress(newFile.file, { 
					maxWidth: this.maxWidth,
					maxHeight: this.maxHeight,
				})
				.then((file) => { 
					this.$refs.upload.update(newFile, { error: '', file, size: file.size, type: file.type })
				})
				.catch((err) => {
					// Handle the error
				}) 
			}

			/**
			 * Create a blob file
			 */
			newFile.blob = "";
			let URL = window.URL || window.webkitURL;
			if (URL && URL.createObjectURL) {
				newFile.blob = URL.createObjectURL(newFile.file);
			}
		},

		/**
		 * add, update, remove File Event
		 * Has changed
		 * @param  Object|undefined   newFile   Read only
		 * @param  Object|undefined   oldFile   Read only
		 * @return undefined
		 */
		inputFile: function (newFile, oldFile) {
			// uploaded file response
			if (newFile && oldFile && !newFile.active && oldFile.active) {
				// Get response data
				console.log("response", newFile.response);
				if (newFile.xhr) {
					//  Get the response status code
					console.log("status", newFile.xhr.status);
				}
			}

			/** Add file */
			if (newFile && !oldFile) {
				this.addNewFile = true;
			}

			/**
			 * Update file
			 */
			if (newFile && oldFile) {
				/**
				 * Proccess File Before Send To Server
				 */
				if (newFile.active !== oldFile.active) {
					console.log("Start upload", newFile.active, newFile);
				}

				/**
				 * Upload Progress
				 */
				if (newFile.progress !== oldFile.progress) {
					console.log("progress", newFile.progress, newFile);
				}

				// Upload error
				if (newFile.error !== oldFile.error) {
					console.log("error", newFile.error, newFile);
					this.$toast.error(newFile.error,
						{
							position: "bottom-left",
						}
					);
				}

				// Uploaded successfully
				if (newFile.success !== oldFile.success) {
					console.log("success", newFile.success, newFile);
					this.files = [];
					this.getFile();
				}
			}

			if (!newFile && oldFile) {
				// Remove file

				// Automatically delete files on the server
				if (oldFile.success && oldFile.response.id) {
					// $.ajax({
					//   type: 'DELETE',
					//   url: '/file/delete?id=' + oldFile.response.id,
					// });
				}
			}

			// Automatic upload
			if (
				Boolean(newFile) !== Boolean(oldFile) ||
				oldFile.error !== newFile.error
			) {
				if (!this.$refs.upload.active) {
					this.$refs.upload.active = true;
				}
			}
		},

		/**
		 * get recent uploaded File from server
		 */
		getFile() {
			let that = this;
			this.isLoading = true;
			axios
				.post(route("admin.file-manager.index"))
				.then((response) => {
					that.tables = response.data;
					that.isLoading = false;
				})
				.catch((err) => {
					console.error(err);
				});
		},
	},
	mounted() {
		this.getFile();
	},
};
</script>
