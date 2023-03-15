<?php

namespace App\Http\Controllers\Common;

use App\Abstracts\Http\Controller;
use App\Models\Common\CatalogPurchase;
use Illuminate\Http\Request;

class CatalogPurchaseController extends Controller
{
    public function search(Request $request, string $type = null)
    {
        $query = $request->all()['q'] ?? '';
        $result = CatalogPurchase::when(!empty($query), function ($q) use ($query) {
            $searchWildcard = '%' . $query . '%';
            $q->where('name', 'iLIKE', $searchWildcard);
        })->when($type, function ($q) use ($type) {
            $q->where('type', $type);
        })->limit(20);

        return $result->get()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->name];
        });
    }
}
