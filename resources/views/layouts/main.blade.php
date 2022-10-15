<html>

<head>
    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="{{ url('assets/images/favicon.ico') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/default.min.css" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js" crossorigin="anonymous"></script>

    <script>hljs.highlightAll();</script>

    <style type="text/css">
        body {
            background-color: #FCFCFC;
            font-family: Rubik,sans-serif;
        }
    </style>

    <link rel="stylesheet" href="{{ url('assets/css/main.css') }}">
    <script src="{{ url('assets/js/main.js') }}"></script>
</head>

<body>
    <div class="ui fixed inverted menu">
        {{-- @link https://semantic-ui.com/examples/fixed.html --}}
        <div class="ui container">
            <a href="{{ route('home') }}" class="header item">
                <img class="logo" src="{{ url('assets/images/upmind-logo.svg') }}" alt="upmind logo">
                Provision Workbench
            </a>
            <a href="{{ route('provision-request-new') }}" class="item">
                Run Function <i class="blue play circle dropdown icon"></i>
            </a>
            <a href="{{ route('provision-request-index') }}" class="item">
                View Requests <i class="zoom-in dropdown icon"></i>
            </a>
            <div class="ui simple dropdown item">
                <a href="{{ route('category-index') }}">
                    Categories <i class="dropdown icon"></i>
                </a>
                <div class="menu">
                    @foreach ($registry->getCategories() as $category)
                        <div class="dropdown item">
                            <a style="color:rgba(0,0,0,.87)" href="{{ route('category-show', ['category_code' => $category->getIdentifier()]) }}">
                                <i class="dropdown icon"></i>
                                {{ $category->getAbout()->name }}
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </a>
                            <div class="menu">
                                @foreach ($category->getProviders() as $provider)
                                    <a class="item"
                                        href="{{ route('provider-show', ['category_code' => $category->getIdentifier(), 'provider_code' => $provider->getIdentifier()]) }}">
                                        {{ $provider->getAbout()->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('package-index') }}" class="item">Packages</a>
        </div>
    </div>

    <div class="ui main container">
        <div class="ui basic segment">
            @if(!($hide_breadcrumbs ?? false)){{ Breadcrumbs::render() }}@endif&nbsp;
        </div>

        <div class="ui very padded raised segment">
            <main>
                <div class="ui @if($center ?? false) center aligned @endif @if(!($wide ?? false)) text @endif container">
                    @hasSection ('title-message')
                        <div class="ui right floated compact basic segment">
                            @yield('title-message')
                        </div>
                    @endif
                    @yield('title-image')
                    <h1 class="ui clearing header">@yield('icon') @yield('title')</h1>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <div class="ui inverted vertical footer segment">
        <div class="ui center aligned container">
            <div class="ui stackable inverted divided grid">
                <div class="six wide column">
                    <h4 class="ui inverted header">Links</h4>
                    <div class="ui inverted link list">
                        <a href="https://upmind.com" target="_blank" class="item">Upmind &nbsp;<i
                                class="external alternate icon"></i></a>
                        <a href="https://docs.upmind.com/docs" target="_blank" class="item">Documentation &nbsp;<i
                                class="external alternate icon"></i></a>
                        <a href="https://github.com/upmind-automation" target="_blank" class="item">GitHub &nbsp;<i
                                class="external alternate icon"></i></a>
                        <a href="https://twitter.com/WeAreUpmind" target="_blank" class="item">Twitter &nbsp;<i
                                class="external alternate icon"></i></a>
                        <a href="https://www.linkedin.com/company/upmindautomation" target="_blank" class="item">LinkedIn
                            &nbsp;<i class="external alternate icon"></i></a>
                    </div>
                </div>
                <div class="ten wide column">
                    <img src="{{ url('assets/images/upmind-logo.svg') }}" alt="upmind logo" class="ui centered mini image">
                    <h4 class="ui inverted header">Get Upmind</h4>
                    <p>Sell, manage and support web hosting, domain names, website builders and more with <a
                        href="https://upmind.com/start">Upmind.com</a> - the ultimate web hosting billing and management
                    solution.</p>
                </div>
            </div>
            <div class="ui inverted section divider"></div>
            <p>Upmind Provision Workbench is distributed under <a href="https://www.gnu.org/licenses/gpl-3.0.txt">GPL-3.0</a></p>
            {{-- <img src="{{ url('assets/images/upmind-logo.svg') }}" alt="upmind logo" class="ui centered mini image"> --}}
        </div>
    </div>
</body>

</html>
