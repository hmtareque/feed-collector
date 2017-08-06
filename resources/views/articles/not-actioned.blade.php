@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Articles <small>Marked as not "Actioned"</small></h3>
    <div class="row">
        <div class="col-xs-12">
            @if($articles->count()>0)
            <form action="{{url('articles/confirm')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <div class="panel panel-default">
                    <div class="panel-heading">List of Articles</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all-article"/></th>
                                        <th>Source</th>
                                        <th>Feed</th>
                                        <th class="text-center">Published</th>
                                        <th class="text-center">Collected</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $key => $article)
                                    <tr class="@if(old('articles.'.$key) == $article->id) info @endif">
                                        <td><input type="checkbox" class="select-article" name="articles[{{$key}}]" value="{{$article->id}}" @if(old('articles.'.$key) == $article->id) checked @endif/></td>
                                        <td>{{$article->source}}</td>
                                        <td><a href="{{ $article->url }}" target="_blank">@if(strlen($article->headline)>100) {{ substr($article->headline,0,97) }} ... @else {{$article->headline}} @endif</a></td>
                                        <td class="text-center">{{ date('d M Y', strtotime($article->published_at)) }}</td>
                                        <td class="text-center">{{ date('d M Y', strtotime($article->collected_at)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="{{ $errors->has('articles') ? ' has-error' : '' }}">
                            @if ($errors->has('articles'))
                            <span class="help-block">
                                {{ $errors->first('articles') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="form-group {{ $errors->has('action') ? ' has-error' : '' }}">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <select name="action" class="form-control">
                                        <option value=""> -- Please Select Action -- </option>
                                        <option value="mark" @if(old('action') == 'mark') selected @endif>Mark Actioned</option>
                                        <option value="delete" @if(old('action') == 'delete') selected @endif>Delete</option>
                                    </select>
                                    @if ($errors->has('action'))
                                    <span class="help-block">
                                        {{ $errors->first('action') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <button type="submit" class="btn btn-primary btn-sm">Proceed to Confirmation</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else 
            <div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> No article found to take action! 
                <a href="{{url('articles/collect')}}" class="alert-link">please collect articles</a>.
            </div>
            @endif 
        </div>
    </div>
</div>
@endsection






