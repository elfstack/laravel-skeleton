<template>
    <div>
        <a-page-header title="Admin Users">

            <template #extra>
                <router-link :to="{ name: 'admin.manage-access.admin-users.create' }">
                    <a-button type="primary" icon="plus">
                        Create
                    </a-button>
                </router-link>
            </template>
        </a-page-header>

        <div class="p3">
            <a-card>
                    <div>
                        <a-form>
                            <a-form-item>
                                <a-input-search
                                    placeholder="Search"
                                    @search="handleSearch"
                                    :loading="loading"
                                    allow-clear
                                />
                            </a-form-item>
                        </a-form>
                    <a-table
                        @change="handleChange"
                        :pagination="listing.pagination"
                        :loading="loading"
                        :columns="columns"
                        row-key="id"
                        :data-source="data">
                            <span slot="roles" slot-scope="text,record">
                                <a-tag color="blue" v-for="role in record.roles" :key="role.id">{{ role.name }}</a-tag>
                            </span>
                            <span slot="action" slot-scope="text,record">
                                <router-link :to="{ name: 'AdminUsersShow', params: { id: record.id }}">Details</router-link>
                            </span>
                    </a-table>
                    </div>
            </a-card>
        </div>
    </div>
</template>

<script>
    import adminUser from "../../../api/admin/adminUser"
    import listing from '../../../common/mixins/listing'
    export default {
        name: "Index",
        mixins: [ listing ],
        data () {
            return {
                api: adminUser.index,
                columns: [
                    { dataIndex: 'id', key: 'id', title: 'ID', sorter: true },
                    { dataIndex: 'name', key: 'name', title: 'Name' },
                    { dataIndex: 'email', key: 'email', title: 'Email'},
                    { dataIndex: 'roles', key: 'roles', title: 'Roles', scopedSlots: { customRender: 'roles' }},
                    { dataIndex: 'action', key: 'action', title: 'Action', scopedSlots: { customRender: 'action' } }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
