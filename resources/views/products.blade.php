@extends('master')

@section('content')

    <div class="row">
        @foreach ($products->data as $product)
            <div class="col-md-3 my-5">
                <div class="product-card" data-product-id="{{ $product->id }}">

                    <a href="{{ route('product.show', $product->languages->sk->slug) }}">
                        @foreach ($product->images as $images)
                            <img src="{{ $images->image->original }}" class="card-img-top" alt="{{ $images->alt }}">
                            @break
                        @endforeach
                    </a>

                    <div class="card-body">
                        <p class="card-text text-muted">
                            {{ $categories[$product->category_id] }}
                        </p>

                        <a href="{{ route('product.show', $product->languages->sk->slug) }}">
                            <p class="card-text">{{ $product->languages->sk->name }}</p>
                        </a>

                        @foreach ($availabilities->data as $available)
                            @if ( property_exists($available, 'combinations') )
                                @if ($product->id == $available->id)
                                    @foreach ($available->combinations as $combination)
                                        <small class="text-center">{!! number_format($combination->price, 2, ",", "&nbsp;") !!} &euro;</small>
                                        @break
                                    @endforeach
                                @endif
                            @else
                                @if ($product->id == $available->id)
                                    <small class="text-center">{!! number_format($available->price, 2, ",", "&nbsp;") !!} &euro;</small>
                                @endif
                            @endif
                        @endforeach

                    </div>

                </div>
            </div>
        @endforeach
    </div>

@endsection
