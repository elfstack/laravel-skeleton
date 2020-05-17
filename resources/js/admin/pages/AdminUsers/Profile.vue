<template>
    <div>
        <a-page-header title='My Profile' @back="$router.go(-1)" style="background: #fff">
            <template slot="extra">
                <a-button key="1" type="primary" icon="save" @click="submit">
                    Save
                </a-button>
            </template>
        </a-page-header>

        <div class="p2">
            <a-card title="Information">

                <a-row>
                    <a-col :span="6" style="min-height: 180px">
                        <div class="ant-upload-preview" @click="avatarModalVisible = true">
                            <div class="mask">
                                <a-icon type="cloud-upload-o"/>
                            </div>
                            <a-avatar :size="180" :src="avatarPreview" v-if="avatarPreview"/>
                            <a-avatar :size="180" :src="adminUser.avatar_url" v-else-if="adminUser.avatar_url"/>
                            <a-avatar :size="180" icon="user" v-else/>
                        </div>
                    </a-col>

                    <a-modal
                        title="Modify Avatar"
                        :visible="avatarModalVisible"
                        @cancel="avatarModalVisible = false"
                        @ok="handleUpload"
                    >
                        <img :src="avatarPreview" alt="Upload Avatar" style="width: 100%"/>
                        <a-upload
                            name="file"
                            action="/api/media/upload"
                            @change="handleChange"
                            :before-upload="checkImgAndGetBase64"
                            with-credential
                        >
                            <a-button> <a-icon type="upload" /> Click to Upload </a-button>
                        </a-upload>
                    </a-modal>

                    <a-col :span="18">
                        <admin-users-form
                            :api="api"
                            :admin-user.sync="adminUser"
                            ref="admin-users-form">
                        </admin-users-form>
                        <a-form-model-item label="Role">
                            <a-tag
                                v-for="role in adminUser.roles"
                                :key="role"
                            >{{ role }}
                            </a-tag>
                        </a-form-model-item>
                    </a-col>
                </a-row>
            </a-card>
        </div>
    </div>
</template>

<script>
    import Form from './Form'
    import adminUser from "../../../api/admin/adminUser";

    export default {
        name: "AdminUsersProfile",
        components: {
            'admin-users-form': Form
        },
        data() {
            return {
                avatarModalVisible: false,
                loading: false,
                avatarPreview: null,
                avatar: null,
                avatarPath: '',
                adminUser: {
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirm: ''
                },
                api: adminUser.updateCurrent
            }
        },
        created() {
            this.adminUser = this.$store.state.adminUser
        },
        methods: {
            submit() {
                this.$refs['admin-users-form'].$submit().then(({data}) => {
                    this.$message.success('Profile updated')
                    this.$store.dispatch('adminUser/getAdminUser')
                })
            },
            checkImgAndGetBase64 (file) {
                this.avatar = file
                const reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = () => {
                    this.avatarPreview = reader.result
                }
                return false
            },
            handleUpload () {
                const formData = new FormData()
                formData.append('file', this.avatar)

                window.axios.post('/media/upload', formData, {
                    baseURL: '/api'
                }).then(({data}) => {
                    this.avatarModalVisible = false
                    this.adminUser.avatar_path = data.path
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

    .avatar-upload-wrapper {
        height: 200px;
        width: 100%;
    }

    .ant-upload-preview {
        position: relative;
        margin: 0 auto;
        width: 100%;
        max-width: 180px;
        border-radius: 50%;

        .mask {
            z-index: 9;
            opacity: 0;
            position: absolute;
            background: rgba(0, 0, 0, 0.4);
            cursor: pointer;
            transition: opacity 0.4s;

            &:hover {
                opacity: 1;
            }

            i {
                font-size: 2rem;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-left: -1rem;
                margin-top: -1rem;
                color: #d6d6d6;
            }
        }

        .mask {
            width: 100%;
            max-width: 180px;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
        }
    }
</style>

