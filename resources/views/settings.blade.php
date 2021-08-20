@extends("statamic::layout")

@section('content')
    @include('autosizeimages::partial.head')

    <hr class="my-4">

    <settings save-action="{{cp_route("autosizeimages.saveSettings")}}" size-configs="{{$sizeconfigs}}" />
@endsection
