<template>
    <div>
        <a-page-header :title="role.name">
            <template slot="extra">
                <a-button key="3">
                    Save
                </a-button>
            </template>
        </a-page-header>
        <div class="p2">
                <a-table
                    :data-source="permissions"
                    rowKey="id"
                    :columns="columns"
                    :row-selection="{ selectedRowKeys: role.permissions, onChange: onSelectChange }"
                ></a-table>
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
                    name: '',
                    permissions: []
                },
                columns: [
                    { dataIndex: 'name', key: 'name', title: 'Permission'}
                ],
                permissions: []
            }
        },
        watch: {
            '$route': 'fetchRole'
        },
        created() {
            this.fetchRole()
        },
        methods: {
            fetchRole () {
                role.show(this.$route.params.id).then(({data}) => {
                    this.role = data.role
                })
                permission.index().then(({data}) => {
                    this.permissions = data.data
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
