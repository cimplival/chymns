@extends('layouts.app')

@section('body')
    <div class="padded-full">
        <div class="padded-full">
            @foreach($choruses as $chorus)
                <p><strong>{!!$chorus!!}.</strong></p>
            @endforeach
        </div>
            @foreach($stanzas as $key=>$stanza)
            <p class="padded-full">{{++$key}}). {!!$stanza!!}</p>
            @endforeach 

    </div>
@endsection