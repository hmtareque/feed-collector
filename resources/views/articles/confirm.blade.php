@extends('layouts.app')

@section('content')
<div class="container">
         
  <h3>Example page header <small>Subtext for header</small></h3>

    <div class="row">
        <div class="col-xs-12">
            <form action="{{url('articles/mark-actioned')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <input type="hidden" name="_method" value="put"/>
            <div class="panel panel-default">
                <div class="panel-heading">List of Articles</div>
                <div class="panel-body">
                    
                    
                    <p>Please confirm you want to mark the following article(s) as Actioned.</p>
                    
                    <ul>
                        @foreach ($articles as $article)
                        <li>
                            <input type="text" name="articles[]" value="{{$article->id}}"/>
                            <a href="{{ $article->url }}" target="_blank">{{ $article->headline }}</a>
                        </li>
                        @endforeach
                    </ul>
                    
                    
                </div>
                <div class="panel-footer">
                    
                   <button type="submit" class="btn btn-primary btn-sm">Proceed</button>
                    
                </div>
            </div>
                                                            
            </form>
        </div>
    </div>
    @endsection
