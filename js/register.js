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
            res(data);
        })
        .catch(catchFunc);
    })
}

function registerForm() {
    const login = document.getElementById('register-login').value;
    const password = document.getElementById('register-password').value;
    const phone = document.getElementById('register-phone').value;
    sendData({
        body: {
            op: 'register',
            login: login,
            password: password,
            phone: phone
        },
        thenFunc: (data) => {
           //document.location.reload(); 
        },
        catchFunc: (err) => {
            console.log(err);
        }
    })
    .then(response => {

        //document.location.reload();
    })
}

document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', (event) => {
        event.preventDefault();
    })
})