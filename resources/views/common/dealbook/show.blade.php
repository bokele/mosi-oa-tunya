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
                    <li><a href="/">{{_("Home")}}</a></li>
                    <li><a href="{{route('common.dealbook')}}">{{_("DealBook")}}</a></li>
                    <li>{{$dealbook->title}}</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
        <div class="container">

            <img src="{{asset($dealbook->cover_image)}}" class="img-fluid" alt="{{$dealbook->title}}">
            <p>
                <h2>{{$dealbook->title}}</h2>
            </p>
            <p>
                {{_('Author')}}: {{$dealbook->author}}, {{_('Last modification')}} : {{$dealbook->updated_at}}

            </p>
            {!! $dealbook->description !!}
            {!! $dealbook->content !!}


            <br />
            <p class="justify-items-center"> {!! $dealbook->video_link !!}</p>

        </div>

        </div>
    </section>

</main><!-- End #main -->

@endsection
