<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Завод пластиковых окон</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <!-- Заголовок сайта с кнопками входа и регистрации -->
        <div class="container">
            <!-- Кнопки навигации по сайту -->
            <nav>
                <ul id="tabs">
                    <li><button id="home_btn" type="button" onclick="showPage('home', this)">Главная</button></li>
                    <li><button id="profile_btn" type="button" onclick="showPage('profiles', this)">Виды профиля</button></li>
                    <li><button id="types_btn" type="button" onclick="showPage('types', this)">Типы окон</button></li>
                    <li><button id="clients_btn" type="button" onclick="showPage('clients', this)">Клиенты</button></li>
                    <li><button id="orders_btn" type="button" onclick="showPage('orders', this)">Заказы</button></li>
                    <!-- <li><button id="payments_btn" type="button" onclick="showPage('payments', this)">Платежи</button></li> -->
                    <li><button id="dispatch_btn" type="button" onclick="showPage('shipping', this)">Отгрузки</button></li>
                </ul>
            </nav>
            <div id="right_log_in" class="right_log_in">
                <button type="button" id="login_btn">Войти</button>
                <button type="button" id="signup_btn">Регистрация</button>
            </div>
            <div id="user">
                <img type="button" id="accountIcon" src="img/labels/profile.png" alt="Profile icon">
            </div>
            <div id="popup" class="popup">
                <button type="button" id="cart_btn" onclick="showCart()">Корзина</button>
                <button type="button" id="quit_btn">Выйти</button>
            </div>
        </div>
    </header>

    <!-- Форма для входа -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Вход в аккаунт</h2>
          <form id="loginForm">

            <label for="username">Логин:</label>
            <div id="username_warn1" class="warning-message"></div>
            <input type="text" id="username" name="username">

            <label for="password">Пароль:</label>
            <div id="pass_warn1" class="warning-message"></div>
            <input type="password" id="password" name="password">
            <button type="button" class="toggle-password" onclick="togglePassword(this, 'password')">Показать</button>

            <button type="submit" id="login_btn2">Войти</button>
            <div id="submit_warn" class="submit_warn"></div>
          </form>
        </div>
    </div>
    <!-- Форма для регистрации -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
          <span class="close1">&times;</span>
          <h2>Регистрация</h2>
          <form id="signupForm">

            <label for="new_username">Логин:</label>
            <div id="username_warn2" class="warning-message"></div>
            <input type="text" id="new_username" name="new_username">

            <label for="new_full_name">ФИО:</label>
            <div id="full_name_warn" class="warning-message"></div>
            <input type="text" id="new_full_name" name="new_full_name">

            <label for="new_rh">Резус фактор:</label>
            <div id="rh_warn" class="warning-message"></div>
            <div id="new_rh" required>
                <button type="button" id="new_pos">Положительный</button>
                <button type="button" id="new_neg">Отрицательный</button>
            </div>

            <label for="new_password">Пароль:</label>
            <div id="pass_warn2" class="warning-message"></div>
            <input type="password" id="new_password" name="new_password">
            <button type="button" class="toggle-password" onclick="togglePassword(this, 'new_password')">Показать</button>

            <button type="submit" id="signup_btn2">Зарегистрироваться</button>
            <div id="submit_warn2" class="submit_warn"></div>
          </form>
        </div>
    </div>

    <div id="cart" class="page">
        <div class="proudct">
            <section class="cart-items"></section>
        </div>

        <div id="confirm-purch">
            <label for="tr_companies">Выберите транспортную компанию:</label>
            <select id="tr_companies" name="tr_companies">
                <option value="1">DPD</option>
                <option value="2">CDEK</option>
                <option value="3">ПЭК</option>
                <option value="4">Деловые линии</option>
            </select>
            <button id="order_btn" type="button">Заказать</button>
            <p id="total-price">Итого: 0₽</p>
        </div>
    </div>

    <!-- Домашняя вкладка -->
    <div id="home" class="page active">
        <div class="index_image_container">
            <img id="zavod_1" src="img/labels/zavod_1.svg" alt="" class="svg-image">
            <img id="rehau_label" src="img/labels/rehau_label.svg" alt="" class="svg-image">
            <img id="text_background" src="img/labels/text_background.png" alt="" class="svg-image">
            <img id="check" src="img/labels/check.svg" alt="" class="svg-image">
            <p id="certificate">Мы сертифицированный<br>
                партнёр ООО «Рехау»,<br>
                работаем по договору<br>
                и даём 5 лет гарантии<br>
                на установленные окна.</p>
        </div>
    </div>
    <!-- Вкладка видов профиля -->
    <div id="profiles" class="page">
        <section id="products">
            <div class="profile">
                <img src="img/profiles_img/profile_blitz.jpg" alt="Стандарт">
                <h3>Blitz</h3>
                <p class="desc">Пластиковые окна BLITZ – оптимальное решение для квартир, загородных и дачных домов по бюджетной цене. Надёжные окна относятся к классу систем с монтажной глубиной 60 мм, наиболее популярных в России.</p>
                <div class="price_cont">
                    <p class="price">7500₽</p>
                    <button type="button" class="add-to-cart" data-product-img="img/profiles_img/profile_blitz.jpg" data-product-id="1" data-product-name="Blitz" data-product-price="7500" data-product-weight="48">Добавить в корзину</button>
                </div>
            </div>

            <div class="profile">
                <img src="img/profiles_img/profile_constanta.jpg" alt="Сохраняет тепло">
                <h3>Constanta</h3>
                <p class="desc">Благодаря применению инновационных технологий удалось снизить теплопередачу профиля. Защитные свойства пластиковых окон подтверждены экспериментально и выдерживают до минус 40° С.</p>
                <div class="price_cont">
                    <p class="price">7900₽</p>
                    <button type="button" class="add-to-cart" data-product-img="img/profiles_img/profile_constanta.jpg" data-product-id="2" data-product-name="Constanta" data-product-price="7900" data-product-weight="53">Добавить в корзину</button>
                </div>
            </div>

            <div class="profile">
                <img src="img/profiles_img/profile_delight.jpg" alt="Пропускает больше дневного света">
                <h3>Delight</h3>
                <p class="desc">Cокращение высоты профильной конструкции позволяет впустить в помещение на 10% больше света без ущерба теплоизоляции. Два варианта: с классическими прямоугольными створками или с закруглёнными формами.</p>
                <div class="price_cont">
                    <p class="price">9430₽</p>
                    <button type="button" class="add-to-cart" data-product-img="img/profiles_img/profile_delight.jpg" data-product-id="3" data-product-name="Delight" data-product-price="9430" data-product-weight="63">Добавить в корзину</button>
                </div>
            </div>

            <div class="profile">
                <img src="img/profiles_img/profile_grazio.jpg" alt="Стандарт+">
                <h3>Grazio</h3>
                <p class="desc">Окна REHAU GRAZIO: теплые и стильные, хорошо защищают от шума и сквозняка, пропускают много света. Защитные свойства пластиковых окон подтверждены экспериментально и выдерживают до минус 40° С.</p>
                <div class="price_cont">
                    <p class="price">8370₽</p>
                    <button type="button" class="add-to-cart" data-product-img="img/profiles_img/profile_grazio.jpg" data-product-id="4" data-product-name="Grazio" data-product-price="8370" data-product-weight="58">Добавить в корзину</button>
                </div>
            </div>

            <div class="profile">
                <img src="img/profiles_img/profile_intelio.jpg" alt="Высокий этаж и сильный ветер">
                <h3>Intelio</h3>
                <p class="desc">Зимой защищают от теплопотерь, а летом – от избытков солнечного тепла. Такой результат достигается за счёт шести воздушных камер. Окна задерживают до 45 дБ, обеспечивая в помещении показатель в 30 дБ.</p>
                <div class="price_cont">
                    <p class="price">11610₽</p>
                    <button type="button" class="add-to-cart" data-product-img="img/profiles_img/profile_intelio.jpg" data-product-id="5" data-product-name="Intelio" data-product-price="11610" data-product-weight="68">Добавить в корзину</button>
                </div>
            </div>
        </section>
    </div>
    <!-- Вкладка типов окон -->
    <div id="types" class="page">
        <section id="types_section">
            <div class="type">
                <img src="img/types_img/type1.png" alt="Тип 1">
                <h3>Глухая створка</h3>
                <p>Самый экономичный и неудобный в использовании. Оно не открывается, откуда выливаются все основные недостатки: проблемы с помывкой и проветриванием помещения. Достоинство (за исключением цены) модели в том, что оно отличается максимальной надёжностью. Здесь нет сложных механизмов открытия, а значит нечему ломаться.</p>
            </div>

            <div class="type">
                <img src="img/types_img/type2.png" alt="Тип 2">
                <h3>Поворотная створка</h3>
                <p>Створки открываются в стандартном направлении: внутрь помещения, вправо или влево. Как упоминалось ранее, их количество может быть разным, например, все имеющиеся, одна или несколько.</p>
            </div>

            <div class="type">
                <img src="img/types_img/type3.png" alt="Тип 3">
                <h3>Раздвижная створка</h3>
                <p>Устанавливается преимущественно на балконах, лоджиях, террасах загородных домов, коттеджей. Классический пример раздвижных пластиковых конструкций – входные двери в магазины, ТЦ. Открытие осуществляется путём передвижения створки параллельно соседней. Движение выполняется по специальным направляющим, которые могут быть открытого или скрытого типа.</p>
            </div>

            <div class="type">
                <img src="img/types_img/type4.png" alt="Тип 4">
                <h3>Откидная створка</h3>
                <p>Этот тип обозначает, что проветривание помещения может осуществляться только путём откидывания верхней части створки внутрь помещения. Модель часто используется с целью снижения стоимости при заказе нескольких окон для одного помещения. Например, одно устанавливается поворотно-откидное, другое – только откидное. Разница фурнитуры скажется на итоговой цене окна.</p>
            </div>

            <div class="type">
                <img src="img/types_img/type5.png" alt="Тип 5">
                <h3>Подвесная створка</h3>
                <p>Чаще всего применяется при остеклении высотных, сложных по архитектурному стилю, зданий, спортивных сооружений, торговых комплексов. Стеклопакеты открываются только в вертикальной плоскости.</p>
            </div>
        </section>
    </div>
    <!-- Вкладка отзывов (клиентов) -->
    <div id="clients" class="page">
        <section id="section_feedback1">
            <div class="client">
                <h3>Василий</h3>
                <p>Отличное качество окон! Работой компании очень доволен. Окна установили быстро и качественно, и теперь в квартире гораздо теплее и тише. Спасибо за профессионализм!</p>
            </div>

            <div class="client">
                <h3>Николай</h3>
                <p>Рекомендую! Заказал окна в этой компании, и остался полностью доволен результатом. Быстрая доставка, установка без нареканий, и что самое главное — отличная тепло- и шумоизоляция!</p>
            </div>

            <div class="client">
                <h3>Светлана</h3>
                <p>Очень хорошая компания! Приятно работать с профессионалами. Окна стоят уже месяц — все как обещали, никаких проблем с ними нет. Качество на высоте!</p>
            </div>

            <div class="client">
                <h3>Владимир</h3>
                <p>Превосходное обслуживание! Замечательная компания с отличным сервисом. Установили окна точно в срок, монтажники работали аккуратно и быстро. Удивлен качеством — все идеально!</p>
            </div>

            <div class="client">
                <h3>Сергей</h3>
                <p>Потрясающая работа! Купил окна для дачи — заказ был выполнен точно в срок, установка прошла без проблем. Очень довольна качеством и результатом. Теперь моя дача стала комфортнее!</p>
            </div>
        </section>
        <section id="section_feedback2">
            <div class="client">
                <h3>Юрий</h3>
                <p>Отличная компания! Заказал окна для нового дома — все сделали быстро и качественно. Установили без задержек, а сами окна прекрасно держат тепло и не пропускают шум. Очень доволен!</p>
            </div>

            <div class="client">
                <h3>Анна</h3>
                <p>Рекомендую! Обслуживание на высшем уровне. Менеджеры вежливые и внимательные, всегда помогали с выбором. Окна отличного качества, монтаж прошел без проблем.</p>
            </div>

            <div class="client">
                <h3>Анастасия</h3>
                <p>Приятно работать с такими специалистами! Сделали заказ на установку пластиковых окон. Все прошло по плану: быстрый расчет, профессиональный монтаж. Результат на 100% соответствует ожиданиям!</p>
            </div>

            <div class="client">
                <h3>Инна</h3>
                <p>Очень довольна покупкой! Установили окна в квартиру, теперь в доме намного тише и теплее. Процесс установки занял всего пару часов. Качество отличное!</p>
            </div>

            <div class="client">
                <h3>Дмитрий</h3>
                <p>Быстро и качественно! Заказал окна в офис — качество материалов на высоте, а монтаж был выполнен в срок. Теперь помещение выглядит гораздо уютнее и светлее. Очень благодарен компании!</p>
            </div>
        </section>
        <section id="section_feedback3">
            <div class="client">
                <h3>Сергей</h3>
                <p>Очень довольны результатом! Заказывали окна в загородный дом. Установили быстро, без лишнего шума. Отличное качество и теплотехнические характеристики. Никаких жалоб!</p>
            </div>

            <div class="client">
                <h3>Игорь</h3>
                <p>Замечательная компания! Поставили окна на балкон, теперь это наше любимое место для отдыха. Ребята все сделали четко, без задержек и с заботой о деталях. Все идеально!</p>
            </div>

            <div class="client">
                <h3>Никита</h3>
                <p>Профессионализм на высоте! Установили окна в нашей квартире. От момента заказа до финальной установки прошло всего несколько дней. Качество на высшем уровне, никаких проблем не возникло.</p>
            </div>

            <div class="client">
                <h3>Иван</h3>
                <p>Рекомендую! Приятно работать с такими людьми. Все сделали быстро и качественно, а окна выглядят отлично. Заказ был выполнен в срок, и даже больше, чем я ожидал.</p>
            </div>

            <div class="client">
                <h3>Сергей</h3>
                <p>Прекрасная компания! Приехали, измерили, привезли и установили окна очень быстро. Вижу, что окна действительно высокого качества — в квартире стало заметно теплее и тише. Супер!</p>
            </div>
        </section>
    </div>
    <!-- Вкладка заказов -->
    <div id="orders" class="page">
        <p>Фильровать с </p>
        <input id="start_date" type="date">
        <p> по </p>
        <input id="end_date" type="date">
        <button type="button" onclick="load_orders_data()">Отфильровать</button>
        <div id="order_table">
            <p class="order_items">Наименования товаров:</p>
            <p class="order_tc">Транспортная компания</p>
            <p class="order_weight">Общий вес</p>
            <p class="order_price">Стоимость</p>
            <p class="order_time">Дата заказа</p>
        </div>
        <section class="order_list">
        </section>
    </div>
    <!-- Вкладка отгрузок -->
    <div id="shipping" class="page">
        <section class="shipping_list">
        </section>
    </div>



    <footer>
        <p>&copy; 2025 Завод пластиковых окон. Все права защищены.</p>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>


