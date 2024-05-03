@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')



    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1>Products</h1>
                <button class="btn btn-success ml-auto m-5">Edit Product</button>
            </div>

        </div>

        <div class="container w-75 border p-3">
            <!-- For Create -->
            <form action="{{ route('products.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
                <!-- Other fields -->
                <div class="form-group">
                    <div class="d-flex row">
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="Inputname" name="name" value="{{$product->name}}">
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="category_id">Category:</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option {{$product->category_id == $category->id ? 'selected':'' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex row">
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="Inputname" name="qty" value="{{$product->qty}}">
                        </div>
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Price</label>
                            <input type="number" class="form-control" id="Inputname" name="price" value="{{$product->price}}">
                        </div>
                    </div>
                    <div class="d-flex row">
                        <div class="mb-3 col-lg-6 col-sm-12 mt-5">
                            <label for="Inputname" class="form-label">Image</label>
                            <input type="file" class="form-control" id="Inputname" name="img" >
                        </div>
                        @if ($errors->has('img'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('img') }}</strong>
                            </span>
                        @endif
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <div class="prescription">
                                <label for="Inputname" class="form-label">Prescription</label>
                                <input type="checkbox" class="" id="Inputname" name="pres" value="1" {{$product->pres == 1 ? 'checked':''}}>
                            </div>
                        </div>
                         <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Discount %</label>
                            <input type="number" class="form-control" id="Inputname" name="discount" value="{{$product->discount}}">
                        </div>
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label for="Inputname" class="form-label">Formula</label>
                            <input type="text" class="form-control" id="Inputname" name="formula" value="{{$product->formula}}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Inputname" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="Inputname" name="desc" value="">{{$product->desc}}</textarea>
                    </div>
                    <label for="related_products">Related Products:</label>
                    <div class="row">
                        @foreach ($products as $relatedProduct)
                            <div class="col-md-3"> <!-- Adjust column width as needed -->
                                <div class="form-check">
                                    <input type="checkbox" id="related_product_ids_{{ $relatedProduct->id }}"
                                        name="related_product_id[]" value="{{ $relatedProduct->id }}" 
                                        {{ $product->related_product_id && in_array($relatedProduct->id, explode(',', $product->related_product_id)) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label"
                                        for="related_product_ids_{{ $relatedProduct->id }}">{{ $relatedProduct->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    

                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>



        </div>
    </div>



@endsection
