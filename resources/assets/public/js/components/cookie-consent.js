import 'vanilla-cookieconsent';

export default function () {
	var cc = window.initCookieConsent();

	/**
	 * @see : https://github.com/orestbida/cookieconsent
	 */
	// run plugin with your configuration
	cc.run({
		current_lang: "fr",
		autoclear_cookies: true, 				   // default: false
		page_scripts: true, 					   // default: false
		auto_language: "document",		 		   // default: null; could also be 'browser' or 'document'

		onFirstAction: function (user_preferences, cookie) {
			// callback triggered only once on the first accept/reject action
		},

		onAccept: function (cookie) {
			// callback triggered on the first accept/reject action, and after each page load
		},

		onChange: function (cookie, changed_categories) {
			// callback triggered when user changes preferences after consent has already been given

			if (!cc.allowedCategory("analytics")) {
				if (typeof window.google !== "undefined")
					document.getElementById("google-maps").innerHTML = "google maps here";
			}
		},

		gui_options: {
			consent_modal: {
				layout: "box", 		// box/cloud/bar
				position: "bottom left", 	// bottom/middle/top + left/right/center  bottom right
				transition: "slide", 	// zoom/slide
				swap_buttons: false 		// enable to invert buttons
			},
			settings_modal: {
				layout: "box", // box/bar
				position: "left", // left/right
				transition: "slide" // zoom/slide
			}
		},

		languages: {
			fr: {
				consent_modal: {
					title: '🍪 On vous présente nos cookies !',
					description: 'Sur ce site, nous utilisons des cookies pour mesurer notre audience, entretenir la relation avec vous et vous adresser de temps à autre du contenu qualitif ainsi que de la publicité. Vous pouvez sélectionner ici ceux que vous autorisez à rester ici. <button type="button" data-cc="accept-necessary" class="custom-close">Continuer sans accepter →</button>',
					secondary_btn: {
						text: "Gérer mes choix",
						role: "settings" // 'settings' or 'accept_necessary'
					},
					primary_btn: {
						text: "J'accepte tout",
						role: "accept_all" // 'accept_selected' or 'accept_all'
					}
				},
				settings_modal: {
					title: "🍪 Bienvenue sur notre plateforme de gestion des cookies",
					save_settings_btn: "Enregistrer paramètres ",
					accept_all_btn: "J'accepte tout",
					reject_all_btn: "Terminer",
					close_btn_label: "Close",
					cookie_table_headers: [
						{ col1: "Name" },
						{ col2: "Domain" },
						{ col3: "Expiration" },
						{ col4: "Description" }
					],
					blocks: [
						{
							description: 'Nos partenaires et nous déposons des cookies et autres traceurs. Certains sont strictement nécessaires au fonctionnement du site ou nécessaires à la fourniture d’un service à votre demande et ne sont pas soumis au recueil de votre consentement. Concernant les autres traceurs et cookies, ils doivent être acceptés par vous. Nos partenaires collecteront et utiliseront vos données pour des finalités qui leur sont propres, conformément à leurs politiques de confidentialité (accessibles en cliquant sur le bouton "Voir nos partenaires") soit sur la base de leur intérêt légitime ou le recueil du consentement. Pour en savoir plus, vous pouvez consulter notre <a  class="cc-link" href="/politique-de-confidentialite">Charte sur les données personnelles et cookies</a>.<br/><br>Vos préférences s’appliqueront uniquement à notre site. Vous pourrez à tout moment revenir sur vos choix ou retirer votre consentement en cliquant sur la rubrique « Gestion des Cookies » présente sur chaque page du site.'
						},
						{
							title: "Facebook Pixel",
							description: "Identifie les visiteurs en provenance de publications Facebook",
							toggle: {
								value: "fb_pixel",
								enabled: false,
								readonly: false
							}
						},
						{
							title: "Google Analytics",
							description: "Permet d'analyser les statistiques de consultation de notre site",
							toggle: {
								value: "google_analytics",
								enabled: false,
								readonly: false
							}
						},
						{
							title: "Plus d’informations",
							description:
								'Pour toute requête en relation avec notre politique de cookies et vos choix, veuillez <a href="/contact" class="cc-link">nous contacter</a>.'
						}
					]
				}
			}
		}
	});

	//cc.show();

}