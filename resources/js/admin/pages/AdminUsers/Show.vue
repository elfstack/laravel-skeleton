<template>
<div>
    <a-page-header :title="adminUser.name" @back="$router.go(-1)"></a-page-header>
    <div class="p2">

    <a-card>
    <a-form-model v-model="adminUser">
        <a-form-model-item label="Name">
            <a-input v-model="adminUser.name"></a-input>
        </a-form-model-item>

        <a-form-model-item label="Email">
            <a-input v-model="adminUser.email"></a-input>
        </a-form-model-item>

        <a-form-model-item label="Password">
            <a-input v-model="adminUser.password"></a-input>
        </a-form-model-item>

        <a-form-model-item label="Confirm Password">
            <a-input v-model="adminUser.password_confirm"></a-input>
        </a-form-model-item>
    </a-form-model>
    </a-card>
    </div>
</div>
</template>

<script>
    import adminUser from "../../../api/admin/adminUser";
    export default {
        name: "Show",
        data () {
            return {
                adminUser: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirm: ''
                }
            }
        },
        watch: {
            '$route': 'fetchData'
        },
        mounted () {
            this.fetchData()
        },
        methods: {
            fetchData () {
                adminUser.show(this.$route.params.id).then(({data}) => {
                    this.adminUser = data.admin_user
                })
            }
        }
    }
</script>

<style scoped>

</style>
