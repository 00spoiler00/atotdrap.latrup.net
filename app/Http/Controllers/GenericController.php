<?php

namespace App\Http\Controllers;

use App\Http\Resources\Dashboard\Dashboard;
use App\Http\Resources\Selector;

class GenericController extends Controller
{
    /**
     * Display the specified resource card.
     */
    public function card(string $modelName, int $id)
    {
        $model = 'App\\Models\\' . ucfirst($modelName);
        $model = new $model();
        $model = $model->findOrFail($id);

        // Create the dynamic resource class name
        $resource = 'App\\Http\\Resources\\Cards\\' . ucfirst($modelName);

        // Return the resource
        return new $resource($model);
    }

    /**
     * Display the specified resource card.
     */
    public function selector(string $modelName)
    {
        $model  = 'App\\Models\\' . ucfirst($modelName);
        $models = $model::all();

        // Return the resource
        return Selector::collection($models);
    }

    /**
     * The dashboard resource.
     */
    public function dashboard()
    {
        return new Dashboard([]);
    }
}
