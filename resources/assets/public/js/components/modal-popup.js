export default function () {
	/**
	 * Artcle: Modal popup
	 */
	const $modalElement = document.querySelector('#adsModal');

	if ($modalElement !== null) {

		const $modalClose = document.querySelector('#adsModalClose');
		const modal = new Modal($modalElement);
		$modalClose.addEventListener('click', function () {
			modal.hide();
		});

		let isDesktop = window.matchMedia("only screen and (min-width: 760px)").matches;

		if (isDesktop) {
			setTimeout(function () {
				modal.show()
			}, 30000);
		}
	}
}