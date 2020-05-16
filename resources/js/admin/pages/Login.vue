<template>
    <a-layout style="height: 100%">
        <a-layout-content class="p1">laravel-skeleton (dev)</a-layout-content>
        <a-layout-sider width="400" class="p3" theme="light">
            <h1 class="h1">Login</h1>
            <a-alert
                message="Invalid credential"
                banner
                v-show="showError"
            />
            <a-form-model ref="login-form" :model="form" :rules="rules">
                <a-form-model-item has-feedback prop="email">
                    <a-input v-model="form.email" type="email" size="large">
                        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
                    </a-input>
                </a-form-model-item>
                <a-form-model-item has-feedback prop="password">
                    <a-input-password v-model="form.password" size="large">
                        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)" />
                    </a-input-password>
                </a-form-model-item>
                <a-form-model-item>
                    <a class="login-form-forgot" href="">
                        Forgot password
                    </a>
                    <a-button type="primary" html-type="submit" @click="submit">
                        Log in
                    </a-button>
                </a-form-model-item>
            </a-form-model>
        </a-layout-sider>
    </a-layout>
</template>

<script>
    import { mapActions } from 'vuex'
    export default {
        name: "Login",
        data () {
            return {
                showError: false,
                form: {
                    email: '',
                    password: ''
                },
                rules: {
                    email: [
                        { required: true, trigger: 'blur' },
                        { type: 'email', trigger: 'change' }
                    ],
                    password: [
                        { required: true, trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            submit () {
                this.$refs['login-form'].validate(valid => {
                    if (valid) {
                        this.showError = false
                        this.login(this.form).catch((e) => {
                            this.showError = true
                        })
                    }
                })
            },
            ...mapActions('adminUser', [
                'login'
            ])
        }
    }
</script>

<style scoped>

</style>
