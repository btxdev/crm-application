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
                thenFunc(data);
            }
            res(data);
        })
        .catch(catchFunc);
    })
}

function loginForm() {
    const login = document.getElementById('login-login').value;
    const password = document.getElementById('login-password').value;
    sendData({
        body: {
            op: 'login',
            login: login,
            password: password
        },
        catchFunc: (err) => {
            console.log(err);
        }
    })
    .then(response => {
        document.location.reload();
    })
}

document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', (event) => {
        if(event.target.id == 'login-btn') {
            console.log(event);
            event.preventDefault();
        }
        
    })
})