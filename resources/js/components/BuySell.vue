<script>

import { RouterLink, RouterView } from "vue-router";
import cardBuyImg from '../../images/buy-card.svg';
import { toRefs, toRef } from 'vue';

export default {
    name: 'BuySell',
    props: [
        'title',
        'image',
        'button_text',
        'button_link',
        'description'
    ]
}

</script>

<template>
<!--    {{image}} Hello world-->
    <div class="shop-single-card ">
        <div class="h-full bg-[#F6F6F6] group hover:bg-[#90B8AB] duration-[.50s] rounded-[10px] border-[1px] pb-[30px] px-[25px] pt-[20px] relative border-[#DADADA]">
            <div class="pb-[20px]">
                <h3 class="z-20 relative text-[40px] leading-8 font-bold text-[#555555] group-hover:text-white">{{title}}</h3>
                <p class="z-20 relative w-[320px] text-[18px] leading-[24px] mb-[30px] text-[#555555] mt-[10px] pb-[15px] group-hover:text-white">{{description}}</p>
                <RouterLink to="/shop" class=" cursor-pointer z-20 relative btn-hear bg-[#00B67A] group-hover:bg-white group-hover:text-[#00B67A] rounded-[73px] px-[64px] py-[14px]  text-[#FFFFFF] mb-[30px] mt-[30px] text-[22px] leading-[27px] font-[TTCommons] font-[600] uppercase tracking-[0.27px]">{{ button_text }}</RouterLink>
            </div>
            <img class=" z-10 absolute right-0 bottom-0 w-auto " :src="image" alt="">
        </div>
    </div>
</template>
