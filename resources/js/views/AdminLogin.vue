<script setup>
import { ref } from 'vue';
import Toast from "@/components/Toast.vue";
import { Form, Field, ErrorMessage, configure  } from 'vee-validate';
import * as yup from 'yup';
import axios from 'axios';
import router from "@/router";
import { useStore } from 'vuex';


const schema = yup.object().shape({
    // company_name: yup.string().required('This field is required'),
    email: yup.string().required('This field is required').email(),
    password: yup.string().required('This field is required').min(6),
});

const showLoader = ref(false);
const errors = ref([]);
const showMessage = ref(false);
const message = ref();

const store = useStore();

// Handle login account functionality
function onSubmit(data) {
    // console.log(data);
    showLoader.value = true;
    axios({
        method: 'POST',
        url: '/admin/login',
        headers: {
            'Content-Type': 'application/json',
        },
        data: data
    }).then( (res) => {
        showLoader.value = false;
        store.dispatch('setToken', res.data.access_token);
        router.push('/admin');
    }).catch( (err) => {
        console.log(err)
        if(err.response.status === 422){
            errors.value = [];
            errors.value = err.response.data
        }
        if(err.response.status === 401){
            showMessage.value = true
            message.value = err.response.data.error;
        }

        showLoader.value = false;
    });
}
</script>
<template>
    <section class="mb-[200px] mt-[150px] md:mt-[240px]">
        <div class="login-form-wrapper mt-[6px] mb-[6px]">
            <div class="container">
                <div class="form-wrapper mx-auto mt-[33px] justify-center items-center lg:flex">
                    <Toast v-show="showMessage" :showMessage="showMessage" :title="message" />
                    <div class="form-hear">
                        <h2 class="font-[TTCommons] text-[#555555] text-[34px] font-[400px] leading-[32px]">Log in</h2>
                        <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ isSubmitting }">
                            <div class="input-wrrapper pt-[20px]">
                                <label class=" block text-[#000]  font-[TTCommons] text-[14px] font-[400] leading-4 ">Email</label>
                                <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="info@jdsports.nl" name="email" type="email" />
                                <ErrorMessage class="text-red-700" name="email" />
                                <span v-if="errors.email" role="alert" class="text-red-700">{{ errors.email[0] }}</span>
                            </div>
                            <div class="input-wrrapper pt-[20px]">
                                <label class=" block text-[#000]  font-[TTCommons] text-[14px] font-[400] leading-4 ">Password</label>
                                <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Password" name="password" type="password" />
                                <ErrorMessage class="text-red-700" name="password" />
                                <span v-if="errors.password" role="alert" class="text-red-700">{{ errors.password[0] }}</span>
                            </div>
                            <div class="form-check mt-[23px]">
                                <label class=" flex items-center form-check-label text-gray-800 font-[400]">
                                    <input class="form-check-input border-[#DADADA] h-4 w-4 border transiton duration-200 rounded-sm  outline-none  align-top  bg-center bg-contain float-left mr-2 cursor-pointer pl-[15px]" required  type="checkbox" value="Remember me">
                                    Remember me
                                </label>
                            </div>
                            <div>
                                <button type="submit" class=" w-full lg:w-[520px] mt-[30px] h-[54px] bg-[#111010] relative rounded-[50px] font-[TTCommons] text-[22px] font-[700] tracking-[0.266667px]  leading-[26px] text-[#fff] px-[14px]" :disabled="showLoader">
                                    <div class="loader_wrraper" v-show="showLoader"><span  class="loader"></span></div>
                                    Login
                                </button>
                            </div>
                            <div class=" flex justify-between items-center ">
                                <RouterLink class=" flex justify-end mt-[13px] font-[TTCommons] text-[18px] font-[400] leading-[34px] text-[#555555]  " to="/register">Fogot your password</RouterLink>
                            </div>
<!--                            <a href="#" class=" flex justify-end mt-[13px] font-[TT Commons] text-[18px] font-bold leading-[34px] text-[#555555]  ">Fogot your password</a>-->

                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
