import $toast from '@meforma/vue-toaster';
import _ from 'lodash';


export default class {

	constructor(options) {

		this.options = _.merge({
			type: null,
			multiple: false,
			route: 'admin.file-manager.index',
			title: 'File Manager',
			backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
		}, options);


		this.events = {};
		this._isHidden = true
		this.frame = this.getFrame();

		this.appendModalToBody();
		this.openFrame();
	}

	on(event, handler) {
		this.events[event] = handler;
	}

	show() {
		this._targetEl = document.getElementById('info-popup');
		this._targetEl.classList.add('flex')
		this._targetEl.classList.remove('hidden')
		this._targetEl.setAttribute('aria-modal', 'true')
		this._targetEl.setAttribute('role', 'dialog')
		this._targetEl.removeAttribute('aria-hidden')
		this._createBackdrop()
		this._isHidden = false
	}

	hide() {
		this._targetEl.classList.add('hidden')
		this._targetEl.classList.remove('flex')
		this._targetEl.setAttribute('aria-hidden', 'true')
		this._targetEl.removeAttribute('aria-modal')
		this._targetEl.removeAttribute('role')
		this._destroyBackdropEl()
		this._isHidden = true
	}

	_createBackdrop() {
		if (this._isHidden) {
			const backdropEl = document.createElement('div');
			backdropEl.setAttribute('modal-backdrop', '');
			backdropEl.classList.add(...this.options.backdropClasses.split(" "));
			document.querySelector('body').append(backdropEl);
		}
	}

	_destroyBackdropEl() {
		if (!this._isHidden) {
			document.querySelector('[modal-backdrop]').remove();
		}
	}

	getFrame() {

		let src = route(this.options.route, {
			type: this.options.type,
			multiple: this.options.multiple,
		});

		return $(`<iframe class="file-manager-iframe w-full h-full" frameborder="0" src="${src}">Loading...</iframe>`);
	}

	appendModalToBody() {
		if ($('.media-picker-modal').length === 1) {
			return;
		}

		$('body').append(this.getModal());
	}

	openFrame() {
		this.showModal();
		this.frame.on('load', () => {
			this.selectMedia();
		});
	}

	showModal() {

		let modal = $('.media-picker-modal');

		this.show();
		this.setFrameHeight();
		this.setModalTitle(modal);
		this.setModalBody(modal);
		this.closeModalOnEsc();
	}

	setFrameHeight() {
		this.frame.css('height', window.innerHeight * 0.8);
	}

	setModalTitle(modal) {
		modal.find('.modal-title').text(this.options.title);
	}

	setModalBody(modal) {
		modal.find('.modal-body').html(this.frame);
	}

	closeModalOnEsc() {

		$(document).on('keydown', (e) => {
			if (e.keyCode === 27) {
				this.hide();
			}
		});

		$(document).on('click', '#modal-closed', () => {
			this.hide();
		});

		this.frame.on('load keydown', () => {
			this.frame.contents().on('keydown', (e) => {
				if (e.keyCode === 27) {
					this.hide();
				}
			});
		});
	}

	selectMedia() {

		this.frame.contents().find('table').on('click', '.select-media', (e) => {
			e.preventDefault();

			this.events['select'](e.currentTarget.dataset);

			if (this.options.multiple) {
				if (this.options.message) {
					$toast.success(this.options.message, {
						position: "bottom-left"
					});
				}
			} else {
				this.hide();
			}
		});
	}

	getModal() {
		return `
			<div id="info-popup" tabindex="-1" class="media-picker-modal justify-center items-center overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
				<div class="relative p-4 w-full h-full md:h-auto lg:mx-20">
					<div class="relative bg-white rounded pb-3 shadow dark:bg-gray-800">
						<div class="flex justify-between p-3 border-b-slate-200 border-b text-sm font-light text-gray-500 dark:text-gray-400">
							<div class="modal-title text-xl font-semibold text-gray-900 dark:text-white">
							</div>
							<div id="modal-closed" class="pr-1 text-lg cursor-pointer">
								<i class="fa fa-window-close"></i>
							</div> 
						</div>
						<div class="modal-body"></div>
					</div>
				</div>
			</div> 
        `;
	}
}



