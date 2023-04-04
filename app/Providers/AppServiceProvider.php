<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\Diegoz\MenuM;
use App\Models\Iprodha\Noc_Notificacion;
use Illuminate\Support\Facades\Auth;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));
       
        view()->composer('*',function($view) {
            $view->with('userMenu', Auth::user());
            $view->with('menus', MenuM::menus(1));
            if(Auth::user()){
                $notificaciones = Noc_Notificacion::where('idusuario', Auth::user()->id)->orderBy('fecha', 'desc')->get();
            }else{
                $notificaciones = [];
            }
            
            $view->with('notificaciones', $notificaciones);
            // $notificaciones = Noc_Notificacion::where('idusuario', Auth::user()->id)->first();
            // View::share('notificaciones', $notificaciones);
        });

        Blade::directive('money', function ($amount) {
            return "<?php echo '$' . number_format($amount, 2); ?>";
        });
    }
}
