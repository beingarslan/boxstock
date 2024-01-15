<script setup>
import { ref } from 'vue';
import Toast from "@/components/Toast.vue";
import { Form, Field, ErrorMessage, configure  } from 'vee-validate';
import * as yup from 'yup';
import axios from 'axios';
import router from "@/router";
import { useStore } from 'vuex';
import Swal from 'sweetalert2';

const schema = yup.object().shape({
    email: yup.string().required('This field is required').email(),
    password: yup.string().required('This field is required').min(6),
});

const showLoader = ref(false);
const errors = ref([]);
const showMessage = ref(false);
const message = ref();

const store = useStore();
function accountCreatedAlert(message) {
    Swal.fire(
        message,
        '',
        'error'
    )
}

// Handle login account functionality
function onSubmit(data) {
    showLoader.value = true;
    axios({
        method: 'POST',
        url: '/auth/login',
        headers: {
            'Content-Type': 'application/json',
        },
        data: data
    }).then( (res) => {
        showLoader.value = false;
        store.dispatch('setToken', res.data.access_token);
        store.dispatch('setUser', res.data.user);
        router.push('/order-list');
    }).catch( (err) => {
        console.log(err)
        accountCreatedAlert('Something went wrong please try again latter')
        showLoader.value = false;
    });
}
</script>
<template>
    <section class="mb-[200px]">
        <div class="login-form-wrapper mt-[6px] mb-[6px] pt-[60px]">
            <div class="container">
                <div class="form-wrapper mx-auto mt-[33px] justify-center items-center lg:flex">
<!--                    <Toast v-show="showMessage" :showMessage="showMessage" :title="message" />-->
                    <div class="form-hear">
                        <h2 class="font-[TTCommons] text-[#555555] text-[34px] font-[400px] leading-[32px]">Log in</h2>
<!--                        <span v-if="message" role="alert" class="text-red-700">{{ message }}</span>-->
                        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ isSubmitting }">
                            <div class="input-wrrapper pt-[20px]">
                                <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Email</label>
                                <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Email adress" name="email" type="email" />
                                <ErrorMessage class="text-red-700" name="email" />
                                <span v-if="errors.email" role="alert" class="text-red-700">{{ errors.email[0] }}</span>
                            </div>
                            <div class="input-wrrapper pt-[20px]">
                                <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Password</label>
                                <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Password" name="password" type="password" />
                                <ErrorMessage class="text-red-700" name="password" />
                                <span v-if="errors.password" role="alert" class="text-red-700">{{ errors.password[0] }}</span>
                            </div>
                            <div class="form-check mt-[23px]">
                                <label class=" flex items-center form-check-label text-gray-800 font-bold">
                                    <input class="form-check-input border-[#DADADA] h-4 w-4 border transiton duration-200 rounded-sm  outline-none  align-top  bg-center bg-contain float-left mr-2 cursor-pointer pl-[15px]" required  type="checkbox" value="Remember me">
                                    Remember me
                                </label>
                            </div>
                            <div>
                                <button type="submit" class="!text-[#fff] w-full lg:w-[520px] mt-[30px] h-[54px] bg-[#111010] relative rounded-[50px] font-[TTCommons] text-[22px] font-[700] tracking-[0.266667px]  leading-[26px] text-[#fff] px-[14px]" :disabled="showLoader">
                                    <div class="loader_wrraper" v-show="showLoader"><span  class="loader"></span></div>
                                    Login
                                </button>
                            </div>
                            <div class=" flex justify-between items-center ">
<!--                                <router-link to="/register"></router-link>-->
                                <RouterLink class=" flex justify-end mt-[13px] font-[TTCommons] text-[18px] font-bold leading-[34px] text-[#00B67A]  " to="/register">Registreer</RouterLink>
<!--                                <RouterLink class=" flex justify-end mt-[13px] font-[TTCommons] text-[18px] font-bold leading-[34px] text-[#555555]  " to="/register">Fogot your password</RouterLink>-->
                            </div>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
