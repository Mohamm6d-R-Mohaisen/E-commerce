<div class="card" style="width: 18rem;height:500px ">
  <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}"style="width: 20rem;height:500px "/>
  <div class="card-body">
    <h5 class="card-title"> {{ $product->name }}</h5>
    
    <p class="card-text mb-2">Price: {{ $product->price }}</p>


    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary">View Product</a>
  </div>
</div>
