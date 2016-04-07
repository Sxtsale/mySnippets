@extends('welcome')

@section('head')
    @parent
    <title>{!! $title !!}</title>
@show
@section('content')

    <nav class="name_input">
        <div class="row">
            <div class="col-lg-2" style="line-height: 34px; ">
                <b style="font-size: 18px; font-weight: 600; ">< > Editing</b>
            </div>
            <div class="col-lg-7" style="line-height: 34px; ">
                @if($revision_id > 0)
                    <a href="/mySnippet/{!! $snippet_id !!}/allSnippetRevisions">Show all snippet's revisions.</a>
                @endif
            </div>
            <div class="col-lg-3" align="right">
                <form action="/mySnippet/{!! $snippet_id !!}/delete" style="margin: 0;">
                    <input type="hidden" value="{!! $snippet_id !!}" name="snippet_id">
                    <input type="hidden" value="{!! $name !!}" name="name">
                    <button type="submit" class="btn btn-default">Delete</button>
                </form>
            </div>
        </div>
    </nav>
    <br />
    <div class="row">
        <form class="navbar-form" role="search" name=form1 id=form1 action="/update-snippet">
            <nav class="name_input">
                <div class="form-group">
                    <input type="text" class="form-control" value="{!! $name !!}" name="name">
                </div>
            </nav>

            <input type="hidden" value="{!! $snippet_id !!}" name="snippet_id">
            <br />

            <nav class="name_input">
                <div class="form-group">
                    <input type="text" class="form-control" value="{!! $extension !!}" name="extension">
                </div>
            </nav>

            <nav class="name_input">
                <textarea class="lined" rows="13" cols="148" name="snippet">{!! $snippet !!}</textarea>
            </nav>

            <br />

            <input type="hidden" value="{!! $snippet_id !!}" name="snippet_id">
            <a href="/" class="btn btn-default">Cancel</a>
            <button type="submit" class="btn btn-default">Update your snippet!</button>
        </form>
    </div>
@endsection
