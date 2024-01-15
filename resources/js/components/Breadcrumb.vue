<template>
    <div class="breadcrumb">
        <ul class="flex items-start">
            <li><RouterLink class="font-[400] text-[#000000] hover:text-[#000000] pr-[10px] border-r-[1px] border-[#8D8D8D]" to="/">Home</RouterLink></li>
            <li><RouterLink class="font-[400] text-[#8D8D8D] hover:text-[#8D8D8D] pl-[10px] " to="/shop">Shop</RouterLink></li>
        </ul>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { RouterLink, RouterView } from "vue-router";
    const currentUrl = ref('');

    onMounted( () => {
        currentUrl.value = window.location.href;
    } );


    console.log(currentUrl)
</script>