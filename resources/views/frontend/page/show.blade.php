@extends('frontend/layout/layout')
@section('content')
{!! HTML::style('ckeditor/contents.css') !!}

<section id="title" class="emerald">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @yield('partial/breadcrumbs', Breadcrumbs::render('page.show', $page))
            </div>
            <div class="col-sm-12">
                <h1>{!! $page->title !!}</h1>
            </div>
        </div>
    </div>
</section><!--/#title-->

<section class="container">
    <div class="row">
        {!! $page->content !!}
    </div>
</section>
@stop


