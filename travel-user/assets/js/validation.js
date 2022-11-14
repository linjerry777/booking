const LocationGroup = document.querySelectorAll('.groupLocation');
const TagGroup = document.querySelectorAll('.groupTag');
const IndoorGroup = document.querySelectorAll('.indoorTag');

for(let i=0;i<LocationGroup.length;i++){
    LocationGroup[i].addEventListener('change',atLeastOne);
}
for(let i=0;i<TagGroup.length;i++){
    TagGroup[i].addEventListener('change',atLeastOne);
}
for(let i=0;i<IndoorGroup.length;i++){
    IndoorGroup[i].addEventListener('change',atLeastOne);
}

function atLeastOne() {
    let mainClass = this.className.split(" ");
    let GroupName = document.querySelectorAll(`.${mainClass[1]}`);
    let atLeastOneIsChecked = false;
    for(let i=0;i<GroupName.length;i++){
        //.checked 會回傳true
        if(GroupName[i].checked){
            atLeastOneIsChecked = true;
        }}
    if(atLeastOneIsChecked){
        for (let i=0;i<GroupName.length;i++){
            GroupName[i].required = false
        }
    }else{
        for (let i=0;i<GroupName.length;i++){
            GroupName[i].required = true;
        }
    }

}
atLeastOne();

