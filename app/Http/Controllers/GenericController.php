<?php

namespace App\Http\Controllers;

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
}
