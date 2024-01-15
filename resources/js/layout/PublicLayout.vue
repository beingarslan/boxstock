<script>
import DefaultHeader from '../components/DefaultHeader.vue';
import DefaultFooter from '../components/DefaultFooter.vue';
import ProductSearch from "@/components/ProductSearch.vue";
import {ref, onBeforeMount, reactive, toRaw} from 'vue';
    export default {
        name: 'PublicLayout',
        components: {
            DefaultHeader,
            DefaultFooter,
            ProductSearch
        }
    }
</script>

<template>
    <main id="publicLayout">
        <DefaultHeader />
        <div class="main mt-[188px] md:mt-[98px]">
            <ProductSearch />
            <router-view/>
        </div>
        <DefaultFooter />
    </main>
</template>
