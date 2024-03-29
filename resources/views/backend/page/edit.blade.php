@extends('backend/layout/layout')
@section('content')
    {!! HTML::script('ckeditor/ckeditor.js') !!}
    <section class="content-header">
        <h1> Page <small> | Update Page</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{!! url(getLang() . '/admin/page') !!}"><i class="fa fa-bookmark"></i> Page</a></li>
            <li class="active">Update Page</li>
        </ol>
    </section>
    <br>
    <br>
    <div class="container">
        {{--//$page->id--}}
        {!! Form::open( array( 'route' => array( getLang() . '.admin.page.update',$page->id ), 'method' => 'PATCH', 'files'=>true,'id'=>'form')) !!}
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li class="{{$localeCode==LaravelLocalization::getCurrentLocale()?'active':''}}"><a href="#box-{{$localeCode}}" data-language="{{$localeCode}}">{!! $properties['native'] !!}</a></li>
                    @endforeach

                </ul>
                <div class="tab-content">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <div  class="{{$localeCode==LaravelLocalization::getCurrentLocale()?'active':''}} tab-pane languagesbox" id="box-{{$localeCode}}">
                            <!-- Title -->
                            <div class="control-group {!! $errors->has('title.'.$localeCode) ? 'has-error' : '' !!}">
                                <label class="control-label" for="title">Title</label>
                                <div class="controls">
                                    {!! Form::text('title['.$localeCode.']', $pages_lang_data[$localeCode]->title, array('class'=>'form-control', 'id' => 'title'.$localeCode, 'placeholder'=>'Title','required'=>'required', 'value'=>Input::old('title.'.$localeCode))) !!}
                                    @if ($errors->first('title.'.$localeCode))
                                        <span class="help-block">{!! $errors->first('title.'.$localeCode) !!}</span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <!-- Content -->
                            <div class="control-group {!! $errors->has('content.'.$localeCode) ? 'has-error' : '' !!}">
                                <label class="control-label" for="title">Content</label>

                                <div class="controls">
                                    {!! Form::textarea('content['.$localeCode.']', $pages_lang_data[$localeCode]->content, array('class'=>'form-control', 'id' => 'content'.$localeCode, 'placeholder'=>'Content','required'=>'required', 'value'=>Input::old('content.'.$localeCode))) !!}
                                    @if ($errors->first('content.'.$localeCode))
                                        <span class="help-block">{!! $errors->first('content.'.$localeCode) !!}</span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <!-- Published -->
                            <div class="control-group {!! $errors->has('is_published.'.$localeCode) ? 'has-error' : '' !!}">

                                <div class="controls">
                                    <label class="">{!! Form::checkbox('is_published['.$localeCode.']', "is_published[$localeCode]",$pages_lang_data[$localeCode]->is_published) !!} Publish ?</label>
                                    @if ($errors->first('is_published.'.$localeCode))
                                        <span class="help-block">{!! $errors->first('is_published.'.$localeCode) !!}</span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <input id="id{{$localeCode}}" name="id[{{$localeCode}}]" type="hidden" value="{{$pages_lang_data[$localeCode]->id}}" />
                        </div><!-- /.tab-pane -->


                    @endforeach
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
        <!-- Form actions -->
        {!! Form::submit('Update', array('class' => 'btn btn-success')) !!}
        {!! Form::close() !!}
        <script>

            $('.nav-tabs li a').click(function (e) {
                e.preventDefault();
                $(this).tab('show')
            });
            $('.nav-tabs li a').on('shown.bs.tab', function (e) {
                var id=$(e.target).attr('href').replace('#box-', '');
                if (CKEDITOR.instances['content'+id]) {
                    CKEDITOR.instances['content'+id].destroy();
                }
                CKEDITOR.replace('content'+id);
            });

            window.onload = function () {
                CKEDITOR.replace('content{!! getLang() !!}', {
                    "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}"
                });
            };
            $("#form").validate({
                ignore: [],
                submitHandler: function(form) {
                    $("input[type=submit]").attr('disabled', false);
                    if ($(form).valid()) {
                        $("input[type=submit]").attr('disabled', true);
                        form.submit();
                    }
                },
                invalidHandler: function(e, validator){
                    var input = $(validator.errorList[0].element);
                    var language_tab = input.attr('data-language');
                    var active_href='#box-'+language_tab;
                    $('.nav-tabs li a[href='+active_href+']').tab('show');
                    input.focus();
                }
            });

        </script>
    </div>
@stop

