<?php

namespace App\Http\Controllers;

use App\Board;

use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
      //
        
     }

    public  function index ($userID)
    {

      return Board::all()->where('user_id','=',$userID);
      // return Board::where('user_id','=',$userID)->get();
        // return "ho";
    }

    public function show ($boardID,$userID)
    {
        $board = Board::findOrFail($boardID);
         // return $board;
         if ($userID != $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        return response()->json(['board'=> $board],'200');
    }

    public function store(Request $request,$userID)
    {
       $this->validate($request,['name'=>'required']);

       $userID->boards()->create([

            'name'    => $request->name,
        ]);
        return response()->json(['message' => 'success'], '200');
    }

    public function update(Request $request,$boardID,$userID)
    {
        $this->validate($request,['name'=>'required']);
        $board = Board::find($boardID);
        if ($userID != $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        $board->update($request->all());
        return response()->json(['message' => 'success', 'board' => $board], '200');
    }

    public function destroy ($id,$userID)
    {
         $board=Board::find($id);
        if($userID != $board->user_id) {
            return response()->json(['status'=>'error','message'=>'unauthorized'],'401');
        }
        if (Board::destroy($id)) {
            return response()->json(['status' => 'success', 'message' => 'Board Deleted Successfully']);
        }
        return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
    }
}
  