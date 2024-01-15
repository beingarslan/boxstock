<script>

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
    <div class="shop-single-card">
        <div class="bg-cover group duration-[.50s] rounded-[10px] border-[1px] relative border-[#DADADA] p-7 hover:bg-[#90B8AB] group-hover:text-white">
            <div class="">
                <slot name="sneaker-title"></slot>
                <p class="z-20 relative w-[320px] text-[14px] mb-[30px] text-[#555555] mt-[10px] pb-[15px] group-hover:text-white">100% eco friendly</p>
                <button class="z-20 btn-hear bg-[#FFF500]  group-hover:bg-[#ffffff] group-hover:text-black rounded-[73px] px-[40px] py-[14px] text-black text-[22px] leading-[27px] font-[TT Commons] font-bold tracking-[0.27px] group-hover:text-white">
                    <div class="flex justify-between">
                        <span class="mr-1 pt-1">Buy € 25,-</span>
                        <span><img src="../assets/arrow-up-outline.svg" alt=""></span>
                    </div>
                </button>
            </div>
            <img :src="image" alt="bg-image" />
        </div>
    </div>
</template>
