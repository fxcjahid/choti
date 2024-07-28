export default function () {
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

	if (isMobile) {
		window.addEventListener("scroll", function () {
			let scroll = this.scrollY;

			if (scroll >= 300) {
				document.querySelector('.cta-mobile-button').style.display = 'block'
			} else {
				document.querySelector('.cta-mobile-button').style.display = 'none'
			}
		});
	}
}