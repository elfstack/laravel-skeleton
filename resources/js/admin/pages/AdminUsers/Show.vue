<template>
    <div>
        <a-page-header title='Admin' :sub-title="adminUser.name" @back="$router.go(-1)" style="background: #fff">
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
                    ref="admin-users-form"
                    can-change-role
                >

                </admin-users-form>
            </a-card>
            <a-card title="Danger Zone">
                <a-button @click="remove" type="danger" icon="delete">Delete</a-button>
            </a-card>
        </div>
    </div>
</template>

<script>
    import adminUser from "../../../api/admin/adminUser";
    import Form from './Form'

    export default {
        name: "Show",
        components: {
            'admin-users-form': Form
        },
        data () {
            return {
                loading: false,
                adminUser: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirm: ''
                },
                api: adminUser.update
            }
        },
        beforeRouteEnter (to, from, next) {
            next(vm => vm.fetchData(to.params.id))
        },
        beforeRouteUpdate (to, from, next) {
            this.fetchData(to.params.id)
            next()
        },
        methods: {
            fetchData (id) {
                adminUser.show(id).then(({data}) => {
                    this.adminUser = data.admin_user
                }).catch(error => {
                    if (error.response.status === 404) {
                        this.$router.replace({ name: '404'})
                    }
                })
            },
            submit () {
                this.$refs['admin-users-form'].$submit().then(({ data }) => {
                    this.$message.success('Updated')
                })
            },
            remove () {
                const _that = this
                this.$confirm({
                    title: 'Do you want to delete this admin user?',
                    onOk() {
                        adminUser.destroy(_that.adminUser.id).then(({data}) => {
                            _that.$message.success('Deleted')
                            _that.$router.push({ name: 'AdminUsersIndex' })
                        })
                    },
                    onCancel() {},
                });
            }
        }
    }
</script>

<style scoped>

</style>
