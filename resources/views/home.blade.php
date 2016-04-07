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

    @if (session('success'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-send"></span>
            <strong> {{ session('success') }}</strong>
        </div>
    @endif
    @if(Auth::check())
    <nav class="name_input">
        <div class="row">
            <div class="col-lg-9">
            </div>
            <div class="col-lg-3" align="right" style="line-height: 34px; ">

                    <a href="/createSnippet">Create your new snippet.</a>

            </div>
        </div>
    </nav>
    @endif
    <br />
    <div class="row">
        @foreach($all_snippets as $snippet)
            <form class="navbar-form" role="search" name=form1 id=form1>
                <nav class="name_input">
                    <div class="form-group">
                        <div class="col-lg-9" style="padding-left: 0; line-height: 30px;">
                            {!! $snippet->name !!}
                        </div>
                        <div class="col-lg-3" style="padding-right: 0; line-height: 30px;" align="right">
                            <a class="btn-default btn" href="/mySnippet/{!! $snippet->snippet_id !!}/revision-{!! $snippet->revision_id !!}">View</a>
                        </div>

                    </div>
                </nav>

                <br />

                <nav class="name_input">
                    <div class="form-group">
                        {!! $snippet->extension !!}
                    </div>
                </nav>

                <nav class="name_input">
                    <textarea class="lined" rows="13" cols="148" name="snippet" disabled>{!! $snippet->snippet !!}</textarea>
                </nav>

                <br />
            </form>
        @endforeach
    </div>
@endsection
