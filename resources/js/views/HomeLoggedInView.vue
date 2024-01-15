<script setup>
import {reactive, onBeforeMount, ref} from 'vue';
import {RouterLink} from "vue-router";
import {Collapse} from 'vue-collapsed';
import toggleBtn from "../../images/toggle-btn.svg";
import moment from 'moment';
import BuySellVue from "../components/BuySell.vue";
// import buyImage from "../../images/buy-card-img.png";
import buyImage from "../../images/jordan.png";
import sellImg from "../../images/sell-card-img.svg";
import safegrilUrl from "../../images/Safegrail.png";
import safegrilUrl2 from "../../images/Safegrail2.png";
import sneakerSellUlr from "../../images/sneaker-sell.svg";

// Store
import {useStore} from 'vuex';
import axios from "axios";

const store = useStore();
let ordersList = [];
const companyName = ref('');
const posts = ref('');

const loading = ref(false);
const showLoader = ref(false);

const orders = reactive(
    ordersList.map(() => ({
        isExpanded: false, // Initial values, display expanded on mount
    }))
);

const activePanel = ref();

function handleAccordion(selectedIndex) {
    activePanel.value = selectedIndex;
}

const orderData = ref([]);


onBeforeMount( () => {
    let user = JSON.parse(localStorage.getItem('user'));
    let token = localStorage.getItem('token');
    companyName.value = user.company_name;
    loading.value = true;
    axios.get('/orders/' + user.id, {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        // ordersList.push(res.data.orders);
        orderData.value = res.data.orders;

    });

    axios.get('/posts/', {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        posts.value = res.data.posts;

    });
    loading.value = false;
});

function cancelOrder(id) {
    showLoader.value = true;
    let token = localStorage.getItem('token');
    axios.delete('/orders/' + id, {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        window.location.reload();
    });
    showLoader.value = false;
}

</script>
<template>
    <section>
        <div class="shope-wrapper-card mt-[100px]">
            <div class="container">
                <div class="row">
                    <h2 class="font-TTcommons font-bold text-[36px] leading-8 text-[#555555] mb-[25px]">Buy sneakers
                        & streetwear!</h2>
                    <div class="shope-card-group-hear ]">
                        <div class="single-card-hear grid-cols-1 md:grid-cols-2 grid gap-[59px]">
                            <BuySellVue
                                title="Koop"
                                description="Koop je sneakers en streetwear met je boxstockb2b account. En laat je stock groeien of maak je klant blij."
                                button_link="/shop"
                                button_text="Buy"
                                :image="buyImage"
                            />

                            <BuySellVue
                                title="Verkoop"
                                description="Verkoop je sneakers of streetwear met je b2b account and sell your stock to other people"
                                button_link="/shop"
                                button_text="Binnenkort Online"
                                :image="sellImg"
                            />
                        </div>
                    </div>
                </div>
                <div class="row mt-[54px]">
                    <div class="shope-card-group-hear">
                        <div class="single-card-hear grid-cols-1 md:grid-cols-2 grid gap-[59px]">
                            <div class="shop-single-card">
                                <div
                                    class="z-20 bg-cover overflow-hidden group duration-[.50s] rounded-[10px] border-[1px] relative border-[#DADADA] p-[30px] hover:bg-[#90B8AB] group-hover:text-white">
                                    <div class="z-20 relative">
                                        <h3 class="text-[40px] text-[#000000] font-bold leading-10  group-hover:text-white">
                                                <span
                                                    class="text-[#27BB6B] text-[40px] font-[700]  group-hover:text-white">SAFEGRAIL PREMIUM</span>
                                            <br> SNEAKER <br> PROTECTOR</h3>
                                        <p class="z-20 relative w-[320px] text-[18px] leading-[24px] mb-[30px] text-[#555555] mt-[10px] pb-[15px] group-hover:text-white">
                                            100% eco friendly</p>
                                        <a href="https://www.safegrail.com/b2b" target="_blank"
                                           class=" flex justify-between items-center max-w-[209px] z-20 bg-[#FFF500]  group-hover:bg-[#ffffff] group-hover:text-black rounded-[73px] pl-[30px] pr-[25px] h-[58px] text-black text-[22px] leading-[27px] font-[TT Commons] font-bold tracking-[0.27px] group-hover:text-white">
                                                <span class="font-[700] text-[26px] leading-[31px] font-[TTCommons]">Buy <span
                                                    class="font-[500] text-[25px]">€ 5.99-</span></span>
                                            <span><img :src="sneakerSellUlr" alt=""></span>
                                        </a>
                                    </div>
                                    <img :src="safegrilUrl" alt="bg-image"
                                         class="object-contain absolute top-[-15px] w-full h-full left-[170px] md:left-[185px] right-0 bottom-0 z-10"/>
                                </div>
                            </div>
                            <div class="shop-single-card">
                                <div
                                    class=" overflow-hidden bg-cover group duration-[.50s] rounded-[10px] border-[1px] relative border-[#DADADA] p-7 hover:bg-[#90B8AB] group-hover:text-white">
                                    <div class="z-20 relative">
                                        <h3 class="text-[40px] text-[#000000] font-bold leading-10  group-hover:text-white">
                                                <span
                                                    class="text-[#27BB6B] text-[40px] font-[700]  group-hover:text-white">PREMIUM</span>
                                            <br> SNEAKER <br> SWIPES</h3>
                                        <p class="z-20 relative w-[320px] text-[18px] leading-[24px] mb-[30px] text-[#555555] mt-[10px] pb-[15px] group-hover:text-white">
                                            100% eco friendly</p>
                                        <a href="https://www.safegrail.com/b2b" target="_blank"
                                           class=" flex justify-between items-center max-w-[209px] z-20 bg-[#FFF500]  group-hover:bg-[#ffffff] group-hover:text-black rounded-[73px] pl-[30px] pr-[25px] h-[58px] text-black text-[22px] leading-[27px] font-[TT Commons] font-bold tracking-[0.27px] group-hover:text-white">
                                                <span class="font-[700] text-[26px] leading-[31px] font-[TTCommons]">Buy <span
                                                    class="font-[500] text-[25px]">€ 3.99-</span></span>
                                            <span><img :src="sneakerSellUlr" alt=""></span>
                                        </a>
                                    </div>
                                    <img :src="safegrilUrl2" alt="bg-image"
                                         class="object-contain absolute top-[-15px] w-full h-full left-[130px] md:left-[130px] right-0 bottom-0 z-10"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="login-btn text-center mt-[40px]  ">
                  <RouterLink class=" inline-block mx-auto bg-[#00B67A] py-[15px] px-[50px] rounded-[40px] text-white " to="/login">Login</RouterLink>
                </div> -->
            </div>
        </div>
    </section>
    <section class="mt-[100px]">
        <div class="shope-wrapper-card">
            <div class="container">
                <div class="row" v-if="posts">
                    <div class="shope-text-hear mt-[50px] flex items-center flex-wrap gap-[20px] justify-between mb-[30px]">
                        <h2 class="font-TTcommens text-[36px] mb-[0px] leading-[32px] tracking-[0.3px] font-bold text-[#555555]">
                            Boxstock B2B news</h2>
                        <RouterLink :to="`/blogs`" class="cursor-pointer btn-hear bg-[#00B67A] border-[#00B67A] border hover:bg-white hover:text-[#000] rounded-[73px] px-[25px] py-[10px] text-[#FFFFFF] mt-[0px] md:mt-[0px] text-[18px] leading-[27px] font-[TTCommons] font-[600] uppercase tracking-[0.27px]">See All</RouterLink>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div  v-for="post in posts.slice(0, 3)">
                            <RouterLink v-if="post.link === '#'" class="font-[600] text-[#fff]" :to="`/blog/${post.slug}`">
                                <div class="border border-[#f5f5f5] rounded-[5px] overflow-hidden">
                                    <div><img class="w-full" :src="post.image" alt="blog-title"/></div>
                                    <div class="content px-[15px]">
                                        <span class="text-[#555555] font-medium inline-block text-[18px] mt-[15px]">By {{ post.user.company_name }}  {{ moment(post.created_at).format('DD dddd YYYY')}}</span>
                                        <h4 class="font-bold text-[18px] mt-[15px]">{{ post.title }}</h4>
                                        <p class="text-[#555555]">{{ post.description }}</p>
                                    </div>
                                </div>
                            </RouterLink>
                            <a v-else :href="post.link">
                                <div class="border border-[#f5f5f5] rounded-[5px] overflow-hidden">
                                    <div><img class="w-full" :src="post.image" alt="blog-title"/></div>
                                    <div class="content px-[15px]">
                                        <span class="text-[#555555] font-medium inline-block text-[18px] mt-[15px]">By {{ post.user.company_name }}  {{ moment(post.created_at).format('DD dddd YYYY')}}</span>
                                        <h4 class="font-bold text-[18px] mt-[15px]">{{ post.title }}</h4>
                                        <p class="text-[#555555]">{{ post.description }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-[95px] mb-[200px]">
        <div class="shope-footer-hear">
            <div class="container">
                <div class="shope-wrapper-hear">
                    <div class="shope-text-hear">
                        <h2 class="font-TTcommens text-[36px] mb-[25px] leading-[32px] tracking-[0.3px] font-bold text-[#555555]">
                            Your products</h2>
                    </div>
                    <div v-for="(order, index) in orderData" :key="order.id" class="Section mb-[10px]">
                        <button
                            class="flex md:flex-row flex-col md:items-center items-start justify-between w-full h-auto p-[10px] border border-[#DADADA] rounded-[5px] px-[10px]"
                            :class="[
                                'Panel',
                                {
                                    Active: activePanel === index,
                                },
                            ]"
                            @click="() => handleAccordion(index)"
                        >
                            <!-- {{ order.title }} -->
                            <div class="flex md:gap-[40px] gap-[10px] flex-wrap ">
                                <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{
                                        order.order_id
                                    }}</span>
                                <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{
                                        order.total_price
                                    }}</span>
                                <span
                                    class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{ order.order_date }}</span>
                                <span
                                    class="text-[#555555] font-[400] text-[16px] leading-[19px] text-ellipsis overflow-hidden"
                                    :title="order.status === '0' ? 'Bestelling onhold' : order.status === '1' ? 'Bestelling gereed' : order.status === '2' ? 'Bestelling niet gereed' : order.status === '3' ? 'Nabestelling' : order.status === '4' ? 'Bestelling is gereed maar sommige items in backorder' : ''">{{
                                        order.status === '0' ? 'Bestelling onhold' : order.status === '1' ? 'Bestelling gereed' : order.status === '2' ? 'Bestelling niet gereed' : order.status === '3' ? 'Nabestelling' : order.status === '4' ? 'Order ready with backorder' : ''
                                    }}</span>
                                <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{
                                        order.delivery_method
                                    }}</span>
                                <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{
                                        order.user.company_name
                                    }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-[20px] md:mt-0">
                                <span>{{ order.user.user_name }}</span>
                                <div class="md:ml-[120px] ml-[20px] flex items-center">
                                    <img class="w-[30px] h-[30px] rounded-full" :src="order.user.image"/>
                                    <span class="ml-[20px]"><img :src="toggleBtn"/></span>
                                </div>
                            </div>
                        </button>

                        <Collapse as="section" :when="activePanel === index" :class="[{
                            Active:activePanel === index
                        }]" class="Collapse">
                            <div class="px-[10px] pb-[30px]">
                                <div
                                    class="border-dashed border-b border-[#DADADA] py-[15px] px-[10px] pl-0 flex items-start gap-[15px]">
                                    <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                            order.user.company_name
                                        }}</span>
                                    <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                            order.user.street_name
                                        }}</span>
                                    <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                            order.user.post_code
                                        }}</span>
                                    <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                            order.user.city
                                        }}</span>
                                    <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                            order.user.country
                                        }}</span>
                                    <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                            order.user.phone_number
                                        }}</span>
                                </div>
                                <div class="mt-[35px] flex flex-col md:flex-row gap-[20px] md:gap-[50px]">
                                    <h4 class="font-[500] text-[16px] leading-[16px] text-[#000000]">Bestelingen</h4>
                                    <div>
                                        <div class="mb-[40px]">
                                            <h4 class="mb-[15px] font-[500] text-[16px] leading-[16px] text-[#000000] border-b border-[#DADADA] pb-[15px]">
                                                {{ order.product.name }}</h4>
                                            <div class="border-b border-[#DADADA] pb-[5px]">
                                                <!--                                                {{order.order_products.variant.name}}-->
                                                <div class="flex md:gap-[60px] mb-[10px] flex-wrap gap-[10px]"
                                                     v-for="variant_product in order.order_products">
                                                    <span class="text-[#555555] text-[16px] leading-[26px] w-[200px]">{{
                                                            variant_product.variant.status
                                                        }}({{ variant_product.qty }})</span>
                                                    <span class="text-[#555555] text-[16px] leading-[26px]">SKU: {{
                                                            order.product.sku
                                                        }}</span>
                                                    <span class="text-[#555555] text-[16px] leading-[26px]">€ {{
                                                            variant_product.amount
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--                                        <div class="">-->
                                        <!--                                            <h4 class="mb-[15px] font-[500] text-[16px] leading-[16px] text-[#000000] border-b border-[#DADADA] pb-[15px]">Air Jordan 1 Low LV8D Elevated Onyx (W)</h4>-->
                                        <!--                                            <div class="border-b border-[#DADADA] pb-[5px]">-->
                                        <!--                                                <div class="flex md:gap-[60px] mb-[10px] flex-wrap gap-[10px]">-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">Maat 38 - Aantal (12)</span>-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">SKU: 325.65-355</span>-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">€ 350</span>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="flex md:gap-[60px] mb-[10px] flex-wrap gap-[10px]">-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">Maat 38 - Aantal (12)</span>-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">SKU: 325.65-355</span>-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">€ 350</span>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="flex md:gap-[60px] mb-[10px] flex-wrap gap-[10px]">-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">Maat 38 - Aantal (12)</span>-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">SKU: 325.65-355</span>-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">€ 350</span>-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="flex md:gap-[60px] mb-[10px] flex-wrap gap-[10px]">-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">Maat 38 - Aantal (12)</span>-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">SKU: 325.65-355</span>-->
                                        <!--                                                    <span class="text-[#555555] text-[16px] leading-[26px]">€ 350</span>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <div class="flex justify-between mt-[15px]">
                                            <span class="text-[#555555] text-[16px] leading-[26px]">Totaal</span>
                                            <span
                                                class="text-[#555555] text-[16px] leading-[26px]">€ {{ order.total_price }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right pr-[10px] md:pr-[55px] pb-[25px] relative">
                                <button @click="cancelOrder(order.id)"
                                        class="relative tracking-[0.266667px] text-[16px] leading-[19px] font-[700] px-[15px] py-[4px] bg-[#000] rounded-[72.5px] text-[#fff]">
                                    <div class="loader_wrraper  z-50 " v-if="showLoader"><span class="loader"></span>
                                    </div>
                                    Cancel order
                                </button>
                            </div>
                        </Collapse>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class=" px-[35px] mt-[40px] h-[54px] bg-[#111010] relative rounded-[50px] ">
                        <RouterLink
                            class="font-[TTCommons] text-[22px] font-[700] tracking-[0.266667px]  leading-[26px] text-[#fff]"
                            to="/shop">See all products
                        </RouterLink>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
<style>
.Collapse {
    transition: height 300ms cubic-bezier(0.3, 0, 0.6, 1);
}

.Section {

}

.Section button.Active {
    background: linear-gradient(0deg, #00B67A, #00B67A), linear-gradient(0deg, #FFFFFF, #FFFFFF), #FFFFFF;
    border: 1px solid #00B67A;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.Section button.Active span {
    color: #fff;
}

.Collapse.Active {
    background: linear-gradient(0deg, #F7F7F7, #F7F7F7), linear-gradient(0deg, #FFFFFF, #FFFFFF), #FFFFFF;
    border: 1px solid #F5F5F5;
    border-radius: 5px;
}
</style>
