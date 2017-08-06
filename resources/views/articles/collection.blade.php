@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Articles <small>Marked as "Actioned"</small></h3>
    <div class="row">
        <div class="col-xs-12">
            @if($articles->count()>0)
          <div class="panel panel-default">
                    <div class="panel-heading">List of Articles</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th>Headline</th>
                                    <th class="text-center">Published</th>
                                    <th class="text-center">Collected</th>
                                    <th class="text-center">Actioned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                <tr class="@if($article->actioned == 1) success @endif">
                                    <td>{{$article->source}}</td>
                                    <td><a href="{{ $article->url }}" target="_blank">@if(strlen($article->headline)>100) {{ substr($article->headline,0,97) }} ... @else {{$article->headline}} @endif</a></td>
                                    <td class="text-center">{{ date('d M Y', strtotime($article->published_at)) }}</td>
                                    <td class="text-center">{{ date('d M Y', strtotime($article->collected_at)) }}</td>
                                    <td class="text-center">
                                        @if($article->actioned == 1) 
                                        <label class="label label-success">Yes</label>
                                        @else 
                                        <label class="label label-danger">No</label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div> 
                </div>
            @else 
            <div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> No article found! 
                <a href="{{url('articles/collect')}}" class="alert-link">please collect article(s)</a>.
            </div>
            @endif 
        </div>
    </div>
</div>
@endsection






