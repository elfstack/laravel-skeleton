<template>
    <a-layout class="h-100">
        <a-row class="h-100">
            <a-col :sm="0" :xs="0" :md="12" :lg="16" class="h-100 login-background">
                <div class="p1" style="color: #fff">
                    Image by <a href="https://pixabay.com/users/MichaelGaida-652234/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1541086">Ich bin dann mal raus hier.</a> from <a href="https://pixabay.com/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1541086">Pixabay</a>
                </div>
            </a-col>
            <a-col :md="12" :lg="8" class="h-100">
                <div class="p3 login-wrapper">
                    <h1 class="h1">Login</h1>
                    <a-alert
                        message="Invalid credential"
                        banner
                        v-show="showError"
                    />
                    <a-form-model ref="login-form" :model="form" :rules="rules">
                        <a-form-model-item has-feedback prop="email">
                            <a-input v-model="form.email" type="email" size="large" placeholder="Email">
                                <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)"/>
                            </a-input>
                        </a-form-model-item>
                        <a-form-model-item has-feedback prop="password">
                            <a-input-password v-model="form.password" size="large" placeholder="Password">
                                <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)"/>
                            </a-input-password>
                        </a-form-model-item>
                        <a-form-model-item>
                            <a-checkbox @change="onChange">
                                Remember Me
                            </a-checkbox>
                        </a-form-model-item>
                        <a-form-model-item>

                            <router-link class="login-form-forgot" :to="{ name: 'admin.reset-password' }">
                                Forgot password
                            </router-link>
                            <a-button
                                type="primary"
                                html-type="submit"
                                @click="submit"
                                class="right"
                            >
                                Log in
                            </a-button>
                        </a-form-model-item>
                    </a-form-model>
                </div>
            </a-col>
        </a-row>
    </a-layout>
</template>

<script>
    import {mapActions} from 'vuex'

    export default {
        name: 'Login',
        metaInfo: {
            title: 'Login | Laravel Skeleton'
        },
        data() {
            return {
                showError: false,
                form: {
                    email: '',
                    password: '',
                    remember: false
                },
                rules: {
                    email: [
                        {required: true, trigger: 'blur'},
                        {type: 'email', trigger: 'change'}
                    ],
                    password: [
                        {required: true, trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            submit() {
                this.$refs['login-form'].validate(valid => {
                    if (valid) {
                        this.showError = false
                        this.login(this.form).catch((e) => {
                            this.showError = true
                        })
                    }
                })
            },
            onChange (e) {
                this.form.remember = e.target.checked
            },
            ...mapActions('adminUser', [
                'login'
            ])
        }
    }
</script>

<style scoped>
    .login-wrapper {
        background: #fff;
        height: 100%;
    }

    .h-100 {
        height: 100%;
    }

    .login-background {
        background: url('/images/admin-login.jpg') no-repeat center center fixed;
        background-size: cover;
    }
</style>
