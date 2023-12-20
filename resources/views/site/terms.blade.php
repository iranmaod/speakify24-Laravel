@extends('layouts.frontend.index')
@section('content')
<?php
    $session = \App::getLocale();
    if (session()->get('locale') != '') {
        $session = session()->get('locale');
    }
    $config = \DB::table('options')->where('code', 'pageTerm')->where('locale', $session)->get();
?>
@isset($config)
@php
$seo = $config->first();
@endphp
@section('title', $seo->seo_title )
@section('meta_description', $seo->seo_description)
@section('meta_keywords', $seo->seo_keywords)
@endisset
<div class="container-fluid p-0 home-content container-top-border">
    <div class="container">

        <div class="row">
            <div class="col-xl-10 offset-xl-0 col-lg-10 offset-lg-0 col-md-8 m-auto">
                <div style="margin-top:50px;">
                    @foreach($config as $con)
                    {!!  str_replace('../../', '', $con->option_value) !!}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
@endsection