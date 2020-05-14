<template>
    <a-form-model :model="adminUser" ref="admin-user-form" :rules="rules">
        <a-row>
            <a-col :span="6">
                <a-form-model-item label="Avatar">
                </a-form-model-item>
            </a-col>

            <a-col :span="18">
                <a-form-model-item label="Name" prop="name">
                    <a-input v-model="adminUser.name"></a-input>
                </a-form-model-item>

                <a-form-model-item label="Email" prop="email">
                    <a-input v-model="adminUser.email"></a-input>
                </a-form-model-item>

                <a-form-model-item label="Password" prop="password">
                    <a-input v-model="adminUser.password" type="password"></a-input>
                </a-form-model-item>

                <a-form-model-item label="Confirm Password" prop="password_confirm">
                    <a-input v-model="adminUser.password_confirm" type="password"></a-input>
                </a-form-model-item>
            </a-col>
        </a-row>
    </a-form-model>
</template>

<script>
    import adminUser from "../../../api/admin/adminUser";

    export default {
        props: {
            adminUser: {
                type: Object,
            },
        },
        name: "AdminUsersForm",
        data () {
            let validateConfirmPassword = (rule, value, callback) => {
                if (value !== this.adminUser.password) {
                    callback(new Error('Password not match'))
                }
                callback()
            }

            return {
                rules: {
                    name: [
                        { required: true }
                    ],
                    email: [
                        { required: true }
                    ],
                    password: [
                        { required: true },
                    ],
                    password_confirm: [
                        { required: true },
                        { validator: validateConfirmPassword, trigger: 'change' }
                    ]
                }

            }
        },
        methods: {
            submit () {
                this.$refs['admin-user-form'].validate(valid => {
                    if (valid) {
                        this.request().then(({data}) => {
                            this.$message.success('Updated!')
                        })
                    }
                })
            },
            request () {
                if (this.adminUser.id) {
                    return adminUser.update(this.adminUser)
                } else {
                    return adminUser.create(this.adminUser)
                }
            }
        }
    }
</script>

<style scoped>

</style>
