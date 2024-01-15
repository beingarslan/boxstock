<template>
    <div class="retailers">

        <div class="container">
            <div class="text-right mt-[100px] mb-[10px]">
                <v-btn @click="addNewModal">
                    Add new
                </v-btn>
            </div>
            <div class="flex items-center flex-wrap gap-[20px] mb-[20px]">
                <div>
                    <span>Product name: </span>
                    <input @input="filterByProductName($event)" class="py-[10px] border border-[#f5f5f5] px-[10px]" type="text" placeholder="Filter by product name" />
                </div>
                <div>
                    <span>Variant name: </span>
                    <input @input="filterByCategoryName($event)" class="py-[10px] border border-[#f5f5f5] px-[10px]" type="text" placeholder="Filter by variant name" />
                </div>
            </div>
            <a-table :columns="columns" :data-source="data" bordered>
                <template #name="{ text }">
                    <a>{{ text }}</a>
                </template>
                <template #product="{ record }">
                    <span>{{ record.products.name }}</span>
                </template>
                <template #operation="{ record }">
                    <div class="flex gap-[10px] items-center">
                        <v-btn @click="editModal(record.id)">Edit</v-btn>
                        <v-btn class="!bg-[#ff4d4f]" type="danger" @click="deleteHandler(record.id)">Delete</v-btn>
                    </div>
                </template>
            </a-table>
        </div>
        <v-dialog
            v-model="visible"
            width="auto"
        >
            <v-card class="product-form">
            <a-form
                ref="formRef"
                :model="formState"
                :rules="rules"
                :label-col="labelCol"
                :wrapper-col="wrapperCol"
            >
                <a-form-item ref="name" label="Variant name" name="name">
                    <a-input v-model:value="formState.name" />
                </a-form-item>
                <a-form-item ref="variant_status" label="Variant status" name="variant_status">
                    <v-combobox
                        label="Combobox"
                        v-model="formState.variant_status"
                        item-value="id"
                        item-title="title"
                        :items="['Doos onbeschadigd', 'Doos kleine beschadiging', 'Doos beschadigd']"
                    ></v-combobox>
                </a-form-item>
<!--                <a-form-item ref="name" label="Image" name="image">-->
<!--                    <div class="flex items-center justify-center w-full relative">-->
<!--                        <div class="flex flex-col items-center justify-center pt-7" v-if="imageUrl">-->
<!--                            <img class="w-[150px]" :src="imageUrl" />-->
<!--                        </div>-->
<!--                        <label v-if="!imageUrl" class="flex flex-col w-full h-32 border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300">-->
<!--                            <div class="flex flex-col items-center justify-center pt-7">-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-gray-600"-->
<!--                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />-->
<!--                                </svg>-->
<!--                                <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">Upload image</p>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                        <input type="file" name="image" @change="onFileChange" class="opacity-0 absolute top-0 left-0 right-0 bottom-0 w-full h-full" />-->
<!--                    </div>-->
<!--                </a-form-item>-->
                <a-form-item ref="sku" label="Stock" name="stock">
                    <a-input v-model:value="formState.stock" />
                </a-form-item>
                <a-form-item ref="amount" label="Amount" name="amount">
                    <a-input v-model:value="formState.amount" />
                </a-form-item>
                <a-form-item label="Size" name="size_id">
                    <v-combobox
                        label="Select size"
                        v-model="formState.size_id"
                        :items="sizes"
                        item-value="id"
                        item-title="name"
                    ></v-combobox>
                </a-form-item>
                <a-form-item label="Product" name="product_id">
                    <v-combobox
                        label="Select product"
                        v-model="formState.product_id"
                        :items="products"
                        item-value="id"
                        item-title="name"
                    ></v-combobox>
                </a-form-item>
                <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                    <v-btn v-if="pId" @click="updateHandler(pId)">Update</v-btn>
                    <v-btn v-if="!pId"  @click="onSubmit">Save</v-btn>
                    <v-btn type="danger" style="margin-left: 10px" @click="resetForm">Reset</v-btn>
                </a-form-item>
            </a-form>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import {onMounted, reactive, ref, toRaw} from 'vue';
import AdminHeaderVue from '../components/AdminHeader.vue';
import { PlusOutlined, LoadingOutlined } from '@ant-design/icons-vue';
import axios from "axios";
const visible = ref(false);
let image = '';
let filterData = [];
const imageUrl = ref('');

const options = {
    responsive: true,
    select: true,
};

const closeModal = () => {
    visible.value = false;
}


const deleteHandler = (id) => {
    let token = localStorage.getItem('token');
    axios({
        method: 'DELETE',
        url: '/variants/'+id,
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then( (res) => {
        window.location.reload();
    })
};

export default {
    components: {
        AdminHeaderVue,
        LoadingOutlined,
        PlusOutlined,
    },

    setup() {
        const columns = [
            {
                title: 'Name',
                dataIndex: 'name',
            },
            {
                title: 'Price',
                dataIndex: 'amount'
            },
            {
                title: 'Products',
                dataIndex: 'product',
                slots: {
                    customRender: 'product',
                },
            },
            {
                title: 'Action',
                dataIndex: 'operation',
                slots: {
                    customRender: 'operation',
                },
            },
        ];

        const products = ref();
        const sizes = ref();
        const pId = ref();
        const data = ref();

        // Add new product functionality
        const formRef = ref();
        const formState = reactive({
            name: '',
            variant_status: '',
            stock: '',
            amount: '',
            product_id: '',
            size_id: '',
        });

        const editModal = (id) => {
            visible.value = true;
            let token = localStorage.getItem('token');
            axios({
                method: 'GET',
                url: '/variants/'+id+'/edit',
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then( (res) => {
                pId.value = res.data.variant.id;
                formState.name = res.data.variant.name;
                formState.variant_status = res.data.variant.status;
                formState.stock = res.data.variant.stock;
                formState.amount = res.data.variant.amount;
                formState.size_id = res.data.variant.sizes;
                formState.product_id = res.data.variant.products
            })
        };

        const filterByCategoryName = (searchText) => {
            data.value = filterData.filter(item => {
                return item.status.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
            });
        }
        const filterByProductName = (searchText) => {
            data.value = filterData.filter(item => {
                return item.products.name.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
            });
        }

        const rules = {
            name: [
                {
                    required: true,
                    message: 'Please insert name',
                    trigger: 'blur',
                }
            ],
            variant_status: [
                {
                    required: true,
                    message: 'Please select status',
                    trigger: 'blur',
                }
            ],
            stock: [
                {
                    required: true,
                    message: 'Please insert stock',
                    trigger: 'blur',
                },
            ],
            amount: [
                {
                    required: true,
                    message: 'Please insert amount',
                    trigger: 'blur',
                },
            ],
            product_id: [
                {
                    required: true,
                    message: 'Please select product',
                    trigger: 'blur',
                },
            ],
            size_id: [
                {
                    required: true,
                    message: 'Please select size',
                    trigger: 'blur',
                },
            ]
        };

        const onSubmit = () => {
            formRef.value
                .validate()
                .then(() => {
                    let data = toRaw(formState);
                    let token = localStorage.getItem('token');
                    axios({
                        method: 'POST',
                        url: '/variants/',
                        headers: {
                            Authorization: 'Bearer ' + token,
                            'content-type': 'multipart/form-data'
                        },
                        data: data
                    }).then( (res) => {
                        // console.log(res)
                        window.location.reload();
                        closeModal();
                    });
                })
                .catch(error => {
                    console.log('error', error);
                });
        };

        const resetForm = () => {
            formRef.value.resetFields();
            // visible.value = false;
        };

        const addNewModal = () => {
            visible.value = true;
            resetForm();
        }

        const updateHandler = (pId) => {
            let token = localStorage.getItem('token');
            let data = toRaw(formState);
            axios({
                method: 'PUT',
                url: '/variants/'+pId,
                headers: {
                    Authorization: 'Bearer ' + token,
                },
                data: data
            }).then( (res) => {
                closeModal();
                window.location.reload();
                visible.value = false;
            });
        }

        const getVariants = (token) => {
            axios.get('/variants', {
               headers: {
                   Authorization: 'Bearer ' + token
               }
            }).then((res) => {
                // console.log(res)
                data.value = res.data.variant;
                filterData = res.data.variant;
            });
        }

        const getSizes = (token) => {

            axios.get('/sizes', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                // console.log(res.data.brand)
                sizes.value = res.data.size;
            });
        }

        const getProducts = (token) => {
            axios.get('/products', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                products.value = res.data.product
            })
        }

        function onFileChange(e) {
            const file = e.target.files[0];
            image = file;
            imageUrl.value = URL.createObjectURL(file);
        }

        onMounted(() => {
            let token = localStorage.getItem('token');
            getSizes(token);
            getProducts(token);
            getVariants(token);
        });

        // End new product functionality
        return {
            data,
            columns,
            visible,
            closeModal,
            updateHandler,
            deleteHandler,
            formRef,
            labelCol: {
                span: 8,
            },
            wrapperCol: {
                span: 12,
            },
            other: '',
            formState,

            rules,
            onSubmit,
            resetForm,
            imageUrl,
            onFileChange,
            sizes,
            products,
            getProducts,
            getVariants,
            addNewModal,
            editModal,
            filterByCategoryName,
            filterByProductName,
            pId,
            filterData
        };
    },
};
</script>

<style>
.ant-table-thead tr th:last-child{
    width: 200px;
}
.ant-modal-footer {
    display: none;
}

.avatar-uploader > .ant-upload {
    width: 128px;
    height: 128px;
}
.ant-upload-select-picture-card i {
    font-size: 32px;
    color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
    margin-top: 8px;
    color: #666;
}

body .ant-select-single:not(.ant-select-customize-input) .ant-select-selector {
    padding: 10px !important;
    border: 1px solid #cecccc !important;
}

body .ant-select:not(.ant-select-customize-input) .ant-select-selector .ant-select-selection-search-input{
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #f5f5f5 !important;
}
</style>
