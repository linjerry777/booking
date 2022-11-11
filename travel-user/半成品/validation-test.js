const LocationGroup = document.querySelectorAll('.groupLocation');
const MajorGroup = document.querySelectorAll('.groupMajor');
// const NormalGroup = document.querySelectorAll('.groupNormal');
// const OtherGroup = document.querySelectorAll('.groupOther');

for(let i=0;i<LocationGroup.length;i++){
    LocationGroup[i].addEventListener('change',atLeastOne);
}
for(let i=0;i<MajorGroup.length;i++){
    MajorGroup[i].addEventListener('change',atLeastOne);
}
// for(let i=0;i<NormalGroup.length;i++){
//     NormalGroup[i].addEventListener('change',atLeastOne);
// }
// for(let i=0;i<OtherGroup.length;i++){
//     OtherGroup[i].addEventListener('change',atLeastOne);
// }

function atLeastOne() {
    let GroupName = document.querySelectorAll(`.${this.className}`);
    let atLeastOneIsChecked = false;
    for(let i=0;i<GroupName.length;i++){
        //.checked 會回傳true
        if(GroupName[i].checked){
            atLeastOneIsChecked = true;
        }}
    if(atLeastOneIsChecked){
        for (let i=0;i<GroupName.length;i++){
            GroupName[i].required = false;
        }
    }else{
        for (let i=0;i<GroupName.length;i++){
            GroupName[i].required = true;
        }
    }

}
atLeastOne();   