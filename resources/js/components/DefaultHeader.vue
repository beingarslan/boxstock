<script setup>

import {ref, onBeforeMount, onMounted, reactive, toRaw} from 'vue';
import {RouterLink} from "vue-router";
import router from "@/router";
import {useStore} from 'vuex';
import axios from 'axios';

// Static image
import imgUrl from '../../images/logo-b2b.svg';
import invoiceLink from '../../images/invoice.svg';
import avatarLink from '../../images/avatar.png';
import logoutBtn from '../../images/logout.svg';

const store = useStore();
const visible = ref(false);
const user = ref();
const products = ref([]);
const layout = ref('');
const imageUrl = ref('');
let image = '';

function orderDetails() {
    router.push({
        name: 'OrderList'
    });
}

function logOut() {
    store.dispatch('removeToken');
    router.push('/')
}

function closeModal() {
    visible.value = false;
}

const loader = ref(true);

onBeforeMount(() => {
    let token = localStorage.getItem('token');
    let layoutData = localStorage.getItem('layout');
    layout.value = layoutData;
    if (token) {
        axios.get('/auth/user-profile', {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }).then((res) => {
            store.dispatch('setUser', res.data);
        }).catch((e) => {
            store.dispatch('removeUser', 0);
            store.dispatch('removeToken', 0);
        })
    }
    loader.value = false;
});

// Form data
const formRef = ref();
const formState = reactive({
    user_id: '',
    user_name: '',
    company_name: '',
    phone_number: '',
    password: '',
});

const editModal = (id) => {
    user.value = id;
    visible.value = true;
    getUserData(id);
};

const getUserData = (id) => {
    let token = localStorage.getItem('token');

    if (token) {
        axios.get('/auth/user/' + id, {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }).then((res) => {
            formState.user_id = res.data.user.id;
            imageUrl.value = res.data.user.image;
            formState.user_name = res.data.user.user_name;
            formState.company_name = res.data.user.company_name;
            formState.phone_number = res.data.user.phone_number;
            formState.password = res.data.user.password;
        }).catch((e) => {
            store.dispatch('removeUser', 0);
            store.dispatch('removeToken', 0);
        })
    }
}

const onSubmit = () => {
    let token = localStorage.getItem('token');
    axios({
        method: 'POST',
        url: '/auth/update/' + formState.user_id,
        headers: {
            Authorization: 'Bearer ' + token
        },
        data: toRaw(formState)
    }).then((res) => {
        let imageData = {
            'id': formState.user_id,
            'type': 'user',
            'image': image
        }

        axios({
            method: 'POST',
            url: '/image/update',
            headers: {
                Authorization: 'Bearer ' + token,
                'content-type': 'multipart/form-data'
            },
            data: imageData
        }).then( (res) => {
            closeModal();
            window.location.reload();
            visible.value = false;
        });
        visible.value = false;
        window.location.reload();
        visible.value = false;
        window.location.reload();
    })
};
function onFileChange(e) {
    const file = e.target.files[0];
    image = file;
    imageUrl.value = URL.createObjectURL(file);
}
</script>

<template>
    <header class="pt-[33px] pb-[33px] fixed top-0 w-full  border-b border-[1px] border-[#ebebeb] bg-[#fff] z-50 ">
        <div class="container">
            <div class="flex items-center justify-between flex-col md:flex-row">
                <div class="logo">
                    <RouterLink to="/"><img :src="imgUrl" alt="logo"/></RouterLink>
                </div>
                <!-- {{ store.getters.getLayout }} -->
                <nav v-if="store.getters.getLayout !== 'LayoutAdmin'"
                     class="navigation flex items-center justify-between flex-col mt-[20px] md:mt-[0px] md:flex-row">
                    <div class="flex items-center md:mr-[20px]">
                        <RouterLink class="font-[600]" to="/shop">Buy</RouterLink>
                        <RouterLink class="font-[600]" to="/shop">Sell</RouterLink>
                        <RouterLink class="font-[400]" to="/contact">Contact</RouterLink>
                    </div>
                    <div class="navigation-right flex items-center mt-[20px] md:mt-[0px]" v-if="store.getters.getToken">
                        <h4 class=" mb-0 font-[TTCommons] font-[600] text-[18px] leading-[22px] text-ellipsis overflow-hidden flex items-center text-[#000] ">
                            {{ store.state.user.company_name }} <span
                            class=" text-[#FD5D2B] font-[TTCommons] text-[18px] font-[400] leading-[22px] block w-[60px] md:w-full text-ellipsis overflow-hidden ml-[20px]">{{
                                store.state.user.user_name
                            }}</span></h4>
                        <img class="ml-[10px] cursor-pointer w-[30px] h-[30px] rounded-full"
                             :src="store.state.user.image ? store.state.user.image : avatarLink" alt="profile-pic"
                             @click="editModal(store.state.user.id)"/>
                        <img @click="orderDetails" class="cursor-pointer ml-[10px]" :src="invoiceLink" alt="invoice"/>
                        <img @click="logOut" class="cursor-pointer ml-[10px]" :src="logoutBtn" alt="logout"/>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <a-modal class="z-[99999] edit_profile" v-model:visible="visible" title="Edit profile">
        <div class="user_udpate_form">
            <a-form :model="formState">
                <a-form-item ref="name" label="Image" name="image">
                    <div class="flex items-center justify-center w-full relative">
                        <div class="flex flex-col items-center justify-center pt-7" v-if="imageUrl">
                            <img class="w-[150px]" :src="imageUrl" />
                        </div>
                        <label v-if="!imageUrl" class="flex flex-col w-full h-32 border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300">
                            <div class="flex flex-col items-center justify-center pt-7">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-gray-600"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">Upload image</p>
                            </div>
                        </label>
                        <input type="file" name="image" @change="onFileChange" class="opacity-0 absolute top-0 left-0 right-0 bottom-0 w-full h-full" />
                    </div>
                </a-form-item>
                <a-form-item label="Company name">
                    <a-input v-model:value="formState.company_name" />
                </a-form-item>
                <a-form-item label="User name">
                    <a-input v-model:value="formState.user_name" />
                </a-form-item>
                <a-form-item label="Phone number">
                    <a-input v-model:value="formState.phone_number" />
                </a-form-item>
                <a-form-item label="Password">
                    <a-input-password v-model:value="formState.password" placeholder="password" />
                </a-form-item>
                <a-form-item class="w-[200px] !text-left">
                    <a-button type="primary" @click="onSubmit">Update</a-button>
                    <a-button style="margin-left: 10px" @click="closeModal">Cancel</a-button>
                </a-form-item>
            </a-form>
        </div>
    </a-modal>
</template>
