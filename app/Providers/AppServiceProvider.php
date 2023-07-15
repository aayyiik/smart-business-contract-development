<?php

namespace App\Providers;

// use App\Models\Tender;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('currency', function ($expression) {
            return "<?php echo number_format($expression, 0, ',', '.'); ?>";
        });

        // view()->composer('layouts.master-dashboard', function ($view) {
        //     $trashed = Tender::onlyTrashed()->count();
        //     $view->with('trashed', $trashed);
        // });
    }
}
