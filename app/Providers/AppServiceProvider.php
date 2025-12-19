<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\Shipping;
use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Gloudemans\Shoppingcart\Facades\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        $country = Country::where('code', 'BD')->first();
        $states = explode(',', $country->states);
        view()->composer('*', function ($view) use ($states) {
            $view->with('cartCount', Cart::count());
            $view->with('cartContent', Cart::content());
            $view->with('cartSubtotal', Cart::subtotal());
            $view->with('siteSettings', SiteSetting::where('id', 1)->first());
            $view->with('countries', Country::where('status', 1)->get());
            $view->with('shipping_methods', Shipping::all());
            $view->with('payment_methods', PaymentMethod::where('status', 1)->get());
            $view->with('states', $states);
        });
    }
}
