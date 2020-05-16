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
                <admin-users-form
                    :api="api"
                    :admin-user.sync="adminUser"
                    ref="admin-users-form">
                </admin-users-form>
                <a-row>
                    <a-col :span="6">
                    </a-col>

                    <a-col :span="18">
                        <a-form-model-item label="Role">
                            <a-tag
                                v-for="role in adminUser.roles"
                                :key="role"
                            >{{ role }}</a-tag>
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
        data () {
            return {
                loading: false,
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
        created () {
            this.adminUser = this.$store.state.adminUser
        },
        methods: {
            submit () {
                this.$refs['admin-users-form'].$submit().then(({data}) => {
                    this.$message.success('Profile updated')
                })
            }
        }
    }
</script>

<style scoped>

</style>

