@extends('welcome')

@section('head')
    @parent
    <title>{!! $title !!}</title>
@show
@section('content')

    <nav class="name_input">
        <div class="row">
            <div class="col-lg-2" style="line-height: 34px;">
                <b style="font-size: 18px; font-weight: 600; ">< > </b>Code
            </div>
            <div class="col-lg-7" style="line-height: 34px; ">
                <a href="/mySnippet/{!! $snippet_id !!}/allSnippetRevisions">Show all snippet's revisions({!! $revision_id !!}).</a>
            </div>
            <div class="col-lg-3" align="right">
                <form action="/mySnippet/{!! $snippet_id !!}" style="margin: 0; display: inline; ">
                    <input type="hidden" value="{!! $snippet_id !!}" name="snippet_id">
                    <input type="hidden" value="{!! $name !!}" name="name">
                    <button type="submit" class="btn btn-default">Edit</button>
                </form>
                <form action="/mySnippet/{!! $snippet_id !!}/delete" style="margin: 0; display: inline; ">
                    <input type="hidden" value="{!! $snippet_id !!}" name="snippet_id">
                    <input type="hidden" value="{!! $name !!}" name="name">
                    <button type="submit" class="btn btn-default">Delete</button>
                </form>
            </div>
        </div>
    </nav>
    <br />
    <div class="row">
        @foreach($snippet_revision_details as $snippet_revision_detail)
            <form class="navbar-form" role="search" name=form1 id=form1>
                <nav class="name_input">
                    <div class="form-group">
                        {!! $snippet_revision_detail->name !!}
                    </div>
                </nav>

                <br />

                <nav class="name_input">
                    <div class="form-group">
                        {!! $snippet_revision_detail->extension !!}
                    </div>
                </nav>

                <nav class="name_input">
                    <textarea class="lined" rows="13" cols="148" name="snippet" disabled>{!! $snippet_revision_detail->snippet !!}</textarea>
                </nav>

                <br />

                <input type="hidden" value="{!! $snippet_revision_detail->snippet_id !!}" name="snippetId">
            </form>
        @endforeach
    </div>
@endsection
