@extends('template.layout')

@section('resources')


@stop



@section('content')

<div class="no-result">
    <img src = '/booking/img/no_more.png'>

    <div>

    <div class="more-option">
        <a href="/"  class="option"><div>
            带我回首页
        </div></a>

        <a href="/destinationList" class="option"><div >
            热门目的地
        </div></a>

        <a href="http://gbhchina.com/newArticles" class="option"><div >
            酒店体验
        </div></a>
    </div>
</div>




@stop




@section('script')

    <script >

        $(document).ready(function(){


        })

    </script>
@stop