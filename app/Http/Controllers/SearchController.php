<?php

namespace App\Http\Controllers;

class SearchController extends Controller
{
    public function getByQuery()
    {
        $query = urlencode($_GET['query']);
        $curl = curl_init("https://www.sima-land.ru/api/v3/item/?page_type=search&q=$query");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'x-api-key: 8de4c439f49586e3ac53a134cb0e15dd61825b1c0dba9d55b86087b28d4e4b799c6e1ecfc213f16b47b723f7e71157d71bdf909f1959c7e01b02d296f548ef20'));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $jsonObject = json_decode(curl_exec($curl));
        return view('search',
            [
                'market' => 'sima',
                'items' => $jsonObject->items,
            ]);
    }
}
