@extends('layouts.app')

@section('partials')

    @if (Session::get('message'))
        @include('core.partials.info')
    @endif

    @if (Session::get('success'))
        @include('core.partials.success')
    @endif

    @if (Session::get('error'))
        @include('core.partials.error')
    @endif

    @if (Session::get('errors'))
        @include('core.partials.errors')
    @endif

@endsection

@section('body')
    <form method="POST" action="{{ url('/') }}">
    {{ csrf_field() }}
        <div class="padded-full">
            <input type="text" name="search" placeholder="Search songs here...(Found {{ $no_of_songs }} songs)" autocomplete="off" autofocus>
        </div>
        <div class="padded-full">
            <button type="submit" class="btn fit-parent primary">Search</button>
        </div>
    </form>
    
    <div class="padded-full">
        <ul class="list">
            @if($songs)
                @foreach($songs as $key=>$song)
                <li>
                    <a class="padded-list" href="{{ url('song', $song->id)}}"> {{ str_limit($song->title, $limit = 25, $end = '...') }}</a>
                </li>
                @endforeach
            @endif
        </ul>
    </div>
@endsection

@section('partials-script')
    @if(Session::get('errors') || Session::get('error') || Session::get('info') || Session::get('success'))
        @include('core.partials.notify-script')
    @endif
@endsection