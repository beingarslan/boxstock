<script xmlns:disabled="http://www.w3.org/1999/xhtml">
import {ref, defineComponent, onBeforeMount} from 'vue';
import singleProductImage from '../../images/single-product-image.svg';
import singleProductChecked from '../../images/product-checked.svg';
import productNew from '../../images/product-new.svg';
import productDelivery from '../../images/product-delivery.svg';
import mintIcon from '../../images/mint-condition.svg';
import minorIcon from '../../images/minor.svg';
import visibleDamage from '../../images/visibale-damage.svg';
import {useRoute} from "vue-router";
import axios from "axios";
import BreadcrumbVue from "@/components/Breadcrumb.vue";
import searchIcon from "../../images/search-icon.svg";
import Swal from 'sweetalert2';
import router from "@/router";
import VueImageZoomer from 'vue-image-zoomer'
import 'vue-image-zoomer/dist/style.css';

export default defineComponent({
    components: {
        BreadcrumbVue,
        VueImageZoomer
    },
    setup() {
        const route = useRoute();
        const showLoader = ref(false);
        const product = ref();
        const variations = ref();
        const totalStock = ref();
        const totalPrice = ref();
        const currentTab = ref('verified');
        const loading = ref(false);
        const qty = ref([]);
        let variants = [];
        let productId = '';
        const renderDom = ref([]);
        let totalPriceData = '';

        onBeforeMount( () => {
            loading.value = true;
            let token = localStorage.getItem('token');
             axios.get('/product/single?slug='+route.params.slug, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                variations.value = res.data.variations;
                product.value = res.data.product;
                productId = res.data.product.id
                totalStock.value = res.data.variations.reduce(
                    function (accumulator, curValue) {
                        if(!isNaN(accumulator) || accumulator !== undefined) {
                            return (parseInt(accumulator) + parseInt(curValue.stock))
                        }
                    }, 0
                );
            });
            loading.value = false;
        });

        function handleTab(value) {
            currentTab.value = value
        }

        function orderCreationMsg(message, status) {
            Swal.fire(
                message,
                '',
                status
            )
        }

        function calculatePrice(event, param) {
            renderDom.value = param;
            if(variants.length < 1) {
                let variantObj = {
                    id: param.id,
                    qty: event,
                    price: event * parseInt(param.price)
                }
                variants.push(variantObj);
            } else {
                if(variants.some(data => data.id === param.id)) {
                    let variantObj = {
                        id: param.id,
                        qty: event,
                        price: event * parseInt(param.price)
                    }
                    let foundIndex = variants.findIndex(x => x.id === param.id);
                    variants[foundIndex] = variantObj;
                } else {
                    let variantObj = {
                        id: param.id,
                        qty: event,
                        price: event * parseInt(param.price)
                    }
                    variants.push(variantObj);
                }
            }

            if(event === 0) {

                const objWithIdIndex = variants.findIndex((obj) => obj.id === param.id);

                if (objWithIdIndex > -1) {
                    variants.splice(objWithIdIndex, 1);
                }
            }

            if(variants.length >= 0) {
                totalPrice.value = variants.reduce(
                    function (accumulator, curValue) {
                        if(!isNaN(accumulator) || accumulator !== undefined) {
                            return (parseInt(accumulator) + parseInt(curValue.price))
                        }
                    }, 0
                );
                totalPriceData = totalPrice.value;
            }
        }

        function createOrder() {
            if(variants.length < 1) {
                // orderCreationMsg('Please select at least one variation', 'error')
                return false;
            }
            showLoader.value = true;
            let price = {};
            price['price'] = totalPriceData;

            let token = localStorage.getItem('token');
            axios({
                method: 'POST',
                url: '/orders/',
                headers: {
                    Authorization: 'Bearer ' + token,
                },
                data: {
                    productId,
                    totalPriceData,
                    variants
                }
            }).then( (res) => {
                showLoader.value = false;
                orderCreationMsg('Order created successfully', 'success');
                // window.location.reload();
                router.push('/order-list');
            })
        }
        return {
            singleProductImage,
            singleProductChecked,
            productNew,
            productDelivery,
            mintIcon,
            searchIcon,
            minorIcon,
            visibleDamage,
            product,
            variations,
            route,
            currentTab,
            totalStock,
            loading,
            variants,
            renderDom,
            totalPrice,
            showLoader,
            productId,
            totalPriceData,

            handleTab,
            calculatePrice,
            createOrder
        };
    }
});

</script>

<template>
    <div class="sneakerview mt-[50px] mb-[100px]">
        <div v-if="product" class="container">
            <div class="breadcrumb mt-[20px]">
                <ul class="flex items-start">
                    <div class="hidden">{{renderDom}}</div>
                    <li><RouterLink class="font-[400] text-[#000000] hover:text-[#000000] pr-[10px] border-[#8D8D8D]" to="/">Home</RouterLink><span class="text-[#8D8D8D]">|</span></li>
                    <li><RouterLink class="font-[400] text-[#000000] hover:text-[#000000] pr-[10px] pl-[10px] border-[#8D8D8D]" to="/shop">Product</RouterLink><span class="text-[#8D8D8D]">|</span></li>
                    <li><a href="#" class="font-[400] text-[#8D8D8D] hover:text-[#8D8D8D] pl-[10px] ">{{product.name}}</a></li>
                </ul>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-[60px] mt-14">
                <div class="col-span-1">
                    <img class="w-full" :src="product.image" alt="">
                    <div class="border-b-[1px] border-[#DADADA] mt-16">
                        <div class="pb-5">
                            <div class="flex items-center justify-between ">
                                <div class="col-span-1 cursor-pointer" @click="handleTab('verified')" >
                                    <div class="flex">
                                        <img class="text-right" :src="singleProductChecked" alt="">
                                        <div class="flex-none ml-2">
                                            <h6 :class="currentTab === 'verified'? 'font-[700]' : ''"  class="text-[15px]  text-left font-TTcommons mb-0">Verified</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1 cursor-pointer" @click="handleTab('new')">
                                    <div class="flex">
                                        <img class="text-right font-TTcommons" :src="productNew" alt="">
                                        <div class="flex-none ml-2">
                                            <h6 :class="currentTab === 'new'? 'font-[700]' : ''" class=" mb-0 text-[15px] text-left font-TTcommons">New & Unworn</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1 cursor-pointer" @click="handleTab('delivery')">
                                    <div class="flex">
                                        <img class="text-right" :src="productDelivery" alt="">
                                        <div class="flex-none ml-2">
                                            <h6 :class="currentTab === 'delivery'? 'font-[700]' : ''" class=" mb-0 text-[15px] text-left font-TTcommons">Delivery</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content relative pb-[30px]">
                        <Transition name="fade" mode="out-in">
                        <div v-if="currentTab === 'verified'" class="absolute">
                            <div>
                                <div class="mt-5">
                                    <p class="text-[15px] text-[#555555] font-TTcommons">Every sneaker goes trough a inspection by one of our authenticators, so we can guarantee you all sneakers are 100 % authentic and new.</p>
                                </div>
                            </div>
                        </div>
                        </Transition>
                        <Transition name="fade" mode="out-in">
                        <div v-if="currentTab === 'new'" class="absolute">
                            <div>
                                <div class="mt-5">
                                    <p class="text-[15px] text-[#555555] font-TTcommons">Every sneaker goes trough a inspection by one of our authenticators, so we can guarantee you all sneakers are 100 % authentic and new.</p>
                                </div>
                            </div>
                        </div>
                        </Transition>
                        <Transition name="fade" mode="out-in">
                        <div v-if="currentTab === 'delivery'" class="absolute">
                            <div>
                                <div class="mt-5">
                                    <p class="text-[15px] text-[#555555] font-TTcommons">Every sneaker goes trough a inspection by one of our authenticators, so we can guarantee you all sneakers are 100 % authentic and new.</p>
                                </div>
                            </div>
                        </div>
                        </Transition>
                    </div>
                    <div class="mt-[70px] border-t-[1px] border-[#DADADA]">
                        <h5 class="text-[20px] leading-[24px] mb-[10px] font-[700] pt-[45px] text-[#555555] font-TTcommons">Product details</h5>
                        <div class="border-y-[1px] border-[#DADADA]">
                            <div class="flex justify-between py-1">
                                <div><span class="text-[15px] text-[#555555] text-right font-TTcommons">SKU</span></div>
                                <div><span class="text-[15px] text-[#555555] text-right font-TTcommons">{{ product.sku }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 ml-4">
                    <h1 class="text-[30px] text-[#555555] font-extrabold font-TTcommons leading-[38px]">{{ product.name }}</h1>
                    <div v-if="product.product_type === '0'" class="border-y-[1px] border-[#DADADA] mt-6">
                        <div class="grid grid-cols-3 gap-4 my-6">
                            <div class="col-span-1">
                                <div class="border-[1px] rounded border-[#DADADA]">
                                    <div>
                                        <div class="flex items-center p-[5px]">
                                            <img class="w-[21px]" :src="mintIcon" alt="">
                                            <h6 class="text-[12px] text-[#000000] font-[400] leading-[14px] ml-[4px] mb-0 font-TTcommons">Doos onbeschadigd</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <div class="border-[1px] rounded border-[#DADADA]">
                                    <div>
                                        <div class="flex items-center p-[5px]">
                                            <img class="w-[21px]" :src="minorIcon" alt="">
                                            <h6 class="text-[12px] text-[#000000] font-[400] leading-[14px] ml-[4px] mb-0 font-TTcommons">Doos kleine beschadiging</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <div class="border-[1px] rounded border-[#DADADA]">
                                    <div>
                                        <div class="flex items-center p-[5px]">
                                            <img class="" :src="visibleDamage" alt="">
                                            <h6 class="text-[12px] text-[#000000] font-[400] leading-[14px] ml-[4px] mb-0 font-TTcommons">Doos beschadigd</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-14 border-b-[1px] border-[#DADADA]">
                        <h5 class="text-[18px] leading-[18px] tracking-[0.3px] text-[#555555] my-[15px] font-TTcommons">Total in stock: <span class="text-[18px] text-[#555555] font-bold font-TTcommons">{{ totalStock }}</span></h5>
                        <div class="flex flex-col sm:flex-row  gap-[20px] mb-[15px]" v-for="(variant, index) in variations">
                            <div class="py-[5px] px-[10px] border-[1px] rounded border-[#DADADA] shrink-0">
                                <div class="flex justify-center items-center">
                                    <div class="flex items-center gap-[3px]">
                                        <img v-if="product.product_type === '0'" class="w-[20px]" :src="variant.status === 'Doos onbeschadigd' ? mintIcon : variant.status === 'Doos kleine beschadiging' ? minorIcon : variant.status === 'Doos beschadigd' ?  visibleDamage : variant.image" alt="">
<!--                                        <span class="text-[14px]" v-if="product.product_type === '0'">{{variant.status}}</span>-->
                                    </div>
                                    <h6 class="mb-0 text-[14px] ml-2 font-TTcommons tracking-[3px]"><span v-if="product.product_type === '0'" class="text-[#8D8D8D]">|</span><span class="text-[14px] tracking-[0px]">{{ variant.size.name }}</span> <span class="text-[#8D8D8D]">|</span><span class="text-[14px] tracking-[0px]">Available</span> <span class="font-bold text-[14px] tracking-[1px]">{{variant.stock}}</span> <span class="text-[#8D8D8D]">|</span>€ <span class="text-[14px] tracking-[0px]">{{ variant.amount }}</span></h6>
                                </div>
                            </div>
                            <div class="qty-wrap shrink-0">
                                <a-input-number class="qty bg-white text-[14px] py-[5px] px-[15px] border border-[#DADADA] rounded w-full h-full !flex items-center justify-center"  @change="calculatePrice($event, {id: variant.id, price: variant.amount})" :min="0" autofocus="false" />
                            </div>
                            <div class="py-[5px] w-[70px] px-[0px] border border-[#DADADA] rounded shrink-0 !flex items-center justify-center">
                                <h6 class="mb-0 text-[14px] font-TTcommons font-[700]">€ {{ variants.length > 0 && variants.some(data => data.id === variant.id) ? variants.find(values => values.id === variant.id).price : 0 }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="mt-14">
                        <div class="flex justify-between py-1">
                            <div><span class="text-[15px] text-[#000000] font-TTcommons">Total</span></div>
                            <div><span class="text-[34px] font-bold font-TTcommons">€ {{ totalPrice ? totalPrice : '00'}}</span></div>
                        </div>

                        <div>
                            <button type="submit" class=" w-full mt-2 font-TTcommons bg-[#00B67A] rounded-[73px] px-[40px] py-[14px] text-white text-[22px] leading-[27px] font-[TT Commons] font-bold tracking-[0.27px]" :class="variants.length < 1 || showLoader ? 'opacity-50 cursor-not-allowed': ''" @click="createOrder" >
                                <div class="loader_wrraper" v-show="showLoader"><span  class="loader"></span></div>
                                Buy now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="loader_wrapper_">
            <span class="loader"></span>
        </div>
    </div>
</template>

<style scoped>
/* we will explain what these classes do next! */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.loader-wrapper {
    position: fixed;
    top: 0;
    width: 100%;
    left: 0;
    right: 0;
    height: 100%;
    background: #fff;
    z-index: 999;
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
