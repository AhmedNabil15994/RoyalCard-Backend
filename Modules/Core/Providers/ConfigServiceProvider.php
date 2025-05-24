<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Area\Entities\Country;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setSettingConfigurations();
        $this->setApiSettingConfigurations();
        $this->setLocalesConfigurations();
    }

    public function boot()
    {

    }

    private function setLocalesConfigurations()
    {
        $defaultLocale = setting('default_locale') ? setting('default_locale') : 'en';
        $locales = setting('locales') ? setting('locales') : ['en'];
        $rtlLocales = setting('rtl_locales') ? setting('rtl_locales') : ['ar'];

        $this->app->config->set([
            'app.locale' => $defaultLocale,
            'app.fallback_locale' => $defaultLocale,
            'laravellocalization.supportedLocales' => $this->supportedLocales($locales),
            'laravellocalization.useAcceptLanguageHeader' => true,
            'laravellocalization.hideDefaultLocaleInURL' => false,
            'default_locale' => $defaultLocale,
            'rtl_locales' => $rtlLocales,
            'translatable.locales' => $locales,
            'translatable.locale' => $defaultLocale,
        ]);

    }


    private function setApiSettingConfigurations()
    {
        $supported_countries = [];
        if(setting('supported_countries')){
            $countries = Country::whereIn('id',setting('supported_countries'))->get();
            foreach ($countries as $country){
                $supported_countries[]= [
                    'id'    => $country->id,
                    'title' => $country->title,
                    'currency'  => $country->currency?->code,
                    'flag'  => $country->emoji,
                    'tax_rate'  => isset(setting('taxes_rates')[$country->id]) ? (int) setting('taxes_rates')[$country->id] : 0,
                    'calling_code' => $country->phone_code,
                ];
            }
        }
        $this->app->config->set([
            'api_setting' => [
                'social_media' => setting('social'),
                'contact_us' => setting('contact_us'),
                'other' => setting('other'),
                'supported_countries'   => $supported_countries ?  : [],
                'default_country'  => setting('default_country'),
                'supported_currencies'   => setting('supported_currencies'),
                'default_currency'  => setting('default_currency'),
            ]
        ]);
    }

    private function setSettingConfigurations()
    {
        $this->app->config->set([
            'app.name' => setting('app_name', locale()),
        ]);
    }

    private function supportedLocales($locales)
    {
        return array_intersect_key(config('core.available-locales'), array_flip($locales));
    }
}
