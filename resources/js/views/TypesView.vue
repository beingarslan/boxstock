<template>
    <div class="retailers">
        <div class="container">
            <div class="text-right mt-[100px] mb-[10px]">
                <a-button class="mr-[10px]" type="primary" @click="addCategory">Add new</a-button>
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
                <a-form-item label="Brand name">
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
    modalTitle.value = 'Add new category';
    visible.value = true;
}

const editModal = (id) => {
    modalTitle.value = 'Edit category';
    visible.value = true;

    let token = localStorage.getItem('token');

    if(token) {
        axios.get('/brands/'+id+'/edit', {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }).then((res) => {
            formState.name = res.data.category.name;
            catId.value = res.data.category.id
        })
    }
};

const updateHandler = (id) => {
    visible.value = false;
    let token = localStorage.getItem('token');
    axios({
        method: 'PUT',
        url: '/brands/'+id,
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
        url: '/brands/'+id,
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
        url: '/brands/',
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

        onMounted(() => {
            // Category date
            let token = localStorage.getItem('token');
            axios.get('/brands', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                data.value = res.data.brand;
            });
        });

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
            deleteHandler
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
