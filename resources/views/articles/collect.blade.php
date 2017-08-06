@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Collect Articles</h3>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Collect Articles From Different Sources</div>
                <div class="panel-body">
                    <div class="row">
                        
                        
                        <div class="col-xs-12 col-md-5">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Collect from known news feed</h3>
                                </div>
                                <div class="panel-body">

                                    @if($errors->has('known_source') || $errors->has('known_rss_url')) 
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Error!</strong> Invalid request provided. <br/>{{$errors->first()}}
                                    </div>
                                    @endif 

                                    <table class="table table-bordered table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th width="80%">Article</th>
                                                <th width="20%">Collect</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Metro News Articles</td>
                                                <td>
                                                    <!-- Metro news article collect trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#metro-article-collector">
                                                        collect
                                                    </button>
                                                    <!-- Metro news article collect modal -->
                                                    <div class="modal fade" id="metro-article-collector" tabindex="-1" role="dialog">
                                                        <form action="{{url('articles/known/collect')}}" method="post">
                                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                            <input type="hidden" name="known_source" value="Metro"/>
                                                            <input type="hidden" name="known_rss_url" value="http://metro.co.uk/feed"/>
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Collect Metro News</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure to collect today's <strong>Metro News</strong> articles?</p>
                                                                        <p>RSS URL: <a href="http://metro.co.uk/feed" target="_blank">http://metro.co.uk/feed</a></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary btn-sm">Yes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>Reuters News Article</td>
                                                <td>
                                                    <!-- Reuters news article collect trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#reuters-article-collector">
                                                        collect
                                                    </button>
                                                    <!-- Reuters news article collect modal -->
                                                    <div class="modal fade" id="reuters-article-collector" tabindex="-1" role="dialog">
                                                        <form action="{{url('articles/known/collect')}}" method="post">
                                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                            <input type="hidden" name="known_source" value="Reuters"/>
                                                            <input type="hidden" name="known_rss_url" value="http://feeds.reuters.com/Reuters/worldNews"/>
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Collect Reuters News</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure to collect today's <strong>Reuters News</strong> articles?</p>
                                                                        <p>RSS URL: <a href="http://feeds.reuters.com/Reuters/worldNews" target="_blank">http://feeds.reuters.com/Reuters/worldNews</a></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary btn-sm">Yes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>CBN News Article</td>
                                                <td>
                                                    <!-- CBN news article collect trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#cbn-article-collector">
                                                        collect
                                                    </button>
                                                    <!-- CBN news article collect modal -->
                                                    <div class="modal fade" id="cbn-article-collector" tabindex="-1" role="dialog">
                                                        <form action="{{url('articles/known/collect')}}" method="post">
                                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                            <input type="hidden" name="known_source" value="CBN"/>
                                                            <input type="hidden" name="known_rss_url" value="http://www.cbn.com/cbnnews/world/feed"/>
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Collect CBN News</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure to collect today's <strong>CBN News</strong> articles?</p>
                                                                        <p>RSS URL: <a href="http://www.cbn.com/cbnnews/world/feed" target="_blank">http://www.cbn.com/cbnnews/world/feed</a></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary btn-sm">Yes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Google News Article</td>
                                                <td>
                                                    <!-- Google news article collect trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#google-article-collector">
                                                        collect
                                                    </button>
                                                    <!-- Google news article collect modal -->
                                                    <div class="modal fade" id="google-article-collector" tabindex="-1" role="dialog">
                                                        <form action="{{url('articles/known/collect')}}" method="post">
                                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                            <input type="hidden" name="known_source" value="Google"/>
                                                            <input type="hidden" name="known_rss_url" value="https://news.google.com/news"/>
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Collect Google News</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure to collect today's <strong>Google News</strong> articles?</p>
                                                                        <p>RSS URL: <a href="https://news.google.com/news" target="_blank">https://news.google.com/news</a></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary btn-sm">Yes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-xs-12 col-md-7">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Collect Articles</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" action="{{url('articles/collect')}}" method="post">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                        <div class="form-group {{ $errors->has('source') ? ' has-error' : '' }}">
                                            <label for="source" class="col-sm-3 control-label">Article Source</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="source" class="form-control" id="inputEmail3" placeholder="Source" value="{{old('source')}}">
                                                <small class="text-muted">Example: Yahoo</small>
                                                @if ($errors->has('source'))
                                                <span class="help-block">
                                                    {{ $errors->first('source') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('rss_url') ? ' has-error' : '' }}">
                                            <label for="rss_url" class="col-sm-3 control-label">RSS URL</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rss_url" class="form-control" placeholder="RSS URL" value="{{old('rss_url')}}">
                                                <small class="text-muted">Example: https://www.yahoo.com/news/rss</small>
                                                @if ($errors->has('rss_url'))
                                                <span class="help-block">
                                                    {{ $errors->first('rss_url') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary btn-sm">Collect</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
