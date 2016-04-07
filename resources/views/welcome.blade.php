<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <link href='../../css/textArea.css' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <style>
            html, body {
                height: 100%;
            }

            body {
                font-weight: 100;
                font-family: 'Montserrat', sans-serif !important;
            }

            .title {
                font-size: 17px;
            }

            .fa{
                font-size: 17px;
            }

            .btn-lg{
                padding: 0 !important;
            }

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
            .diff td{
                vertical-align : top;
                white-space    : pre;
                white-space    : pre-wrap;
                font-family    : monospace;
            }
            .diffDeleted{
                background-color: rgb(255,224,224);
                border: 1px solid rgb(255,192,192);
                padding: 0 5px;
                min-width: 500px;
                max-width: 490px;
                margin-top: 5px;
            }
            .diffDeleted span{
                line-height: 20px;
            }
            .diffUnmodified{
                background-color: transparent;
                border: 1px solid rgb(226, 223, 223);
                padding: 0 5px;
                min-width: 500px;
                max-width: 490px;
            }
            .diffUnmodified span{
                line-height: 20px;
            }
            .diffInserted{
                border: 1px solid rgb(192,255,192);
                background-color: rgb(224,255,224);
                padding: 0 5px;
                min-width: 500px;
                max-width: 490px;
            }
            .diffInserted span{
                line-height: 20px;
            }
            .extension span{
                line-height: 34px;
            }
        </style>
    </head>
    <body>


    <div class="navbar navbar-default">
            <div class="col-lg-1"></div>
            <div class="col-lg-7">
                <a class="navbar-brand" href="/">
                    <span class="glyphicon glyphicon-list-alt" style="font-size: 30px;"></span> <i style="font-family: 'Lobster', cursive;">MySnippets ...</i>
                </a></div>
            <div class="col-lg-3">
                <div style="border: 2px solid #000000; border-top-right-radius: 10px; border-bottom-left-radius: 10px; margin: 10px;">
                    <div class="btn btn-block btn-social btn-lg btn-github">
                        @if(!Auth::check())
                            <a href="/github/authorize" style="text-underline: none; color: #000000;">
                                <span class="fa fa-github">Sign in with GitHub account!</span>
                            </a>
                        @else
                            <div class="title">Welcome {!! Auth::user()->username !!} !</div>
                            <a href="/github/logout">logout</a>
                        @endif
                    </div>
                </div>
            </div>
    </div>

    <div class="container">
        <div class="col-lg-12" style="padding-left: 38px; padding-right: 30px;">
            @yield('content')
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../../js/snippetJS.js"></script>
    <script>
        $(function() {
            $(".lined").linedtextarea(
                    {selectedLine: 1}
            );
        });
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>
