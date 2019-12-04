<?php

namespace App\Http\Controllers\Bread;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bread\Attribute;
use App\Models\Bread\Relationship;
use App\Models\Bread\Table;
use App\Http\Controllers\Bread\RelationshipController;
use App\Traits\Bread\AttributesProcess;

class BreadController extends Controller
{
    use AttributesProcess;

    private $table, $model, $arrTableWhere = [], $arrTableAttributes = [];

    public function __construct()
    {
        $this->table = new Table;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $intTableId)
    {
        // Get a Table instance
        $this->table = $this->table
            ->with(['attributes', 'relationships.attributes'])
            ->find($intTableId);

        // Remove relationships which doesn't havy any attributes
        $this->table->relationships = $this->table->relationships->filter(function($value, $key){
            return $value->attributes->count() > 0;
        });

        // 404 if a table instance not found
        if(empty($this->table)){
            return abort(404, 'Not Found');
        }

        // Generate Model object of associated Table.
        $this->model = (new $this->table->model);

        $this->applyListing($request, $this->table->attributes, $this->arrTableAttributes, $this->arrTableWhere);

        // dd([$this->arrTableAttributes, $this->arrTableWhere]);
        // Process Table's attributes
        // foreach ($this->table->attributes as $attribute) {
        //     // Add in listing array if listing flag is set
        //     if($attribute->listing){
        //         array_push($this->arrTableAttributes, $attribute->name);
        //     }
        //     // Apply search on a model instance if search flag is set
        //     if($attribute->search){
        //         $this->applySearch($request, $attribute);
        //     }
        // }
        // Initialize relationship controller
        $objRelationshipController =  new RelationshipController($request, $this->model);
        // Process relationship attributes.
        // foreach($this->table->relationships as $relationship){
        //    $objRelationshipController->handle($relationship);
        // }
        // Apply relationship
        $this->model = $objRelationshipController->applyRelationships($this->table->relationships);
        // foreach ($this->table->relationships as $relationship) {
        //     $this->model = $objRelationshipController->applyRelationship($relationship);
        // }

        $this->arrTableAttributes = array_unique(array_merge($this->arrTableAttributes, $objRelationshipController->getModelAttributes()));
        
        return $this->model
            ->select($this->arrTableAttributes)
            ->when($this->arrTableWhere, function($query, $arrWhere){
                return $query->where($arrWhere);
            })
            ->paginate(10);
        // dd($objRelationshipController->getRelationsAttributes());
        dd($this->model);

    }

    /**
     * Apply search on a model object.
     *
     * @return void
     */
    // private function applySearch(Request $request,Attribute $attribute){
    //     $this->model->when($request->{$attribute->name}, function($query, $strSearchValue) use($attribute){
    //         return $query->where($attribute->name, $strSearchValue);
    //     });
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
