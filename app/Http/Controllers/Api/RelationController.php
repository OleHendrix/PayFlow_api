<?php

namespace App\Http\Controllers\Api;

use App\Models\Relation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\CanLoadRelationship;
use App\Http\Resources\RelationResource;

class RelationController extends Controller
{
    use CanLoadRelationship;

    protected $relations = ['user'];

    public function index()
    {
        $query = $this->loadRelationships(Relation::query());
        return RelationResource::collection($query->paginate());
    }


    public function store(Request $request)
    {
      $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'name' => 'required|string|max:255',
        'email' => 'email|unique:relations',
        'country' => 'string|max:255',
        'city' => 'string|max:255',
        'state_province' => 'string|max:255',
        'address' => 'string|max:255',
        'zip' => 'string|max:255',
        'phone' => 'string|max:255',
        'IBAN' => 'string|max:255',
        'BIC' => 'string|max:255',
        'VAT number' => 'string|max:255',
      ]);

      $relation = Relation::create($validated);
      return new RelationResource($this->loadRelationships($relation));
        
    }

    public function show(Relation $relation)
    {
        return new RelationResource($this->loadRelationships($relation));
    }


    public function update(Request $request, Relation $relation)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:relations',
            'country' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'state_province' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'zip' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:255',
            'IBAN' => 'sometimes|string|max:255',
            'BIC' => 'sometimes|string|max:255',
            'VAT number' => 'sometimes|string|max:255',
        ]);

        $relation->update($validated);
        return new RelationResource($this->loadRelationships($relation));
    }

    public function destroy(Relation $relation)
    {
        $relation->delete();
        return response()->json(['message' => 'Relation deleted successfully']);
    }
}
