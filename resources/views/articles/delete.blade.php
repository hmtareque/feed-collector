@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Articles <small>Delete confirmation</small></h3>
    <div class="row">
        <div class="col-xs-12">
            @if($articles->count()>0)
            <form action="{{url('articles/delete')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <input type="hidden" name="_method" value="delete"/>
                <input type="hidden" name="return_path" value="{{URL::previous()}}"/>
                <div class="panel panel-default">
                    <div class="panel-heading">List of Articles</div>
                    <div class="panel-body">
                        <div class="alert alert-warning" role="alert">
                            <strong>Please confirm!</strong><br/> Are you sure to <span class="label label-danger">Delete</span> the following article(s)?
                        </div>
                        <ul>
                            @foreach ($articles as $article)
                            <li>
                                <input type="hidden" name="articles[]" value="{{$article->id}}"/>
                                <a href="{{ $article->url }}" target="_blank">{{ $article->headline }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </div>                                 
            </form>
            @else 
            <div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> No article(s) selected.
            </div>
            @endif 
        </div>
    </div>
</div>
@endsection
