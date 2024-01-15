<template>
    <div class="retailers">
        <div class="container">
            <div class="text-right mt-[100px] mb-[10px]">
                <a-button class="mr-[10px]" type="primary" @click="addNewModal">Add new</a-button>
            </div>
            <div class="flex items-center flex-wrap gap-[20px] mb-[20px]">
                <div>
                    <span>Post name: </span>
                    <input @input="filterByPostName($event)" class="py-[10px] border border-[#f5f5f5] px-[10px]"
                           type="text" placeholder="Filter by post name"/>
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
        <a-modal v-model:visible="visible" class="!w-full !max-full" :title="`${pId ? 'Edit Post': 'Add new post'}`">
            <a-form
                ref="formRef"
                :model="formState"
                :rules="rules"
                :label-col="labelCol"
                :wrapper-col="wrapperCol"
            >

                <a-form-item ref="title" label="Post title" name="title">
                    <a-input v-model:value="formState.title"/>
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
                <a-form-item ref="link" label="Post external link" name="link">
                    <a-input v-model:value="formState.link"/>
                </a-form-item>
                <a-form-item ref="description" label="Content" name="description">
                    <editor
                        v-model="formState.content"
                        api-key="tjw4jd9m79ff5a6n1tssaafm7ikn5dtpw1kdn9rza02sd19y"
                        :init="{
         height: 500,
         menubar: false,
         plugins: [
           'anchor headings autolink charmap codesample emoticons link lists searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tableofcontents footnotes mergetags autocorrect typography inlinecss'
         ],
         toolbar:
           'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat'
       }"
                    />
                </a-form-item>
                <a-form-item ref="description" label="Description" name="description">
                    <a-textarea
                        v-model:value="formState.description"
                        placeholder="Autosize height with minimum and maximum number of lines"
                        :auto-size="{ minRows: 2, maxRows: 5 }"
                    />
                </a-form-item>
                <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                    <a-button v-if="pId" type="primary" @click="updateHandler(pId)">Update</a-button>
                    <a-button v-if="!pId" type="primary" @click="onSubmit">Save</a-button>
                    <a-button style="margin-left: 10px" @click="resetForm">Reset</a-button>
                </a-form-item>
            </a-form>
        </a-modal>
    </div>
</template>
<script>
import {onMounted, reactive, ref, toRaw} from 'vue';
import AdminHeaderVue from '../components/AdminHeader.vue';
import {PlusOutlined, LoadingOutlined} from '@ant-design/icons-vue';
import Editor from '@tinymce/tinymce-vue'
import axios from "axios";

const visible = ref(false);

const closeModal = () => {
    visible.value = false;
}

const deleteHandler = (id) => {
    let token = localStorage.getItem('token');
    axios({
        method: 'DELETE',
        url: '/posts/' + id,
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
        PlusOutlined,
        'editor': Editor
    },

    setup() {
        const columns = [
            {
                title: 'Title',
                dataIndex: 'title',
            },
            {
                title: 'Description',
                dataIndex: 'description'
            },
            {
                title: 'Action',
                dataIndex: 'operation',
                slots: {
                    customRender: 'operation',
                },
            },
        ];

        const pId = ref();
        const data = ref();
        let image = '';
        let filterData = [];
        const imageUrl = ref('');

        // Add new product functionality
        const formRef = ref();
        const formState = reactive({
            title: '',
            description: '',
            link: '',
            content: '',
        });

        const editModal = (id) => {
            visible.value = true;
            let token = localStorage.getItem('token');
            axios({
                method: 'GET',
                url: '/posts/' + id + '/edit',
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                pId.value = res.data.post.id;
                formState.title = res.data.post.title;
                imageUrl.value = res.data.post.image;
                formState.link = res.data.post.link;
                formState.description = res.data.post.description;
                formState.content = res.data.post.content;
            })
        };


        const rules = {
            title: [
                {
                    required: true,
                    message: 'Please input post title',
                    trigger: 'blur',
                }
            ],
            description: [
                {
                    required: true,
                    message: 'Please insert post description',
                    trigger: 'blur',
                },
            ],
            link: [
                {
                    required: true,
                    message: 'Please insert link',
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
                    // console.log('values', formState, toRaw(formState));
                    let token = localStorage.getItem('token');
                    axios({
                        method: 'POST',
                        url: '/posts/',
                        headers: {
                            Authorization: 'Bearer ' + token,
                            'content-type': 'multipart/form-data'
                        },
                        data: data
                    }).then((res) => {
                        closeModal();
                        window.location.reload();
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
            formRef.value.resetFields();
        };

        const addNewModal = () => {
            visible.value = true;
            resetForm();
        }

        const updateHandler = (pId) => {
            let token = localStorage.getItem('token');
            axios({
                method: 'PUT',
                url: '/posts/' + pId,
                headers: {
                    Authorization: 'Bearer ' + token
                },
                data: toRaw(formState)
            }).then((res) => {
                let imageData = {
                    'id': pId,
                    'type': 'post',
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

        const getPosts = (token) => {
            axios.get('/posts', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                data.value = res.data.posts
                filterData = res.data.posts;
            })
        }

        onMounted(() => {
            let token = localStorage.getItem('token');
            getPosts(token);
        });

        const filterByPostName = (searchText) => {
            data.value = filterData.filter(item => {
                return item.title.toLowerCase().indexOf(searchText.target.value.toLowerCase()) > -1
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
            getPosts,
            addNewModal,
            editModal,
            filterByPostName,
            pId
        };
    },
};
</script>

<style>
.ant-table-thead tr th:last-child {
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

body .ant-select:not(.ant-select-customize-input) .ant-select-selector .ant-select-selection-search-input {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #f5f5f5 !important;
}
</style>
