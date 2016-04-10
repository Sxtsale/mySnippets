@extends('welcome')

@section('head')
    @parent
    <title>{!! $title !!}</title>

    <style>
        .name_input{
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: #f8f8f8;
            border-color: #e7e7e7;

            padding: 5px;;
        }

        .name_input input{
            width: 100% !important;
        }

        .form-group{
            width: 100% !important;
        }
    </style>
@show
@section('content')

    @if (session('warning'))
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-alert"></span>
            <strong> {{ session('warning') }}</strong>
        </div>
    @endif

    <nav class="name_input">
        <div class="row">
            <div class="col-lg-9">
                @foreach($last_snippets as $last_snippet)
                    <div class="col-lg-3" align="center">
                        <b style="height: 30px;">< ></b><a href="/mySnippet/{!! $last_snippet->snippet_id !!}">{!! $last_snippet->extension !!}</a>
                        <br />
                        <a href="/mySnippet/{!! $last_snippet->snippet_id !!}">{!! $last_snippet->name !!}</a>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-3" align="right" style="line-height: 34px; ">
                <a href="/">Show all of your snippets</a>
            </div>
        </div>
    </nav>
    <br />
    <div class="row">
        <form class="navbar-form" role="search" name=form1 id=form1 action="/store-snippet">
            <nav class="name_input">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="Snippet name" name="name" value="{!! old('name') !!}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </nav>

            <br />

            <nav class="name_input">
                <div class="form-group{{ $errors->has('extension') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="Filename including extension..." name="extension" value="{!! old('extension') !!}">

                    @if ($errors->has('extension'))
                        <span class="help-block">
                            <strong>{{ $errors->first('extension') }}</strong>
                        </span>
                    @endif
                </div>
            </nav>

            <nav class="name_input">
                <div class="form-group{{ $errors->has('snippet') ? ' has-error' : '' }}">
                    <textarea class="lined" rows="13" cols="148" name="snippet" >{!! old('snippet') !!}</textarea>

                    @if ($errors->has('snippet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('snippet') }}</strong>
                        </span>
                    @endif
                </div>
            </nav>

            <br />

            <button type="submit" class="btn btn-default">Create</button>
        </form>
    </div>
@endsection
