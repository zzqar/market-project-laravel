@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="/storage/uploads/aCztME4QInUJBTZxSFdYJGi2aIB8lvBWjjtdtEVH.jpg" alt="Product Image" class="img-thumbnail img-scale-down">
                <h2>Product Title</h2>
                <p>Product Description</p>
                <h3>Price: $99.99</h3>
            </div>

            <div class="col-md-6">
                <h2>Add Review</h2>
                <form action="/submit-review" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="review" class="form-label">Review:</label>
                        <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images:</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>

        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <h2>Reviews</h2>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">John Doe</h5>
                        <p class="card-text">This is a great product!</p>

                        <div class="row">
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal1">
                                    <img src="/storage/uploads/aCztME4QInUJBTZxSFdYJGi2aIB8lvBWjjtdtEVH.jpg" class="img-thumbnail" alt="Image 1">
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal2">
                                    <img src="/storage/uploads/aCztME4QInUJBTZxSFdYJGi2aIB8lvBWjjtdtEVH.jpg" class="img-thumbnail" alt="Image 2">
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal3">
                                    <img src="/storage/uploads/aCztME4QInUJBTZxSFdYJGi2aIB8lvBWjjtdtEVH.jpg" class="img-thumbnail" alt="Image 3">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
