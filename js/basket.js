function getItemsInBasket() {
  sendData({
    body: {
      op: 'get_basket_items',
    },
    catch: (err) => {
      document.getElementById('basket-items-container').innerHTML = '';
      console.log(err);
    },
  }).then((serverData) => {
    console.log('basket:');
    console.log(serverData);

    $elem = document.getElementById('basket-items-container');
    $elem.innerHTML = '';
    let content = '';

    const items = serverData['items'];
    if (!items) return;
    for (item of items) {
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
        <div class="basket__product-item__delete" onclick="removeItemFromOrder(${item['item_id']});">x</div>
        </div>
    `;
    }

    $elem.innerHTML = content;
  });
}

function getOrders() {
  sendData({
    body: {
      op: 'get_orders',
    },
    catch: (err) => {
      document.getElementById('orders-container').innerHTML = '';
      console.log(err);
    },
  }).then((serverData) => {
    console.log('orders:');
    console.log(serverData);

    $elem = document.getElementById('orders-container');
    $elem.innerHTML = '';
    let content = '';

    const items = serverData['data'];
    for (item of items) {
      let status = item['status'] == 'wait' ? 'В обработке' : 'Готов к выдаче';
      let className =
        item['status'] == 'wait' ? ' order-wait' : ' order-complete';
      content += `
        <div class="basket__product-item ${className}">
          <span class="basket__product-item__id" style="display: inline-block; width: 40px;">${item['id']}</span>
          <a class="basket__product-item__title" style="display: inline-block; width: 800px;">${item['description']}</a>
          <span class="basket__product-item__price" style="display: inline-block; width: 100px;">${status}</span>
          <span class="basket__product-item__price-total" style="display: inline-block; width: 80px;">${item['price']} ₽</span>
        </div>
    `;
    }

    $elem.innerHTML = content;
  });
}

function removeItemFromOrder(id) {
  sendData({
    body: {
      op: 'remove_item_from_basket',
      id: id,
    },
    catch: (err) => {
      console.log(err);
    },
  }).then(() => {
    document.location.reload();
  });
}

document.addEventListener('DOMContentLoaded', () => {
  getItemsInBasket();
  getOrders();
});
