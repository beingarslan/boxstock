<script setup>

import {RouterLink, RouterView} from "vue-router";
import BuySellVue from "../components/BuySell.vue";
import sellImg from "../../images/sell-card-img.svg";
import safegrilUrl from "../../images/Safegrail.png";
import safegrilUrl2 from "../../images/Safegrail2.png";
import buyImage from "../../images/jordan.png";
import sneakerSellUlr from "../../images/sneaker-sell.svg";
import sneakerCleaning from "../../images/cleaning-services.jpg";
import moment from 'moment';

// Store
import {useStore} from 'vuex';
import {onBeforeMount, ref} from "vue";
import axios from "axios";

const store = useStore();
const posts = ref('');

onBeforeMount( () => {
    let token = localStorage.getItem('token');
    axios.get('/posts/', {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        posts.value = res.data.posts;
    });
});
</script>

<template>
    <div class="shops-wrapper" :class="store.getters.getToken ? 'mt-[100px]': 'mt-[150px]'">
        <div class="container">
            <div class="shap-text ">
                <h2 class="font-bold text-[34px] font-TTcommons leading-[40px] tracking-[0.3px] text-[#00B67A]">
                    BOXSTOCKB2B for Exclusive Shops</h2>
                <div class="shope-wrapper-text">
                    <p class="pera1 mt-1 text-[18px] leading-6 text-[#000] font-[400px]">Hét platform voor
                        retailers</p>
                    <div
                        class="shape-groupin-text mt-5 text-[18px] leading-6 text-[#000] font-[400px] font-TTcommons">
                        <p class="mb-[30px]">Boxstock B2B is ontstaan uit een passie voor sneakers & streetwear en
                            opgericht om de ingewikkelde resell markt een stukje makkelijker te maken .</p>
                        <p class="mb-[30px]">Door middel van de beste service te leveren en duidelijke te
                            communiceren maken wij het proces van een exclusief item kopen veiliger en
                            makkelijker. </p>
                        <p class="mb-[30px]">Onze experts garanderen authentieke en ongedragen items door ieder item
                            zorgvuldig te controleren. Daarnaast verpakken wij ieder item met de luxe die het
                            verdient en proberen maken wij de ervaring zo compleet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section :class="store.getters.getToken && 'mt-[100px]'" v-if="store.getters.getToken">
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
    </section>
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

                <div class="row mt-[100px]">

                    <div class="single-card-hear grid-cols-1 md:grid-cols-2 grid gap-[59px] items-center">
                        <div>
                            <h2 class="text-[40px] font-TTcommons font-bold leading-[50px] text-[#000000] uppercase mb-[25px]">Sneaker Cleaning Services</h2>
                            <a href="https://www.depoetsdoos.nl/aanvraagb2b" class="cursor-pointer z-20 relative btn-hear bg-[#00B67A] border-[1px] border-[#00B67A] hover:bg-white hover:text-[#000] rounded-[73px] px-[64px] py-[14px]  text-[#FFFFFF] mt-[50px] text-[22px] leading-[27px] font-[TTCommons] font-[600] uppercase tracking-[0.27px]">
                                Aanvragen
                            </a>
                        </div>
                        <div>
                            <img :src="sneakerCleaning" />
                        </div>
                    </div>
                </div>

                <!-- <div class="login-btn text-center mt-[40px]  ">
                  <RouterLink class=" inline-block mx-auto bg-[#00B67A] py-[15px] px-[50px] rounded-[40px] text-white " to="/login">Login</RouterLink>
                </div> -->
            </div>
        </div>
    </section>
    <section>
        <div class="background-card mt-[90px] bg-[#F6F6F6] pb-[188px]">
            <div class="container">
                <div class="row">
                    <div class="card-wrapper-hear ">
                        <div class="card-title-hear ">
                            <h2 class="font-[TT Commons] font-bold text-[32px] leading-8 text-[#555555] text-center  pt-[72px]">
                                Voordelen Boxstock B2B</h2>
                            <p class="text-center bg-[TT Commons] text-[18px] font-[400] leading-6 text-[#000] pt-[14px] ">
                                Boxstock B2B is ontstaan uit een passie voor sneakers & streetwear en opgericht om
                                de ingewikkelde resell markt<br>een stukje makkelijker te maken. Door middel van de
                                beste service te leveren en duidelijke te communiceren<br> maken wij het proces van
                                een exclusief item kopen veiliger en makkelijker.
                            </p>
                        </div>
                        <div class="total-card grid-cols-1  md:grid-cols-3 grid gap-[27px] pt-[38px]">
                            <div
                                class="card w-full h-full bg-[#00B67A] text-[#FFFFFF] rounded-[9px] pl-[25px] pt-[25px] pr-[23px] pb-[25px] m-auto">
                                <h2 class="font-bold text-[32px] leading-[38px] text-[#fff] pb-[10px]">Fast</h2>
                                <p class="font-[TT Commons] font-[400] text-[16px] tracking-[0] leading-6 text-[#fff] mt-0">
                                    Dezelfde dag in huis of de volgende dag uiterst.
                                </p>
                            </div>

                            <div
                                class="card w-full h-full bg-[#5E5755] text-[#FFFFFF] rounded-[9px] pl-[25px] pt-[25px] pr-[23px] pb-[25px] m-auto">
                                <h2 class="font-bold text-[32px] leading-[38px] text-[#fff] pb-[10px]">Safe</h2>
                                <p class="font-[TT Commons] font-[400] text-[16px] tracking-[0] leading-6 text-[#fff] mt-0">
                                    Alles wordt op echtheid gecontrolleerd dus daar hoef jij je geen zorgen over te maken. Alles krijgt ook een tag en wordt een foto van gemaakt incl kenmerken van ons daarbij zodat de historie kunnen terughalen.
                                </p>
                            </div>

                            <div
                                class="card w-full h-full bg-[#90B8AB] text-[#FFFFFF] rounded-[9px] pl-[25px] pt-[25px] pr-[23px] pb-[25px] m-auto">
                                <h2 class="font-bold text-[32px] leading-[38px] text-[#fff] pb-[10px]">More</h2>
                                <p class="font-[TT Commons] font-[400] text-[16px] tracking-[0] leading-6 text-[#fff] mt-0">
                                    Er komen steeds meer features bij voor nu hebben we de cleaning services erbij in combinatie met een ophaal service.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>


