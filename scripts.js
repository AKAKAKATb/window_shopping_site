const loginModal = document.getElementById("loginModal");
const signupModal = document.getElementById("signupModal");
const closeModal = document.getElementsByClassName("close")[0];
const closeModal1 = document.getElementsByClassName("close1")[0];
const popup = document.getElementById('popup');
let cart = [];

// Открытие модального окна при нажатии на кнопку
document.getElementById("login_btn").onclick = function() {
    loginModal.style.display = "block";
}
document.getElementById("signup_btn").onclick = function() {
    signupModal.style.display = "block";
}

// Закрытие модального окна при нажатии на кнопку закрытия
closeModal.onclick = function() {
    loginModal.style.display = "none";
    clearLogin();
}
closeModal1.onclick = function() {
    signupModal.style.display = "none";
    clearSignup();
}

// Закрытие модального окна при клике вне области окна
window.onclick = function(event) {
    if (event.target == loginModal) {
        loginModal.style.display = "none";
        clearLogin();
    }
    else if(event.target == signupModal){
        signupModal.style.display = "none";
        clearSignup();
    } else if(event.target == popup){
        popup.style.display = "none";
    }
}

function clearLogin(){
    document.getElementById("username").value = '';
    document.getElementById("password").value = '';
}

function clearSignup(){
    document.getElementById("new_username").value = '';
    document.getElementById("new_full_name").value = '';
    document.getElementById("new_password").value = '';
    new_neg.classList.remove('active');
    new_pos.classList.remove('active');
}

document.getElementById('accountIcon').addEventListener('click', function() {
     const rect = document.getElementById('accountIcon').getBoundingClientRect();

     // Позиционируем окно под кнопкой
     popup.style.left = `${rect.left - 125}px`;
     popup.style.top = `${rect.top - 10}px`; // Сдвигаем вниз от кнопки

     // Показываем окно
     popup.style.display = 'flex';
 });

window.addEventListener('click', function(event) {
    // Проверяем, был ли клик вне модального окна
    if (!popup.contains(event.target) && !document.getElementById('accountIcon').contains(event.target)) {
        popup.style.display = 'none'; // Закрыть модальное окно
    }
});

window.onload = function(){
    document.getElementById('home_btn').classList.add('active-btn');

    if(getCookie('username') !== null && getCookie('password') !== null){
        fetch('login.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({   
                username: getCookie('username'), 
                password: getCookie('password')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                alert(data.message); // выводим сообщение об ошибке
            } else {
                //alert(data.message);
                hideAuth();
            }
        })
        .catch(error => console.error('Ошибка:', error));
    }
    showPage(getCookie('page'), document.getElementById(getCookie('button')));
}

function getCookie(cookieName) {
    const cookies = document.cookie.split('; ');
    // Пройдемся по всем cookies и ищем нужную
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const [name, value] = cookie.split('=');

        if (name === cookieName) {
            return decodeURIComponent(value); // Декодируем значение, если оно закодировано
        }
    }
    return null; // Если cookie не найдена
}

document.getElementById('quit_btn').addEventListener('click', function() {
    fetch('logout.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            //alert(data.message); 
            document.getElementById('right_log_in').style.display = 'flex';
            document.getElementById('user').style.display = 'none';
            load_orders_data();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Ошибка:', error));
    window.location.reload();
    popup.style.display = 'none';
    console.log('cart до очистки - '. cart);
    cart = [];
    console.log('cart после очистки - '. cart);
    document.querySelector('.cart-items').innerHTML = '';
    document.getElementById('total-price').textContent = `Итого: 0₽`;
});



document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем стандартное отправление формы
    
    if (document.getElementById('username').value !== '' && document.getElementById('password').value !== ''){
        // Отправляем данные через fetch
        fetch('login.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({   
                username: document.getElementById('username').value, 
                password: document.getElementById('password').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                alert(data.message); // выводим сообщение об ошибке
            } else {
                loginModal.style.display = "none";
                clearLogin();
                hideAuth();
                load_orders_data();
                //alert(data.message);
            }
        })
        .catch(error => console.error('Ошибка:', error));
    } else {
        alert("Введите все данные!");
    }
});

function hideAuth (){
    document.getElementById('right_log_in').style.display = 'none';
    document.getElementById('user').style.display = 'flex';
}

document.getElementById("username").addEventListener("input", function() {
    const username = this.value;
    const warningMessage = document.getElementById("username_warn1");

    // Если пароль не соответствует требованиям, показываем предупреждение
    if (validateUsername1(username) !== "подходит!") {
        warningMessage.textContent = validateUsername1(username);
        warningMessage.style.display = "block"; // Показываем предупреждение
    } else {
        // Если пароль подходит
        warningMessage.style.display = "none"; // Скрываем предупреждение
    }
});

function validateUsername1(username) {
    if (/[А-Яа-я]/.test(username)) {
        return "Логин не может содержать кирилицу.";
    }
    return "подходит!";
}

document.getElementById("password").addEventListener("input", function() {
    const password = this.value;
    const warningMessage = document.getElementById("pass_warn1");

    // Если пароль не соответствует требованиям, показываем предупреждение
    if (validatePassword1(password) !== "подходит!") {
        warningMessage.textContent = validatePassword1(password);
        warningMessage.style.display = "block"; // Показываем предупреждение
    } else {
        // Если пароль подходит
        warningMessage.style.display = "none"; // Скрываем предупреждение
    }
});

function validatePassword1(password) {
    if (/[А-Яа-я]/.test(password)) {
        return "Пароль не может содержать кирилицу.";
    }
    return "подходит!";
}


document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault();

    new_username = document.getElementById('new_username').value;
    new_full_name = document.getElementById('new_full_name').value;
    new_password = document.getElementById('new_password').value;

    let warningMessages = document.getElementById("signupForm").getElementsByClassName("warning-message");
    let allHidden = true; // Переменная для отслеживания состояния всех элементов

    if(!document.getElementById("new_pos").classList.contains("active") && !document.getElementById("new_neg").classList.contains("active")){
        document.getElementById("rh_warn").style.display = "block";
        document.getElementById("rh_warn").textContent = "Выберите резус фактор.";
    }

    for (let i = 0; i < warningMessages.length; i++) {
        if (warningMessages[i].style.display !== "none") {
            allHidden = false; // Если хотя бы один элемент не скрыт
            break;
        }
    }

    if(allHidden && new_username !== '' && new_full_name !== '' && new_password !== ''){
        fetch('signup.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({   
                new_username: new_username, 
                new_full_name: new_full_name, 
                new_password: new_password,
                new_rh: new_rh
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                alert(data.message); // выводим сообщение об ошибке
            } else {
                alert(data.message);
                signupModal.style.display = "none";
                clearSignup();
                hideAuth ();
            }
        });
    } else{
        document.getElementById("submit_warn2").style.display = "block";
        document.getElementById("submit_warn2").textContent = "Заполните все данные.";
    }
});

function checkSignup(){
    let warningMessages = document.getElementById("signupForm").getElementsByClassName("warning-message");
    let allHidden = true; // Переменная для отслеживания состояния всех элементов

    if(document.getElementById("new_pos").classList.contains("active") || document.getElementById("new_neg").classList.contains("active")){
        for (let i = 0; i < warningMessages.length; i++) {
            if (warningMessages[i].style.display !== "none") {
                allHidden = false; // Если хотя бы один элемент не скрыт
                break;
            }
        }
    }

    if(allHidden){
        document.getElementById("submit_warn2").style.display = "none";
    }
}

document.getElementById("new_password").addEventListener("input", function() {
    const password = this.value;
    const warningMessage = document.getElementById("pass_warn2");

    // Если пароль не соответствует требованиям, показываем предупреждение
    if (validatePassword(password) !== "Пароль подходит!") {
        warningMessage.textContent = validatePassword(password);
        warningMessage.style.display = "block"; // Показываем предупреждение
    } else {
        // Если пароль подходит
        warningMessage.style.display = "none"; // Скрываем предупреждение
        checkSignup();
    }
});

function validatePassword(password) {
    if (/[ ]/.test(password)) {
        return "Пароль не должен содержать пробелов.";
    }
    if (password.length < 8) {
        return "Пароль должен содержать минимум 8 символов.";
    }
    if (!/[A-Za-z]/.test(password)) {
        return "Пароль должен содержать только латиницу.";
    }
    if (!/[0-9]/.test(password)) {
        return "Пароль должен содержать хотя бы одну цифру.";
    }
    return "Пароль подходит!";
}

document.getElementById("new_username").addEventListener("input", function() {
    const username = this.value;
    const warningMessage = document.getElementById("username_warn2");

    // Если пароль не соответствует требованиям, показываем предупреждение
    if (validateUsername(username) !== "Пароль подходит!") {
        warningMessage.textContent = validateUsername(username);
        warningMessage.style.display = "block"; // Показываем предупреждение
    } else {
        // Если пароль подходит
        warningMessage.style.display = "none"; // Скрываем предупреждение
        checkSignup();
    }
});

function validateUsername(username) {
    if (/[ ]/.test(username)) {
        return "Логин не должен содержать пробелов.";
    }
    if (username.length < 4) {
        return "Логин должен содержать минимум 4 символа.";
    }
    if (!/^[A-Za-z0-9_-]+$/.test(username)) {
        return "Логин может содержать только латинские буквы, цифры, дефисы и подчеркивания.";
    }
    return "Пароль подходит!";
}

document.getElementById("new_full_name").addEventListener("input", function() {
    let full_name = this.value.trim(); // Убираем начальные и конечные пробелы
    const warningMessage = document.getElementById("full_name_warn");

    // Исправляем лишние пробелы внутри строки
    full_name = full_name.replace(/\s+/g, ' '); // Заменяем все подряд идущие пробелы на один

    // Валидация и автоматическое преобразование
    const validatedName = validateFullname(full_name);

    if (validatedName === "ФИО может содержать только кириллицу" || validatedName === "Напишите ФИО полностью") {
        warningMessage.textContent = validatedName;
        warningMessage.style.display = "block"; // Показываем предупреждение
    } else {
        // Если ФИО прошло валидацию, скрываем предупреждение и обновляем поле ввода
        warningMessage.style.display = "none"; // Скрываем предупреждение
        this.value = validatedName; // Автоматически обновляем значение поля
        checkSignup();
    }
});

function validateFullname(full_name) {
    // Проверка на кириллицу
    if (!/^[А-Яа-я ]+$/.test(full_name)) {
        return "ФИО может содержать только кириллицу";
    }
    
    // Проверка на наличие хотя бы одного пробела (два слова)
    if (full_name.split(' ').length < 3) {
        return "Напишите ФИО полностью";
    }

    // Разделяем ФИО на части по пробелам
    const parts = full_name.split(' ');

    // Проходим по каждой части и делаем первую букву заглавной, остальные — строчными
    const capitalizedParts = parts.map(part => {
        return part.charAt(0).toUpperCase() + part.slice(1).toLowerCase();
    });

    // Собираем ФИО обратно
    return capitalizedParts.join(' ');
}

document.getElementById('order_btn').addEventListener('click', function(){

    if(cart.length === 0){
        alert('Добавьте товары в корзину для заказа!');
    } else {
        let simplifiedCart = cart.map(
            ({ id, name, weight, quantity }) => 
            ({ id, name, weight, quantity })
        );

        fetch('order.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ 
                cart: simplifiedCart,
                username: getCookie('username'), 
                id_tc: document.getElementById('tr_companies').value,
                price: cart.reduce((total, item) => total + item['price']*item.quantity, 0)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                alert(data.message); // выводим сообщение об ошибке
            } else {
                alert(data.message);
                cart = [];
                document.querySelector('.cart-items').innerHTML = '';
                document.getElementById('total-price').textContent = `Итого: 0₽`;
            }
        })
        .catch(error => console.error('Ошибка:', error));
    }
})

document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        if(getCookie('username') == null){
            alert('Войдите в аккаунт, чтобы совершать заказы')
        } else {
            const productImg = this.dataset.productImg;
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = this.dataset.productPrice;
            const productWeight =  this.dataset.productWeight;

            // Добавляем товар в корзину
            // Проверяем, есть ли товар в корзине
            const existingProduct = cart.find(item => item.id === productId);

            if (existingProduct) {
                // Если товар уже в корзине, увеличиваем количество
                existingProduct.quantity += 1;
            } else {
                // Если товара нет, добавляем его в корзину
                cart.push({ img: productImg, id: productId, name: productName, price: productPrice, weight: productWeight, quantity: 1 });
            }
            // Обновляем корзину
            updateCart();
        }
    });
});

// Функция для обновления содержимого корзины
function updateCart() {
    const cartItemsSection = document.querySelector('.cart-items');
    
    // Очистим список товаров в корзине
    cartItemsSection.innerHTML = '';

    // Заполняем корзину товарами
    cart.forEach(item => {
        const prodElement = document.createElement('div');
        prodElement.classList.add('prod_element');

        // Заполняем новый элемент разметкой
        prodElement.innerHTML = `
            <img class="cart_img" src="${item.img}" alt="profile">
            <div class="cart_desc">
                <div class="name_n_amount">
                    <h3>${item.name}</h3>
                    <button type="button" onclick="decrease(this)" data-product-id="${item.id}" class="decrease_btn">-</button>
                    <input type="number" oninput="inputRestrict(this)" onblur="quantityValid(this)" class="quantity_inp" data-product-id="${item.id}" value="${item.quantity}">
                    <button type="button" onclick="increase(this)" data-product-id="${item.id}" class="increase_btn">+</button>
                </div>
                <div class="price_n_delete">
                    <p class="price">${item.price} ₽</p>
                    <button type="button" onclick="delete_prod(this)" data-product-id="${item.id}" class="delete_btn">Удалить</button>
                </div>
            </div>
        `;
        cartItemsSection.appendChild(prodElement);
    });

    document.querySelectorAll('.quantity_inp').forEach(item =>{
        inputRestrict(item);
    });
    // Выводим общую стоимость
    totalPrice('price');
}

function totalPrice(field){
    const totalPrice = cart.reduce((total, item) => total + item[field]*item.quantity, 0);
    document.getElementById('total-price').textContent = `Итого: ${totalPrice}₽`;
}

function decrease(btn){
    const productId = btn.dataset.productId;
    const existingProduct = cart.find(item => item.id === productId);
    if(existingProduct.quantity > 1){
        existingProduct.quantity--;

        let input = btn.closest('.name_n_amount').querySelector('.quantity_inp');

        input.value--;
        inputRestrict(input);
    }
    totalPrice('price');
}

function increase(btn){
    const productId = btn.dataset.productId;
    const existingProduct = cart.find(item => item.id === productId);

    existingProduct.quantity++;

    // Находим input внутри этого div
    let input = btn.closest('.name_n_amount').querySelector('.quantity_inp');

    input.value++;
    inputRestrict(input);
    totalPrice('price');
}

function quantityValid(input){
    const productId = input.dataset.productId;
    const existingProduct = cart.find(item => item.id === productId);
    

    let value = parseInt(input.value);

    // Проверяем, что введённое значение не меньше 1
    if (input.value === "" || isNaN(value) || value < 1) {
        input.value = 1;
        existingProduct.quantity = 1;
    } else {
        existingProduct.quantity = value;
    }
    totalPrice('price');
    inputRestrict(input);
    console.log(existingProduct);
}

function inputRestrict(input) {
    input.style.width = (input.value.length) + "ch";
}

function delete_prod(btn){
    let prod_element = btn.closest('.prod_element');
    prod_element.remove();

    let indexToRemove = cart.findIndex(item => item.id === btn.dataset.productId);
    cart.splice(indexToRemove, 1);  // Удаляем элемент по индексу

    totalPrice('price');
}

function load_orders_data(){
    if(getCookie('username') == null){
        const alert = `Войдите в аккаунт, чтобы просматривать доступную информацию`;
        const ordersItemsSection = document.querySelector('.order_list');
        ordersItemsSection.innerHTML = '';

        const shippingItemsSection = document.querySelector('.shipping_list');
        shippingItemsSection.innerHTML = '';

        const noauth_order = document.createElement('p');
        noauth_order.classList.add('noauth_notification');

        const noauth_ship = document.createElement('p');
        noauth_ship.classList.add('noauth_notification');

        // Заполняем новый элемент разметкой
        noauth_order.innerHTML = alert;
        noauth_ship.innerHTML = alert;

        ordersItemsSection.appendChild(noauth_order);
        shippingItemsSection.appendChild(noauth_ship);
    } else {
        fetch('get_order.php', {
            method: 'POST',
            headers:{'Content-Type': 'application/json'},
            body: JSON.stringify({   
                username: getCookie('username'),
                start: document.getElementById('start_date').value,
                end: document.getElementById('end_date').value
            })
        })
        .then(response=> response.json())
        .then(data => {
            update_orders(data);
        })
        .catch(error => console.error('Ошибка:', error));
    }
}

function update_orders(arr){
    const ordersItemsSection = document.querySelector('.order_list');
    ordersItemsSection.innerHTML = '';

    const shippingItemsSection = document.querySelector('.shipping_list');
    shippingItemsSection.innerHTML = '';
    var i = 1;

    arr.forEach(item => {
        const prodElement = document.createElement('div');
        prodElement.classList.add('order_desc');

        const shipElement = document.createElement('div');
        shipElement.classList.add('shipping_item');

        if(i == 16){
            i = 1;
        }

        // Заполняем новый элемент разметкой
        prodElement.innerHTML = `
            <p class="order_items">Заказ №${item.order_id}<br>${item.prods_name}</p>
            <p class="order_tc">${item.tc_name}</p>
            <p class="order_weight">${item.prods_weight}кг</p>
            <p class="order_price">${item.price}₽</p>
            <p class="order_time">${item.order_time}</p>
        `;

        shipElement.innerHTML = `
            <img class="image_item" src="get_image.php?id_image=${i}" alt="Фото товара">
            <p class="shipping_label"><b>Фотоотчет<br>отгрузки</b></p>
            <div class="detail_container">
                <p class="order_details"><b>Номер заказа:</b><br>№${item.order_id}<br><br><b>Время заказа:</b><br>${item.order_time}</p>
            </div>
        `;

        ordersItemsSection.appendChild(prodElement);
        shippingItemsSection.appendChild(shipElement);
        i++;
    });

    orders_amount = arr.length;
}

// Функция для отображения нужной страницы
function showPage(pageId, button) {
    // Скрыть все страницы
    document.cookie = "page=" + pageId + "; path=/";
    document.cookie = "button=" + button.id + "; path=/";

    if(pageId == 'orders' || pageId == 'shipping'){
        load_orders_data();
    }

    let pages = document.querySelectorAll('.page');
    pages.forEach(function(page) {
        page.classList.remove('active');
    });
    document.getElementById("cart").style.display = 'none';

    // Показать нужную страницу
    let page = document.getElementById(pageId);
    page.classList.add('active');

    // Сбросить стили для всех кнопок
    let buttons = document.querySelectorAll('button');
    buttons.forEach(function(btn) {
        btn.classList.remove('active-btn');
    });

    // Добавить стиль к текущей кнопке
    button.classList.add('active-btn');
}

function showCart(){
    let pages = document.querySelectorAll('.page');
    pages.forEach(function(page) {
        page.classList.remove('active');
    });
    document.getElementById("cart").style.display = 'flex';
    document.getElementById("cart").classList.add('active');

    let buttons = document.querySelectorAll('button');
    buttons.forEach(function(btn) {
        btn.classList.remove('active-btn');
    });
    popup.style.display = 'none';
}

function togglePassword(btn, input_id) {
    const passwordField = document.getElementById(input_id);

    if (passwordField.type === 'password') {
        passwordField.type = 'text';  // Показываем пароль
        btn.textContent = 'Скрыть';  // Меняем текст кнопки
    } else {
        passwordField.type = 'password';  // Скрываем пароль
        btn.textContent = 'Показать';  // Меняем текст кнопки
    }
}

new_pos = document.getElementById('new_pos');
new_neg = document.getElementById('new_neg');

new_pos.addEventListener('click', function() {
    document.getElementById("rh_warn").style.display = 'none';
    checkSignup();
    new_rh = 1;
    new_pos.classList.add('active');
    new_neg.classList.remove('active');
});

new_neg.addEventListener('click', function() {
    document.getElementById("rh_warn").style.display = 'none';
    checkSignup();
    new_rh = 0;
    new_neg.classList.add('active');
    new_pos.classList.remove('active');
});