<template>
    <a-layout>
        <a-row type="flex" justify="space-around" align="middle" class="h-100 p2">
            <a-col :xs="24" :md="16" :lg="12">
                <a-card title="Reset Password">
                    <a-form-model ref="form" :rules="rules" :model="form">
                        <a-form-model-item label="Email" prop="email">
                            <a-input v-model="form.email"></a-input>
                        </a-form-model-item>
                    </a-form-model>

                    <a-button type="primary" @click="submit">
                        Send Verification Email
                    </a-button>
                </a-card>
            </a-col>
        </a-row>
    </a-layout>
</template>

<script>
    import adminUser from "../../../api/admin/adminUser";
    export default {
        name: "ResetPassword",
        metaInfo: {
            title: 'Reset Password | Laravel Skeleton'
        },
        data () {
            return {
                form: {
                    email: ''
                },
                rules: {
                    email: [
                        { required: true },
                        { type: 'email' }
                    ]
                }
            }
        },
        methods: {
            submit () {
               this.$refs['form'].validate(value => {
                   if (value) {
                       adminUser.sendVerificationEmail(this.form.email).then(({data}) => {
                           this.$message.success('Verification sent, please check your email')
                           // TODO: timer for disabling button
                       }).catch(e => {
                           // TODO
                       })
                   }
               })
            }
        }
    }
</script>

<style scoped>
.h-100 {
    height: 100%;
}
</style>
