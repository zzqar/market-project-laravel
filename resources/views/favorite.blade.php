@extends('layouts.app')
@section('title', 'Изранное')

@section('content')

    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Cost</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
                @forelse($products as $element)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $element->title }}</td>
                        <td>{{ $element->cost }}</td>
                        <td> <a class="btn btn-secondary btn-sm favorite-btn"
                                data-id="{{ $element->id}}"
                                data-updated-text= "Убранно"
                                data-href = "/deleteToFavorites"
                            >Убрать из изранного</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Записей нет</td>
                    </tr>
                @endforelse


            </tbody>

        </table>
    </div>
@endsection
