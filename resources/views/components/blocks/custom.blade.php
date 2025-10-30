@foreach($data as $item)
    @if(($item['type'] ?? null) === 'markdown')
    <div class="container">
        {!! \Illuminate\Support\Str::markdown($item['value']) !!}
    </div>
    @else
        {!! $item['value'] !!}
    @endif
@endforeach