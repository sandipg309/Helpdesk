<?php

namespace App\Http\Controllers;

use App\Board;
use App\Lists;
use Illuminate\Http\Request;

class ListController extends Controller
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
      public function index($boardID,$userID)
    {
        $board = Board::find($boardID);
         // return $board;

        if ($userID != $board->user_id){

            return response()->json(['status'=>'error','message'=>'unauthorize'], '401');

        }
        return response()->json(['lists'=>$board->lists]);
        // return $user;
    }

    public function show ($boardID,$userID,$listID)
    {
        $board=Board::find($boardID);

          if ($userID!= $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        $list = $board->lists()->find($listID);
        return response()->json(['status'=>'success','list'=>$list]);
    }


     public function store(Request $request,$boardID,$userID)
    {
        $this->validate($request,['name'=>'required']);

        $board=Board::find($boardID);

        if ( $userID != $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        $board->lists()->create([
            'name' => $request->name,
        ]);
        return response()->json(['message' => 'success'], '200');
    }


     public function update(Request $request, $boardID,$listID, $userID)
    {
        $this->validate($request,['name'=>'required']);
        $board = Board::find($boardID);

        if ($userID != $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        $board->update($request->all());
        return response()->json(['message' => 'success', 'board' => $board], '200');
    }

    public function destroy($boardID,$userID, $listID)
    {
        $board=Board::find($boardID);

        if($userID != $board->user_id) {

            return response()->json(['status'=>'error','message'=>'unauthorized'], '401');
        }

        $list=$board->lists()->find($listID);

        if ($list->delete()) {
            
            return response()->json(['status' => 'success', 'message' => 'List Deleted Successfully']);
        }
        return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
    }
}
