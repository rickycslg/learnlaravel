@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑一篇文章</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>编辑失败</strong> 输入不符合要求<br><br>
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif

                        <form action="{{ url('admin/articles/' . $articles->id) }}" method="POST">
                            {{ method_field('PATCH') }}
                            {!! csrf_field() !!}
                            <input type="text" name="title" class="form-control" value="{{$articles->title}}" required="required" placeholder="请输入标题">
                            <input type="hidden" name="image" id="hideimage" value="{{$articles->image}}">
                            <br>
                            文章封面图：
                            <input type="file" id="qiqiuupload" class="form-control-static">
                            <div id="upload2" class="btn-info col-md-1" onclick="clicktest()">上传</div>
                            <div class="showimg" style="display: block;margin-top: 40px">
                                @if(!empty($articles['image']))
                                    <img src="http://{{$articles->image}}" width='200' />
                                @endif
                            </div>
                            <br><br>
                            <textarea name="body" rows="10" class="form-control" required="required" placeholder="请输入内容">{{$articles->body}}</textarea>
                            <br>
                            <button class="btn btn-lg btn-info">编辑文章</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/layer/3.1.1/layer.js"></script>
<script>
    function clicktest()
    {
        // var kk = $("#qiqiuupload").val();
        var img = document.getElementById("qiqiuupload").files[0];
        if (!img) {
            layer.alert('请选择图片');
            return;
        }

        var form = new FormData();
        form.append("file",img);
        form.append("_token",'{{csrf_token()}}');
        form.append("token",'{{ $token }}');
        $.ajax({
            url: '/uploadqiniu',
            data: form,
            type: "POST",
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#hideimage").val(data);
                var http = "";
                $(".showimg").empty();
                http = "<img src=http://" + data + " width='200' />";
                $(".showimg").append(http);

            },
            error: function (data) {
                layer.alert("上传失败!");
            }
        });
    }

</script>