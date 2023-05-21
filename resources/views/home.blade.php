@extends('layouts.app')
@section('title', 'Товары')

@section('content')

    <div class="container">
        <ul class="nav nav-tabs">
            <a href="{{ route('home',['id' => 0]) }}" class="nav-link {{ $catTab == 0 ? 'active' : '' }}">Все</a>
            @foreach ($category as $item)
                <li class=" nav-item">
                    <a href="{{ route('home',['id' => $item->id]) }}"
                       class="nav-link {{ $catTab == $item->id ? 'active' : '' }}">{{ $item->name }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row row-cols-1 row-cols-md-5 g-4">
                    @foreach ($products as $element)
                        <div class="col">
                            <div class="card h-100">
                                <a href="#" class="text-decoration-none text-black">
                                    <img src="{{ asset('images/no_icon.png') }}" class="card-img-top"
                                         alt="{{ asset('images/no_icon.png') }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $element->title}}</h5>
                                        <p class="card-text ">This is a wider card with supporting text below as a
                                            natural lead-in to additional content. This card has even longer content
                                            than the first to show that equal height action.</p>
                                    </div>
                                </a>
                                <div class="card-footer">
                                    @if(empty($favorite[$element->id]))
                                        <a class="btn btn-secondary btn-sm favorite-btn"
                                           data-id="{{ $element->id}}"
                                           data-updated-text= "Добавлено"
                                           data-href = "/addToFavorites"
                                        >Добавить в избранное</a>
                                    @else
                                        <a class="btn btn-sm favorite-btn  btn-outline-success"
                                           data-id="{{$element->id}}">Добавлено</a>
                                    @endif
                                    <a class="btn btn-secondary btn-sm">FFF</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
