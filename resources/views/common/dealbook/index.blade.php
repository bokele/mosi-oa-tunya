@extends('layouts.guest')

@section('page-ttile')
DealBook |
@endsection

@section('content')
<main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>{{_("DealBook")}}</h2>
                <ol>
                    <li><a href="/">Home</a></li>
                    <li>{{_("DealBook")}}</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
        <div class="container">
            <div class="row">
                @forelse ($dealbooks as $dealbook)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{asset($dealbook->cover_image)}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$dealbook->title}}</h5>
                            <p class="card-text fs-6 fw-light text-muted">{!! $dealbook->description !!}</p>
                            <a href="{{route("common.dealbook.show", $dealbook->slug)}}"
                                class="btn btn-primary">{{_('Read More')}}</a>
                        </div>
                    </div>
                </div>
                @empty

                @endforelse

            </div>

        </div>
    </section>

</main><!-- End #main -->

@endsection
