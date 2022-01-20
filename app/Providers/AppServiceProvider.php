<?php

namespace App\Providers;

use App\Models\Department;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();

        $departments = Department::get();

        //route('department-page', ['department' => 1, 'page' => 3]);

        /*$catalogMenu = ProductsCategory::whereParentId(0)->get();

        foreach ($catalogMenu as $key => $category) {

            $catalogMenu[$key]['url'] = ProductsCategory::getPageUrl($category->id);
//            echo "<pre>";
//            print_r($category);
//            echo "</pre>";

            foreach ($category->children as $k => $item) {
//                echo "<pre>";
//                print_r($category->children);
//                echo "</pre>";

                $catalogMenu[$key]['children'][$k]['url'] = ProductsCategory::getPageUrl($item->id);
            }
        }*/

        View::share(['departments' => $departments]);
    }
}
