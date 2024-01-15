<script setup>

import {onMounted, ref, toRaw} from "vue";
import { Form, Field, ErrorMessage, configure  } from 'vee-validate';
import * as yup from 'yup';
import axios from 'axios';
import router from "@/router";
import Swal from 'sweetalert2';

const showLoader = ref(false);

//
const schema = yup.object().shape({
    email: yup.string().required('Email is required').email(),
    name: yup.string().required('Name is required'),
    question: yup.string().required('Question is required'),
});

function sendEmailAlert() {
    Swal.fire(
        'Successful',
        'Your message send successfully. Thank you.',
        'success'
    )
}

const onSubmit = (data) => {
    showLoader.value = true;
    let token = localStorage.getItem('token');
    axios({
        method: 'POST',
        url: '/contact/',
        headers: {
            Authorization: 'Bearer ' + token,
            'content-type': 'multipart/form-data'
        },
        data: data
    }).then( (res) => {
        showLoader.value = false;
        sendEmailAlert();
    });
};
</script>

<template>
    <section class="mt-[100px]">
        <div class="contact-wrapper-hear">
            <div class="container">
                <div class="contact-text-hear">
                    <div class="contact-text">
                        <h2 class=" mb-0 font-TTcommens text-[34px] leading-[40px] font-bold text-[#00B67A]">Contact</h2>
                        <p class="font-TTcommens text-[18px] leading-[24px] mb-0 font-[400] text-[#000] pt-[15px]">Bij
                            Boxstock hechten wij veel waarde aan service en willen wij iedereen goed <br class="hidden md:block" /> kunnen helpen. Maak hier keuze uit de
                            contactmethode die het beste bij jou <br class="hidden md:block" /> past, ons team staat voor je klaar!</p>
                    </div>
                    <div class="contact-btn-hear">
                        <div class="row">
                            <div class="contact-btn-with-form grid grid-cols-1 md:grid-cols-2 gap-[24px]">
                                <div class="contact-btn-text-hear">
                                    <hr class="text-[#E5E5E5] mt-[58px]" />
                                    <h2 class=" mt-[20px] font-TTcommens text-[22px] leading-[18px] mb-0 font-[700] text-[#555555] "> Hotline order</h2>
                                    <span class=" flex items-center mt-[15px] gap-[10px] font-TTcommens text-[22px] leading-[18px] mb-0 font-[400] text-[#555555]">
                                        <svg fill="#000000" height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                             viewBox="0 0 473.806 473.806" xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <path d="M374.456,293.506c-9.7-10.1-21.4-15.5-33.8-15.5c-12.3,0-24.1,5.3-34.2,15.4l-31.6,31.5c-2.6-1.4-5.2-2.7-7.7-4
                                                            c-3.6-1.8-7-3.5-9.9-5.3c-29.6-18.8-56.5-43.3-82.3-75c-12.5-15.8-20.9-29.1-27-42.6c8.2-7.5,15.8-15.3,23.2-22.8
                                                            c2.8-2.8,5.6-5.7,8.4-8.5c21-21,21-48.2,0-69.2l-27.3-27.3c-3.1-3.1-6.3-6.3-9.3-9.5c-6-6.2-12.3-12.6-18.8-18.6
                                                            c-9.7-9.6-21.3-14.7-33.5-14.7s-24,5.1-34,14.7c-0.1,0.1-0.1,0.1-0.2,0.2l-34,34.3c-12.8,12.8-20.1,28.4-21.7,46.5
                                                            c-2.4,29.2,6.2,56.4,12.8,74.2c16.2,43.7,40.4,84.2,76.5,127.6c43.8,52.3,96.5,93.6,156.7,122.7c23,10.9,53.7,23.8,88,26
                                                            c2.1,0.1,4.3,0.2,6.3,0.2c23.1,0,42.5-8.3,57.7-24.8c0.1-0.2,0.3-0.3,0.4-0.5c5.2-6.3,11.2-12,17.5-18.1c4.3-4.1,8.7-8.4,13-12.9
                                                            c9.9-10.3,15.1-22.3,15.1-34.6c0-12.4-5.3-24.3-15.4-34.3L374.456,293.506z M410.256,398.806
                                                            C410.156,398.806,410.156,398.906,410.256,398.806c-3.9,4.2-7.9,8-12.2,12.2c-6.5,6.2-13.1,12.7-19.3,20
                                                            c-10.1,10.8-22,15.9-37.6,15.9c-1.5,0-3.1,0-4.6-0.1c-29.7-1.9-57.3-13.5-78-23.4c-56.6-27.4-106.3-66.3-147.6-115.6
                                                            c-34.1-41.1-56.9-79.1-72-119.9c-9.3-24.9-12.7-44.3-11.2-62.6c1-11.7,5.5-21.4,13.8-29.7l34.1-34.1c4.9-4.6,10.1-7.1,15.2-7.1
                                                            c6.3,0,11.4,3.8,14.6,7c0.1,0.1,0.2,0.2,0.3,0.3c6.1,5.7,11.9,11.6,18,17.9c3.1,3.2,6.3,6.4,9.5,9.7l27.3,27.3
                                                            c10.6,10.6,10.6,20.4,0,31c-2.9,2.9-5.7,5.8-8.6,8.6c-8.4,8.6-16.4,16.6-25.1,24.4c-0.2,0.2-0.4,0.3-0.5,0.5
                                                            c-8.6,8.6-7,17-5.2,22.7c0.1,0.3,0.2,0.6,0.3,0.9c7.1,17.2,17.1,33.4,32.3,52.7l0.1,0.1c27.6,34,56.7,60.5,88.8,80.8
                                                            c4.1,2.6,8.3,4.7,12.3,6.7c3.6,1.8,7,3.5,9.9,5.3c0.4,0.2,0.8,0.5,1.2,0.7c3.4,1.7,6.6,2.5,9.9,2.5c8.3,0,13.5-5.2,15.2-6.9
                                                            l34.2-34.2c3.4-3.4,8.8-7.5,15.1-7.5c6.2,0,11.3,3.9,14.4,7.3c0.1,0.1,0.1,0.1,0.2,0.2l55.1,55.1
                                                            C420.456,377.706,420.456,388.206,410.256,398.806z"/>
                                                        <path d="M256.056,112.706c26.2,4.4,50,16.8,69,35.8s31.3,42.8,35.8,69c1.1,6.6,6.8,11.2,13.3,11.2c0.8,0,1.5-0.1,2.3-0.2
                                                            c7.4-1.2,12.3-8.2,11.1-15.6c-5.4-31.7-20.4-60.6-43.3-83.5s-51.8-37.9-83.5-43.3c-7.4-1.2-14.3,3.7-15.6,11
                                                            S248.656,111.506,256.056,112.706z"/>
                                                        <path d="M473.256,209.006c-8.9-52.2-33.5-99.7-71.3-137.5s-85.3-62.4-137.5-71.3c-7.3-1.3-14.2,3.7-15.5,11
                                                            c-1.2,7.4,3.7,14.3,11.1,15.6c46.6,7.9,89.1,30,122.9,63.7c33.8,33.8,55.8,76.3,63.7,122.9c1.1,6.6,6.8,11.2,13.3,11.2
                                                            c0.8,0,1.5-0.1,2.3-0.2C469.556,223.306,474.556,216.306,473.256,209.006z"/>
                                                    </g>
                                                </g>
                                                </svg>
                                        06123456789
                                    </span>
                                    <hr class="text-[#E5E5E5] mt-[25px]" />
                                    <h2 class=" mt-[20px] font-TTcommens text-[22px] leading-[18px] mb-0 font-[700] text-[#555555] "> Neem contact op via mail</h2>
                                    <a href="mailto:admin@boxstock.com" class="bg-[#000000] hover:text-[#fff] rounded-[73px] px-[28px] py-[14px] font-[700] inline-block tracking-[0.27px] mt-[26px] text-[#FFFFFF] ">Contact us</a>
                                </div>
                                <div class="contact-form">
                                    <hr class="text-[#E5E5E5] mt-[58px]" />
                                    <h2 class=" mt-[20px] font-TTcommens text-[22px] leading-[18px] inline-block mb-[15px] font-bold text-[#555555]"> Of vul het formulier in</h2>
                                    <Form class="inline-block" @submit="onSubmit" :validation-schema="schema" v-slot="{ isSubmitting }">
                                        <div class="input-wrrapper">
                                            <Field class="  mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="Name" name="name" type="text" />
                                            <ErrorMessage class="text-red-700" name="name" />
                                        </div>
                                        <div class="input-wrrapper pt-[15px]">
                                            <Field class="mt-[10px] py-[18px] rounded-[5px]  w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px] " placeholder="info@jdsports.nl" name="email" type="email" />
                                            <ErrorMessage class="text-red-700" name="email" />
                                        </div>
                                        <div class="input-wrapper pt-[15px]">
                                            <Field v-model="question" type="text" name="question" v-slot="{ field }">
                                                <textarea v-bind="field" class="border w-full border-[#DADADA] rounded-[5px] outline-none pl-[17px] py-[18px]" cols="54" rows="5" placeholder="Question..."></textarea>
                                            </Field>
                                            <ErrorMessage class="text-red-700" name="question" />
                                        </div>
                                        <div class="loader_wrraper" v-show="showLoader"><span  class="loader"></span></div>
                                        <button type="submit" class="btn-hear bg-[#000000] rounded-[73px] font-[700] hover:text-[#fff] px-[28px] py-[14px] mt-[30px] tracking-[0.27px] mb-[30px] text-[#FFFFFF] inline-block">Send question</button>
                                        <hr class="text-[#E5E5E5] mt-[30px] mb-[250px]" />
                                    </Form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
