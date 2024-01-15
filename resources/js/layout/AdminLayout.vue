<template>
    <main id="adminLayout">
        <AdminTopHeader />
        <div class="mt-[50px] pt-[15px]">
            <router-view/>
        </div>
    </main>
</template>
<script>
import AdminHeader from "@/components/AdminHeader.vue";
import AdminTopHeader from "@/components/AdminTopHeader.vue";
export default {
    components: {AdminTopHeader, AdminHeader}
}
</script>
