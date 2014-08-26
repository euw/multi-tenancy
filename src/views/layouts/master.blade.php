<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>

    <meta name="description" content="">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="cleartype" content="on">

    {{ HTML::style('css/main.css') }}

    {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.dev.js') }}
    <!--[if lt IE 9]>
    {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js') }}
    <![endif]-->
</head>
<body ng-controller="AppController">
<div id="fb-root"></div>

<div class="wrapper" id="wrapper">

    @include('facebook-app::_partials._header')

    @include('facebook-app::_partials._content')

    @include('facebook-app::_partials._footer')

</div>

{{ HTML::script('js/bundle.js') }}

</body>
</html>