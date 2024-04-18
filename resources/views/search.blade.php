@extends('layouts/app')

@section('title', 'Поиск')

@section('content')
    <div class="container">
        <div class="importants mt-3">
            <div class="important-text">
                <p class="mb-5">
                    Результаты поиска
                </p>
                <form action="search" class="search__form">
                    <input id="search__input" class="form-control" type="text" name="query"
                           placeholder="Что ещё поищем?">
                </form>
            </div>

            <br>

            <div class="row pb-5 mb-4">
                @foreach($marketplacesResults as $marketplacesResult)
                    @foreach($marketplacesResult->getItems() as $item)
                        <div class="col-lg-4 col-md-6" style="margin-bottom: 20px">
                            <div class="card rounded shadow-sm border-0 mb-5 h-100">
                                <div class="card-body p-4"><img
                                        src="{{ $item->getPhotoUrl() }}" alt=""
                                        class="img-fluid d-block mx-auto mb-3">
                                    <h5><a href="{{ $item->getItemUrl() }}"
                                           class="text-dark">{{ $item->getName() }}</a></h5>
                                    <p class="small text-muted font-italic">
                                        Текст для описания товара
                                    </p>
                                    <div class="market__box float-start">
                                        <div class="row">
                                            <img src="{{ $marketplacesResult->getLogoPath() }}"
                                                 style="width: 75px !important; height: 45px !important;" alt="">
                                            <div class="col">
                                                <p class="small text-muted font-italic"
                                                   style="margin-top: 0.65rem !important">
                                                    {{ $marketplacesResult->getSign() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="price__box float-end">
                                        <h4>{{ $item->getPrice() }} ₽</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
