{
  let dateSelector = document.getElementById('date_selector');
  let showBtn = document.getElementById('show_products_btn');
  let errorLayout = document.getElementsByClassName('error_message')[0];
  let warehouseLayout = document.getElementsByClassName('warehouse_info')[0];
  let priceLayout = document.getElementsByClassName('price_label_info')[0];
  showBtn.addEventListener('click', (e) => {
    let selectedDate = dateSelector.value;
    errorLayout.innerText = '';
    warehouseLayout.innerHTML = '';
    fetch('/api.php?method=getWarehouse&date=' + selectedDate, {
      mode: "no-cors",
      headers: {
        'Accept': 'application/json; charset=UTF-8',
      },
      method: 'GET',
    }).then(response => response.json())
      .then(result => {
        switch (result.code) {
          case 200:
            console.log(result)
            priceLayout.innerText = `Наклеили сегодня этикетку на носки с числом: ${result.data.priceLabel}`;
            result.data.warehouse.forEach((elem)=>{
              warehouseLayout.innerHTML += `<div class="warehouse_elem">
                <div>${elem.name}</div>
                <div>Остаток: ${elem.quantity}</div>
                <div>Цена за шт: ${elem.price}</div>
              </div>`;
            })
            break;
          case 1:
            errorLayout.innerText = 'Невалидная дата';
            break;
          case 2:
            errorLayout.innerText = 'Ошибка сервера';
            break;
          default:
            errorLayout.innerText = 'Произошла неизвестная ошибка!';
        }
      })
  })
}