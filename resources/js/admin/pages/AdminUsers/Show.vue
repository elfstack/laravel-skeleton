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
                    :admin-user.sync="adminUser"
                    ref="admin-users-form"
                    can-change-role
                >

                </admin-users-form>
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
                })
            },
            submit () {
                this.$refs['admin-users-form'].submit()
            }
        }
    }
</script>

<style scoped>

</style>
