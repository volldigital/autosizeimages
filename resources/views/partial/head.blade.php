<div class="name">
    <h1>{{$pageInfo["name"]}}</h1>
</div>

<div class="version mt-1">
    <h2>Version: {{$pageInfo["version"]}}</h2>
</div>

<div class="keywords mt-2">
    @foreach($pageInfo["keywords"] as $keyword)
        <span class="badge-sm bg-blue-light mr-1">{{$keyword}}</span>
    @endforeach
</div>

<div class="description mt-3">
    <p>{{$pageInfo["description"]}}</p>
</div>

<div class="homepage mt-4">
    Visit us at <a class="font-bold" href="{{$pageInfo["homepage"]}}" rel="nofollow" target="_blank">{{$pageInfo["homepage"]}}</a>
</div>
