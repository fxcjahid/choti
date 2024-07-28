export default function () {
	/**
	 * Artcle: Inline ads show
	 */
	const HeadingTags = document.querySelector('.art-content');
	const InlineAds = `
			<div role="ads" aria-label="ads" class="inline-ads mt-8 mb-10">
				<div class="relative h-[300px] w-full overflow-hidden rounded-lg bg-gray-100 shadow dark:bg-gray-800 sm:py-7 sm:px-10">
					<div class="flex h-full items-center justify-between gap-5">
						<div class="p-5 text-left">
							<div class="mb-4 mt-2 text-2xl font-semibold text-slate-900">Faites-vous face à une infestation de nuisibles ?</div>
							<p class="mb-6 mt-2 text-base text-slate-800">Ne restez pas seul dans la bataille contre les nuisibles. Faites appel à un expert !</p>
							<div class="animate-infinite mt-12 mb-10 md:mb-5 animate-shake cursor-pointer hover:animate-none">
								<a onclick="window.open('tel:'+app.leadNumber, '_self');" class="rounded-lg bg-theme-color px-6 py-3 text-xl font-medium !text-white transition-colors hover:animate-none hover:bg-gray-900 hover:!no-underline focus:outline-none">
									Appelez-nous
								</a>
							</div>
						</div>
						<div class="hidden md:block relative h-full w-3/6">
							<div class="h-full w-full">
								<div class="absolute"></div>
								<img class="m-auto h-[107%] object-cover" src="/assets/public/img/inline-man-ads.png"></div>
						</div>
					</div>
				</div>
			</div>
		`;

	if (HeadingTags !== null) {
		const HeadingTags = document.querySelector('.art-content').querySelectorAll('h1,h2,h3,h4,h5,h5');
		const HeadingTagsLenght = HeadingTags.length;
		const TargetDivided = Math.floor((HeadingTagsLenght <= 6) ? (HeadingTagsLenght / 2) : (HeadingTagsLenght / 3));

		HeadingTags.forEach((element, i, a) => {
			if (i % TargetDivided != 0) return;
			var span = document.createElement('div');
			span.innerHTML = InlineAds;
			span.className = 'asterisk';

			element.before(span);
		});
	}
}