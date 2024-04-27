@extends('layouts/app')

@section('title', 'Главная')

@section('content')
    <div class="container">
        <div class="importants mt-3">
            <div class="important-text mb-5">
                <p>
                    Очень важный текст
                </p>
            </div>

            <div class="container">
                <div class="row ">
                    <div class="col-xl-6 col-lg-6">
                        <div class="card l-bg-orange">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Количество заказов</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            3,243
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span>12.5% за месяц <i class="fa fa-arrow-up"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card l-bg-orange">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">Товаров</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            >3 млн.
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <form action="search" class="search__form" style="width: 100%;">
                <div class="row">
                    <input id="search__input" class="form-control" type="text" name="query" placeholder="Что поискать?" style="width: 80%;">
                    <input type="hidden" name="filters" value="all">
                    <button class="btn" type="submit" style="width: 19%; margin-left: 1%; background-color: #f9900e; color: white; font-size: 21px; font-family: 'Roboto', sans-serif;">Поиск</button>
                </div>
            </form>
        </div>
    </div>
@endsection
