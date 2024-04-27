@extends('layouts/app')

@section('title', 'Поиск')

@section('content')
    <div class="container">
        <div class="importants mt-3">
            <div class="important-text">
                <p class="mb-5">
                    Результаты поиска
                </p>
                <form action="search" class="search__form" style="width: 100%;">
                    <div class="row">
                        <input id="search__input" class="form-control" type="text" name="query" placeholder="Что поискать?" style="width: 80%;">
                        <input type="hidden" name="filters" value="all">
                        <button class="btn" type="submit" style="width: 19%; margin-left: 1%; background-color: #f9900e; color: white; font-size: 21px; font-family: 'Roboto', sans-serif;">Поиск</button>
                    </div>
                </form>

                <div class="container">
                    <span class="form-text marketplace__button__text">Искать на:</span>
                    <div class="row marketplace__button_box">
                            <button class="btn marketplace__button" type="submit" onclick="marketplaceFilterButtonAction(this)" enabled>SimaLand</button>
                            <button class="btn marketplace__button" type="submit" onclick="marketplaceFilterButtonAction(this)" enabled>Wildberries</button>
                            <button class="btn marketplace__button" type="submit" onclick="marketplaceFilterButtonAction(this)" enabled>YandexMarket</button>
                    </div>
                </div>

                <p class="marketplace__button__text" style="color: #171717">Ещё чуть-чуть! Получаем товары с <span id="marketplace_name"></span></p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #f9900e;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <br>

            <div class="row pb-5 mb-4" id="basket">
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/search.js') }}"></script>
@endsection
