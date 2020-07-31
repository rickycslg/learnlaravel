<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\QuniuServiceController;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    // 后台文章首页
    public function index()
    {
        $list = Article::orderBy('id', 'desc')->paginate(5);
        return view('admin/article/index')->withArticles($list);
    }

    // 后台添加文章页面
    public function create()
    {
        $qiniu = new QuniuServiceController();
        $token = $qiniu->getToken();
        return view('admin/article/create')->with('token', $token);
    }

    // 后台文章编辑页面
    public function edit($id, Request $request)
    {
        $qiniu = new QuniuServiceController();
        $token = $qiniu->getToken();
        return view('admin/article/edit')->withArticles(Article::find($id))->with('token', $token);
    }


    // 添加？
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255',
            'body' => 'required'
        ]);

        $article = new Article();
        $article->title = $request->get('title');
        $article->body = $request->get('body');
        if ($request->get('image')) {
            $article->image = $request->get('image');
        }
        $article->user_id = $request->user()->id;

        if ($article->save()) {
            return redirect('admin/articles');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }

    }

    // 编辑 ?
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles,title,' . $id . '|max:255',
            'body' => 'required',
        ]);
        $param = $request->all();       // 这个可以获取传的参数？

        $article = Article::find($id);
        $article->title = $request->get('title');
        $article->body = $request->get('body');
        $article->image = $request->get('image');
        if ($article->save()) {
            return redirect('admin/articles');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    // 删除文章
    public function destroy($id)
    {
        Article::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }


}
