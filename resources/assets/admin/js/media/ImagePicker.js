import MediaPicker from './MediaPicker';

export default class {

	constructor() {

		$('.image-picker').on('click', (e) => {
			this.pickImage(e);
		});

		this.removeImageEventListener();
	}

	pickImage(e) {
		let inputName = e.currentTarget.dataset.inputName;
		let multiple = e.currentTarget.hasAttribute('data-multiple');

		let picker = new MediaPicker({ type: 'image', multiple });

		picker.on('select', (file) => {
			this.addImage(inputName, file, multiple, e.currentTarget);
		});
	}

	addImage(inputName, file, multiple, target) {
		console.log(inputName);
		console.log(target);
		let html = this.getTemplate(inputName, file);

		if (multiple) {
			let multipleImagesWrapper = $(target).next('.multiple-images');

			multipleImagesWrapper.find('.image-holder.placeholder').remove();
			multipleImagesWrapper.find('.image-list').append(html);
		} else {
			$(target).hide();
			$(target).next('.placholder-image').html(html);
		}
	}

	getTemplate(inputName, file) {
		return $(`
            <div class="image-holder relative flex h-64 w-full items-center justify-center -m-1">
                <img class="w-auto h-full" src="${file.path}">
                <button type="button" class="btn absolute top-1 right-1 remove-image">
					<i class="fa fa-window-close"></i>
				</button>
                <input type="hidden" id="feature-image" name="${inputName}" value="${file.id}">
            </div>
        `);
	}

	removeImageEventListener() {
		$(document).on('click', '.image-holder', (e) => {
			e.preventDefault();
			$('.image-holder').remove();
			$('#select-image').show();
		});
	}

	getImagePlaceholder(inputName) {
		return `
            <div class="image-holder placeholder cursor-auto">
                <i class="fa fa-picture-o"></i>
                <input type="hidden" name="${inputName}">
            </div>
        `;
	}

}
