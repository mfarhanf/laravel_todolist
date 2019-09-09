<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Todo;
use Illuminate\Http\Request;
use Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->get('userId');
        $todos = Todo::whereUserId($userId)->get();
        $deleteSelected = $todos->where('is_done', 1)->count() > 0 ? '' : 'disabled';

        return response()->json(['todos' => $todos->toArray(), 'deleteSelected' => $deleteSelected], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'todo' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json(['error' => $message], 422);
        }

        $todo = $request->get('todo');
        $userId = $request->get('userId');

        try {
            $result = Todo::create(['todo' => $todo, 'user_id' => $userId]);
            return response()->json(['success' => 'Data created successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
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
        $isChecked = $request->get('isChecked');

        try {
            $todo = Todo::find($id);
            $todo->is_done = ($isChecked === 'true') ? true : false;
            $todo->save();

            return response()->json(['success' => 'Data updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $todo = Todo::find($id);
            $todo->delete();

            return response()->json(['success' => 'Data deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelectedIds(Request $request, $id)
    {
        $ids = $request->get('ids');
        $userId = $request->get('userId');

        try {
            Todo::whereIn('id', $ids)->whereUserId($userId)->delete();
            return response()->json(['success' => 'Data deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
