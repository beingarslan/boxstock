<script setup>
import {onBeforeMount, reactive, ref, toRaw} from 'vue';
import {Collapse} from 'vue-collapsed';
import toggleBtn from "../../images/toggle-btn.svg";
import axios from "axios";

const visible = ref(false);
const showLoader = ref(false);
const autocompleteVal = ref(undefined);
const loading = ref(false);
const current = ref(2);

const closeModal = () => {
    visible.value = false;
}

const filterOption = (input, option) => {
    return option.value.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};

const formRef = ref();
let filterData = [];
const formState = reactive({
    status: '',
    delivery_method: '',
});

let ordersList = [];
let labelCol = {
    span: 8,
}
let wrapperCol = {
    span: 12,
}


const orders = reactive(
    ordersList.map(() => ({
        isExpanded: false, // Initial values, display expanded on mount
    }))
);

const activePanel = ref();

function handleAccordion(selectedIndex) {
    activePanel.value = selectedIndex;
}

const orderData = ref([]);

onBeforeMount(async () => {
    let token = localStorage.getItem('token');

    loading.value = true;
    await axios.get('/orders/', {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        orderData.value = res.data.orders;
        filterData = res.data.orders;

    });
    loading.value = false;
});

let orderId = '';

function editOrder(oId) {
    orderId = oId;
    visible.value = true;
    let token = localStorage.getItem('token');
    axios({
        method: 'GET',
        url: '/orders/' + oId + '/edit',
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        formState.status = res.data.order.status;
        formState.delivery_method = res.data.order.delivery_method;
    })
}

function updateHandler() {

    let token = localStorage.getItem('token');
    showLoader.value = true;
    axios({
        method: 'PUT',
        url: '/orders/' + orderId,
        headers: {
            Authorization: 'Bearer ' + token
        },
        data: toRaw(formState)
    }).then((res) => {
        closeModal();
        window.location.reload();
    })
}

function filterByProductName(searchText) {
    orderData.value = filterData.filter(item => {
        return item.product.name.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
    });
}

function cancelOrder(id) {
    showLoader.value = true;
    let token = localStorage.getItem('token');
    axios.delete('/orders/' + id, {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        window.location.reload();
    });
    showLoader.value = false;
}

const onShowSizeChange = (current, pageSize) => {
    current.value = current;
}

</script>
<template>
    <a-modal v-model:visible="visible" title="Edit order" class="relative">
        <div class="loader_wrraper  z-50 " v-show="showLoader"><span class="loader"></span></div>
        <a-form
            ref="formRef"
            :model="formState"
            :label-col="labelCol"
            :wrapper-col="wrapperCol"
        >
            <a-form-item label="Delivery method" name="delivery_method">
                <a-select v-model:value="formState.delivery_method" placeholder="please select delivery method">
                    <a-select-option value="DHL">DHL</a-select-option>
                    <a-select-option value="POSTNL">POSTNL</a-select-option>
                    <a-select-option value="DPD">DPD</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item label="Order status" name="status">
                <a-select v-model:value="formState.status" placeholder="please select status">
                    <a-select-option value="0">Bestelling onhold</a-select-option>
                    <a-select-option value="1">Bestelling gereed</a-select-option>
                    <a-select-option value="2">Bestelling niet gereed</a-select-option>
                    <a-select-option value="3">Nabestelling</a-select-option>
                    <a-select-option value="4">Bestelling is gereed maar sommige items in backorder</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                <a-button type="primary" @click="updateHandler">Update</a-button>
            </a-form-item>
        </a-form>
    </a-modal>
    <div class="mt-[188px] md:mt-[97px] mb-[100px]">
        <div class="container">
            <div class="flex items-center flex-wrap gap-[20px] mb-[20px]">
                <div>
                    <span>Product name: </span>
                    <input @input="filterByProductName($event)" class="py-[10px] border border-[#f5f5f5] px-[10px]" type="text" placeholder="Filter by product name" />
                </div>
            </div>
            <div v-if="orderData.length > 0" v-for="(order, index) in orderData" :key="order.id" class="Section mb-[10px]">
                <button
                    class="flex md:flex-row flex-col md:items-center items-start justify-between w-full h-auto p-[10px] border border-[#DADADA] rounded-[5px] px-[10px]"
                    :class="[
                                'Panel',
                                {
                                    Active: activePanel === index,
                                },
                            ]"
                    @click="() => handleAccordion(index)"
                >
                    <!-- {{ order.title }} -->
                    <div class="flex md:gap-[40px] gap-[10px] flex-wrap ">
                        <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{ order.order_id }}</span>
                        <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{
                                order.total_price
                            }}</span>
                        <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{ order.order_date }}</span>
                        <span class="text-[#555555] font-[400] text-[16px] leading-[19px] text-ellipsis overflow-hidden"
                              :title="order.status === '0' ? 'Bestelling onhold' : order.status === '1' ? 'Bestelling gereed' : order.status === '2' ? 'Bestelling niet gereed' : order.status === '3' ? 'Nabestelling' : order.status === '4' ? 'Bestelling is gereed maar sommige items in backorder' : ''">{{
                                order.status === '0' ? 'Bestelling onhold' : order.status === '1' ? 'Bestelling gereed' : order.status === '2' ? 'Bestelling niet gereed' : order.status === '3' ? 'Nabestelling' : order.status === '4' ? 'Order ready with backorder' : ''
                            }}</span>
                        <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{
                                order.delivery_method
                            }}</span>
                        <span class="text-[#555555] font-[400] text-[16px] leading-[19px]">{{
                                order.user.company_name
                            }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-[20px] md:mt-0">
                        <span>{{ order.user.user_name }}</span>
                        <div class="md:ml-[120px] ml-[20px] flex items-center">
                            <img class="w-[30px] h-[30px] rounded-full" :src="order.user.image"/>
                            <span class="ml-[20px]"><img :src="toggleBtn"/></span>
                        </div>
                    </div>
                </button>

                <Collapse as="section" :when="activePanel === index" :class="[{
                            Active:activePanel === index
                        }]" class="Collapse">
                    <div class="px-[10px] pb-[30px]">
                        <div
                            class="border-dashed border-b border-[#DADADA] py-[15px] px-[10px] pl-0 flex items-start gap-[15px]">
                            <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                    order.user.company_name
                                }}</span>
                            <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                    order.user.street_name
                                }}</span>
                            <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                    order.user.post_code
                                }}</span>
                            <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                    order.user.city
                                }}</span>
                            <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                    order.user.country
                                }}</span>
                            <span class="text-[#555555] text-[16px] leading-[19px] font-[400]">{{
                                    order.user.phone_number
                                }}</span>
                        </div>
                        <div class="mt-[35px] flex flex-col md:flex-row gap-[20px] md:gap-[50px]">
                            <h4 class="font-[500] text-[16px] leading-[16px] text-[#000000]">Bestelingen</h4>
                            <div>
                                <div class="mb-[40px]">
                                    <h4 class="mb-[15px] font-[500] text-[16px] leading-[16px] text-[#000000] border-b border-[#DADADA] pb-[15px]">
                                        {{ order.product.name }}</h4>
                                    <div class="border-b border-[#DADADA] pb-[5px]">
                                        <!--                                                {{order.order_products.variant.name}}-->
                                        <div class="flex md:gap-[60px] mb-[10px] flex-wrap gap-[10px]"
                                             v-for="variant_product in order.order_products">
                                            <span class="text-[#555555] text-[16px] leading-[26px] w-[200px]">{{
                                                    variant_product.variant.status
                                                }}({{
                                                    variant_product.qty
                                                }}) {{
                                                    variant_product.status === '0' ? 'Bestelling onhold' : variant_product.status === '1' ? 'Bestelling gereed' : variant_product.status === '2' ? 'Bestelling niet gereed' : variant_product.status === '3' ? 'Nabestelling' : variant_product.status === '4' ? 'Bestelling is gereed maar sommige items in backorder' : ''
                                                }}</span>
                                            <span class="text-[#555555] text-[16px] leading-[26px]">SKU: {{
                                                    order.product.sku
                                                }}</span>
                                            <span class="text-[#555555] text-[16px] leading-[26px]">€ {{
                                                    variant_product.amount
                                                }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-[15px]">
                                    <span class="text-[#555555] text-[16px] leading-[26px]">Totaal</span>
                                    <span
                                        class="text-[#555555] text-[16px] leading-[26px]">€ {{
                                            order.total_price
                                        }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-right pr-[10px] md:pr-[55px] pb-[25px] relative">
                            <button @click="cancelOrder(order.id)"
                                    class="relative tracking-[0.266667px] text-[16px] leading-[19px] font-[700] px-[15px] py-[4px] bg-[#000] rounded-[72.5px] text-[#fff]">
                                <div class="loader_wrraper  z-50 " v-if="showLoader"><span class="loader"></span>
                                </div>
                                Cancel order
                            </button>
                        </div>
                        <div class="text-right pr-[10px] md:pr-[55px] pb-[25px]">
                            <button @click="editOrder(order.id)"
                                    class="tracking-[0.266667px] text-[16px] leading-[19px] font-[700] px-[15px] py-[4px] bg-[#000] rounded-[72.5px] text-[#fff]">
                                Stuur mail
                            </button>
                        </div>
                    </div>
                </Collapse>
            </div>
            <div v-else class="ant-empty ant-empty-normal"><div class="ant-empty-image"><svg class="ant-empty-img-simple" width="64" height="41" viewBox="0 0 64 41"><g transform="translate(0 1)" fill="none" fill-rule="evenodd"><ellipse class="ant-empty-img-simple-ellipse" fill="#F5F5F5" cx="32" cy="33" rx="32" ry="7"></ellipse><g class="ant-empty-img-simple-g" fill-rule="nonzero" stroke="#D9D9D9"><path d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z"></path><path d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z" fill="#FAFAFA" class="ant-empty-img-simple-path"></path></g></g></svg></div><p class="ant-empty-description">No Data</p><!----></div>
            <a-pagination
                v-model:current="current"
                show-less-items
                :default-current="3"
                :total="orderData.length"
                @showSizeChange="onShowSizeChange"
            />
        </div>
    </div>
</template>
<style>
.Collapse {
    transition: height 300ms cubic-bezier(0.3, 0, 0.6, 1);
}

.Section {

}

.Section button.Active {
    background: linear-gradient(0deg, #00B67A, #00B67A), linear-gradient(0deg, #FFFFFF, #FFFFFF), #FFFFFF;
    border: 1px solid #00B67A;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.Section button.Active span {
    color: #fff;
}

.Collapse.Active {
    background: linear-gradient(0deg, #F7F7F7, #F7F7F7), linear-gradient(0deg, #FFFFFF, #FFFFFF), #FFFFFF;
    border: 1px solid #F5F5F5;
    border-radius: 5px;
}
</style>
