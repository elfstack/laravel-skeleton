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
                <admin-users-form :admin-user.sync="adminUser" ref="admin-users-form"></admin-users-form>
            </a-card>
        </div>
    </div>
</template>

<script>
    import Form from './Form'
    import { mapGetters } from 'vuex'

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
            }
        },
        created () {
            // copy admin user from store
            this.adminUser = this.$store.state.adminUser
        },
        methods: {
            submit () {
                this.$refs['admin-users-form'].submit()
            }
        }
    }
</script>

<style scoped>

</style>

