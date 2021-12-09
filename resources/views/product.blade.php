@extends('master')

@section('content')

    <div class="row">
        @foreach ($products->data as $product)
            @if ($product->languages->sk->slug == $slug)
                <div class="col-md-6 mt-5">
                    @foreach ($product->images as $images)
                        <img class="rounded img-fluid img-thumbnail product-image" src="{{ $images->image->medium }}" alt="{{ $images->alt }}">
                        @break
                    @endforeach
                    <div class="row mt-3">
                        @foreach ($product->images as $images)
                            <div class="col-md-2">
                                <img class="rounded img-fluid img-thumbnail product-thumbnail product-images" src="{{ $images->image->medium }}" alt="{{ $images->alt }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6 mt-5 product" data-product_id="{{ $product->id }}">
                    <h3>{{ $product->languages->sk->name }}</h3>
                    {!! $product->languages->sk->short_description !!}

                    <p class="text-muted">
                        Variant:
                    </p>

                    <div class="group mb-3">
                        @foreach ($products->data as $product_)
                            @if ($product->internal_name === $product_->internal_name)
                                @foreach ($product_->images as $variant)
                                    @if ($product->languages->sk->slug == $product_->languages->sk->slug)
                                        @continue
                                    @endif
                                    <a href="{{ route('product.show', $product_->languages->sk->slug) }}">
                                        <img class="rounded img-fluid img-thumbnail product-thumbnail" src="{{ $variant->image->thumb }}" alt="{{ $variant->alt }}">
                                    </a>
                                    @break
                                @endforeach
                            @endif
                        @endforeach
                    </div>

                    @foreach ($availabilities->data as $available)
                            @if ( property_exists($available, 'combinations') )
                                @if ($product->id == $available->id)
                                    @foreach ($available->combinations as $combination)
                                        <p class="my-3 h2 price">{!! number_format($combination->price, 2, ",", "&nbsp;") !!} &euro;</p>
                                        <p>Dostupnosť: <span class="availability">{{ $combination->available }}</span></p>
                                        @break
                                    @endforeach
                                @endif
                            @else
                                @if ($product->id == $available->id)
                                    <p class="my-3 h2">{!! number_format($available->price, 2, ",", "&nbsp;") !!} &euro;</p>
                                    <p>Dostupnosť: {{ $available->available }}</p>
                                @endif
                            @endif
                    @endforeach

                    @if ( property_exists($product, 'options') )
                        @foreach ($product->options as $option)
                            @if ($option->languages->sk->name == "Farby")
                                <input type="hidden" name="option[{{ $option->id }}]" class="choose-option" value="{{ $product->variation_option_id }}">
                                @continue
                            @endif
                            <p>{{ $option->languages->sk->name }}</p>
                            <select name="option[{{ $option->id }}]" class="form-select form-select-sm my-3 choose-option choose-option-main">
                                @foreach ($option->items as $option)
                                        <option value="{{ $option->id }}">{{ $option->languages->sk->name }}</option>
                                @endforeach
                            </select>
                        @endforeach
                    @endif

                    <div class="row">
                        <div class="col-md-2 mt-4">
                            <select class="form-select form-select-md select-count">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-10 d-grid gap-2 mt-4">
                            <button class="btn btn-success add-to-cart">Pridať do košíka</button>
                        </div>
                    </div>

                </div>
            @endif

        @endforeach
    </div>

@endsection


