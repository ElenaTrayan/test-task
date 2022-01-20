@extends('layouts.app')

@section('content')

    <div class="row align-items-center">
        <div class="col-sm-6 col-md-6 col-lg-9">
            <h2 class="h2">{{ $department->name ?? ''}}</h2>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <select class="form-select" aria-label="Default select example">
                <option value="1" selected>10</option>
                <option value="2">20</option>
                <option value="3">50</option>
                <option value="3">100</option>
            </select>
        </div>
    </div>

    @if (!empty($employes))

        <ul class="list-group py-4">
            @foreach ($employes as $employe)
                <li class="list-group-item py-4">
                    <p><b>ФИО:</b> {{ $employe->full_name }}</p>
                    <p><b>Дата рождения:</b> {{ $employe->birthday }}</p>
                    <p><b>Отдел:</b> {{ $employe->department->name }}</p>
                    <p><b>Должность:</b> {{ $employe->position->name }}</p>
                    <p><b>Тип сотрудника:</b> {{ $employe->getRateType() }}</p>
                    <p><b>Оплата за месяц:</b> {{ $employe->getSalary() }} грн.</p>
                </li>
            @endforeach
        </ul>

        <div class="row">
            <div class="col-6">
                {{ $employes->links() }}
            </div>
        </div>

    @endif

@endsection
