<script setup>
import {onMounted, reactive, toRaw, ref} from 'vue';
    import router from "@/router";
    import { useStore } from 'vuex';
    import axios from 'axios';
    const store = useStore();

    const visible = ref(false);
    const user = ref();
    let filterData = [];
    const columns = [
        {
            title: '',
            dataIndex: 'image',
            slots: {
                customRender: 'image',
            },
        },
        {
            title: 'Company name',
            dataIndex: 'company_name',
        },
        {
            title: 'Email',
            dataIndex: 'email',
            slots: {
                customRender: 'email',
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

    const editModal = (id) => {
        user.value = id;
        visible.value = true;
        getUserData(id);
    };

    const getUserData = (id) => {
        let token = localStorage.getItem('token');

        if(token) {

            // store.dispatch('setToken', token);

            axios.get('/auth/user/'+id, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                formState.user_id = res.data.user.id;
                formState.user_name = res.data.user.user_name;
                formState.company_name = res.data.user.company_name;
                formState.phone_number = res.data.user.phone_number;
                formState.password = res.data.user.password;
                formState.approved = res.data.user.approved === 1;

            }).catch((e) => {
                store.dispatch('removeUser', 0);
                store.dispatch('removeToken', 0);
            })
        }
    }

    const userLists = ref([]);

    const formState = reactive({
        user_id: '',
        user_name: '',
        company_name: '',
        phone_number: '',
        password: '',
        approved: false
    });

    const onSubmit = () => {
        let token = localStorage.getItem('token');
        axios({
            method: 'POST',
            url: '/auth/update/'+formState.user_id,
            headers: {
                Authorization: 'Bearer ' + token
            },
            data: toRaw(formState)
        }).then( (res) => {
            closeModal();
            window.location.reload();
        })
    };

    const closeModal = () => {
        visible.value = false;
    }

    const deleteHandler = (id) => {
        let token = localStorage.getItem('token');
        axios({
            method: 'POST',
            url: '/auth/delete/'+id,
            headers: {
                Authorization: 'Bearer ' + token
            }
        }).then( (res) => {
            closeModal();
            window.location.reload();
        })
    }

    const filterByCompanyName = (searchText) => {
        userLists.value = filterData.filter(item => {
            return item.company_name.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
        });
    }
onMounted(() => {
    // User date
    let token = localStorage.getItem('token');
    axios.get('/auth/user-profile', {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then((res) => {
        if(res.data.type !== 'admin') {
            router.push('/login');
        }
    })

    if(token) {
        axios.get('/auth/users', {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }).then((res) => {
            userLists.value = res.data.user;
            filterData = res.data.user;
        }).catch((e) => {
            store.dispatch('removeUser', 0);
            store.dispatch('removeToken', 0);
        })
    } else {
        router.push('/login')
    }
});

</script>
<template>
    <div class="retailers text-right mt-[100px] mb-[10px]">
        <div class="container">
            <div class="flex items-center flex-wrap gap-[20px] mb-[20px]">
                <div>
                    <span>Company name: </span>
                    <input @input="filterByCompanyName($event)" class="py-[10px] border border-[#f5f5f5] px-[10px]" type="text" placeholder="Filter by company name" />
                </div>
            </div>
            <a-table :columns="columns" :data-source="userLists" bordered>
                <template #image="{ record }">
                    <img class="w-[60px] h-[60px] rounded-full" :src="record.image" alt="image" />
                </template>
                <template #company_name="{ record }">
                    <a>{{ record.company_name }}</a>
                </template>
                <template #email="{ record }">
                    <span>{{record.email}}</span>
                </template>
                <template #operation="{ record }">
                    <a-button class="mr-[10px]" type="primary" @click="editModal(record.id)">Edit</a-button>
                    <a-button class="mr-[10px]" type="danger" @click="deleteHandler(record.id)">Delete</a-button>
                </template>
            </a-table>
        </div>
        <a-modal v-model:visible="visible" title="User update">
            <div class="user_udpate_form">
                <a-form :model="formState">
                    <a-form-item label="Company name">
                        <a-input v-model:value="formState.company_name" />
                    </a-form-item>
                    <a-form-item label="User name">
                        <a-input v-model:value="formState.user_name" />
                    </a-form-item>
                    <a-form-item label="Phone number">
                        <a-input v-model:value="formState.phone_number" />
                    </a-form-item>
                    <a-form-item label="Approved ?">
                        <a-switch v-model:checked="formState.approved" />
                    </a-form-item>
                    <a-form-item label="Password">
                        <a-input-password v-model:value="formState.password" placeholder="password" />
                    </a-form-item>

                    <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                        <a-button type="primary" @click="onSubmit">Update</a-button>
                        <a-button style="margin-left: 10px" @click="closeModal">Cancel</a-button>
                    </a-form-item>
                </a-form>
            </div>
        </a-modal>
    </div>
</template>
<style>
    .ant-modal-footer {
        display: none;
    }
</style>
