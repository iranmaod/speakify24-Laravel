@extends('layouts.frontend.index')
@section('content')
<?php
    $session = \App::getLocale();
    if (session()->get('locale') != '') {
        $session = session()->get('locale');
    }
    $config = \DB::table('options')->where('code', 'pageAgreement')->where('locale', $session)->get();
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
    @foreach($config as $con)
        {!!  str_replace('../../', '', $con->option_value) !!}
    @endforeach
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
@endsection