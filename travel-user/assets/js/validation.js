const LocationGroup = document.querySelectorAll('.groupLocation');
const TagGroup = document.querySelectorAll('.groupTag');
const IndoorGroup = document.querySelectorAll('.indoorTag');

const LocationChecked = document.querySelectorAll('.groupLocation[checked]');
const TagGroupChecked = document.querySelectorAll('.groupTag[checked]');
const IndoorChecked = document.querySelectorAll('.indoorTag[checked]');
//如果gruop裏頭的選項沒人選→全部人加require 
// 找 有人被勾選與否

    if (LocationChecked.length != 0){
        for(let i=0;i<LocationGroup.length;i++){
        LocationGroup[i].required = false;
        LocationGroup[i].addEventListener('change',atLeastOne);}
    }else{
        for(let i=0;i<LocationGroup.length;i++){
            LocationGroup[i].required = true;
            LocationGroup[i].addEventListener('change',atLeastOne);
        }
    }


    if (TagGroupChecked.length != 0){
        for(let i=0;i<TagGroup.length;i++){
        TagGroup[i].required = false;
        TagGroup[i].addEventListener('change',atLeastOne);}
    }else{
        for(let i=0;i<TagGroup.length;i++){
            TagGroup[i].required = true;
            TagGroup[i].addEventListener('change',atLeastOne);
        }
    }

    if (IndoorChecked.length != 0){
        for(let i=0;i<IndoorGroup.length;i++){
        IndoorGroup[i].required = false;
        IndoorGroup[i].addEventListener('change',atLeastOne);}
    }else{
        for(let i=0;i<IndoorGroup.length;i++){
            IndoorGroup[i].required = true;
            IndoorGroup[i].addEventListener('change',atLeastOne);
        }
    }



function atLeastOne() {
    let target = this;
    let mainClass = target.className.split(" ");
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

