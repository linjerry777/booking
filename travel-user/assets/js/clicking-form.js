let updateButton = document.querySelector('.Ubtn');
let deleteButton = document.querySelector('.Dbtn')

let priceForm = document.querySelector('.price');
let startDateForm = document.querySelector('.start-date');
let endDateForm = document.querySelector('.end-date');
let guideForm = document.querySelector('.guide');
let locationForm = document.querySelector('.location');
let descriptionForm = document.querySelector('.description');

function showTheForm () {
    priceForm.innerHTML = '價格：<input type="text"></input>';
}
function resetTheForm () {
    priceForm.innerHTML = `價格:+${phpPrice}`;
}
updateButton.addEventListener('click',showTheForm);
deleteButton.addEventListener('click',resetTheForm);





