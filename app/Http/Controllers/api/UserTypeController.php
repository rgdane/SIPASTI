<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTypeModel;

class UserTypeController extends Controller
{
    public function index(){
        return UserTypeModel::all();
    }
    public function store(Request $request){
        $user_type = UserTypeModel::create($request->all());
        return response()->json($user_type, 201);
    }
    public function show(UserTypeModel $user_type){
        return UserTypeModel::find($user_type);
    }
    public function update(Request $request, UserTypeModel $user_type){
        $user_type->update($request->all());
        return UserTypeModel::find($user_type);
    }
    public function destroy(UserTypeModel $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}