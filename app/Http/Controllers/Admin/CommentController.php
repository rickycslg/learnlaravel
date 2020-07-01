<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    //  评论列表首页
    public function index()
    {
        $list = Comment::orderBy('id', 'desc')->paginate(3);        // 倒序  获取所有
//        $list = Comment::all();
        return view('admin/comment/index')->withComments($list);
    }


    // 删除评论
    public function destroy($id)
    {
        Comment::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }

    // 评论查看/编辑页
    public function edit($id)
    {
        return view('admin/comment/edit')->withComment(Comment::find($id));
    }

    // 编辑
    public function update(Request $request, $id)
    {
        $param = $request->all();
        $comment = Comment::find($id);

        $comment->nickname = $param['nickname'];
        $comment->email = $param['email'];
        $comment->website = $param['website'];
        $comment->content = $param['content'];

        if ($comment->save()) {

        } else {

        }

    }

}
