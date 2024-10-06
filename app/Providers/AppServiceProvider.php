<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;

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
        Builder::macro('filterBy', function ($column,$value) {
            if ($value) {
                return $this->where($column, $value);
            }
            return $this;
        });

        Builder::macro('search', function ($field, $data) {
            return $data ? $this->where($field, 'like', "%$data%") : $this;
        });

        Builder::macro('orSearch', function ($field, $data) {
            return $data ? $this->orWhere($field, 'like', "%$data%") : $this;
        });

        Builder::macro('filterByDate', function ($dateFrom, $dateTo, $column='created_at') {
            if ($dateFrom && $dateTo) {
                return $this->whereBetween($column, [
                    Carbon::parse($dateFrom)->startOfDay(),
                    Carbon::parse($dateTo)->endOfDay()
                ]);
            }
            return $this;
        });

        Paginator::useBootstrapFive();
    }
}
