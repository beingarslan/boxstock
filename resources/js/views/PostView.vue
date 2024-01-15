<template>
    <div class="retailers">
        <div class="container">
            <div class="main-content mt-[50px] mb-[100px]">
                <div v-if="data">
                    <div v-if="data.image" class="mb-[20px]">
                        <img :src="data.image" :alt="data.title" />
                    </div>
                    <div class="user_info">
                        <div class="flex items-center gap-[10px] mb-[50px]">
                            <div>
                                <img class="rounded-full w-[40px] h-[40px]" :src="data.user.image ? data.user.image : avatarLink" :alt="data.user.user_name" />
                            </div>
                            <div>
                                <span class="block font-medium font-[16px]">{{data.user.user_name}}</span>
                                <span class="block font-medium font-[16px]">{{format_date(data.updated_at)}}</span>
                            </div>
                        </div>
                        <div v-html="data.content"></div>
                    </div>
                </div>
                <div v-else class="loader_wrapper_">
                    <span class="loader"></span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {onMounted, reactive, ref, toRaw} from 'vue';
import axios from "axios";
import moment from 'moment';
import avatarLink from '../../images/avatar.png';
import router from "@/router";
const visible = ref(false);

export default {
    components: {
        moment
    },
    setup() {
        const data = ref();
        const getPosts = (token, slug) => {
            axios.get('/posts/'+slug, {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then((res) => {
                data.value = res.data.post;
            })
        }

        const format_date = (value) => {
            if (value) {
                return moment(String(value)).format('DD / MM / YYYY')
            }
        }

        onMounted(() => {
            let token = localStorage.getItem('token');
            if(router.currentRoute._value.params.slug !== 'undefined') {
                getPosts(token, router.currentRoute._value.params.slug);
            }
        });


        // End new product functionality
        return {
            data,
            visible,
            avatarLink,
            format_date
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
