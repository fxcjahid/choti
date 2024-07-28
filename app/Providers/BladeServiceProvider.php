<?php

namespace App\Providers;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('appHelperJs', function () {

            $collect = collect();
            $collect->put('leadNumber', AppHelper::$leadNumber);
            $collect->put('leadFormLink', AppHelper::$leadFormLink);

            return <<<HTML
				<script type="text/javascript">
					window.app = {$collect->toJson()}
				</script>
			HTML;
        });
    }
}
