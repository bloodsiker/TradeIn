<section class="cost_page">

    <div class="select_cost">
        <div class="left_block">
            <h1 class="calculator_title">Калькулятор оценки стоимости</h1>
            <h2 class="calculator_description">Помогите нам предоставить точную цену, ответив на вопросы ниже.</h2>
        </div>
        <div class="right_block" style="visibility: hidden">
        </div>
    </div>

    <div class="select_cost">
        <div class="left_block">
            <div class="select">
                <div class="type" id="typeList" data-url="{{ route('api.type_device') }}">
                    <div class="type-search-one">
                        <p class="type-search-text"></p>
                        <input class="type-search" type="text" placeholder="Выберите тип устройства">
                    </div>
                    <ul class="type-list" id="type-list"></ul>
                </div>
                <div class="brand" id="brandList" data-url="{{ route('api.brands', ['type_id' => '', 'network_id' => Auth::check() ? Auth::user()->network_id : null]) }}">
                    <div class="brand-search-one">
                        <p class="brand-search-text"></p>
                        <input class="brand-search" type="text" placeholder="Выберите производителя">
                    </div>
                    <ul class="brand-list" id="brand-list"></ul>
                </div>
                <div class="model" id="modelList" data-url="{{ route('api.models', ['type_id' => '', 'brand_id'  => '', 'network_id' => Auth::check() ? Auth::user()->network_id : null]) }}">
                    <div class="model-search-one">
                        <p class="model-search-text"></p>
                        <input class="model-search" type="text" placeholder="Выберите модель">
                    </div>
                    <ul class="model-list"></ul>
                </div>
            </div>
            <div class="power">
                <div class="disabled-off disabled"></div>
                <p class="power_question">Ваше устройство включается?</p>
                <div class="power_option">
                    <button class="power_option1">Да</button>
                    <button class="power_option2">Нет</button>
                </div>
            </div>
            <div class="screen">
                <div class="disabled-off disabled"></div>
                <div class="screen-block">
                    <p class="screen_question">Экран устройства полностью рабочий?</p>
                    <ul class="screen_title">
                        <li>На экране нет трещин, сколов</li>
                        <li>На экране нет полос, пятен, битых пикселей, остаточного изображения</li>
                        <li>Подсветка равномерная по всему экрану</li>
                        <li>Сенсор полностью рабочий</li>
                    </ul>
                </div>
                <div class="screen_option">
                    <button class="screen_option1">Да</button>
                    <button class="screen_option2">Нет</button>
                </div>
            </div>
            <div class="function_phone">
                <div class="disabled-off disabled"></div>
                <div class="function_phone-block">
                    <p class="function_phone-question">Все функции устройства работают?</p>
                    <ul class="function_phone-title">
                        <li>Динамик и микрофон</li>
                        <li>Кнопки включения, громкости</li>
                        <li>Сканер отпечатка пальца, лицо, сетчатки глаза</li>
                        <li>Камеры основная, фронтальная и вспышки</li>
                        <li>Мобильная связь, Wi-Fi, Bluetooth, GPS</li>
                        <li>Разъемы зарядки и наушников</li>
                        <li>Датчик приближения, гироскоп, компас</li>
                    </ul>
                </div>
                <div class="function_phone-option">
                    <button class="function_phone-option1">Да</button>
                    <button class="function_phone-option2">Нет</button>
                </div>
            </div>
            <div class="screen_state">
                <div class="disabled-off disabled"></div>
                <p class="screen_state-question">Выберите состояние экрана наиболее похож на ваш.</p>
                <div class="screen_state-option">
                    <button class="screen_state-option1"><img src="{{ asset('assets/img/calculator/display_grade_A.jpg') }}" alt="">
                        <p>* Нет царапин</p></button>
                    <button class="screen_state-option2"><img src="{{ asset('assets/img/calculator/display_grade_B.jpg') }}" alt="">
                        <p>* Едва заметные</p></button>
                    <button class="screen_state-option3"><img src="{{ asset('assets/img/calculator/display_grade_C.jpg') }}" alt="">
                        <p>* Достаточно заметные</p></button>
                    <button class="screen_state-option4"><img src="{{ asset('assets/img/calculator/display_grade_D.jpg') }}" alt="">
                        <p>* Сильные царапины</p></button>
                </div>
            </div>
            <div class="cover_state">
                <div class="disabled-off disabled"></div>
                <p class="cover_state-question">Выберите состояние корпуса наиболее похож на ваш.</p>
                <div class="cover_state-option">
                    <button class="cover_state-option1"><img src="{{ asset('assets/img/calculator/cover_A.jpg') }}" alt=""><p>* Нет царапин</p></button>
                    <button class="cover_state-option2"><img src="{{ asset('assets/img/calculator/cover_B.jpg') }}" alt=""><p>* Едва заметные царапины</p></button>
                    <button class="cover_state-option3"><img src="{{ asset('assets/img/calculator/cover_C.jpg') }}" alt=""><p>* Достаточно заметные царапины</p></button>
                    <button class="cover_state-option4"><img src="{{ asset('assets/img/calculator/cover_D.jpg') }}" alt=""><p>* Сильные царапины</p></button>
                </div>
            </div>
        </div>
        <div class="right_block">
            <p class="sentence">Наше предложение</p>
            <div class="phone_cost">
                <!-- <p class="phone_cost-text">Вартість</p> -->
                <p class="phone_cost-change_cost">0</p>
                <div class="get_offers_btn">
                    <div class="disabled-off-one disabled"></div>
                    <button class="get_offers-button" id="btn-offer">Регистрация обмена</button>
                </div>
            </div>
            <div class="get_offers">
                <p>В случае вопросов, обратитесь в службу поддержки партнеров</p>
            </div>
        </div>
    </div>
</section>
