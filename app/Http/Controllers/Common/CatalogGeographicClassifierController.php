<?php

namespace App\Http\Controllers\Common;

use App\Abstracts\Http\Controller;
use App\Models\Common\CatalogGeographicClassifier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogGeographicClassifierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('modules.budget.catalogs.budget-classifier-geographic');
    }

    public function search(Request $request, string $type = null)
    {
        $query = $request->all()['q'] ?? '';
        $result = CatalogGeographicClassifier::when(!empty($query), function ($q) use ($query) {
            $searchWildcard = '%' . $query . '%';
            $q->where('description', 'iLIKE', $searchWildcard);
        })->when($type, function ($q) use ($type) {
            $q->where('type', $type);
        })->limit(20);

        if ($type == CatalogGeographicClassifier::TYPE_PARISH) {
            $result->with('parent.parent');
        } else {
            $result->with('parent');
        }

        return $result->get()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->getPath()];
        });
    }
}
