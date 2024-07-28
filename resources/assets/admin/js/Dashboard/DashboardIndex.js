import axios from "axios";
export default {
	template: '<slot v-bind="self"/>',
	computed: {
		self() {
			return this;
		},
	},
	methods: {
		makeDraft(postID) {
			let data = {
				id: postID,
				status: 'draft'
			};

			this.$swal({
				title: 'Are you sure?',
				html: `Really! Do yo want to make as draft post?`,
				showCancelButton: true,
				confirmButtonColor: '#a82730',
				confirmButtonText: 'Yes, Make Draft!'
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
								title: 'Post has been draft.'
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
		delete(postID) {
			let data = {
				id: postID,
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
		moveTrash(postID) {
			let data = {
				id: postID,
				status: 'trash'
			};

			this.$swal({
				title: 'Are you sure?',
				html: `Really! Do yo want to move trash?`,
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
								title: 'Post has move to Trash.'
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
	},
	mounted() {

	},
}