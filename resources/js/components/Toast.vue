<script>
export default {
    name: 'Toast',
    props: [
        'title',
        'showMessage'
    ],

    data() {
        return {
            showMessage: false
        }
    },

    methods:{
        hideMessage() {
            this.showMessage = false
        }
    }
}

</script>

<template>
    <div class="flex toaster" v-if="showMessage" @click="hideMessage">
        <div class="mr-auto mr-0">
            <div class="bg-white rounded-lg border-gray-300 border p-3 shadow-lg">
                <div class="flex">
                    <div class="ml-2 mr-6">
                        <span class="font-semibold">{{ title }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.toaster {
    position: fixed;
    top: 30px;
    right: 15px;
    z-index: 9999;
}
</style>
