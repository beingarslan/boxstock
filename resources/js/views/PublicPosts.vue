<template>
    <div class="retailers">
        <div class="container">
            <div class="main-content mt-[50px] mb-[100px]">
<!--                {{data}}-->
<!--                {{posts}}-->
                <div v-if="!loading">
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
                            <RouterLink :to="'/blog/' + item.slug">
                                <div class="p-3 cursor-pointer overflow-hidden ">
                                    <div class="sneakers-card h-full w-full bg-white transform transition duration-500 rounded border border-[#DADADA] hover:shadow-xl hover:border-[#ffffff] ">
                                        <div><img class="w-full" :src="item.image" alt="blog-title"/></div>
                                        <div class="content px-[15px]">
                                            <span class="text-[#555555] font-medium inline-block text-[18px] mt-[15px]">By {{ item.user.company_name }}  {{ format_date(item.created_at)}}</span>
                                            <h4 class="font-bold text-[18px] mt-[15px]">{{ item.title }}</h4>
                                            <p class="text-[#555555]">{{ item.description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </RouterLink>
                        </template>
                    </a-list>
                </div>
                <div v-else class="loader_wrapper_">
                    <span class="loader"></span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {nextTick, onMounted, reactive, ref, toRaw} from 'vue';
import axios from "axios";
import router from "@/router";
import moment from 'moment';
const visible = ref(false);

export default {
    components: {
        moment
    },
    setup() {
        const posts = ref();
        const initLoading = ref(true);
        const loading = ref(false);
        const totalProduct = ref();
        const list = ref([]);
        const value = ref('');
        const dataSource = ref([]);
        let page = ref(1);

        const getPosts = (token) => {
            axios.get('/posts/?page='+page.value, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                initLoading.value = false;
                console.log(res)
                posts.value = res.data.posts.data;
                list.value = res.data.posts.data;
                totalProduct.value = res.data.posts.total;
            })
        }

        const format_date = (value) => {
            if (value) {
                return moment(String(value)).format('DD / MM / YYYY')
            }
        }

        const onLoadMore = () => {
            loading.value = true;

            page.value = page.value + 1;

            list.value = posts.value.concat([...new Array(page.value)].map(() => ({
                loading: true,
                name: {},
                picture: {},
            })));

            let token = localStorage.getItem('token');
            axios.get('/posts?page='+page.value, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                // console.log(res)
                const newData = posts.value.concat(res.data.posts.data);
                loading.value = false;
                posts.value = newData;
                list.value = newData;
                nextTick(() => {
                    window.dispatchEvent(new Event('resize'));
                });
            });
        };

        onMounted(() => {
            let token = localStorage.getItem('token');
            getPosts(token);
        });


        // End new product functionality
        return {
            posts,
            visible,
            format_date,
            initLoading,
            loading,
            totalProduct,
            value,
            dataSource,
            page,
            list,
            onLoadMore
        };
    },
};
</script>
