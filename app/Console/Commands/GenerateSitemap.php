<?php

namespace App\Console\Commands;

use App\Helpers\AppHelper;
use App\Models\Categories;
use App\Models\City;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use SertxuDeveloper\Sitemap\Sitemap;
use SertxuDeveloper\Sitemap\Url;

/**
 * @see : https://github.com/sertxudeveloper/laravel-sitemap
 */

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new sitemap';

    public $progressBar;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function progress($count)
    {
        $this->progressBar = $this->output->createProgressBar($count);
        $this->progressBar->start();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * get items
         */
        $cities      = City::all();
        $page        = Page::sitemap();
        $post        = Post::sitemap();
        $category    = Categories::sitemap();
        $landingPage = AppHelper::getLandingPage();

        /**
         * Create progress bar
         */
        $progressCount = (
            count($page) +
            count($post) +
            count($category) +
            (
                count($landingPage) * count($cities)
            )
        );

        $this->progress($progressCount);

        /**
         * Create sitemap object
         * @see : https://github.com/sertxudeveloper/laravel-sitemap
         */
        $sitemap = Sitemap::create();

        /**
         * Create page Map
         */
        foreach ($page as $url) {
            $sitemap->add(
                Url::create($url)
                    ->setChangeFrequency('monthly')
            );
            /**
             * Update progress bar status
             */
            $this->progressBar->advance();
        }

        /**
         * Create Category Map
         */
        foreach ($category as $value) {
            $sitemap->add(
                Url::create($value['url'])
                    ->setChangeFrequency('monthly')
            );
            $this->progressBar->advance();
        }

        /**
         * Create Post Map
         */
        foreach ($post as $value) {
            $sitemap->add(
                Url::create($value['url'])
                    ->setChangeFrequency('monthly')
            );
            $this->progressBar->advance();
        }

        $this->createParentMap($landingPage);

        /**
         * Place sitemap to Public Folder
         */
        $sitemap->writeToFile(
            public_path('sitemap/main.xml')
        );

        $this->newLine(2);
        $this->info('Sitemap was generate successful!');
    }

    /**
     * Create parent landing page map
     */
    private function createParentMap($page)
    {
        $sitemap = '';

        foreach ($page as $url) {
            /**
             * Generate URL
             */
            $sitemap .= $this->xmlUrl(
                url(
                    sprintf('sitemap/service/%s.xml', $url)
                )
            );
            /**
             * To create every single landing sitemap
             */
            $this->createMap($url);

            /**
             * Update progress bar status
             */
            $this->progressBar->advance();
        }

        /**
         * Create parent sitemap of landing page
         */
        Storage::put(
            'sitemap/servicemap.xml',
            $this->xml($sitemap)
        );
    }

    /**
     * Create single landing page sitemap
     */
    private function createMap($name)
    {
        /**
         * Get all city list
         */
        $cities = City::all();

        /**
         * Create sitemap object
         */
        $sitemap = Sitemap::create();

        foreach ($cities as $city) {

            $url = route('service.page', ['service' => $name, 'city' => $city->city_slug]);

            $sitemap->add(
                Url::create($url)
                    ->setChangeFrequency('monthly')
            );
            /**
             * Update progress bar status
             */
            $this->progressBar->advance();
        }

        /**
         * Place sitemap to Public Folder
         */
        $sitemap->writeToFile(
            public_path(
                sprintf('sitemap/service/%s.xml', $name)
            )
        );
    }

    /**
     * Create sitemap XML boilerplate
     */
    private function xml($content)
    {
        return <<<xml
		<?xml version="1.0" encoding="UTF-8"?>
			<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
				$content
			</sitemapindex>
		xml;
    }

    /**
     * Create a sitemap URL XML boilerplate
     */
    private function xmlUrl($url)
    {
        return <<<xml
			<sitemap>
				<loc>{$url}</loc>
			</sitemap>
		xml;
    }
}
