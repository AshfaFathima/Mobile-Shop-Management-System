var cards = document.querySelectorAll('.product-box');

cards.forEach((card)=>{
    card.addEventListener('mouseover', function(){
        card.classList.add('is-hover');
    })
    card.addEventListener('mouseleave', function(){
        card.classList.remove('is-hover');
    })
})

const profileBtn=document.getElementById('profilebtn');
const privacyBtn=document.getElementById('privacybtn');
const profileArea=document.getElementById('profile');
const privacyArea=document.getElementById('privacy');

profileBtn.addEventListener('click',function(){
    profileArea.style.display="none";
    privacyArea.style.display="block";
})

privacyBtn.addEventListener('click',function(){
    privacyArea.style.display="none";
    profileArea.style.display="block";
})