<script setup>
import { ref } from 'vue';
import { PlusOutlined } from '@ant-design/icons-vue';
import { Form, Field, ErrorMessage, configure  } from 'vee-validate';
import * as yup from 'yup';
import axios from 'axios';
import router from "@/router";
import Swal from 'sweetalert2';

const phoneRegExp = /^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/

const schema = yup.object().shape({
    email: yup.string().required().email(),
    password: yup.string().required().min(6),
    password_confirmation: yup.string().oneOf([yup.ref('password'), null], 'Passwords must match'),
    company_name: yup.string().required('This field is required'),
    phone_number: yup.string().matches(phoneRegExp, 'Phone number is not valid').required('This field is required'),
    country: yup.string().required('This field is required'),
    city: yup.string().required('This field is required'),
    post_code: yup.string().required('This field is required'),
    street_name: yup.string().required('This field is required'),
    user_name: yup.string().required('This field is required'),
});

const showLoader = ref(false);
const errors = ref([]);
const success = ref(false);
const successMsg = ref('');
let image = '';
const imageUrl = ref('');

function accountCreatedAlert() {
    Swal.fire(
        'Account Successfully Created',
        'Once your account approve by admin then you can login',
        'success'
    )
}
// accountCreatedAlert();
// Upload image
function onFileChange(e) {
    const file = e.target.files[0];
    image = file;
    imageUrl.value = URL.createObjectURL(file);
}

// Handle register account functionality
function onSubmit(data) {
    showLoader.value = true;

    data['image'] = image;

    axios({
        method: 'POST',
        url: '/auth/register',
        headers: {
            'content-type': 'multipart/form-data'
        },
        data: data
    }).then( (res) => {
        showLoader.value = false;
        success.value = true;
        successMsg.value = res.data.message;
        accountCreatedAlert();
    }).catch( (err) => {
        if(err.response.status === 400) {
            errors.value = [];
            errors.value = err.response.data
        }
        showLoader.value = false;
    });
}
</script>

<template>
    <section class="mb-[200px] md:mt-[105px] mt-[150px]">
        <div class="login-form-wrapper mt-[6px] mb-[6px] block">
            <div class="container">
                <div class="form2-wrapper mx-auto justify-center items-center lg:flex mt-[33px] pt-[60px]">
                    <div class="form-wrapper">
                        <div class="form-hear">
                            <h2 class=" font-[TTCommons] text-[34px] leading-8 text[#555555] font-[400] ">Registreer</h2>
                                <Form @submit="onSubmit" :validation-schema="schema" class="text-[#a09595] mt-[28px] " v-slot="{ isSubmitting }">
                                    <div class="grouping-form-hear">
                                        <div class="input-wrrapper block justify-center">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Bedrijfsnaam</label>
                                            <Field class="  mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Company" name="company_name" type="text" />
                                            <ErrorMessage class="text-red-700" name="company_name" />
                                            <span v-if="errors.company_name" role="alert" class="text-red-700">{{ errors.company_name[0] }}</span>
                                        </div>
                                        <div class="input-wrrapper block justify-center pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Gebruikersnaam</label>
                                            <Field class="  mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Gebruikersnaam" name="user_name" type="text" />
                                            <ErrorMessage class="text-red-700" name="user_name" />
                                            <span v-if="errors.user_name" role="alert" class="text-red-700">{{ errors.user_name[0] }}</span>
                                        </div>
                                        <div class="input-wrrapper pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Telephonenumber</label>
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Telephonenumber" name="phone_number" type="number" />
                                            <ErrorMessage class="text-red-700" name="phone_number" />
                                            <span v-if="errors.phone_number" role="alert" class="text-red-700">{{ errors.phone_number[0] }}</span>
                                        </div>
                                        <div class="input-wrrapper pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Email</label>
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Email Adress" name="email" type="email" />
                                            <ErrorMessage class="text-red-700" name="email" />
                                            <span v-if="errors.email" role="alert" class="text-red-700">{{ errors.email[0] }}</span>
                                        </div>
                                        <div class="input-wrrapper pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Password</label>
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Password" name="password" type="password" />
                                            <ErrorMessage class="text-red-700" name="password" />
                                            <span v-if="errors.password" role="alert" class="text-red-700">{{ errors.password[0] }}</span>
                                        </div>

                                        <div class="input-wrrapper pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Password confirmation</label>
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Confirm password" name="password_confirmation" type="password" />
                                            <ErrorMessage class="text-red-700" name="password_confirmation" />
                                            <span v-if="errors.password_confirmation" role="alert" class="text-red-700">{{ errors.password_confirmation[0] }}</span>
                                        </div>
                                        <div class="input-wrrapper pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Land</label>
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Netherlands" name="country" type="text" />
                                            <ErrorMessage class="text-red-700" name="country" />
                                            <span v-if="errors.country" role="alert" class="text-red-700">{{ errors.country[0] }}</span>
                                        </div>
                                        <div class="input-wrrapper pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">City</label>
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="City" name="city" type="text" />
                                            <ErrorMessage class="text-red-700" name="city" />
                                            <span v-if="errors.city" role="alert" class="text-red-700">{{ errors.city[0] }}</span>
                                        </div>
                                        <div class="input-wrrapper pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Postcode</label>
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Postcode" name="post_code" type="text" />
                                            <ErrorMessage class="text-red-700" name="post_code" />
                                            <span v-if="errors.post_code" role="alert" class="text-red-700">{{ errors.post_code[0] }}</span>
                                        </div>
                                        <div class="input-wrrapper pt-[20px]">
                                            <label class=" block text-[#000] font-medium  font-[TTCommons] text-[14px] font-[400] leading-4 ">Street name</label>
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Street name" name="street_name" type="text" />
                                            <ErrorMessage class="text-red-700" name="street_name" />
                                            <span v-if="errors.street_name" role="alert" class="text-red-700">{{ errors.street_name[0] }}</span>
                                        </div>
                                        <div class="input-wrapper pt-[20px]">
                                            <label class="block text-[#000] mb-[15px]">Profile picture</label>
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
                                                        <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">Upload profile picture</p>
                                                    </div>
                                                </label>
                                                <input type="file" name="image" @change="onFileChange" class="opacity-0 absolute top-0 left-0 right-0 bottom-0 w-full h-full" />
                                            </div>
                                        </div>

                                        <p class="text-[#555555] font-[TTCommons] text-[400] text-[18px] leading-[18px] pt-[36px]">NAW gegevens aanpassen, neem dan <RouterLink class="text-[#00B67A]" to="/contact">contact</RouterLink> met ons op.</p>
                                    </div>
                                    <button type="submit" class=" w-full lg:w-[520px] mt-[60px] h-[54px] bg-[#000] relative rounded-[50px] font-[TTCommons] text-[22px] font-[700] tracking-[0.266667px]  leading-[26px] text-[#fff] px-[14px]">
                                        <div class="loader_wrraper" v-show="showLoader"><span  class="loader"></span></div>
                                        Registreer
                                    </button>
                                </Form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
