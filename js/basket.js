function getItemsInBasket() {
  sendData({
      body: {
          op: 'get_basket_items'
      },
      catch: (err) => {
          console.log(err);
      }
  })
  .then((serverData) => {
    console.log('basket:');
    console.log(serverData);

    $elem = document.getElementById('basket-items-container');
    let content = '';

    const items = serverData['items'];
    for(item of items) {
    content += `
        <div class="basket__product-item">
        <span class="basket__product-item__id">#${item['item_id']}</span>
        <div class="basket__product-item__image-wrap">
            <img class="basket__product-item__image" src="img/${item['image']}" alt="${item['title']}" width="45" height="45">
        </div>
        <a class="basket__product-item__title">${item['title']}</a>
        <span class="basket__product-item__price">${item['price']} ₽</span>
        <!--<div class="basket__product-item__count">
            <div class="count-minus count-wrap">-</div>
            <input class="count-input" type="text" value="1">
            <div class="count-plus count-wrap">+</div>
        </div>-->
        <span class="basket__product-item__price-total">${item['price']} ₽</span>
        <div class="basket__product-item__delete">x</div>
        </div>
    `;
    }

    $elem.innerHTML = content;

  })
}

function removeItemFromOrder(id) {
  sendData({
      body: {
          op: 'remove_item_from_basket',
          id: id
      },
      catch: (err) => {
          console.log(err);
      }
  })
  .then(() => {
    document.location.reload();
  })
}

document.addEventListener('DOMContentLoaded', () => {

  getItemsInBasket();

});