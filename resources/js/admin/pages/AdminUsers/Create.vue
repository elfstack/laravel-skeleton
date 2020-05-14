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
                <admin-users-form :admin-user.sync="adminUser" ref="admin-users-form">

                </admin-users-form>
            </a-card>
        </div>
    </div>
</template>

<script>
    import Form from './Form'

    export default {
        name: "Create",
        components: {
            'admin-users-form': Form
        },
        data () {
            return {
                adminUser: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirm: ''
                },

            }
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
