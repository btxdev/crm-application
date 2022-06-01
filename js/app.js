const categories = document.querySelectorAll('.aside__categories');

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.aside__categories').forEach(elem => {
    
    elem.addEventListener('click', (event) => {

      const path = event.currentTarget.dataset.path;
      document.querySelectorAll('.catalog__product-list').forEach(elem => {
        elem.classList.remove('catalog__product-list--active');
      });
      document.querySelector(`[data-target="${path}"]`).classList.add('catalog__product-list--active');
    });
    
  });
  
  
});
  document.addEventListener('click', (event) => {
    categories.forEach(elem => {
      elem.classList.remove('aside__categories--active');
    })
    document.querySelector(`[data-path="${event.target.dataset.path}"]`).classList.add('aside__categories--active');
});
