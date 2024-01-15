<script>
import { ref } from 'vue';
import toggleBtn from '../../images/toggle-menu.svg';
const hideSidebar = ref(false);

export default {
    setup() {
        return {
            hideSidebar,
            toggleBtn,
        }
    }
}

</script>
<template>
    <div>
        <div class="">
            <div class="fixed top-0 left-0 w-[300px] h-full bg-[#000] z-[9999]">
                <ul class="mt-[100px] pt-[50px] pl-[30px]">
                    <li class="mb-[20px]"><RouterLink class="font-[600] text-[#fff]" to="/admin">Users</RouterLink></li>
                    <li class="mb-[20px]"><RouterLink class="font-[600] text-[#fff]" to="/admin/products">Products</RouterLink></li>
                    <li class="mb-[20px]"><RouterLink class="font-[600] text-[#fff]" to="/admin/posts">Posts</RouterLink></li>
                    <li class="mb-[20px]"><RouterLink class="font-[600] text-[#fff]" to="/admin/category">Categories</RouterLink></li>
                    <li class="mb-[20px]"><RouterLink class="font-[600] text-[#fff]" to="/admin/brands">Brands</RouterLink></li>
                    <li class="mb-[20px]"><RouterLink class="font-[600] text-[#fff]" to="/admin/sizes">Sizes</RouterLink></li>
                    <li class="mb-[20px]"><RouterLink class="font-[600] text-[#fff]" to="/admin/variants">Variants</RouterLink></li>
                    <li><RouterLink class="font-[600] text-[#fff]" to="/admin/orders">Orders</RouterLink></li>
                </ul>
            </div>
        </div>
    </div>
</template>
