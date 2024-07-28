<?php

namespace App\Helpers;

/**
 * AppHelper Classes
 * Thats can uses global in any file, any where
 */

class AppHelper
{
    /**
     * Lead Collection Number
     */
    public static $leadNumber = '01 84 60 88 18';

    /**
     * Lead Collection Form
     */
    public static $leadFormLink = 'https://docs.google.com/forms/d/1BrTQwhGH3KV1ecKa7qND8Gf5MmLl-C5dc3NfngtBrF8';

    /**
     * Hellobar show/hide as specific page
     * @return boolen
     */
    public static function HelloBarStatus()
    {
        /**
         * if route is post area
         */
        if (
            request()->route()->getName() == 'post.show'
        ) {
            return true;
        }

        return false;
    }

    /**
     * Register Landing page items
     */
    public static function getLandingPage()
    {
        return [
            "deratisation-urgence",
            "destruction-enlevement-nid-guepes-frelons",
            "inspection-nuisibles",
            "traitement-anti-anthrene-des-tapis",
            "traitement-araignees",
            "traitement-cafards",
            "traitement-fourmis",
            "traitement-mites",
            "traitement-nuisibles-bureaux",
            "traitement-nuisibles-entrepots",
            "traitement-nuisibles-entreprises",
            "traitement-nuisibles-restaurants",
            "traitement-oiseaux-depigeonnage",
            "traitement-poissons-dargent",
            "traitement-professionnel-mouches",
            "traitement-puces",
            "traitement-punaises-de-lit",
            "traitement-renards",
            "traitement-souris",
            "traitement-vapeur-punaises-de-lit",
            "traitement-vers-a-bois-insectes-xylophages",
        ];
    }

    public static function HireExpert($category)
    {
        $message = "Suspectez-vous un problème de $category ?";

        $exitPest = [
            'abeilles'                   => 'Suspectez-vous un problème d\'abeilles ?',
            'acariens'                   => 'Suspectez-vous un problème d\'acariens ?',
            'araignees'                  => 'Suspectez-vous un problème d\'araignées ?',
            'belettes'                   => 'Suspectez-vous un problème de belettes ?',
            'cafards'                    => 'Suspectez-vous un problème de cafards ?',
            'chenilles-processionnaires' => 'Suspectez-vous un problème de chenilles processionnaires ?',
            'coccinelles-gendarmes'      => 'Suspectez-vous un problème de coccinelles ou de gendarmes ?',
            'coleoptere'                 => 'Suspectez-vous un problème de coléoptères ?',
            'deratisation'               => 'Suspectez-vous un problème de souris ou de rats ?',
            'ecureuils'                  => 'Suspectez-vous un problème d\'écureuils ?',
            'fouines'                    => 'Suspectez-vous un problème de fouines ?',
            'fourmis'                    => 'Suspectez-vous un problème de fourmis ?',
            'grillons'                   => 'Suspectez-vous un problème de grillons ?',
            'guepes'                     => 'Suspectez-vous un problème de guêpes ?',
            'loirs'                      => 'Suspectez-vous un problème de loirs ?',
            'martres'                    => 'Suspectez-vous un problème de martres ?',
            'mites'                      => 'Suspectez-vous un problème de mites ?',
            'moucherons'                 => 'Suspectez-vous un problème de moucherons ?',
            'mouches'                    => 'Suspectez-vous un problème de mouches ?',
            'moustiques'                 => 'Suspectez-vous un problème de moustiques ?',
            'oiseaux'                    => 'Suspectez-vous un problème d\'oiseaux ?',
            'poissons-dargent'           => 'Suspectez-vous un problème de poissons d\'argent ?',
            'poux'                       => 'Suspectez-vous un problème de poux ?',
            'puces'                      => 'Suspectez-vous un problème de puces ?',
            'punaises-de-lit'            => 'Suspectez-vous un problème de punaises de lit ?',
            'punaises-diaboliques'       => 'Suspectez-vous un problème de punaises diaboliques ?',
            'ratons-laveurs'             => 'Suspectez-vous un problème de ratons laveurs ?',
            'renards'                    => 'Suspectez-vous un problème de renards ?',
            'taupes'                     => 'Suspectez-vous un problème de taupes ?',
            'termites'                   => 'Suspectez-vous un problème de termites ?',
            'tiques'                     => 'Suspectez-vous un problème de tiques ?',
            'prix'                       => 'Suspectez-vous un problème de nuisibles ?',
            'vers-a-bois'                => 'Suspectez-vous un problème de vers à bois ?',
        ];

        if (!array_key_exists($category, $exitPest)) {
            return;
        }

        return [
            'title' => $exitPest[$category],
        ];
    }
}
