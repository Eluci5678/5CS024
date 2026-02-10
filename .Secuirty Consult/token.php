use Illuminate\Http\Request;	

Route::get('/token',function(Request $request){
	$token = $request->session()->token();
	
	$token 	= csrf_token();
	
}