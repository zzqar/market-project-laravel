@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset($product->image) }}" alt="{{ asset('images/no_icon.png') }}" class="img-thumbnail img-scale-down">
                <h2>{{ $product->title }}</h2>
                <p>{{ $product->description }}</p>
                <h3>{{ $product->cost }} руб.</h3>
            </div>

            <div class="col-md-6">
                <h2>Добавить отзыв</h2>
                {!! form($form) !!}

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <h2>Отзывы</h2>
                @foreach($reviews as $review)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $names[$review->user_id] }}</h5>
                            <p class="card-text">{{$review->content}}</p>
                            <div class="row">
                            @foreach($images[$review->id] as $image)
                                    <div class="col-4">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal1">
                                            <img src="{{ asset($image->path) }}" class="img-thumbnail" alt="Image 1">
                                        </a>
                                    </div>
                            @endforeach
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            {{ $review->created_at }}
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
@endsection
