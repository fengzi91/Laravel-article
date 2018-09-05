<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'generator']]);
    }

    public function show(User $user)
    {
      
      return view('users.show', compact('user'));
    }

    public function editavatar(User $user)
    {
      $this->authorize('update', $user);
      return view('users.editavatar', compact('user'));
    }

    public function edit(User $user)
    {
      $this->authorize('update', $user);
      return view('users.edit', compact('user'));
    }
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 240);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
    // 生成一个默认的头像
    public function generator(User $user) 
    {
        $identicon = new \Identicon\Identicon();
        $avatar = $identicon->displayImage($user->email);
        return response($avatar, 200)
              ->header('Content-Type', 'image/png');
    }
}
