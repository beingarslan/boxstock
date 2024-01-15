<template>
    <div class="retailers">
        <div class="container">

            <div class="text-right mt-[100px] mb-[10px]">
                <a-button class="mr-[10px]" type="primary" @click="addCategory">Add new</a-button>
            </div>
            <div class="flex items-center flex-wrap gap-[20px] mb-[20px]">
                <div>
                    <span>Size name: </span>
                    <input @input="filterByCategoryName($event)" class="py-[10px] border border-[#f5f5f5] px-[10px]" type="text" placeholder="Filter by size name" />
                </div>
            </div>
            <a-table :columns="columns" :data-source="data" bordered>
                <template #name="{ text }">
                    <a>{{ text }}</a>
                </template>
                <template #operation="{ record }">
                    <a-button class="mr-[10px]" type="primary" @click="editModal(record.id)">Edit</a-button>
                    <a-button class="mr-[10px]" type="danger" @click="deleteHandler(record.id)">Delete</a-button>
                </template>
            </a-table>
        </div>
        <a-modal v-model:visible="visible" :title="modalTitle">
            <a-form :model="formState">
                <a-form-item label="Size name">
                    <a-input aria-required="true" required="required" v-model:value="formState.name" />
                    <span v-if="requiredMsg" role="alert" class="text-red-700 text-[12px]">{{ requiredMsg }}</span>
                </a-form-item>

                <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                    <a-button type="primary" v-if="catId" @click="updateHandler(catId)">Update</a-button>
                    <a-button type="primary" v-if="!catId" @click="onSubmit">Save</a-button>
                    <a-button style="margin-left: 10px" @click="closeModal">Cancel</a-button>
                </a-form-item>
            </a-form>
        </a-modal>
    </div>
</template>
<script>
import {onMounted, reactive, ref, toRaw} from 'vue';
import AdminHeaderVue from '../components/AdminHeader.vue';
import axios from "axios";

const visible = ref(false);
const modalTitle = ref();
const requiredMsg = ref();
const catId = ref();


const addCategory = () => {
    modalTitle.value = 'Add new sizes';
    visible.value = true;
}

const editModal = (id) => {
    modalTitle.value = 'Edit sizes';
    visible.value = true;

    let token = localStorage.getItem('token');

    if(token) {
        axios.get('/sizes/'+id+'/edit', {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }).then((res) => {
            formState.name = res.data.size.name;
            catId.value = res.data.size.id
        })
    }
};

const updateHandler = (id) => {
    visible.value = false;
    let token = localStorage.getItem('token');
    axios({
        method: 'PUT',
        url: '/sizes/'+id,
        headers: {
            Authorization: 'Bearer ' + token
        },
        data: toRaw(formState)
    }).then( (res) => {
        closeModal();
        window.location.reload();
    })
}

const deleteHandler = (id) => {
    let token = localStorage.getItem('token');
    axios({
        method: 'DELETE',
        url: '/sizes/'+id,
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then( (res) => {
        window.location.reload();
    })
};

const formState = reactive({
    name: '',
});

const onSubmit = () => {

    if(!formState.name) {
        requiredMsg.value = 'Brand name required.';
        return false;
    }

    let token = localStorage.getItem('token');
    axios({
        method: 'POST',
        url: '/sizes/',
        headers: {
            Authorization: 'Bearer ' + token
        },
        data: toRaw(formState)
    }).then( (res) => {
        window.location.reload();
    })
};

const closeModal = () => {
    visible.value = false;
}



export default {
    components: {
        AdminHeaderVue
    },

    setup() {

        const data = ref();
        let filterData = [];

        onMounted(() => {
            // Category date
            let token = localStorage.getItem('token');
            axios.get('/sizes', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                data.value = res.data.size;
                filterData = res.data.size;
            });
        });
        const filterByCategoryName = (searchText) => {
            data.value = filterData.filter(item => {
                return item.name.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
            });
        }

        const columns = [
            {
                title: 'Title',
                dataIndex: 'name',
            },
            {
                title: 'Action',
                dataIndex: 'operation',
                slots: {
                    customRender: 'operation',
                },
            },
        ];
        return {
            data,
            columns,
            visible,
            formState,
            requiredMsg,
            catId,
            editModal,
            modalTitle,
            closeModal,
            onSubmit,
            addCategory,
            updateHandler,
            deleteHandler,
            filterData,
            filterByCategoryName
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
</style>
