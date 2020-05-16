<template>
    <a-form-model :model="adminUser" ref="form" :rules="rules">
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

                <a-form-model-item label="Roles" prop="roles" v-if="canChangeRole">
                    <a-select
                        :default-value="adminUser.roles"
                        mode="multiple"
                        v-model="adminUser.roles"
                        @dropdownVisibleChange="onOpen"
                        @onChange="value => adminUser.roles = value"
                    >
                        <a-select-option
                            v-for="role in roles"
                            :key="role.id"
                        >
                            {{ role.name }}
                        </a-select-option>
                    </a-select>
                </a-form-model-item>
            </a-col>
        </a-row>
    </a-form-model>
</template>

<script>
    import role from '../../../api/admin/role'

    export default {
        props: {
            adminUser: {
                type: Object,
            },
            canChangeRole: {
                type: Boolean,
                default: false
            },
            api: {
                type: Function,
                required: true
            },
            extraRules: {
                type: Object
            }
        },
        name: "AdminUsersForm",
        data () {
            let validateConfirmPassword = (rule, value, callback) => {
                if (this.adminUser.password !== '' && value !== this.adminUser.password) {
                    callback(new Error('Password not match'))
                }
                callback()
            }

            let validateGroupRole = {
                roles: [
                    { required: true }
                ]
            }

            return {
                loading: false,
                roles: [],
                rules: {
                    name: [
                        { required: true }
                    ],
                    email: [
                        { required: true }
                    ],
                    password: [
                        { min: 6 },
                    ],
                    password_confirm: [
                        { validator: validateConfirmPassword, trigger: 'change' }
                    ],
                    ...(this.canChangeRole && validateGroupRole)
                },
            }
        },
        created () {
            this.$watch('adminUser.roles', this.getRoles)
            if (this.extraRules) {
                for (const prop in this.extraRules) {
                    this.rules[prop] = this.rules[prop].concat(this.extraRules[prop])
                }
            }
        },
        methods: {
            getRoles () {
                if (this.canChangeRole && !this.roles.length) {
                    this.loading = true
                    role.index().then(({data}) => {
                        this.roles = data.roles
                        this.loading = false
                    })
                }
            },
            onOpen () {
                this.getRoles()
            },
            $submit () {
                const form = this.$refs['form']
                return form.validate().then(() => {
                    return this.api(this.adminUser).then(response => {
                        return response
                    }).catch(error => {
                        if (error.response.status === 422) {
                            const errors = error.response.data.errors
                            form.fields.filter(field => errors[field.prop] !== undefined).forEach(field => {
                                field.validateState = 'error'
                                // set to first error message
                                field.validateMessage = errors[field.prop][0]
                            })
                        }
                    })
                })

            }
        }
    }
</script>

<style scoped>

</style>
