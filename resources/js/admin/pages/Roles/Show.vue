<template>
    <div>
        <a-page-header :title="role.name" style="background: #fff">
            <template slot="extra">
                <a-button key="1" icon="save" type="primary" @click="updateRole">
                    Save
                </a-button>
            </template>
        </a-page-header>
        <a-row :gutter="16" class="p2">
            <a-col :span="12">
                <a-card>
                    <a-statistic
                        title="Permissions"
                        :value="role.permissions.length"
                        style="margin-right: 50px"
                    >
                    </a-statistic>
                </a-card>
            </a-col>
            <a-col :span="12">
                <a-card>
                    <a-statistic
                        title="Users"
                        :value="role.total_users"
                        style="margin-right: 50px"
                    >
                    </a-statistic>
                </a-card>
            </a-col>
        </a-row>
        <div class="p2">
            <a-table
                :pagination="false"
                :data-source="permissions"
                rowKey="id"
                :columns="columns"
                :row-selection="{ selectedRowKeys: role.permissions, onChange: onSelectChange }"
            ></a-table>
            <a-button type="danger" icon="delete" class="mt2">
                Delete
            </a-button>
        </div>
    </div>
</template>

<script>
    import role from '../../../api/admin/role'
    import permission from '../../../api/admin/permission'
    export default {
        name: "Show",
        data () {
            return {
                role: {
                    id: '',
                    name: '',
                    permissions: []
                },
                columns: [
                    { dataIndex: 'name', key: 'name', title: 'Permission'}
                ],
                permissions: [],
            }
        },
        beforeRouteEnter (to, from, next) {
            next(vm => vm.fetchRole(to.params.id))
        },
        beforeRouteUpdate (to, from, next) {
            this.fetchRole(to.params.id)
            next()
        },
        created() {
            this.fetchRole()
        },
        methods: {
            // TODO: sort permissions selected, name
            fetchRole (id) {
                role.show(id).then(({data}) => {
                    this.role = data.role
                })
                permission.index().then(({data}) => {
                    this.permissions = data.permissions
                })
            },
            updateRole () {
                role.update(this.role).then(({data}) => {
                    this.$message.success("Updated!")
                })
            },
            onSelectChange(selectedRowKeys) {
                this.role.permissions = selectedRowKeys;
            },
        }
    }
</script>

<style scoped>

</style>
