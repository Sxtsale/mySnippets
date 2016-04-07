@extends('welcome')

@section('head')
    @parent
    <title>{!! $title !!}</title>
@show
@section('content')

    <nav class="name_input">
        <div class="row">
            <div class="col-lg-9" style="line-height: 34px; ">
                <b style="font-size: 18px; font-weight: 600; ">< > Revisions ({!! $revision_id !!})</b>
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
        <?php
        $j = $counter - 1;
        ?>
        @foreach($snippet_details as $snippet_detail)
            <form class="navbar-form" role="search" name=form1 id=form1>
            <nav class="name_input">
                <div class="form-group" style="margin-left: 70px;">
                    {!! $difference_name[$j] !!}
                </div>
            </nav>

            <br />

            <nav class="name_input">
                <div class="form-group">
                    <div class="col-lg-1" align="left" style="padding-right: 0; padding-left: 0; max-width: 55px; ">
                        <a class="btn-default btn" href="/mySnippet/{!! $snippet_id !!}/revision-{!! $snippet_detail->revision_id !!}">View</a>
                    </div>
                    <div class="col-lg-9 extension" style=" line-height: 30px; ">
                        {!! $difference_extension[$j] !!}
                    </div>
                </div>
            </nav>

            <nav class="name_input">
                <div class="form-group">
                    <div class="lines col-lg-1" style="max-width: 30px; padding-right: 40px; border-right: 1px solid gray;">
                        <div class="codelines">
                            <div class="lineno lineselect">1</div>
                            @for($i = 2; $i <= substr_count( $difference_snippet[$j], "\n" ) + 1; $i++)
                                <div class="lineno">{!! $i !!}</div>
                            @endfor
                        </div>
                    </div>
                    <div class="col-lg-11">
                        {!! $difference_snippet[$j] !!}
                    </div>
                </div>
            </nav>

            <br />

            <input type="hidden" value="{!! $snippet_detail->snippet_id !!}" name="snippetId">
        </form>
            <?php
                $j--;
            ?>
        @endforeach
    </div>
@endsection
