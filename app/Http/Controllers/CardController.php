<?php

namespace App\Http\Controllers;

use App\Board;
use App\Lists;
use Illuminate\Http\Request;

class CardController extends Controller
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
      public function index($boardID, $userID, $listID)
    {

        $board=Board::find($boardID);
        // return $board;

          if ($userID != $board->user_id) {

            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        $list = $board->lists()->find($listID);
        // $list = $board->lists()->get();
        if(is_null($list))
        {
            return "null";
        }
        else
        {
            return $list;
        }

        return response()->json(['cards'=>$list->cards]);
    }

    public function show ($boardID,$userID,$listID,$cardID)
    {
        $board=Board::find($boardID);

          if ($userID != $board->user_id)
           {

            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        
        $list = $board->lists()->find($listID);

        $card = $list->cards()->find($cardID);

        return response()->json(['status'=>'success','card'=>$card]);
    }


     public function store(Request $request, $boardID,$userID,$listID)
    {
        $this->validate($request,['name'=>'required']);

        $board=Board::find($boardID);

        if ($userID != $board->user_id) {

            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        $board->lists()->find($listID)->cards()->create([
            'name' => $request->name,
        ]);
        return response()->json(['message' => 'success'], '200');
    }


     public function update(Request $request, $boardID,$userID,$listID,$cardID)
    {
       
        $this->validate($request,['name'=>'required']);
        
        $board = Board::find($boardID);

        if ($userID != $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'unauthorized'], '401');
        }
        $card=$board->lists()->find($listID)->cards()->find($cardID);

        $card->update($request->all());
        return response()->json(['message' => 'success', 'card' => $card], '200');
    }

    public function destroy($boardID,$userID,$listID,$cardID)
    {
        $board=Board::find($boardID);
        if($userID != $board->user_id) {

            return response()->json(['status'=>'error','message'=>'unauthorized'],'401');
        }
        $card=$board->lists()->find($listID)->cards->find($cardID);

        if ($card->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Card Deleted Successfully']);
        }
        return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
    }
}
