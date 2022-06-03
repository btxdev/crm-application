const POPUP_TIME = 500;

// main
addEventListener('DOMContentLoaded', () => {

    document.querySelector('#windows')
        .addEventListener('click', (event) => {
            if(event.target.id == 'windows') {
                closePopup();
            }
        });

    getBasicInfo();
    updateCategories();
    updateItems();
    updateUsers();

});

function removeEventListenersFrom(element) {
    let clone = element.cloneNode(true);
    element.parentNode.replaceChild(clone, element);
}

// отправка данных на сервер, обработка ответа

const HEADERS = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
}

function sendData(args) {
    return new Promise((res) => {
        const method = 'method' in args ? args['method'] : 'POST';
        const headers = 'headers' in args ? args['headers'] : HEADERS;
        const body =  JSON.stringify(args['body']);
        const thenFunc = 'then' in args ? args['then'] : () => {};
        const catchFunc = 'catch' in args ? args['catch'] : () => {};
        fetch('php/app.php', {
            method: method,
            headers: headers,
            body: body
        })
        .then(response => response.text())
        .then(body => {
            console.log('raw response data:');
            console.log(body);
            try {
                return JSON.parse(body);
            }
            catch {
                throw Error(body);
            }
        })
        .then(data => {
            console.log('JSON response data:');
            console.log(data);
            if(data['status'] == 'OK') {
                thenFunc(data);
            }
            res(data);
        })
        .catch(catchFunc);
    })
}

// переключение вкладок
const openPage = page => {

    const pages = [
        ['categories', 'Категории'],
        ['items', 'Товары'],
        ['orders', 'Заказы'],
        ['users', 'Пользователи'],
        ['admin', 'Администрирование']
    ];

    // const pages = [
    //     ['categories', 'Категории'],
    //     ['items', 'Товары'],
    //     ['orders', 'Заказы']
    // ];

    // change aside button style
    const aside = document.querySelectorAll('aside')[0];
    const ul = aside.querySelectorAll('ul');
    for(i in pages) {
        let elem = pages[i][0] == 'admin'
            ? ul[1].querySelector('li')
            : ul[0].querySelectorAll('li')[i];

        if(page == pages[i][0]) elem.classList.add('aside-li_focused');
        else elem.classList.remove('aside-li_focused');
    }

    // hide all pages
    new Promise((resolve, reject) => {

        for(pageSet of pages) {
            try {
                let pageId = pageSet[0];
                document.getElementById('header-title').style.opacity = 0;
                document.getElementById(pageId).style.opacity = 0;
                setTimeout(() => {
                    document.getElementById(pageId).style.display = 'none';
                }, 200);
            }
            catch(exc) {
                console.log('error');
                console.log(exc);
            }
        }

        setTimeout(() => {
            resolve();
        }, 220)

    })

    .then(() => {

        // change title
        document.getElementById('header-title').innerHTML = pages.find(elem => elem[0] == page)[1];
        document.getElementById('header-title').style.opacity = 1;

        // show page
        document.getElementById(page).style.display = 'block';
        document.getElementById(page).style.opacity = 1;

    })

}

// всплывающие окна

const shadow = visible => {
    return new Promise((resolve, reject) => {
        let param = visible ? 'flex' : 'none';
        if(visible) {
            document.getElementById('windows').style.display = param;
            setTimeout(() => {
                document.getElementById('windows').style.opacity = 1;
            }, 10);
            setTimeout(() => {
                resolve();
            }, POPUP_TIME);
            
        }
        else {
            document.getElementById('windows').style.opacity = 0;
            setTimeout(() => {
                document.getElementById('windows').style.display = param;
                resolve();
            }, POPUP_TIME);
        }
    })
}

const popup = (id, visible) => {
    return new Promise((resolve, reject) => {
        let param = visible ? 'block' : 'none';
        if(visible) {
            document.getElementById(id).style.display = param;
            setTimeout(() => {
                document.getElementById(id).style.opacity = 1;
            }, 10);
            setTimeout(() => {
                resolve();
            }, POPUP_TIME);
        }
        else {
            document.getElementById(id).style.opacity = 0;
            setTimeout(() => {
                document.getElementById(id).style.display = param;
                resolve();
            }, POPUP_TIME);
        }
    });
}

let activePopup;

const openPopup = id => {
    activePopup = id;
    let p1 = shadow(true);
    let p2 = popup(id, true);
    return Promise.all([p1, p2]);
}

const closePopup = (id = activePopup) => {
    let p1 = shadow(false);
    let p2 = popup(id, false);
    return Promise.all([p1, p2]);
}

// изменение данных формы во всплывающем окне
function replacePopupData(type, id) {
    switch(type) {

        case 'categories':
            sendData({
                body: {
                    op: 'get_category_data',
                    id: id
                }
            })
            .then(response => {
                const $title = document.getElementById('input-editCategory-name');
                const $link = document.getElementById('input-editCategory-link');
                let $button = document.getElementById('btn-editCategory');
                const title = response['data']['title'];
                const link = response['data']['icon'];
                $title.value = title;
                $link.value = link;
                removeEventListenersFrom($button);
                $button = document.getElementById('btn-editCategory');
                $button.addEventListener('click', (e) => {
                    editCategoryForm(id);
                });
            })
            break;

        case 'items':
            sendData({
                body: {
                    op: 'get_item_data',
                    id: id
                }
            })
            .then(response => {

                const $title = document.getElementById('input-editItem-title');
                const $description = document.getElementById('input-editItem-description');
                const $link = document.getElementById('input-editItem-link');
                const $price = document.getElementById('input-editItem-price');
                const $count = document.getElementById('input-editItem-count');
                let $button = document.getElementById('btn-editItem');

                const title = response['data']['title'];
                const description = response['data']['description'];
                const link = response['data']['link'];
                const price = response['data']['price'];
                const count = response['data']['count'];

                $title.value = title;
                $description.value = description;
                $link.value = link;
                $price.value = price;
                $count.value = count;

                removeEventListenersFrom($button);
                $button = document.getElementById('btn-editItem');
                $button.addEventListener('click', (e) => {
                    editItemForm(id);
                });
            })
            break;

    }
}

// перезагрузка
function reload() {
    document.location.reload();
}

// выход из системы
function logout() {
    fetch('php/auth.php', {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            op: 'logout'
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data['status'] == 'OK') reload();
        else {
            console.log(data);
            alert(data['msg']);
        }
    })
}

// получение данных текущей сессии

function getBasicInfo() {
    fetch('php/app.php', {
        method: 'POST',
        headers: HEADERS,
        body: JSON.stringify({
            op: 'basic_info'
        })
    })
    .then(response => response.text())
    .then(body => {
        try {
            return JSON.parse(body);
        }
        catch {
            throw Error(body);
        }
    })
    .then(data => {
        console.log(data);
        if(data['status'] == 'OK') {
            document.querySelector('#header-username')
                .innerHTML = data['username'];
            document.querySelector('#header-name')
                .innerHTML = data['first_name'] + ' ' 
                + data['second_name'];
        }
    })
    .catch(console.error);
}

// категории

function updateCategories() {
    sendData({
        body: {
            op: 'get_categories'
        }
    })
    .then(response => {
        const items = response['categories'];
        const $table = document.getElementById('categories-table');
        let content = `
            <tr class="employees-table__title-row">
                    <td style="width: 20px;"><div class="title">#</div></td>
                    <td class="td-wide"><div class="title">Наименование категории</div></td>
                    <td style="width: 100px;"><div class="title"></div></td>
                    <td style="width: 100px;"><div class="title"></div></td>
            </tr>
            `;
        for(item of items) {
            content += `
                <tr>
                    <td style="width: 20px;"><div class="field">${item['id']}</div></td>
                    <td class="td-wide"><div class="field">${item['title']}</div></td>
                    <td style="width: 160px;"><button onclick="openPopup('popup-category-edit'); replacePopupData('categories', '${item['id']}')">Редактировать</button></td>
                    <td style="width: 100px;"><button class="table-btn__remove" onclick="removeCategory('${item['id']}');">Удалить</button></td>
                </tr>
                `;
        }
        $table.innerHTML = content;
    })
}

function addCategory(title, link) {
    return new Promise((resolve, reject) => {
        sendData({
            body: {
                op: 'add_category',
                title: title,
                link: link
            }
        })
        .then(() => { resolve(); })
        .catch(() => { reject(); })
    })
}

function addCategoryForm() {
    const $title = document.getElementById('input-addCategory-name');
    const $link = document.getElementById('input-addCategory-link');
    let title = $title.value;
    let link = $link.value;
    addCategory(title, link)
    .then(() => {
        closePopup();
        updateCategories();
    })
    .catch((err) => {
        console.log(err);
    })
}

function removeCategory(id) {
    sendData({
        body: {
            op: 'remove_category',
            id: id
        }
    })
    .then(() => {
        updateCategories();
    })
}

function editCategory(id, title, link) {
    sendData({
        body: {
            op: 'edit_category',
            id: id,
            title: title,
            link: link
        }
    })
    .then(() => {
        closePopup();
        updateCategories();
    })
}

function editCategoryForm(id) {
    console.log(id);
    const title = document.getElementById('input-editCategory-name').value;
    const link = document.getElementById('input-editCategory-link').value;
    editCategory(id, title, link);
}

// товары

function updateItems() {
    sendData({
        body: {
            op: 'get_items'
        }
    })
    .then(response => {
        const items = response['items'];
        const $table = document.getElementById('items-table');
        let content = `
            <tr class="employees-table__title-row">
                    <td style="width: 20px;"><div class="title">#</div></td>
                    <td class="td-wide"><div class="title">Наименование товара</div></td>
                    <td><div class="title">Стоимость</div></td>
                    <td><div class="title">Количество</div></td>
                    <td style="width: 160px;"><div class="title"></div></td>
                    <td style="width: 100px;"><div class="title"></div></td>
            </tr>
            `;
        for(item of items) {
            content += `
                <tr>
                    <td style="width: 20px;"><div class="field">${item['id']}</div></td>
                    <td class="td-wide"><div class="field">${item['title']}</div></td>
                    <td><div class="field">${item['price']} руб.</div></td>
                    <td><div class="field">${item['count']} шт.</div></td>
                    <td style="width: 160px;"><button onclick="openPopup('popup-item-edit'); replacePopupData('items', '${item['id']}');">Редактировать</button></td>
                    <td style="width: 100px;"><button class="table-btn__remove" onclick="removeItem('${item['id']}');">Удалить</button></td>
                </tr>
                `;
        }
        $table.innerHTML = content;
    })
}

function addItem(title, description, link, price, count) {
    console.log(title, description, link, price, count)
    return new Promise((resolve, reject) => {
        sendData({
            body: {
                op: 'add_item',
                title: title,
                description: description,
                link: link,
                price: price,
                count: count
            }
        })
        .then(() => { resolve(); })
        .catch(() => { reject(); })
    })
}

function addItemForm() {
    const $title = document.getElementById('input-addItem-title');
    const $description = document.getElementById('input-addItem-description');
    const $link = document.getElementById('input-addItem-link');
    const $price = document.getElementById('input-addItem-price');
    const $count = document.getElementById('input-addItem-count');

    let title = $title.value;
    let description = $description.value;
    let link = $link.value;
    let price = $price.value;
    let count = $count.value;

    addItem(title, description, link, price, count)
    .then(() => {
        closePopup();
        updateItems();
    })
    .catch((err) => {
        console.log(err);
    })
}

function removeItem(id) {
    sendData({
        body: {
            op: 'remove_item',
            id: id
        }
    })
    .then(() => {
        updateItems();
    })
}

function editItem(id, title, description, link, price, count) {
    sendData({
        body: {
            op: 'edit_item',
            id: id,
            title: title,
            description: description,
            link: link,
            price: price,
            count: count
        }
    })
    .then(() => {
        closePopup();
        updateItems();
    })
}

function editItemForm(id) {
    const title = document.getElementById('input-editItem-title').value;
    const description = document.getElementById('input-editItem-description').value;
    const link = document.getElementById('input-editItem-link').value;
    const price = document.getElementById('input-editItem-price').value;
    const count = document.getElementById('input-editItem-count').value;
    editItem(id, title, description, link, price, count);
}

// пользователи

function updateUsers() {
    sendData({
        body: {
            op: 'get_users'
        }
    })
    .then(response => {
        console.log('users:');
        console.log(response);
        const users = response['msg'];
        console.log(users);
        const $table = document.getElementById('users-table');
        let content = `
            <tr class="employees-table__title-row">
                    <td style="width: 20px;"><div class="title">#</div></td>
                    <td><div class="title">Пользователь</div></td>
                    <td><div class="title">Имя</div></td>
                    <td><div class="title">Фамилия</div></td>
                    <td><div class="title">Отчество</div></td>
                    <td><div class="title">Телефон</div></td>
                    <td><div class="title">Почта</div></td>
                    <td><div class="title">Дата регистрации</div></td>
            </tr>
            `;
        for(user of users) {
            content += `
                <tr>
                    <td style="width: 20px;"><div class="field">${user['id']}</div></td>
                    <td><div class="field">${user['username']}</div></td>
                    <td><div class="field">${user['first_name']}</div></td>
                    <td><div class="field">${user['second_name']}</div></td>
                    <td><div class="field">${user['patronymic']}</div></td>
                    <td><div class="field">${user['phone']}</div></td>
                    <td><div class="field">${user['email']}</div></td>
                    <td><div class="field">${user['reg_date']}</div></td>
                </tr>
                `;
        }
        $table.innerHTML = content;
    })
}