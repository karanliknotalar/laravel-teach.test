@if(isset($products) && $products->count() > 0)
    <div class="row mb-5">
        @foreach($products as $product)
            <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                <div class="block-4 text-center border">
                    <figure class="block-4-image">
                        <a href="{{ route("page.product", ["slug_name" => $product->slug_name]) }}">
                            <img
                                src="{{ $product->image != null ? asset($product->image) : asset("images/cloth_1.jpg") }}"
                                alt="{{ $product->name }}" class="img-fluid">
                        </a>
                    </figure>
                    <div class="block-4-text p-4">
                        <h3>
                            <a href="{{ route("page.product", ["slug_name" => $product->slug_name]) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="mb-0">{{ $product->sort_description }}</p>
                        <p class="text-primary font-weight-bold">{{ number_format($product->price, 2) }}
                            TL</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {!! $products->links('pagination::front-products') !!}
@endif
