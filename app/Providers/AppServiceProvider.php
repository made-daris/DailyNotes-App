<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Memo;
use App\Tag;
use Illuminate\Routing\UrlGenerator;
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
    public function boot(UrlGenerator $url)
    {
        // 全てのメソッドが呼ばれる前に先に呼ばれるメソッド
        view()->composer('*', function ($view) {
            // get the current user
            $user = \Auth::user();
             // インスタンス化
            $memoModel = new Memo();
            $memos = $memoModel->myMemo( \Auth::id() );
            
            // タグに取得
             $tagModel = new Tag();
             $tags = $tagModel->where('user_id', \Auth::id())->get();
            
            $view->with('user', $user)->with('memos', $memos)->with('tags', $tags);

            if (env('APP_ENV') == 'production') {
                $url->forceScheme('https');
            }
        });
    }

    // public function boot(UrlGenerator $url)
    // {
    //     if (env('APP_ENV') == 'production') {
    //         $url->forceScheme('https');
    //     }
    // }
}
