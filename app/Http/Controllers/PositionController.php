<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function getPosition()
    {
        $position = Position::paginate(10);

        $position->getCollection()->transform(function ($pos) {
            $pos->encrypted_id = encrypt($pos->id);
            return $pos;
        });

        return response()->json($position);
    }

    public function storePosition(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:position,name',
        ]);

        $position = new Position();
        $position->created_by = Auth::user()->id;
        $position->name = $request->name;
        $position->save();

        return response()->json(['message' => 'Position added successfully.'], 200);
    }

    public function editPosition($id)
    {
        $decryptID = decrypt($id);
        $position = Position::find($decryptID);
        return response()->json($position);
    }

    public function updatePosition(Request $request, $id)
    {
        $decryptID = decrypt($id);
        $position = Position::findOrFail($decryptID);

        $validatedData = $request->validate([
            'name' => 'required|string|unique:position,name,' . $position->id,
        ]);

        $position->name = $request->name;
        $position->save();

        return response()->json(['message' => 'Position updated successfully']);
    }

    public function deletePosition($id)
    {
        $decryptID = decrypt($id);

        DB::beginTransaction();

        try {
            $position = Position::findOrFail($decryptID);
            $position->delete();
            DB::commit();
            return response()->json(['message' => 'Position deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete position.'], 500);
        }
    }
}
