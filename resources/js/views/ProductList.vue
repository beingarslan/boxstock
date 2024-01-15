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
                    <span>Category name: </span>
                    <input @input="filterByCategoryName($event)" class="py-[10px] border border-[#f5f5f5] px-[10px]" type="text" placeholder="Filter by category name" />
                </div>
                <div>
                    <span>Brand name: </span>
                    <input @input="filterByBrandName($event)" class="py-[10px] border border-[#f5f5f5] px-[10px]" type="text" placeholder="Filter by brand name" />
                </div>
            </div>
            <a-table
                :columns="columns"
                :data-source="data"
                bordered
            >
                <template #image="{ record }">
                    <img class="w-[100px]" :src="record.image" alt="image" />
                </template>
                <template #name="{ text }">
                    <a>{{ text }}</a>
                </template>
                <template #category="{ record }">
                    <span>{{record.category.name}}</span>
                </template>
                <template #brand="{ record }">
                    <span>{{record.brand.name}}</span>
                </template>
                <template #operation="{ record }">
                    <div class="flex items-center gap-[15px]">
                        <v-btn class="mr-[10px]" type="primary" @click="editModal(record.id)">Edit</v-btn>
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
                <a-form-item ref="name" label="Product name" name="name">
                    <a-input v-model:value="formState.name"/>
                </a-form-item>
                <a-form-item ref="sku" label="SKU" name="sku">
                    <a-input v-model:value="formState.sku"/>
                </a-form-item>
                <a-form-item ref="name" label="Image" name="image">
                    <div class="flex items-center justify-center w-full relative">
                        <div class="flex flex-col items-center justify-center pt-7" v-if="imageUrl">
                            <img class="w-[150px]" :src="imageUrl"/>
                        </div>
                        <label v-if="!imageUrl"
                               class="flex flex-col w-full h-32 border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300">
                            <div class="flex flex-col items-center justify-center pt-7">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-8 h-8 text-gray-400 group-hover:text-gray-600"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">Upload
                                    image</p>
                            </div>
                        </label>
                        <input type="file" name="image" @change="onFileChange"
                               class="opacity-0 absolute top-0 left-0 right-0 bottom-0 w-full h-full"/>
                    </div>
                </a-form-item>
                <a-form-item ref="amount" label="Amount" name="amount">
                    <a-input v-model:value="formState.amount"/>
                </a-form-item>
                <a-form-item ref="des" label="Description" name="des">
                    <a-textarea v-model:value="formState.des" allow-clear/>
                </a-form-item>
                <a-form-item class="combobox_select" label="Category" name="category_id">
                    <v-combobox
                        label="Select category"
                        v-model="formState.category_id"
                        :items="categories"
                        item-value="id"
                        item-title="name"
                    ></v-combobox>
                </a-form-item>
                <a-form-item class="combobox_select" label="Brand" name="brand_id">
                    <v-combobox
                        label="Select brand"
                        v-model="formState.brand_id"
                        :items="brands"
                        item-value="id"
                        item-title="name"
                        :return-object="true"
                    ></v-combobox>
                </a-form-item>
                <a-form-item class="combobox_select" label="Product type" name="product_type">
                    <v-combobox
                        label="Select product type"
                        v-model="formState.product_type"
                        :items="['Sneakers', 'Streetwear']"
                    ></v-combobox>
                </a-form-item>
                <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                    <v-btn class="mr-[10px]" v-if="pId" type="primary" @click="updateHandler(pId)">Update</v-btn>
                    <v-btn class="mr-[10px]" v-if="!pId" type="primary" @click="onSubmit">Save</v-btn>
                    <v-btn class="!bg-[#ff4d4f]" type="danger" @click="closeModal">Close</v-btn>
                </a-form-item>
            </a-form>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import {onMounted, reactive, ref, toRaw} from 'vue';
import AdminHeaderVue from '../components/AdminHeader.vue';
import {LoadingOutlined, PlusOutlined} from '@ant-design/icons-vue';
import axios from "axios";

const visible = ref(false);

const closeModal = () => {
    visible.value = false;
}

const deleteHandler = (id) => {
    let token = localStorage.getItem('token');
    axios({
        method: 'DELETE',
        url: '/products/' + id,
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        window.location.reload();
    })
};

export default {
    components: {
        AdminHeaderVue,
        LoadingOutlined,
        PlusOutlined
    },

    setup() {
        const columns = [
            {
                title: '',
                dataIndex: 'image',
                slots: {
                    customRender: 'image',
                },
            },
            {
                title: 'Title',
                dataIndex: 'name',
            },
            {
                title: 'Price',
                dataIndex: 'amount'
            },
            {
                title: 'Category',
                dataIndex: 'category',
                slots: {
                    customRender: 'category',
                },
            },
            {
                title: 'Brand',
                dataIndex: 'brand',
                slots: {
                    customRender: 'brand',
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
        const categories = ref();
        const brands = ref();
        const pId = ref();
        const data = ref();
        const product_name = ref();
        let image = '';
        const imageUrl = ref('');
        let filterBands = [];
        let filterData = [];

        // Add new product functionality
        const formRef = ref();
        const formState = reactive({
            name: '',
            sku: '',
            amount: '',
            brand_id: '',
            category_id: '',
            des: '',
            product_type: '',
        });

        const editModal = (id) => {
            visible.value = true;
            let token = localStorage.getItem('token');
            axios({
                method: 'GET',
                url: '/products/' + id,
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                pId.value = res.data.product.id;
                formState.name = res.data.product.name;
                imageUrl.value = res.data.product.image;
                formState.sku = res.data.product.sku;
                formState.amount = res.data.product.amount;
                formState.des = res.data.product.des;
                formState.category_id = res.data.product.category;
                formState.brand_id = res.data.product.brand;
                formState.product_type = res.data.product.product_type;
            })
        };

        const rules = {
            name: [
                {
                    required: true,
                    message: 'Please input product name',
                    trigger: 'blur',
                }
            ],
            des: [
                {
                    required: true,
                    message: 'Please insert product description',
                    trigger: 'blur',
                },
            ],
            sku: [
                {
                    required: true,
                    message: 'Please insert sku',
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
            brand_id: [
                {
                    required: true,
                    message: 'Please select brand',
                    trigger: 'blur',
                },
            ],
            category_id: [
                {
                    required: true,
                    message: 'Please select category',
                    trigger: 'blur',
                },
            ],
            product_type: [
                {
                    required: true,
                    message: 'Please select type',
                    trigger: 'blur',
                },
            ]
        };

        const onSubmit = () => {
            let data = toRaw(formState);
            data['image'] = image;
            formRef.value
                .validate()
                .then(() => {
                    let token = localStorage.getItem('token');
                    axios({
                        method: 'POST',
                        url: '/products/',
                        headers: {
                            Authorization: 'Bearer ' + token,
                            'content-type': 'multipart/form-data'
                        },
                        data: data
                    }).then((res) => {
                        window.location.reload();
                        closeModal();
                    })
                })
                .catch(error => {
                    console.log('error', error);
                });
        };

        function onFileChange(e) {
            const file = e.target.files[0];
            image = file;
            imageUrl.value = URL.createObjectURL(file);
        }

        const resetForm = () => {
            pId.value = '';
            formState.name = '';
            imageUrl.value = '';
            formState.sku = '';
            formState.amount = '';
            formState.des = '';
            formState.category_id = '';
            formState.brand_id = '';
            formState.product_type = '';
        };

        const addNewModal = () => {
            visible.value = true;
        }

        const updateHandler = (pId) => {
            let token = localStorage.getItem('token');
            axios({
                method: 'PUT',
                url: '/products/' + pId,
                headers: {
                    Authorization: 'Bearer ' + token
                },
                data: toRaw(formState)
            }).then((res) => {
                let imageData = {
                    'id': pId,
                    'type': 'product',
                    'image': image
                }

                axios({
                    method: 'POST',
                    url: '/image/update',
                    headers: {
                        Authorization: 'Bearer ' + token,
                        'content-type': 'multipart/form-data'
                    },
                    data: imageData
                }).then((res) => {
                    closeModal();
                    window.location.reload();
                    visible.value = false;
                });
            })
        }

        const getBrands = (token) => {

            axios.get('/brands', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                // console.log(res.data.brand)
                brands.value = res.data.brand;
            });
        }

        const getProducts = (token) => {
            axios.get('/products', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                data.value = res.data.product;
                filterData = res.data.product;
            })
        }

        onMounted(() => {
            // Category date
            let token = localStorage.getItem('token');
            getBrands(token);
            getProducts(token);
            axios.get('/categories', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                categories.value = res.data.category;
            });
        });

        const filterByProductName = (searchText) => {
            data.value = filterData.filter(item => {
                return item.name.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
            });
        }

        const filterByCategoryName = (searchText) => {
            data.value = filterData.filter(item => {
                return item.category.name.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
            });
        }

        const filterByBrandName = (searchText) => {
            data.value = filterData.filter(item => {
                return item.brand.name.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
            });
        }

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
            getProducts,
            addNewModal,
            categories,
            brands,
            editModal,
            pId,
            product_name,
            filterByProductName,
            filterByCategoryName,
            filterByBrandName,
            filterData,
        };
    },
};
</script>

<style>
.ant-table-thead tr th:last-child {
    width: 200px;
}
.ant-select-dropdown {
    z-index: 999999 !important;
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

body .ant-select:not(.ant-select-customize-input) .ant-select-selector .ant-select-selection-search-input {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #f5f5f5 !important;
}
</style>
