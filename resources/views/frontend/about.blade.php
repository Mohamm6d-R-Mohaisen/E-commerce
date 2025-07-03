@extends('frontend.layout')

@section('title', __('app.about_us'))

@section('content')
<!-- Start Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">{{ __('app.about_us') }}</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('app.home') }}</a></li>
                    <li>{{ __('app.about_us') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start About Area -->
<section class="about-us section">
    <div class="container">
        <div class="row align-items-center">
            @if($about)
            <div class="col-lg-6 col-md-12 col-12">
                <div class="content-left">
                    @if($about->image)
                        <img src="{{ asset($about->image) }}" alt="{{ $about->title }}" class="img-fluid rounded shadow">
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <div class="content-right">
                    <h2>{{ $about->title }}</h2>
                    <p class="lead">{{ $about->description }}</p>
                    @php
                        // Split content into paragraphs for better display
                        $contentParagraphs = explode("\n\n", $about->content);
                    @endphp
                    @foreach($contentParagraphs as $paragraph)
                        @if(trim($paragraph))
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
            @else
            <div class="col-12">
                <div class="text-center py-5">
                    <h3 class="text-muted">{{ __('admin.no_about_content_found') }}</h3>
                    <p class="text-muted">{{ __('admin.please_add_about_content_from_admin_panel') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- End About Area -->

<!-- Start Team Area -->
<section class="team section">
    <div class="container">
        @if($teamMembers && $teamMembers->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>{{ __('app.our_team') }}</h2>
                    <p>{{ __('app.meet_our_professional_team') }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($teamMembers as $member)
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="single-team">
                        @if($member->image)
                        <div class="image">
                            <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" class="img-fluid">
                        </div>
                        @endif
                        <div class="content">
                            <div class="info">
                                <h3>{{ $member->name }}</h3>
                                <h5>{{ $member->position }}</h5>
                                @if($member->facebook || $member->twitter || $member->linkedin || $member->skype)
                                <ul class="social">
                                    @if($member->facebook)
                                        <li><a href="{{ $member->facebook }}" target="_blank" aria-label="Facebook"><i class="lni lni-facebook-filled"></i></a></li>
                                    @endif
                                    @if($member->twitter)
                                        <li><a href="{{ $member->twitter }}" target="_blank" aria-label="Twitter"><i class="lni lni-twitter-original"></i></a></li>
                                    @endif
                                    @if($member->linkedin)
                                        <li><a href="{{ $member->linkedin }}" target="_blank" aria-label="LinkedIn"><i class="lni lni-linkedin-original"></i></a></li>
                                    @endif
                                    @if($member->skype)
                                        <li><a href="skype:{{ $member->skype }}" aria-label="Skype"><i class="lni lni-skype"></i></a></li>
                                    @endif
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- End Team Area -->
@endsection

@push('script')
<script type="text/javascript">
    //========= glightbox
    GLightbox({
        'href': 'https://www.youtube.com/watch?v=r44RKWyfcFw&fbclid=IwAR21beSJORalzmzokxDRcGfkZA1AtRTE__l5N4r09HcGS5Y6vOluyouM9EM',
        'type': 'video',
        'source': 'youtube', //vimeo, youtube or local
        'width': 900,
        'autoplayVideos': true,
    });
</script>
@endpush 