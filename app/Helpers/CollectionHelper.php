<?php


namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

/**
 * Class CollectionHelper
 * Laravel supports eloquent model pagination out of the box, but not custom collection.
 * This helper provides an easy way to paginate any collections.
 *
 * @see https://sam-ngu.medium.com/laravel-how-to-paginate-collection-8cb4b281bc55
 *
 * @package App\Helpers
 */
class CollectionHelper
{
    /**
     * Resolve current page number in the query metadata.
     *
     * @param  Collection  $results
     * @param int $pageSize
     * @return LengthAwarePaginator
     */
    public static function paginate(Collection $results, int $pageSize): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage('page');
        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return LengthAwarePaginator
     */
    protected static function paginator($items, int $total, int $perPage, int $currentPage, array $options): LengthAwarePaginator
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
