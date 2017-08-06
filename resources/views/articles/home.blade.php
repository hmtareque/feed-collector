@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Welcome to JournoFeed Collector</h3>
    <div class="row">
        <div class="col-xs-12">
            @if($collections->count()>0)
                <div class="panel panel-default">
                    <div class="panel-heading">Today's Collection</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th class="text-center">Collected</th>
                                    <th class="text-center">No of Article</th>
                                    <th class="text-center">Actioned</th>
                                    <th class="text-center">Not Actioned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collections as $collection)
                                <tr>
                                    <td><a href="{{ url('collections/'.$collection->id.'/articles') }}">{{$collection->source}}</a></td>
                                    <td class="text-center">{{ date('d M Y', strtotime($collection->collected_at)) }}</td>
                                    <td class="text-center">{{ $collection->no_of_article }}</td>
                                    <td class="text-center">{{ $collection->no_actioned }}</td>
                                    <td class="text-center">{{ $collection->no_not_actioned }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            @else 
            <div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> No article collection found! 
                <a href="{{url('articles/collect')}}" class="alert-link">please collect article(s)</a>.
            </div>
            @endif 
        </div>
    </div>
</div>
@endsection






