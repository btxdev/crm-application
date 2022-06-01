const POPUP_TIME = 500;

const openPage = page => {

    const pages = [
        ['employees', 'Сотрудники'],
        ['services', 'Услуги'],
        ['contracts', 'Договоры'],
        ['deals', 'Сделки'],
        ['apartments', 'Недвижимость'],
        ['clients', 'Клиенты'],
        ['admin', 'Администрирование']
    ];

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
            let pageId = pageSet[0];
            document.getElementById('header-title').style.opacity = 0;
            document.getElementById(pageId).style.opacity = 0;
            setTimeout(() => {
                document.getElementById(pageId).style.display = 'none';
            }, 200);
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

function reload() {
    document.location.reload();
}

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

const HEADERS = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
}

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

addEventListener('DOMContentLoaded', () => {

    document.querySelector('#windows')
        .addEventListener('click', (event) => {
            if(event.target.id == 'windows') {
                closePopup();
            }
        });

    getBasicInfo();

});