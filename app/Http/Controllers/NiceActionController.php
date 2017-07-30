<?php
namespace App\Http\Controllers;
 
 use App\NiceAction;
 use App\NiceActionLog;
 use \Illuminate\Http\Request;
 use DB;
 
 class NiceActionController extends Controller
 {


    public function getHome(){
      $actions =NiceAction::all();
      // $actions =NiceAction::orderBy('niceness','desc')->get();
      // $query=DB::table('nice_action_logs')
      //       ->join('nice_actions','nice_action_logs.nice_action_id', '=','nice_actions.id')
      //       ->get();
      // $query=DB::table('nice_action_logs')
      //       ->join('nice_actions','nice_action_logs.nice_action_id', '=','nice_actions.id')
      //       ->where('nice_actions.name', '=', 'Kiss')
      //       ->get();
      // $query=DB::table('nice_action_logs')
            // ->where('id','>','3')
            // ->count();
      // ->max('id');
      $logged_actions =NiceActionLog::paginate(5);
      // $logged_actions = NiceActionLog::whereHas('nice_action', function($query){
      //   $query->where('name', '=', 'Kiss')->orWhere('name', '=', 'Smile');
      // })->get();

      //add item to the table when we click on any of the items
      // $nice_action =NiceAction::where('name','Hug')->first();
      // $nice_action_log =new NiceActionLog();
      // $nice_action->logged_actions()->save($nice_action_log);

      // $query=DB::table('nice_action_logs')
      //       ->insertGetId([
      //         'nice_action_id'=>DB::table('nice_actions')->select('id')->where('name', 'Hug')->first()->id

      //         ]);
       // $query ="";
      //       $hug =NiceAction::where('name','Hug')->first();
      //       if($hug){
      //       $hug->name ="Smile";
      //       $hug->update();
      //       }
            // $wave =NiceAction::where('name','Wave')->first();
            // if($wave){
            // $wave->delete();
            // }
      // return view('home', ['actions'=>$actions,'logged_actions'=>$logged_actions,'db'=>$query]);
       return view('home', ['actions'=>$actions,'logged_actions'=>$logged_actions]);
    }
     public function getNiceAction($action, $name=null)
     {
      if($name === null){
        $name ='you';
      }
      $nice_action =NiceAction::where('name',$action)->first();
      $nice_action_log =new NiceActionLog();
      $nice_action->logged_actions()->save($nice_action_log);

         return view('actions.nice', ['action'=>$action,'name'=> $name]);
     }
     
     public function postInsertNiceAction(Request $request)
     {
         $this->validate($request,[
          'name' =>'required|alpha|unique:nice_actions',
          'niceness' =>'required|numeric'
          ]);
         $action =new NiceAction();
         $action->name = ucfirst(strtolower($request['name']));
         $action->niceness =$request['niceness'];
         $action->save(); 

         $actions =NiceAction::all();
              //  return view('home', ['actions'=>$actions]); //stays on /add_action route to avoid adding the item twice or more
         if($request->ajax()){
          return response()->json();
         }
          return redirect()->route('home', ['actions' =>$actions]);
         
     }

     private function transformName($name){
         $prefix ='KING ';
         return $prefix. strtoupper($name);
     }
 }
 
 
 