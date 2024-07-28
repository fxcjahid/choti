@extends('public.app')

@section('title', 'Qui sommes-nous - Blanee.com')
@section('canonical', route('about-us'))

@section('content')
    <main class="">
        <section class="bg-white dark:bg-gray-900">
            <div class="mx-auto max-w-screen-xl py-8 px-4 lg:py-16">

                <div class="px-4 sm:px-6 lg:px-8">
                    <h1 class="mb-2 font-trebuchet text-[36px] font-extrabold text-slate-900">
                        Qui sommes-nous
                    </h1>
                    <p class="mt-1 text-base leading-7 text-slate-600">
                        Dernière mise à jour le 2 mars 2023
                    </p>
                </div>

                <div class="relative px-4 sm:px-6 lg:mt-10 lg:px-8">
                    <h1 class="mb-3 font-nato text-[27px] font-semibold text-slate-800">
                        Ne laissez plus les nuisibles vous gâcher la vie. Éliminez-les grâce à
                        Blanee.
                    </h1>
                    <p class="my-3">
                        Les nuisibles et les parasites sont une vraie nuisance. Ils peuvent
                        nuire à votre santé et à l’hygiène de votre maison. C’est pourquoi
                        vous devez les éliminer au plus vite. Mais comment faire ? C'est pour
                        répondre à cette problématique que nous avons créé Blanee, la seule
                        plateforme qui vous aide à vous débarrasser des nuisibles et à trouver
                        le professionnel qu'il vous faut.
                    </p>
                    <h1 class="mb-3 font-nato text-[27px] font-semibold text-slate-800">
                        Le traitement des nuisibles n'a jamais été aussi facile qu'avec Blanee
                    </h1>
                    <p class="my-3">
                        Blanee est une plateforme 100% française qui accompagne et met en
                        relation toutes les personnes possédant un problème de nuisibles. Et
                        ce, que vous habitiez à Lyon, Marseille, Paris ou ailleurs.
                    </p>
                    <p class="my-3">
                        Trouver un professionnel grâce à Blanee est simple, sûr et rapide.
                        Vous pouvez, par exemple, faire une demande en ligne ou encore, nous
                        contacter afin de vous mettre en relation avec l’entreprise la plus
                        proche de chez vous, sélectionnée et validée par nos soins.
                    </p>
                    <h1 class="mb-3 font-nato text-[27px] font-semibold text-slate-800">
                        Grâce à Blanee, trouvez des professionnels sûrs et agréés dans votre
                        région !
                    </h1>
                    <p class="my-3">
                        Notre plateforme à la particularité d’être sélective : elle a recensé
                        les meilleures entreprises de traitement anti nuisible de France en
                        suivant un protocole de sélection interne draconien. Nous avons donc
                        regroupé les meilleurs professionnels du secteur sur notre plateforme
                        et nous avons élaboré une méthodologie rigoureuse pour les choisir. En
                        somme, c’est vous qui choisissez l’entreprise anti nuisible la plus
                        proche de chez vous parmi un panel des meilleurs professionnels du
                        secteur.

                    </p>
                    <h1 class="mb-3 font-nato text-[27px] font-semibold text-slate-800">
                        Un service tout compris. Contactez-nous, on s'occupe de régler votre
                        problème de nuisibles. Simple comme un coup de fil !
                    </h1>
                    <p class="my-3">
                        Vous avez donc la garantie d’une prestation de qualité et d’un travail
                        soigné en toute sécurité. Nous assurons aussi un suivi après le
                        passage du professionnel afin de vous garantir les meilleurs
                        résultats.

                        Ne perdez plus une minute et contactez-nous au
                        {{ AppHelper::$leadNumber }} ou en
                        cliquant sur le bouton ci-dessous.
                    </p>
                </div>
                <div class="pt-16 text-center">
                    <a href="{{ AppHelper::$leadFormLink }}"
                       target="_blank"
                       class="block rounded-lg bg-theme-color py-5 px-7 text-center text-xl font-medium text-white outline-none hover:bg-gray-700 dark:bg-primary-600 dark:hover:bg-primary-700 sm:w-fit md:text-2xl">
                        Je me débarrasse de mes nuisibles
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
