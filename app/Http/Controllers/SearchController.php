<?php

namespace App\Http\Controllers;

use App\Models\service\CommonSearchService;

/**
 * Контроллер поиска товаров по текстовому запросу.
 */
class SearchController extends Controller
{
    /**
     * Получить список товаров со всех маркетплейсов по текстовому запросу.
     */
    public function getByQuery()
    {
        $query = urlencode($_GET['query']);

        $commonSearch = new CommonSearchService();
        $marketplacesResults = $commonSearch->search($query);

        return view('search',
            [
                'marketplacesResults' => $marketplacesResults,
            ]);
    }
}
