@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>评论管理</h3></div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif

                        @foreach ($comments as $comment)
                            <div class="article">
                                <h4>文章：《{{ $comment->article->title }}》</h4>
                                <div class="content">
                                    <p>
                                        姓名：{{ $comment->nickname }}
                                    </p>
                                    <p>
                                        评论内容：<br>{{ $comment->content }}
                                    </p>
                                    <p>评论时间：{{ $comment->created_at }}</p>
                                </div>
                            </div>
                            <a href="{{ url('admin/comments/'.$comment->id.'/edit') }}" class="btn btn-success">查看</a>
                            <form action="{{ url('admin/comments/'.$comment->id) }}" method="POST" style="display: inline;">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger">删除</button>
                            </form>
                            <hr>
                        @endforeach
                            <!-- 分页  laravel自带的？  -->
                            <div class="pull-right paginate">
                                {{ $comments->links() }}
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection