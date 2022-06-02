const HEADERS = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
}


function sendData(args) {
    return new Promise((res, rej) => {
        const method = 'method' in args ? args['method'] : 'POST';
        const headers = 'headers' in args ? args['headers'] : HEADERS;
        const body =  JSON.stringify(args['body']);
        const thenFunc = 'then' in args ? args['then'] : () => {};
        const catchFunc = 'catch' in args ? args['catch'] : () => {};
        fetch('php/shop.php', {
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
            else {
              catchFunc(data);
            }
            res(data);
        })
        .catch(catchFunc);
    })
}

function setAnimation() {

  const categories = document.querySelectorAll('.aside__categories');

  document.querySelectorAll('.aside__categories').forEach(elem => {
    elem.addEventListener('click', (event) => {
      const path = event.currentTarget.dataset.path;
      document.querySelectorAll('.catalog__product-list').forEach(elem => {
        elem.classList.remove('catalog__product-list--active');
      });
      document.querySelector(`[data-target="${path}"]`).classList.add('catalog__product-list--active');
    });
  });

  document.addEventListener('click', (event) => {
    categories.forEach(elem => {
      elem.classList.remove('aside__categories--active');
    })
    document.querySelector(`[data-path="${event.target.dataset.path}"]`).classList.add('aside__categories--active');
  });

}

document.addEventListener('DOMContentLoaded', () => {

  getCats();
  getBasketPrice();

});



function getCats() {

    sendData({
        body: {
            op: 'get_cats_items'
        },
        catchFunc: (err) => {
            console.log(err);
        }
    })
    .then(serverData => {
      let html = '';
      let first = 'aside__categories--active';
      let first2 = 'catalog__product-list--active';
      let catalog = '';
      for(categoryDataId in serverData) {
        const categoryData = serverData[categoryDataId];
        let category;
        for(itemDataId in categoryData) { const itemData = serverData[categoryDataId][itemDataId]; category = itemData['cat_data']; break; }

        catalog += `<ul class="catalog__product-list ${first2}" data-target="cat${category['category_id']}">`;
        catalog += `<h3 class="catalog__product-title">${category['title']}</h3>`;

        for(itemDataId in categoryData) {
          const itemData = serverData[categoryDataId][itemDataId];
          const item = itemData['item_data'];

          console.log(category);
          console.log(item);

          let hasItem = item['count'] > 0;
          let itemMsg = hasItem ? `В наличии, ${item['count']} шт.` : 'Нет в наличии';
          let hasItemClass = hasItem ? '' : 'not-availability';
          let basketDisabled = hasItem ? '' : 'basket-disabled';
          let func = hasItem ? `onclick="addItemToBasket(${item['item_id']}, this, ${item['price']});"` : '';
          
          catalog += `
            <li class="catalog__product-item">
              <a class="catalog__product-image" href="catalog-product">
                <img src="img/${item['image']}" alt="Ардуино" width="110" height="80">
              </a>
              <div class="catalog__product-descr card">
                <a class="card__title" href="catalog-product">${item['title']}</a>
                <p class="card__descr">${item['description']}</p>
                <span class="card__id">Код товара: ${item['item_id']}</span>
                <span class="card__availability ${hasItemClass}">${itemMsg}</span>
              </div>
              <div class="catalog__product-price price-wrapper">
                <span class="price-text price-disabled">${item['price']} ₽</span>
                <button class="price-basket ${basketDisabled}" ${func}>В корзину</button>
              </div>
            </li>
          `;
        }

        catalog += '</ul>';

        html += `
            <a class="aside__categories ${first}" data-path="cat${category['category_id']}">
              <img class="aside__categories-image" src="img/${category['icon']}" alt="kits" width="25" height="25" data-path="cat${category['category_id']}">
              <span class="aside__categories-text" data-path="cat${category['category_id']}">${category['title']}</span>
            </a>
        `;

        first = '';
        first2 = '';


      }
      document.getElementById('categories').innerHTML = html;
      document.getElementById('catalog').innerHTML = catalog;
      setAnimation();
    })

}

function addItemToBasket(id, elem, price) {
  // if(typeof elem != 'undefined') {
  //   //elem.classList.add('basket-disabled');
  //   //elem.removeAttribute('onclick');
  // }
  

  sendData({
      body: {
          op: 'add_item_to_basket',
          id: id
      },
      catch: (err) => {
          console.log(err);
          alert('Товар уже добавлен');
      }
  })
  .then(() => {
    if(typeof price != 'undefined') {
      let basketTotal = Number(document.getElementById('basket-total').innerHTML);
      document.getElementById('basket-total').innerHTML = basketTotal + price;
    }
    alert('Товар добавлен в корзину');
  })
}

function getBasketPrice() {
  sendData({
      body: {
          op: 'get_basket_price'
      },
      catch: (err) => {
          console.log(err);
      }
  })
  .then((serverData) => {
    document.getElementById('basket-total').innerHTML = serverData['price']; 
    $elem = document.getElementById('basket-page-total-price');
    if($elem) {
      $elem.innerHTML = serverData['price'] + ' ₽';
    }
  })
}
