<template>
    <router-view></router-view>
    <div>
        <button class="w-[70px] fixed bottom-[20px] right-[20px]" @click="openWhatsApp">
            <img :src="whatsappButton" />
        </button>
    </div>
</template>

<script>
import whatsappButton from '../images/WhatsApp.svg';
export default {
    name: 'App',
    methods: {
        openWhatsApp() {
            window.open('https://wa.link/boxstockb2b', '_blank');
        }
    },
    data() {
        return {
            whatsappButton: whatsappButton,
        };
    }
}

</script>
