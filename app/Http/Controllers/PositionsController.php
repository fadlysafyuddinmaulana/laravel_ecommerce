<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Positions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Positions = Position::all();

        return response()->json([
            'success' => true,
            'data' => $Positions,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'is_active'   => 'boolean',
        ]);

        $position = Position::create($data);

        return response()->json([
            'success' => true,
            'data'    => $position,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'success' => true,
            'data'    => Position::findOrFail($id),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'is_active'   => 'boolean',
        ]);

        $Positions->update($data);

        return response()->json([
            'success' => true,
            'data'    => $Positions,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return response()->json([
            'success' => true,
            'message' => 'Position deleted successfully.',
        ], Response::HTTP_OK);
    }
}