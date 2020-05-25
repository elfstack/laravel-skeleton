<template>
    <div>
        <a-page-header title='Create Admin User' @back="$router.go(-1)">
            <template slot="extra">
                <a-button key="1" type="primary" icon="save" @click="submit">
                    Create
                </a-button>
            </template>
        </a-page-header>
        <div class="p2">
            <a-card title="Information">
                <admin-users-form
                    :admin-user.sync="adminUser"
                    ref="admin-users-form"
                    :api="api"
                    :extra-rules="rules"
                    can-change-role>

                </admin-users-form>
            </a-card>
        </div>
    </div>
</template>

<script>
    import Form from './Form'
    import adminUser from "../../../api/admin/adminUser"

    export default {
        name: "Create",
        components: {
            'admin-users-form': Form
        },
        metaInfo: {
            title: 'Create Admin User'
        },
        data () {
            return {
                adminUser: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirm: ''
                },
                api: adminUser.create,
                rules: {
                    password: [{ required: true }]
                }
            }
        },
        methods: {
            submit () {
                this.$refs['admin-users-form'].$submit().then(({data}) => {
                    this.$message.success('Admin Created')
                    this.$router.push({ name: 'AdminUsersShow', params: { id: data.id } })
                })
            }
        }
    }
</script>

<style scoped>

</style>
