
//寫在js檔案裡 讀不到 php變數
if(window.matchMedia("(max-width:1260px)").matches) {
for (i=0;i<titlecard.length;i++) {
startDate[i].innerHTML='<ion-icon name="calendar-outline"></ion-icon><span><?=$product["start_date"]?></span>';
price[i].innerHTML='<ion-icon name="cash-outline"></ion-icon><span>NT$<?=$product["price"]?></span>';
commentStar[i].innerHTML='<ion-icon name="star-outline"></ion-icon><span>5</span>';

}
}

//全開全關
// for (i=0;i<titlecard.length;i++) {
//   titlecard[i].addEventListener("click",function(){
//     for (j=0;j<productSummary.length;j++){
//         productSummary[j].classList.toggle("open");
//     }
//   })
// }