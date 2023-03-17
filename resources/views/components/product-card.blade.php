<div class="single-product">
    <div class="product-image">
        <img src="{{$product->image_url}}" alt="#">
        @if ($product->present_product)
        <span class="sale-tag">{{$product->present_product}}</span>  
        @endif
        @if ($product->new)
        <span class="new-tag">New</span>
        @endif
        <div class="button">
            <a href="" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
        </div>
    </div>
    <div class="product-info">
        <span class="category">{{$product->category->name}}</span>
        <h4 class="title">
            <a href="{{route("products.show",$product->slug)}}">{{$product->name}}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star"></i></li>
            <li><span>4.0 Review(s)</span></li>
        </ul>
        <div class="price">
            <span>{{currency::format($product->price)}}</span>
            @if ($product->price_compare)
            <span class="discount-price">{{currency::format($product->price_compare)}}</span> 
            @endif
        </div>
    </div>
</div>