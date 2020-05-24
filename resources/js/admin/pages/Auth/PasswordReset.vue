<template>
    <a-layout>
        <a-row type="flex" justify="space-around" align="middle">
            <a-col :span="8">
                <a-card title="Reset Password">
                    <a-form-model ref="form" :rules="rules" :model="form">
                        <a-form-model-item label="Password" prop="password">
                            <a-input-password v-model="form.password"></a-input-password>
                        </a-form-model-item>
                    </a-form-model>

                    <a-button type="primary" @click="submit">
                        Change Password
                    </a-button>
                </a-card>
            </a-col>
        </a-row>
    </a-layout>

</template>

<script>
    import adminUser from "../../../api/admin/adminUser"
    export default {
        name: "PasswordReset",
        data () {
            return {
                form: {
                    password: '',
                },
                credential: {
                    email: '',
                    token: ''
                },
                rules: {
                    password: [
                        { required: true },
                        { min: 8 }
                    ]
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            // TODO: validate password reset token
            next(vm => {
                vm.credential = {
                    token: to.params.token,
                    email: to.params.email
                }
                adminUser.verifyPasswordResetToken(vm.credential).catch(e => {
                    vm.$message.error('Invalid Link')
                    vm.$router.push('/')
                })
            })
        },
        methods: {
            submit () {
                adminUser.resetPassword(this.form.password, this.credential).then(({data}) => {
                    this.$message.success("Password changed")
                    this.$router.push({ name: 'Login' })
                }).catch(e => {
                    this.$message.error("An error occured")
                })
            }
        }
    }
</script>

<style scoped>

</style>
