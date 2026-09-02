@extends('layouts.app')
@section('title', ($content->translation()?->title ?? '') . ' - ' . ($siteName ?? 'ZEK SHOP'))
@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ $content->translation()?->title }}</h1>
    <div class="page-body">
        {!! $content->translation()?->body !!}
    </div>
</div>
@endsection
