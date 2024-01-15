<template>
    <div class="container !mb-[150px]">
        <div class="breadcrumb mt-[20px]">
            <ul class="flex items-start">
                <li><RouterLink class="font-[400] text-[#000000] hover:text-[#000000] pr-[10px] border-r-[1px] border-[#8D8D8D]" to="/">Home</RouterLink></li>
                <li><RouterLink class="font-[400] text-[#8D8D8D] hover:text-[#8D8D8D] pl-[10px] " to="/shop">Shop</RouterLink></li>
            </ul>
        </div>

        <div class="sneakers-title-box mt-[30px]">
            <h3 class="text-[#555555] text-[26px] font-[700] font-TTcommons leading-[32px]">{{ title }}</h3>
            <p class="mt-1 text-[18px] font-[400] text-[#000] font-TTcommons mb-0 leading-[24px]">{{sub_title}}<br class="md:block">{{description}}</p>
        </div>

        <div class=" flex items-center flex-col md:flex-row md:mb-[0] mb-[50px] mt-[100px] ">
            <div class="sidebar-left w-full md:w-[280px] shrink-0">
                <h3 class=" text-[16px]  mt-0 mb-0 font-extrabold font-TTcommons cursor-pointer" :class="title === 'Sneakers' ? 'text-[#000000]': 'text-[#555555]'" @click="filterByType('Sneakers')">Sneakers</h3>
                <h3 class=" text-[16px] mt-0 mb-0 font-extrabold font-TTcommons cursor-pointer" :class="title === 'Streetwear' ? 'text-[#000000]': 'text-[#555555]'" @click="filterByType('Streetwear')">Streetwear</h3>
            </div>
            <div class="sidebar-right mt-[20px] md:mt-0 ">
                <h3 class="text-[#00B67A] text-[18px] font-extrabold !mb-[15px] font-TTcommons">Alles is nieuw en ongedragen!</h3>
                <p class="text-[18px] font-[400] text-[#000] mb-0 font-TTcommons leading-[24px]">Bij Boxstock hechten wij veel waarde aan service en willen wij iedereen goed kunnen helpen. Maak hier keuze uit de contactmethode die het beste bij jou past, ons team staat voor je klaar!</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 md:gap-[30px] mt-[20px] pt-[20px]">
            <div class=" col-span-full md:col-span-1">
                <div class=" relative sneakers-search-field flex items-center justify-start border border-[#DADADA] rounded-[5px] bg-white w-full overflow-hidden ">
                    <div class="certain-category-search-wrapper border-none relative ">
                        <input v-model="searchText" @keyup="searchFilter" class="py-[10px] pl-[60px] focus:outline-none" type="text" placeholder="Search for brands, color..." />
                        <img :src="searchIcon" class="absolute left-[10px] top-0" alt="">
                    </div>
                </div>
                <div class="sneakers-filter-merken mt-[30px] ">
                    <h3 class="text-[#555555] text-[16px] font-bold font-TTcommons">Merken</h3>
                    <ul class="mt-5 space-y-2">
                        <li class="filter" v-for="brand in brands" >
                            <label class="flex items-center cursor-pointer">
                                <input class="w-4 h-4 rounded-md" :value="brand.id" @click="filterByBrand(brand.id)" type="radio" name="brand"> <span class="text-[#555555] pl-3 text-[15px] font-TTcommons"> {{ brand.name }}</span>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="sneakers-filter-prijzen mt-8 font-TTcommons">
                    <h3 class="text-[#555555] text-[16px] font-bold font-TTcommons">Prijzen</h3>
                    <ul class="mt-5 space-y-2">
                         <li class="filter">
                            <label class="flex items-center cursor-pointer">
                                <input class="w-4 h-4 rounded" type="radio" name="price" @click="filterByPrice('0-100')"> <span class="text-[#555555] pl-3 text-[15px] font-TTcommons"> 0-100</span>
                            </label>
                        </li>
                         <li class="filter">
                            <label class="flex items-center cursor-pointer">
                                <input class="w-4 h-4 rounded" type="radio" name="price" @click="filterByPrice('100-200')"> <span class="text-[#555555] pl-3 text-[15px] font-TTcommons">100-200</span>
                            </label>
                        </li>
                         <li class="filter">
                            <label class="flex items-center cursor-pointer">
                                <input class="w-4 h-4 rounded" type="radio" name="price" @click="filterByPrice('200-300')"> <span class="text-[#555555] pl-3 text-[15px] font-TTcommons">200-300</span>
                            </label>
                        </li>
                         <li class="filter">
                            <label class="flex items-center cursor-pointer">
                                <input class="w-4 h-4 rounded" type="radio" name="price" @click="filterByPrice('300-400')"> <span class="text-[#555555] pl-3 text-[15px] font-TTcommons">300-400</span>
                            </label>
                        </li>
                         <li class="filter">
                            <label class="flex items-center cursor-pointer">
                                <input class="w-4 h-4 rounded" type="radio" name="price" @click="filterByPrice('400-500')"> <span class="text-[#555555] pl-3 text-[15px] font-TTcommons">400-500</span>
                            </label>
                        </li>
                         <li class="filter">
                            <label class="flex items-center cursor-pointer">
                                <input class="w-4 h-4 rounded" type="radio" name="price" @click="filterByPrice('500-600')">  <span class="text-[#555555] pl-3 text-[15px] font-TTcommons">500-600</span>
                            </label>
                        </li>
                         <li class="filter">
                            <label class="flex items-center cursor-pointer">
                                <input class="w-4 h-4 rounded" type="radio" name="price" @click="filterByPrice('600-130000')">  <span class="text-[#555555] pl-3 text-[15px] font-TTcommons">600+</span>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="sneakers-filter-voor mt-8">
                    <h3 class="text-[#555555] text-[16px] font-bold font-TTcommons">Voor</h3>
                    <ul class="mt-5 space-y-2">
                        <li class="filter" v-for="cat in catList">
                            <label class="flex items-center cursor-pointer" >
                                <input class="w-4 h-4 rounded bg-[#00B67A]" @click="filterByCat(cat.id)" type="radio"  name="cat" :value="cat.id"> <span class="text-[#555555] pl-3 text-[15px] font-TTcommons"> {{ cat.name }}</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-span-3 relative">
                <div v-if="loading" class="loader-wrapper">
                    <div class="loader"></div>
                </div>
                <a-list
                    class="demo-loadmore-list"
                    :loading="initLoading"
                    item-layout="horizontal"
                    :data-source="list"
                    :grid="{ gutter: 16, xs: 1, sm: 2, md: 3, lg: 3, xl: 3, xxl: 3, xxxl: 3 }"
                >
                    <template #loadMore v-if="page < totalProduct && list.length < totalProduct">
                        <div
                            v-if="!initLoading && !loading"
                            class="mt-[115px] text-center loading-button "
                        >
                            <a-button @click="onLoadMore" class="font-[700]">Load more</a-button>
                        </div>
                    </template>
                    <template #renderItem="{ item }">
                        <RouterLink :to="'/product/' + item.slug">
                            <div class="p-3 cursor-pointer overflow-hidden ">
                                <div class="sneakers-card h-full w-full bg-white transform transition duration-500 rounded border border-[#DADADA] hover:shadow-xl hover:border-[#ffffff] ">
                                    <img :src="item.image" class="w-full p-[10px]" alt="">
                                    <div class="p-3">
                                        <h4 class="text-[18px] mb-0 leading-[26px]  text-[#555555] font-[600] font-TTcommons">{{ item.name }}</h4>
                                        <p class="text-[16px] font-TTcommons text-[#555555]">{{ item.category && item.category.name }}</p>
                                        <p class="text-[16px] mt-[20px] text-[#000] font-[400] font-TTcommons">From <br> <span class="font-[600]">€ {{ item.amount }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </RouterLink>
                    </template>
                </a-list>
            </div>
        </div>
    </div>
</template>
<script>
import {defineComponent, onMounted, ref, nextTick, toRaw} from 'vue';
import { RouterLink, RouterView } from "vue-router";
import BreadcrumbVue from '../components/Breadcrumb.vue';
import searchIcon from '../../images/search-icon.svg';
import axios from "axios";

const count = 3;

export default defineComponent({
    components: {
        BreadcrumbVue
    },
    setup() {
        const initLoading = ref(true);
        const loading = ref(false);
        const data = ref([]);
        const list = ref([]);
        const brands = ref();
        const catList = ref();
        const searchText = ref();
        let page = ref('Sneakers');
        const totalProduct = ref();
        const value = ref('');
        const dataSource = ref([]);
        const title = ref('Sneakers');
        const sub_title = ref('Bij Boxstock is elk item authentieke en beschikbaar.');
        const description = ref('Koop en verkoop alle sneakers van Air Jordan ,NIKE, YEEZY en meer!')

        onMounted(() => {
            let token = localStorage.getItem('token');
            brandList(token);
            productList(token);
            categoryList(token);
        });

        // Get category list
        const categoryList = (token) => {
            axios.get('/categories', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                catList.value = res.data.category
            });
        }

        // Get brand list
        const brandList = (token) => {

            axios.get('/brands', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                // console.log(res)
                brands.value = res.data.brand;
            });
        }

        const filterByType = (type) => {
            if(type === 'Sneakers') {
                title.value = 'Sneakers';
                sub_title.value = 'Bij Boxstock is elk item authentieke en beschikbaar.';
                description.value = 'Koop en verkoop alle sneakers van Air Jordan ,NIKE, YEEZY en meer!';
            } else {
                title.value = 'Streetwear';
                sub_title.value = 'Op Boxstock is elk item dat je wilt altijd beschikbaar en authentiek.';
                description.value = 'Koop en verkoop nieuwe streetwear van Supreme, Fear of God, Nike, Yeezy en meer!';
            }

            loading.value = true;
            let token = localStorage.getItem('token');
            axios.get('/filter/type?type='+type, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                initLoading.value = false;
                data.value = res.data.products;
                list.value = res.data.products;
                totalProduct.value = res.data.products.length
                loading.value = false;
            });

        }

        // Get product
        const productList = (token) => {
            console.log(page.value)
            axios.get('/products?page='+page.value, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                initLoading.value = false;
                data.value = res.data.product.data;
                list.value = res.data.product.data;
                totalProduct.value = res.data.product.total
            });
        }


        const onLoadMore = () => {
            loading.value = true;

            page.value = page.value + 1;

            list.value = data.value.concat([...new Array(page.value)].map(() => ({
                loading: true,
                name: {},
                picture: {},
            })));

            let token = localStorage.getItem('token');
            axios.get('/products?page='+page.value, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                // console.log(res)
                const newData = data.value.concat(res.data.product.data);
                loading.value = false;
                data.value = newData;
                list.value = newData;
                nextTick(() => {
                    window.dispatchEvent(new Event('resize'));
                });
            });
        };

        const filterApiCall = (id, param) => {
            loading.value = true;
            let token = localStorage.getItem('token');
            axios.get('/filter/search?'+param+'='+id, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                initLoading.value = false;
                data.value = res.data.products;
                list.value = res.data.products;
                totalProduct.value = res.data.products.length
                loading.value = false;
            });
        }

        // Filter functionality start
        const filterByCat = (id) => {
            filterApiCall(id, 'category')
        }

        const filterByBrand = (id) => {
            filterApiCall(id, 'brand');
        }

        const filterByPrice = (price) => {
            filterApiCall(price, 'price');
        }

        const searchFilter = () => {
            filterApiCall(searchText.value, 'search');
        }
        // Filter functionality end

        return {
            loading,
            initLoading,
            data,
            list,
            onLoadMore,
            searchIcon,
            value,
            dataSource,
            brandList,
            brands,
            catList,
            categoryList,
            title,
            description,
            sub_title,

            // Products
            productList,
            page,
            totalProduct,
            searchText,

            // Filter
            filterApiCall,
            filterByCat,
            filterByBrand,
            filterByPrice,
            searchFilter,
            filterByType
        };
    },
});
</script>
<style>
.demo-loadmore-list {
    min-height: 350px;
}

body .ant-input-group-addon{
    display: none !important;
}
body .ant-select-single:not(.ant-select-customize-input) .ant-select-selector {
    padding-left: 60px !important;
    border: none !important;
}
body .ant-select:not(.ant-select-customize-input) .ant-select-selector .ant-select-selection-search-input {
    border: none !important;
}
.certain-category-search-wrapper{
    width: 100%;
}
.certain-category-search-wrapper input {
    width: 100%;
    border: none;
}

body .loading-button button span{
    font-weight: 700 !important;
    font-family: 'TTCommons' !important;
}
.loader-wrapper {
    position: absolute;
    top: 0;
    width: 100%;
    left: 0;
    right: 0;
    height: 100%;
    background: #fff;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}
.loading {
    height: 0;
    width: 0;
    padding: 15px;
    border: 6px solid #ccc;
    border-right-color: #888;
    border-radius: 22px;
    -webkit-animation: rotate 1s infinite linear;
    /* left, top and position just for the demo! */
    position: absolute;
    left: 50%;
    top: 50%;
}

@-webkit-keyframes rotate {
    /* 100% keyframe for  clockwise.
       use 0% instead for anticlockwise */
    100% {
        -webkit-transform: rotate(360deg);
    }
}
</style>
