@extends('layouts.app')
@section('title', 'Популярные категории')

@section('content')

    <div class="container">
        <div class="accordion" id="categoriesAccordion">
            @foreach($categories as $category)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $category['id'] }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category['id'] }}" aria-expanded="true" aria-controls="collapse{{ $category['id'] }}">
                            <span class="category-name">{{ $category['name'] }}</span>
                            <span class="badge bg-primary">{{ $category['count'] ?? 0 }}</span>
                        </button>


                    </h2>
                    <div id="collapse{{ $category['id'] }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $category['id'] }}" data-bs-parent="#categoriesAccordion">
                        <div class="accordion-body">
                            @foreach($category['products'] as $product)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->title }}</h5>
                                        <p class="card-text">{{ $product->description }}</p>
                                        <p class="card-text">Count: {{ $product->count }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
