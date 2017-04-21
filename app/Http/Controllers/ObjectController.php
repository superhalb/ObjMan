<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Object;
use App\Relation;

class ObjectController extends Controller
{
    private $path = 'object/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('object.create');
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
        $object = new Object;
        $object->name = $request->name; 
        $object->description = $request->description; 
        $object->type = $request->type;
        $object->save();

        return $object->id;
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
        $object = Object::where('id',$id)->first();
        $relations = Relation::where('from',$id)->get();
        $objectrelations = [];
        foreach($relations as $relation){
            $related = Object::where('id',$relation->to)->first();
            $objectrelations[] = array( 'id' => $relation->id , 'name' => $related->name );
        }
        $object->relations = $objectrelations;

        $relationsb = Relation::where('to',$id)->get();
        $objectrelationsb = [];
        foreach($relationsb as $relation){
            $related = Object::where('id',$relation->from)->first();
            $objectrelationsb[] = array( 'id' => $relation->id , 'name' => $related->name );
        }
        $object->relationsb = $objectrelationsb;

        return response()->json( $object );
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
        $object = Object::where('id',$id)->first();
        $relations = Relation::where('from',$id)->get();
        $objectrelations = [];
        foreach($relations as $relation){
            $related = Object::where('id',$relation->to)->first();
            $objectrelations[] = array( 'id' => $relation->id , 'name' => $related->name );
        }
        $object->relations = $objectrelations;

        $relationsb = Relation::where('to',$id)->get();
        $objectrelationsb = [];
        foreach($relationsb as $relation){
            $related = Object::where('id',$relation->from)->first();
            $objectrelationsb[] = array( 'id' => $relation->id , 'name' => $related->name );
        }
        $object->relationsb = $objectrelationsb;

        return view('object.edit')->with('object',$object);
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
        $object = Object::where('id',$id)->first();
        $object->name = $request->name; 
        $object->description = $request->description; 
        $object->type = $request->type;
        $object->save();

        return $object->id;
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
        Object::destroy( $id );
        Relation::where('to' , $id )->delete();
        Relation::where('from' , $id )->delete();
    }

    /**
     * Search for named like resources from storage.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        //
        $objects = Object::where('name','LIKE',"%$name%")->get(['id','name']);
        return response()->json( $objects );
    }

    /**
     * Create relation from one object to another.
     *
     * @param  string  $from
     * @param  string  $to
     * @return \Illuminate\Http\Response
     */
    public function link($from,$to)
    {
        //
        $relation = new Relation;
	$relation->from = $from;
        $relation->to = $to;
	$relation->save();
	
    }

    /**
     * Remove relation from one object to another.
     *
     * @param  int  $id (relation id)
     * @return \Illuminate\Http\Response
     */
    public function unlink($id)
    {
        //
        Relation::destroy( $id );	
    }

}
