@extends('layouts.app')

@php($translation = $content->translation())

@section('title', ($translation?->title ?? 'Về chúng tôi') . ' - ' . ($siteName ?? 'ZEK SHOP'))

@section('content')
    <section class="about-page py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="{{ $content->image ? 'col-lg-6' : 'col-lg-8 mx-auto' }}">
                    <span class="text-primary fw-semibold text-uppercase small">ZEK SHOP</span>
                    <h1 class="display-5 fw-bold mt-2 mb-4">{{ $translation?->title }}</h1>
                    <div class="page-body about-content">
                        {!! $translation?->body !!}
                    </div>
                </div>
                @if($content->image)
                    <div class="col-lg-6">
                        <img src="{{ Storage::url($content->image) }}" alt="{{ $translation?->title }}" class="img-fluid rounded-4 shadow-sm">
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
