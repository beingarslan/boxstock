<script setup>
import {ref} from 'vue';
import router from "@/router";
import { useStore } from 'vuex';
import axios from 'axios';

// Static image
import searchImgUrl from '../../images/search-icon.svg';

const store = useStore();
const visible = ref(false);
const user = ref();
const showSearchList = ref(false);
const products = ref([]);
const searchLoader = ref(false);
const layout = ref('');

function closeModal() {
    visible.value = false;
}

const loader = ref(true);

const productSearch = (e) => {
    searchLoader.value = true;
    let token = localStorage.getItem('token');
    axios.get('/search?search='+e.target.value, {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        console.log(res)
        products.value = res.data.products;
        searchLoader.value = false;
    });
}

const showSearchModal = () => {
    showSearchList.value = true;
}

const closeSearchModal = (param) => {
    router.push('/product/'+param)
    showSearchList.value = false;
}

</script>

<template>
    <div class="search-bar bg-[#3D3735] py-[30px]" v-if="store.getters.getToken">
        <div class="container">
            <div class="search-field flex items-center justify-start  rounded-[5px] bg-white w-full overflow-hidden ">
                <img :src="searchImgUrl" alt="search-icon" />
                <input type="text" @click="showSearchModal" placeholder="Search for brands, color, sort..." class="w-full min-h-[58px] px-[3px] focus:outline-none focus:border-none placeholder:text-[#555555] placeholder:tracking-[0.3px] placeholder:font-[400px] " />
            </div>
        </div>
    </div>
    <a-modal v-model:visible="showSearchList" title="Search product" class="py-[100px]" v-if="store.getters.getToken">
        <div class="search-field flex items-center justify-start border-[1px] border-[#f5f5f5]  rounded-[5px] bg-white w-full overflow-hidden ">
            <img :src="searchImgUrl" alt="search-icon" />
            <input type="text" @keyup="productSearch" placeholder="Search for brands, color, sort..." class="w-full min-h-[58px] px-[3px] focus:outline-none focus:border-none placeholder:text-[#555555] placeholder:tracking-[0.3px] placeholder:font-[400px] " />
        </div>
        <div class="mt-[30px] min-h-[300px] overflow-y-auto relative">
            <div class="loader_wrraper  z-50 " v-show="searchLoader"><span  class="loader"></span></div>
            <div class="mb-[20px]" v-for="product in products">
                <div class="flex items-center gap-[20px] cursor-pointer " @click="closeSearchModal(product.slug)">
                    <img :src="product.image" class="w-[30px] h-[30px] rounded-full" >
                    <h4 class="mb-[0]">{{ product.name }}</h4>
                </div>
            </div>
            <div class="text-center text-[#cbc9c9]" v-if="products.length < 1">Product not found</div>
        </div>
    </a-modal>
</template>
