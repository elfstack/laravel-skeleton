<template>
    <div>
        <a-page-header
            style="border: 1px solid rgb(235, 237, 240); background: #fff"
            title="Admin Users"
        />

        <div class="p3">
            <a-card>
                <listing
                    :api="adminUserListingApi"
                    :columns="columns"
                    inline-template>
                    <div>
                        <a-input-search placeholder="input search text" style="width: 200px" @search="handleSearch" />
                    <a-table
                        @change="handleChange"
                        :pagination="pagination"
                        :loading="loading"
                        :columns="columns"
                        row-key="id"
                        :data-source="data">
                            <span slot="action" slot-scope="text,record">
                                <router-link :to="{ name: 'AdminUsersShow', params: { id: record.id }}">View</router-link>
                                <a-divider type="vertical" />
                                <a>Delete</a>
                            </span>
                    </a-table>
                    </div>
                </listing>
            </a-card>
        </div>
    </div>
</template>

<script>
    import adminUser from "../../../api/admin/adminUser";
    export default {
        name: "Index",
        data () {
            return {
                adminUserListingApi: adminUser.index,
                columns: [
                    { dataIndex: 'id', key: 'id', title: 'ID', sorter: true },
                    { dataIndex: 'name', key: 'name', title: 'Name' },
                    { dataIndex: 'email', key: 'email', title: 'Email'},
                    { dataIndex: 'roles', key: 'roles', title: 'Roles'},
                    { dataIndex: 'action', key: 'action', title: 'Action', scopedSlots: { customRender: 'action' } }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
