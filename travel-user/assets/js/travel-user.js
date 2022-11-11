// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

let titlecard = document.querySelectorAll(".titlecard");
// let productSummary = document.querySelectorAll(".products-summary");



for (i=0;i<titlecard.length;i++) {
  titlecard[i].addEventListener("click",function(){
    this.nextElementSibling.classList.toggle("open");
  })
  }

let startDate = document.querySelectorAll(".start-date");
let price = document.querySelectorAll(".price");
let commentStar = document.querySelectorAll(".comment-star");


    
