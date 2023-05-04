<?php

namespace App\Http\Controllers;

use App\Models\Kangaroo;
use Illuminate\Http\Request;

class KangarooController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kangaroos.index');
    }


    /**
     * Show a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $kangaroos = Kangaroo::orderBy('created_at', 'desc')->get();

        return response()->json($kangaroos);
    }

    /**
     * Validate name, must be unique
     *
     * @return \Illuminate\Http\Response
     */
    public function validateName(Request $request)
    {   
        $kangaroo = Kangaroo::where('name', $request->name);
        if ($request->has('id')) {
            $kangaroo->where('id', '!=', (int)$request->id);
        }
        
        $kangaroo = $kangaroo->first();
        
        if ($kangaroo) {
            return response()->json(['status' => 1]);
        }
        
        return response()->json(['status' => 0]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kangaroos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name'     => 'required|unique:kangaroos,name',
            'weight'   => 'required|numeric|min:0',
            'height'   => 'required|numeric|min:0',
            'gender'   => 'required|in:0,1',
            'birthday' => 'required|date',
        ]);

        $kangaroo               = new Kangaroo();
        $kangaroo->name         = $validated_data['name'];
        $kangaroo->nickname     = $request->input('nickname');
        $kangaroo->weight       = $validated_data['weight'];
        $kangaroo->height       = $validated_data['height'];
        $kangaroo->gender       = $validated_data['gender'];
        $kangaroo->color        = $request->input('color');
        $kangaroo->friendliness = $request->input('friendliness');
        $kangaroo->birthday     = $validated_data['birthday'];
        $kangaroo->save();

        if (!$kangaroo) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kangaroo  $kangaroo
     * @return \Illuminate\Http\Response
     */
    // public function show(Kangaroo $kangaroo)
    // {
    //     return view('kangaroos.show');
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kangaroo  $kangaroo
     * @return \Illuminate\Http\Response
     */
    public function edit(Kangaroo $kangaroo)
    {
        return view('kangaroos.edit', compact('kangaroo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kangaroo  $kangaroo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kangaroo $kangaroo)
    {
        $validated_data = $request->validate([
            'name'     => 'required|unique:kangaroos,name,'.$kangaroo->id,
            'weight'   => 'required|numeric|min:0',
            'height'   => 'required|numeric|min:0',
            'gender'   => 'required|in:0,1',
            'birthday' => 'required|date',
        ]);

        $kangaroo->name         = $validated_data['name'];
        $kangaroo->nickname     = $request->input('nickname');
        $kangaroo->weight       = $validated_data['weight'];
        $kangaroo->height       = $validated_data['height'];
        $kangaroo->gender       = $validated_data['gender'];
        $kangaroo->color        = $request->input('color');
        $kangaroo->friendliness = $request->input('friendliness');
        $kangaroo->birthday     = $validated_data['birthday'];
        $kangaroo->save();

        if (!$kangaroo) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kangaroo  $kangaroo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kangaroo $kangaroo)
    {
        $kangaroo->delete();

        if (!$kangaroo) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }
}
