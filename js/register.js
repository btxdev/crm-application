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
        fetch('php/shop-auth.php', {
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
                //thenFunc(data);
                document.location.reload(); 
            }
            else {
                alert('Указанный пользователь уже существует');
            }
            res(data);
        })
        .catch(catchFunc);
    })
}

function registerForm() {
    // сбор данных
    const login = document.getElementById('register-login').value;
    const password = document.getElementById('register-password').value;
    const name1 = document.getElementById('register-name1').value;
    const name2 = document.getElementById('register-name2').value;
    const name3 = document.getElementById('register-name3').value;
    const phone = document.getElementById('register-phone').value;
    const email = document.getElementById('register-email').value;
    // валидация
    const p1 = validate(login);
    const p2 = validate(password);
    const p3 = validate(name1);
    const p4 = validate(name2);
    const p5 = validate(name3);
    const p6 = validate(phone);
    const p7 = validate(email);
    Promise.all([p1, p2, p3, p4, p5, p6, p7])
    .then(() => {
        sendData({
            body: {
                op: 'register',
                login: login,
                password: password,
                name1: name1,
                name2: name2,
                name3: name3,
                phone: phone,
                email: email
            },
            then: (data) => {
                console.log(data);
                //document.location.reload(); 
            },
            catch: (err) => {
                console.log(err);
            }
        })
    })
    .catch(() => {
        alert('Необходимо заполнить все поля!')
    })

}

// валидация данных формы
function validate(field) {
    return new Promise((resolve, reject) => {
        if(field) resolve();
        else reject();
    })
}

document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', (event) => {
        event.preventDefault();
    })
})