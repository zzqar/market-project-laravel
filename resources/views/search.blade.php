@extends('layouts.app')
@section('title', 'Изранное')

@section('content')

    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Name</th>
                <th scope="col">Кол-во отзывов</th>

            </tr>
            </thead>
            <tbody>
            @forelse($results as $element)
                <tr>
                    @if(empty($element->description))
                        <td>Категория</td>
                    @else
                        <td>Товар</td>
                    @endif
                    <td>{{ $element->title }}</td>


                        <td>{{ $element->count ?? 0 }}</td>


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
