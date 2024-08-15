<?php

namespace App\Providers;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\Facades\PackageManager;
use Butschster\Head\MetaTags\Entities\Webmaster;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Contracts\Packages\ManagerInterface;
use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\Providers\MetaTagsApplicationServiceProvider as ServiceProvider;

class MetaTagsServiceProvider extends ServiceProvider
{
    protected function packages()
    {
        // Create your own packages here
    }

    // if you don't want to change anything in this method just remove it
    protected function registerMeta() : void
    {
        $this->app->singleton(MetaInterface::class, function () {
            $meta = new Meta(
                $this->app[ManagerInterface::class],
                $this->app['config'],
            );

            /**
             * This method gets default values from config and creates tags, includes default packages, e.t.c
             * If you don't want to use default values just remove it.
             */
            $meta->initialize();


            /**
             * It just an imagination, you can automatically
             * add favicon if it exists
             */
            if (file_exists(public_path('assets/public/img/icon.png'))) {
                $meta->setFavicon(asset('/assets/public/img/icon.png'));
            }

            if (env('GOOGLE_WEBMASTER_ID')) {
                $meta->addWebmaster(Webmaster::GOOGLE, env('GOOGLE_WEBMASTER_ID'));
            }


            return $meta;
        });
    }
}